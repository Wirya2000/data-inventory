<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ===============================
        // 1. HANDLE FILTER TANGGAL GLOBAL
        // ===============================

        $filter = $request->filter ?? 'today';

        if ($filter == '7days') {
            $start = Carbon::now()->subDays(6)->startOfDay();
            $end   = Carbon::now()->endOfDay();
        } elseif ($filter == '30days') {
            $start = Carbon::now()->subDays(29)->startOfDay();
            $end   = Carbon::now()->endOfDay();
        } elseif ($filter == 'custom') {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end   = Carbon::parse($request->end_date)->endOfDay();
        } else {
            $start = Carbon::today();
            $end   = Carbon::today()->endOfDay();
        }

        // ===============================
        // 2. CARD RINGKASAN
        // ===============================

        $totalPenjualan = Penjualan::whereBetween('tanggal', [$start, $end])
            ->sum('grand_total');

        // PROFIT dihitung dari pivot (modal_satuan)
        $totalProfit = DetailPenjualan::join('penjualans', 'detail_penjualans.penjualans_id', '=', 'penjualans.id')
            ->whereBetween('penjualans.tanggal', [$start, $end])
            ->sum(DB::raw('(detail_penjualans.harga_satuan - detail_penjualans.modal_satuan) * detail_penjualans.jumlah'));

        $totalTransaksi = Penjualan::whereBetween('tanggal', [$start, $end])
            ->count();

        // stok menipis (kalau ada minimum_stock pakai whereColumn)
        $stokMenipis = Barang::where('stock', '<=', 5)->count();

        $margin = $totalPenjualan > 0
            ? ($totalProfit / $totalPenjualan) * 100
            : 0;

        // ===============================
        // 3. GRAFIK 7 HARI TERAKHIR
        // ===============================

        $grafik7Hari = Penjualan::select(
                DB::raw('DATE(tanggal) as tanggal'),
                DB::raw('SUM(grand_total) as total')
            )
            ->whereBetween('tanggal', [
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::now()->endOfDay()
            ])
            ->groupBy(DB::raw('DATE(tanggal)'))
            ->orderBy('tanggal')
            ->get();

        // ===============================
        // 4. PROFIT BULANAN (12 BULAN)
        // ===============================

        $profitBulanan = BarangHasPenjualan::join('penjualans', 'barangs_has_penjualans.penjualans_id', '=', 'penjualans.id')
            ->select(
                DB::raw('MONTH(penjualans.tanggal) as bulan'),
                DB::raw('SUM((barangs_has_penjualans.harga_satuan - barangs_has_penjualans.modal_satuan) * barangs_has_penjualans.jumlah) as total')
            )
            ->whereYear('penjualans.tanggal', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(penjualans.tanggal)'))
            ->orderBy('bulan')
            ->get();

        // ===============================
        // 5. TOP 5 BARANG
        // ===============================

        $topBarang = BarangHasPenjualan::join('penjualans', 'barangs_has_penjualans.penjualans_id', '=', 'penjualans.id')
            ->whereBetween('penjualans.tanggal', [$start, $end])
            ->select(
                'barangs_has_penjualans.barangs_id',
                DB::raw('SUM(barangs_has_penjualans.jumlah) as total_qty'),
                DB::raw('SUM(barangs_has_penjualans.jumlah * barangs_has_penjualans.harga_satuan) as total_penjualan')
            )
            ->with('barang')
            ->groupBy('barangs_has_penjualans.barangs_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // ===============================
        // 6. TOP 5 CUSTOMER
        // ===============================

        $topCustomer = Penjualan::select(
                'customers_id',
                DB::raw('COUNT(id) as total_transaksi'),
                DB::raw('SUM(grand_total) as total_belanja')
            )
            ->whereBetween('tanggal', [$start, $end])
            ->with('customer')
            ->groupBy('customers_id')
            ->orderByDesc('total_belanja')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalPenjualan',
            'totalProfit',
            'totalTransaksi',
            'stokMenipis',
            'margin',
            'grafik7Hari',
            'profitBulanan',
            'topBarang',
            'topCustomer',
            'filter'
        ));
    }
}
