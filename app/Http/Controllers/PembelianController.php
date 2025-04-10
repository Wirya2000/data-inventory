<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Pembelian;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
        session()->forget('cart_pembelian');
        return view('pages.admin.pembelian.create', [
            'kategoris' => Kategori::all(),
            'barangs' => Barang::all(),
            'users' => User::where('role', '!=', 'kasir')->get(),
            'suppliers' => Supplier::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function insertBarangTransaction($cart, $pembelian) {
        // $this->authorize('customer-permission');

        $total = 0;
        foreach($cart as $id => $detail) {
            $total += $detail['harga_satuan'] * $detail['jumlah'];
            $pembelian->barangs()->attach($id, ['jumlah' => $detail['jumlah'], 'harga_satuan' => $detail['harga_satuan']]);

            $barang = Barang::findOrFail($id); // Find the item

            // Update stock value
            $barang->stock += $detail['jumlah'];
        }

        return $total;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'users_id' => 'required',
            'suppliers_id' => 'required'
          ]);

        $cart = session()->get('cart_pembelian');
        $user = Auth::user();
        $p = new Pembelian();
        $p->users_id = $user->id;
        $p->tanggal_beli = Carbon::now()->toDateTimeString();
        $p->total = 0;
        $p->users_id = $validatedData['users_id'];
        $p->suppliers_id = $validatedData['suppliers_id'];
        $p->save();
        $pembelian = Pembelian::find($p->id);

        $totalPrice = $this->insertBarangTransaction($cart, $pembelian);
        $p->total = $totalPrice;
        $p->save();

        // Pembelian::create($validatedData);

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

        // $id = $request->get('id');
        // $data = Pembelian::find($id);
        // $barangs = Barang::all();
        $kategoris = Kategori::all();

        return response()->json(array(
            'msg' => view('pages.admin.pembelian.showAddDetailPembelian', compact('kategoris'))->render()
        ), 200);
    }

    public function getBarangsDataByKategori(Request $request) {
        // $this->authorize('customer-permission');

        $barangs = Barang::where('kategoris_id', $request->kategoris_id);

        return response()->json(array(
            'msg' => view('pages.admin.pembelian.showAddDetailPembelian', compact('barangs'))->render()
        ), 200);
    }

    public function addDetailPembelian(Barang $barang) {
        $message = $this->addToCart($barang->id);
        $data = $barang;
        $cart = session()->get('cart_pembelian');
        $data['jumlah'] = $cart[$barang->id]['jumlah'];
        return response()->json(array(
            'status'=>200,
            'message' => $message,
            'data' => $data
        ), 200);
    }

    public function addToCart($id) {
        // $this->authorize('customer-permission');

        $barang = Barang::find($id);
        $cart = session()->get('cart_pembelian');

        if(!isset ($cart[$id])) {
            $cart[$id]=[
            "kode" => $barang->kode,
            "nama" => $barang->nama,
            "jumlah" => 1,
            "harga_satuan" => $barang->harga_beli,
            ];
            $message = 'Item added to cart!';
        } else {
            $cart[$id]['jumlah']++;
            $message = 'Item quantity updated!';
        }
        session()->put('cart_pembelian', $cart);

        return $message;
    }

    public function updateJumlah($id) {
        // $this->authorize('customer-permission');

        $barang = Barang::find($id);
        $cart = session()->get('cart_pembelian');

        if(!isset ($cart[$id])) {
            $cart[$id]=[
            "kode" => $barang->kode,
            "nama" => $barang->nama,
            "jumlah" => 1,
            "harga_satuan" => $barang->harga_beli,
            ];
            $message = 'Item added to cart!';
        } else {
            $cart[$id]['jumlah']++;
            $message = 'Item quantity updated!';
        }
        session()->put('cart_pembelian', $cart);

        return redirect()->back()->with('status', $message);
    }

    public function removeFromCart(Request $request) {
        // $this->authorize('customer-permission');

        $cart = session()->get('cart_pembelian');

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

    public function getDataHargaJual(Barang $barang) {
        return response()->json(array(
            'status'=>200,
            'message' => $barang->harga_beli
        ), 200);
    }
}
