<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.satuan.index', [
            "datas" => Satuan::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.satuan.create', [
            // 'satuans' => Satuan::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
          ]);

          Satuan::create($validatedData);

          return redirect('/satuans')->with('success', 'New Satuan has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Satuan $satuan)
    {
        return view('pages.admin.satuan.show', [
            'data' => $satuan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Satuan $satuan)
    {
        return view('pages.admin.satuan.edit', [
            'data' => $satuan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Satuan $satuan)
    {
        $rules = ([
            'nama' => 'required|max:255',
          ]);

          $validatedData = $request->validate($rules);

          Satuan::where('id', $satuan->id)
              ->update($validatedData);

          return redirect('/satuans')->with('success', 'Satuan has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Satuan $satuan)
    {
        Satuan::destroy($satuan->id);

        return redirect('/satuans')->with('success', 'Satuan has been deleted!');
    }
}
