<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Pembelian;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.pembelian.index', [
            "datas" => Pembelian::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.pembelian.create', [
            'kategoris' => Kategori::all(),
            'barangs' => Barang::all(),
            'users' => User::all(),
            'suppliers' => Supplier::all()
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
            'tanggal_beli' => 'required|max:255'
          ]);

          Pembelian::create($validatedData);

          return redirect('/pembelians')->with('success', 'New Pembelian has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function show(Pembelian $pembelian)
    {
        return view('pages.admin.pembelian.show', [
            'data' => $pembelian
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembelian $pembelian)
    {
        return view('pages.admin.barang.edit', [
            'data' => $pembelian
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        $rules = ([
            'tanggal_beli' => 'required|max:255'
          ]);

          $validatedData = $request->validate($rules);

          Pembelian::where('id', $pembelian->id)
              ->update($validatedData);

          return redirect('/pembelians')->with('success', 'Pembelian has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembelian $pembelian)
    {
        Pembelian::destroy($pembelian->id);

        return redirect('/pembelians')->with('success', 'Pembelian has been deleted!');
    }


    public function showAddDetailPembelian(Request $request) {
        // $this->authorize('customer-permission');

        $id = $request->get('id');
        // $data = Pembelian::find($id);
        $barangs = Barang::all();

        return response()->json(array(
            'msg' => view('pages.admin.pembelian.showAddDetailPembelian', compact('barangs'))->render()
        ), 200);
    }

    public function addToCart($id) {
        // $this->authorize('customer-permission');

        $barang = Barang::find($id);
        $cart = session()->get('cart');

        if(!isset($cart[$id])) {
            $cart[$id]=[
            "name" => $barang->nama,
            "quantity" => 1,
            "price" => $barang->harga_jual,
            ];
        } else {
            $cart[$id]['quantity']++;
        }
        session()->put('cart', $cart);

        return redirect()->back()->with('status', 'Barang added to cart successfully!');
    }
    public function removeFromCart(Request $request) {
        // $this->authorize('customer-permission');

        $cart = session()->get('cart');

        if(isset($cart[$request->get('id')])) {
            session()->forget('cart.' . $request->get('id'));
        } else {
            return response()->json(array(
                'status'=>400,
                'msg' => "Failed to remove barang from cart!"
            ), 400);
        }

        return response()->json(array(
            'status'=>200,
            'msg' => "Barang removed from cart successfully!"
        ), 200);
    }

    public function cart() {
        // $this->authorize('customer-permission');

        return view('customer.cart');
    }
}
