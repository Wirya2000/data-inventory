<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                    'details.barang',
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
            $laporan = Penjualan::with(['customer', 'details'])
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->select('id', 'tanggal', 'customers_id', 'discount', 'grand_total')
            ->get()
            ->map(function ($penjualan) {
                // hitung total item & subtotal per transaksi
                $totalItem = $penjualan->details->sum('jumlah');
                $subtotal = $penjualan->details->sum(function ($detail) {
                    return $detail->jumlah * $detail->harga_satuan;
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
            $laporan = Penjualan::with('details')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get()
            ->groupBy('tanggal')
            ->map(function ($group) {
                $jumlahTransaksi = $group->count();
                $totalBarang = $group->sum(function ($penjualan) {
                    return $penjualan->details->sum('jumlah');
                });
                $totalSubtotal = $group->sum(function ($penjualan) {
                    return $penjualan->details->sum(function ($detail) {
                        return $detail->jumlah * $detail->harga_satuan;
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
                    'penjualans' => $group,
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
        $laporan = Barang::with(['detailPenjualans' => function ($query) use ($startDate, $endDate) {
            if ($startDate && $endDate) {
                $query->whereHas('penjualan', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('tanggal', [$startDate, $endDate]);
                });
            }
        }])
        ->get()
        ->map(function ($barang) use ($startDate, $endDate) {
            $details = $barang->detailPenjualans;

            // Filter by date if provided
            if ($startDate && $endDate) {
                $details = $details->filter(function ($detail) use ($startDate, $endDate) {
                    $tanggal = $detail->penjualan->tanggal;
                    return $tanggal >= $startDate && $tanggal <= $endDate;
                });
            }

            return (object) [
                'nama' => $barang->nama,
                'total_qty' => $details->sum('jumlah'),
                'total_penjualan' => $details->sum(function ($detail) {
                    return $detail->jumlah * $detail->harga_satuan;
                }),
            ];
        })
        ->filter(function ($item) {
            return $item->total_qty > 0;
        })
        ->sortByDesc('total_penjualan')
        ->values();

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
        $endDate   = $request->end_date;

        // Query total pembelian per customer
        $laporan = Customer::with(['penjualans' => function ($query) use ($startDate, $endDate) {
            if ($startDate && $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            }
        }])
        ->withSum(['penjualans as total_pembelian' => function ($query) use ($startDate, $endDate) {
            if ($startDate && $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            }
        }], 'grand_total')
        ->withCount(['penjualans as total_transaksi' => function ($query) use ($startDate, $endDate) {
            if ($startDate && $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            }
        }])
        ->orderByDesc('total_pembelian')
        ->get();


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
            $laporan = Barang::with(['detailPenjualans' => function ($query) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $query->whereHas('penjualan', function ($q) use ($startDate, $endDate) {
                        $q->whereBetween('tanggal', [$startDate, $endDate]);
                    });
                }
            }])
            ->get()
            ->map(function ($item) use ($startDate, $endDate) {
                // Filter details by date if provided
                $details = $item->detailPenjualans;

                if ($startDate && $endDate) {
                    $details = $details->filter(function ($detail) use ($startDate, $endDate) {
                        $tanggal = $detail->penjualan->tanggal;
                        return $tanggal >= $startDate && $tanggal <= $endDate;
                    });
                }

                // Perhitungan profit per barang
                $totalQty = $details->sum('jumlah');
                $totalPenjualan = $details->sum(function ($detail) {
                    return $detail->jumlah * $detail->harga_satuan;
                });
                $totalModal = $details->sum('total_modal');
                $profit = $totalPenjualan - $totalModal;

                return [
                    'nama' => $item->nama,
                    'total_qty' => $totalQty,
                    'total_penjualan' => $totalPenjualan,
                    'total_modal' => $totalModal,
                    'profit' => $profit,
                ];
            })
            ->sortByDesc('profit')
            ->values();
        // }

        return view('pages.admin.laporan.penjualanProfitPenjualan', compact('laporan', 'startDate', 'endDate'));
    }
}
