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
        // Set default dates if not provided (current month)
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');
        $barangId = $request->barang_id;
        $customerId = $request->customer_id;

        $query = Penjualan::with([
                'details.barang',
                'customer:id,nama',
                'user:id,nama'
            ])
            ->whereBetween('tanggal', [$startDate, $endDate]);

        if ($customerId) {
            $query->where('customers_id', $customerId);
        }

        $laporan = $query->orderBy('tanggal', 'asc')->get();

        // Filter by barang if selected
        if ($barangId) {
            $laporan = $laporan->map(function ($penjualan) use ($barangId) {
                $penjualan->details = $penjualan->details->filter(function ($detail) use ($barangId) {
                    return $detail->barangs_id == $barangId;
                });
                return $penjualan;
            })->filter(function ($penjualan) {
                return $penjualan->details->count() > 0;
            })->values();
        }

        $barangs = Barang::orderBy('nama')->get();
        $customers = Customer::orderBy('nama')->get();

        return view('pages.admin.laporan.penjualanDetail', compact('laporan', 'barangs', 'customers', 'startDate', 'endDate', 'barangId', 'customerId'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function penjualanRekap(Request $request)
    {
        // Set default dates if not provided (current month)
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');
        $customerId = $request->customer_id;

        $query = Penjualan::with(['customer', 'details'])
            ->whereBetween('tanggal', [$startDate, $endDate]);

        if ($customerId) {
            $query->where('customers_id', $customerId);
        }

        $laporan = $query->select('id', 'tanggal', 'customers_id', 'discount', 'grand_total')
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

        $customers = Customer::orderBy('nama')->get();

        return view('pages.admin.laporan.penjualanRekap', compact('laporan', 'customers', 'startDate', 'endDate', 'customerId'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function penjualanHarian(Request $request)
    {
        // Set default dates if not provided (current month)
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');

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
        // Set default dates if not provided (current month)
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');
        $barangId  = $request->barang_id;

        // Jika belum ada filter tanggal, ambil semua
        $query = Barang::with(['detailPenjualans' => function ($query) use ($startDate, $endDate) {
            $query->whereHas('penjualan', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal', [$startDate, $endDate]);
            });
        }]);

        if ($barangId) {
            $query->where('id', $barangId);
        }

        $laporan = $query->get()
        ->map(function ($barang) use ($startDate, $endDate) {
            $details = $barang->detailPenjualans;

            // Filter by date if provided
            $details = $details->filter(function ($detail) use ($startDate, $endDate) {
                $tanggal = $detail->penjualan->tanggal;
                return $tanggal >= $startDate && $tanggal <= $endDate;
            });

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

        $barangs = Barang::orderBy('nama')->get();

        return view('pages.admin.laporan.penjualanPerBarang', compact('laporan', 'barangs', 'startDate', 'endDate', 'barangId'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function penjualanPerCustomer(Request $request)
    {
        // Set default dates if not provided (current month)
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');
        $customerId = $request->customer_id;

        // Query total pembelian per customer
        $query = Customer::with(['penjualans' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }])
        ->withSum(['penjualans as total_pembelian' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }], 'grand_total')
        ->withCount(['penjualans as total_transaksi' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }]);

        if ($customerId) {
            $query->where('id', $customerId);
        }

        $laporan = $query->orderByDesc('total_pembelian')->get();

        $customers = Customer::orderBy('nama')->get();

        return view('pages.admin.laporan.penjualanPerCustomer', compact('laporan', 'customers', 'startDate', 'endDate', 'customerId'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function penjualanProfitPenjualan(Request $request)
    {
        // Set default dates if not provided (current month)
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');
        $barangId = $request->barang_id;

        $query = Barang::with(['detailPenjualans' => function ($query) use ($startDate, $endDate) {
            $query->whereHas('penjualan', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal', [$startDate, $endDate]);
            });
        }]);

        if ($barangId) {
            $query->where('id', $barangId);
        }

        $laporan = $query->get()
            ->map(function ($item) use ($startDate, $endDate) {
                // Filter details by date if provided
                $details = $item->detailPenjualans;

                $details = $details->filter(function ($detail) use ($startDate, $endDate) {
                    $tanggal = $detail->penjualan->tanggal;
                    return $tanggal >= $startDate && $tanggal <= $endDate;
                });

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
            ->filter(function ($item) {
                return $item['total_qty'] > 0;
            })
            ->sortByDesc('profit')
            ->values();

        $barangs = Barang::orderBy('nama')->get();

        return view('pages.admin.laporan.penjualanProfitPenjualan', compact('laporan', 'barangs', 'startDate', 'endDate', 'barangId'));
    }
}
