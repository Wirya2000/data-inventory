<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function penjualanDetail(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        // if ($startDate != null && $endDate != null) {
            $laporan = Penjualan::with([
                    'barangs',
                    'customer:id,nama',
                    'user:id,nama'
                ])
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->orderBy('tanggal', 'asc')
                ->get();
        // }

        return view('pages.admin.laporan.penjualanDetail', compact('laporan', 'startDate', 'endDate'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function penjualanRekap(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        // if ($startDate != null && $endDate != null) {
            $laporan = Penjualan::with(['customer', 'barangs'])
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->select('id', 'tanggal', 'customers_id', 'discount', 'grand_total')
            ->get()
            ->map(function ($penjualan) {
                // hitung total item & subtotal per transaksi
                $totalItem = $penjualan->barangs->sum('pivot.jumlah');
                $subtotal = $penjualan->barangs->sum(function ($barang) {
                    return $barang->pivot->jumlah * $barang->pivot->harga_satuan;
                });

                return (object) [
                    'tanggal'      => $penjualan->tanggal,
                    'no_transaksi' => $penjualan->id,
                    'customer'     => $penjualan->customer->nama ?? $penjualan->nama_customer,
                    'total_item'   => $totalItem,
                    'subtotal'     => $subtotal,
                    'discount'     => $penjualan->discount,
                    'grand_total'  => $penjualan->grand_total,
                ];
            });
        // }

        return view('pages.admin.laporan.penjualanRekap', compact('laporan', 'startDate', 'endDate'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function penjualanHarian(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        // if ($startDate != null && $endDate != null) {
            $laporan = Penjualan::with('barangs')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get()
            ->groupBy('tanggal')
            ->map(function ($group) {
                $jumlahTransaksi = $group->count();
                $totalBarang = $group->sum(function ($penjualan) {
                    return $penjualan->barangs->sum('pivot.jumlah');
                });
                $totalSubtotal = $group->sum(function ($penjualan) {
                    return $penjualan->barangs->sum(function ($barang) {
                        return $barang->pivot->jumlah * $barang->pivot->harga_satuan;
                    });
                });
                $totalDiskon = $group->sum('discount');
                $totalGrand = $group->sum('grand_total');

                return (object) [
                    'tanggal' => $group->first()->tanggal,
                    'jumlah_transaksi' => $jumlahTransaksi,
                    'total_barang' => $totalBarang,
                    'total_subtotal' => $totalSubtotal,
                    'total_diskon' => $totalDiskon,
                    'total_grand' => $totalGrand,
                    'rata_rata_transaksi' => $jumlahTransaksi > 0 ? $totalGrand / $jumlahTransaksi : 0,
                ];
            })->values();
        // }

        return view('pages.admin.laporan.penjualanHarian', compact('laporan', 'startDate', 'endDate'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function penjualanPerBarang(Request $request)
    {
        $startDate = $request->start_date;
        $endDate   = $request->end_date;

        // Jika belum ada filter tanggal, ambil semua
        $laporan = \DB::table('penjualan_barangs')
            ->join('penjualans', 'penjualans.id', '=', 'penjualan_barangs.penjualans_id')
            ->join('barangs', 'barangs.id', '=', 'penjualan_barangs.barangs_id')
            ->select(
                'barangs.nama as nama_barang',
                \DB::raw('SUM(penjualan_barangs.qty) as total_terjual'),
                \DB::raw('SUM(penjualan_barangs.subtotal) as total_pendapatan')
            )
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('penjualans.tanggal', [$startDate, $endDate]);
            })
            ->groupBy('barangs.nama')
            ->orderByDesc('total_terjual')
            ->get();

        return view('reports.penjualanPerBarang', compact('laporan', 'startDate', 'endDate'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function penjualanPerCustomer(Request $request)
    {
        $startDate = $request->start_date;
        $endDate   = $request->end_date;

        // Query total pembelian per customer
        $laporan = Customer->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        })
        ->selectRaw('customers_id, COUNT(id) as total_transaksi, SUM(grand_total) as total_pembelian')
        ->groupBy('customers_id')
        ->orderByDesc('total_pembelian')
        ->get();

    // Muat data customer untuk setiap hasil
    $laporan->load('customer');


        return view('reports.penjualanPerCustomer', compact('laporan', 'startDate', 'endDate'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function penjualanProfitPenjualan(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        // if ($startDate != null && $endDate != null) {
            $laporan = Penjualan::with([
                    'barangs',
                    'customer:id,nama',
                    'user:id,nama'
                ])
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->orderBy('tanggal', 'asc')
                ->get();
        // }

        return view('pages.admin.laporan.penjualanProfitPenjualan', compact('laporan', 'startDate', 'endDate'));
    }
}
