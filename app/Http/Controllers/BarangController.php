<?php

namespace App\Http\Controllers;

use App\Models\Barang;
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
        return view('pages.admin.barang.create', [
            // 'categories' => Category::all()
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
            'kode' => 'required|max:255',
            'nama' => 'required|max:255',
            'satuan' => 'required|max:255',
            'stock' => 'required|max:255',
            'harga_beli' => 'required|max:255',
            'harga_jual' => 'required|max:255'
          ]);

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
            'stock' => 'required|max:255',
            'harga_beli' => 'required|max:255',
            'harga_jual' => 'required|max:255'
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
}
