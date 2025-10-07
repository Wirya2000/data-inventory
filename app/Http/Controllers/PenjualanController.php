<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.penjualan.index', [
            "datas" => Penjualan::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!session()->has('cart_penjualan')) {
            session()->put('cart_penjualan', []);
        }
        return view('pages.admin.penjualan.create', [
            'kategoris' => Kategori::all(),
            'barangs' => Barang::all(),
            'users' => User::where('role', '!=', 'kasir')->get(),
            'customers' => Customer::all(),
            'cart' => session()->get('cart_penjualan', [])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function insertBarangTransaction($cart, $penjualan) {
        // $this->authorize('customer-permission');

        $total = 0;
        foreach($cart as $id => $detail) {
            $total += $detail['harga_satuan'] * $detail['jumlah'];
            $penjualan->barangs()->attach($id, ['jumlah' => $detail['jumlah'], 'harga_satuan' => $detail['harga_satuan']]);

            $barang = Barang::findOrFail($id); // Find the item

            // Update stock value
            $barang->stock -= $detail['jumlah'];
            $barang->save();
        }

        return $total;
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
            'users_id' => 'required',
            'customers_id' => 'required',
            'nama_customer' => 'required',
            'discount' => 'required|numeric',
          ]);

        $cart = session()->get('cart_penjualan');
        $user = Auth::user();
        $p = new Penjualan();
        $p->users_id = $user->id;
        $p->tanggal = Carbon::now()->toDateTimeString();
        $p->total = 0;
        $p->grand_total = 0;
        $p->users_id = $validatedData['users_id'];
        $p->customers_id = $validatedData['customers_id'];
        $p->nama_customer = $validatedData['nama_customer'];
        $p->discount = $validatedData['discount'];
        $p->save();
        $penjualan = Penjualan::find($p->id);

        $totalPrice = $this->insertBarangTransaction($cart, $penjualan);
        $p->total = $totalPrice;
        $p->grand_total = $totalPrice - ($totalPrice * ($validatedData['discount']/100.0));
        $p->save();

        // Penjualan::create($validatedData);

        return redirect('/penjualans')->with('success', 'New Penjualan has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Penjualan $penjualan)
    {
        return view('pages.admin.penjualan.show', [
            'data' => $penjualan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjualan $penjualan)
    {
        return view('pages.admin.penjualan.edit', [
            'data' => $penjualan->load('barangs'),
            'kategories' => Kategori::all(),
            'barangs' => Barang::all(),
            'users' => User::where('role', '!=', 'kasir')->get(),
            'customers' => Customer::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        $rules = ([
            'tanggal' => 'required|max:255'
          ]);

          $validatedData = $request->validate($rules);

          Penjualan::where('id', $penjualan->id)
              ->update($validatedData);

          return redirect('/penjualans')->with('success', 'Penjualan has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjualan $penjualan)
    {
        Penjualan::destroy($penjualan->id);

        return redirect('/penjualans')->with('success', 'Penjualan has been deleted!');
    }

    public function showAddDetailPenjualan(Request $request) {
        // $this->authorize('customer-permission');

        // $id = $request->get('id');
        // $data = Penjualan::find($id);
        // $barangs = Barang::all();
        $kategoris = Kategori::all();

        return response()->json(array(
            'msg' => view('pages.admin.penjualan.showAddDetailPenjualan', compact('kategoris'))->render()
        ), 200);
    }

    public function getBarangsDataByKategori(Request $request) {
        // $this->authorize('customer-permission');

        $barangs = Barang::where('kategoris_id', $request->kategoris_id);

        return response()->json(array(
            'msg' => view('pages.admin.penjualan.showAddDetailPenjualan', compact('barangs'))->render()
        ), 200);
    }

    public function addDetailPenjualan(Barang $barang) {
        $message = $this->addToCart($barang->id);
        $data = $barang;
        $cart = session()->get('cart_penjualan');
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
        $cart = session()->get('cart_penjualan');

        if(!isset ($cart[$id])) {
            $cart[$id]=[
            "kode" => $barang->kode,
            "nama" => $barang->nama,
            "jumlah" => 1,
            "harga_satuan" => $barang->harga_jual,
            ];
            $message = 'Item added to cart!';
        } else {
            $cart[$id]['jumlah']++;
            $message = 'Item quantity updated!';
        }
        session()->put('cart_penjualan', $cart);

        return $message;
    }

    public function updateJumlah(Request $request) {
        // $this->authorize('customer-permission');

        $cart = session()->get('cart_penjualan');

        if (!isset($cart[$request->barang_id])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item not in cart!'
            ], 400); // HTTP 400 = Bad Request
        }

        $barang = Barang::find($request->barang_id);
        if (!$barang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barang not found!'
            ], 404); // Not Found
        }

        if ($barang->stock >= $request->jumlah) {
            $cart[$request->barang_id]['jumlah'] = $request->jumlah;
            session()->put('cart_penjualan', $cart);

            return response()->json([
                'status' => 'success',
                'message' => 'Item quantity updated!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient stock items! (stock:'. $barang->stock. ')',
                'stock' => $barang->stock
            ], 400);
        }
    }

    public function removeFromCart($barang_id) {
        // $this->authorize('customer-permission');

        $cart = session()->get('cart_penjualan');

        // if(isset($cart[$request->get('id')])) {
        //     session()->forget('cart.' . $request->get('id'));
        // } else {
        //     return response()->json(array(
        //         'status'=>400,
        //         'msg' => "Failed to remove barang from cart!"
        //     ), 400);
        // }

        // return response()->json(array(
        //     'status'=>200,
        //     'msg' => "Barang removed from cart successfully!"
        // ), 200);

        if(isset($cart[$barang_id])) {
            session()->forget('cart_penjualan.' . $barang_id);
            return response()->json(array(
                'status'=>200,
                'message' => "Barang removed from cart successfully!"
            ), 200);
        } else {
            return response()->json(array(
                'status'=>400,
                'message' => "Failed to remove barang from cart!"
            ), 400);
        }
    }

    public function getDataBarangSelected(Barang $barang) {
        $data = [
            'harga_jual' => $barang->harga_jual,
            'stock' => $barang->stock
        ];
        return response()->json(array(
            'status'=>200,
            'message' => $data
        ), 200);
    }
}
