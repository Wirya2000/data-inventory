<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
            ->select('id', 'tanggal', 'customer_id', 'discount', 'grand_total')
            ->get()
            ->map(function ($penjualan) {
                // hitung total item & subtotal per transaksi
                $totalItem = $penjualan->barangs->sum('pivot.jumlah');
                $subtotal = $penjualan->barangs->sum(function ($barang) {
                    return $barang->pivot->jumlah * $barang->pivot->harga_satuan;
                });

                return [
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
            $laporan = Penjualan::with([
                    'barangs',
                    'customer:id,nama',
                    'user:id,nama'
                ])
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->orderBy('tanggal', 'asc')
                ->get();
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

        return view('pages.admin.laporan.penjualanPerBarang', compact('laporan', 'startDate', 'endDate'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function penjualanPerCustomer(Request $request)
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

        return view('pages.admin.laporan.penjualanPerCustomer', compact('laporan', 'startDate', 'endDate'));
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
