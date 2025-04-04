<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Satuan;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.barang.index', [
            "datas" => Barang::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // dd((Barang::where('kategoris_id',Kategori::first()->id)->first()->kode));
        ;
        // dd(substr((Barang::where('kategoris_id',Kategori::first()->id)->first()->kode), -3));
        // $no_kode = str_pad(substr((Barang::where('kategoris_id',Kategori::first()->id)->latest()->first()->kode), -3)+1,3, '0', 0);
        $kategori = Kategori::first(); // Get the first category
        $barangTerakhir = Barang::where('kategoris_id', $kategori->id)->latest()->first();

        $lastKode = $barangTerakhir ? substr($barangTerakhir->kode, -3) : '000'; // If no barang, use '000'
        $no_kode = str_pad($lastKode + 1, 3, '0', STR_PAD_LEFT);

        $kode_kategori = Kategori::first()->kode;
        $kode = $kode_kategori . $no_kode;
        return view('pages.admin.barang.create', [
            'kategoris' => Kategori::all(),
            'satuans' => Satuan::all(),
            'kode' => $kode,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode' => 'required|max:20',
            'nama' => 'required|max:255',
            'satuan' => 'required|max:255',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'kategoris_id' => 'required',
          ]);

          $validatedData['stock'] = 0;

          Barang::create($validatedData);

          return redirect('/barangs')->with('success', 'New Barang has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        return view('pages.admin.barangs.show', [
            'data' => $barang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang)
    {
        return view('pages.admin.barang.edit', [
            'kategoris' => Kategori::all(),
            'satuans' => Satuan::all(),
            'data' => $barang
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barang $barang)
    {
        $rules = ([
            'nama' => 'required|max:255',
            'satuan' => 'required|max:255',
            // 'stock' => 'required|max:255',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric'
        ]);

        $validatedData = $request->validate($rules);

        Barang::where('id', $barang->id)
            ->update($validatedData);

        return redirect('/barangs')->with('success', 'Barang has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        Barang::destroy($barang->id);

        return redirect('/barangs')->with('success', 'Barang has been deleted!');
    }

    public function getKodeBarang(Request $request) {
        $no_kode = str_pad(substr((Barang::where('kategoris_id',Kategori::find($$request->kategoris_id)->id)->latest()->first()->kode), -3)+1,3, '0', 0);
        $kode_kategori = Kategori::first()->kode;
        $kode = $kode_kategori . $no_kode;
        return $kode;
    }
}
