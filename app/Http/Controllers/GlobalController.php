<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class GlobalController extends Controller
{
    public function getDataListBarang(Request $request) {
        $datas = Barang::where('kategoris_id', $request->kategori_id)->get();
        return response()->json(array(
            'status'=>200,
            'message' => $datas
        ), 200);
    }

    public function getDataKategoriBarang() {
        $datas = Kategori::all();
        return response()->json(array(
            'status'=>200,
            'message' => $datas
        ), 200);
    }
}
