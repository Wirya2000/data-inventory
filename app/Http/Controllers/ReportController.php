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
}
