<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailPembelian;
use App\Models\Kategori;
use App\Models\Pembelian;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // Jangan reset cart, hanya inisialisasi jika belum ada
        if (!session()->has('cart_pembelian')) {
            session()->put('cart_pembelian', []);
        }
        return view('pages.admin.pembelian.create', [
            'kategoris' => Kategori::all(),
            'barangs' => Barang::all(),
            'users' => User::where('role', '!=', 'kasir')->get(),
            'suppliers' => Supplier::all(),
            'cart' => session()->get('cart_pembelian', [])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function insertBarangTransaction($cart, $pembelian)
    {
        $total = 0;

        foreach ($cart as $id => $detail) {

            // VALIDASI
            if (!$detail['jumlah'] || $detail['jumlah'] <= 0) {
                throw new \Exception("Jumlah barang kosong");
            }

            if (!$detail['harga_satuan'] || $detail['harga_satuan'] <= 0) {
                throw new \Exception("Harga barang kosong");
            }

            $barang = Barang::findOrFail($id);

            $subtotal = $detail['harga_satuan'] * $detail['jumlah'];
            $total += $subtotal;

            // simpan batch FIFO
            DetailPembelian::create([
                'pembelians_id' => $pembelian->id,
                'barangs_id' => $id,
                'jumlah' => $detail['jumlah'],
                'sisa_qty' => $detail['jumlah'],
                'harga_satuan' => $detail['harga_satuan']
            ]);

            // update stok
            $barang->increment('stock', $detail['jumlah']);
        }

        return $total;
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart_pembelian', []);

        if (empty($cart)) {
            return redirect()->back()->withErrors(['message' => 'Cart masih kosong!']);
        }

        $validatedData = $request->validate([
            'users_id' => 'required',
            'suppliers_id' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $pembelian = Pembelian::create([
                'users_id' => $validatedData['users_id'],
                'suppliers_id' => $validatedData['suppliers_id'],
                'tanggal_beli' => now(),
                'total' => 0
            ]);

            $totalPrice = $this->insertBarangTransaction($cart, $pembelian);

            $pembelian->update([
                'total' => $totalPrice
            ]);

            DB::commit();


            session()->forget('cart_pembelian');

            return redirect('/pembelians')->with('success', 'Pembelian berhasil disimpan!');

        } catch (\Exception $e) {

            DB::rollBack();
            return redirect()->back()->withErrors([
                'message' => 'Terjadi kesalahan: '.$e->getMessage()
            ]);
        }
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
        return view('pages.admin.pembelian.edit', [
            'data' => $pembelian->load('details.barang'),
            'kategories' => Kategori::all(),
            'barangs' => Barang::all(),
            'users' => User::where('role', '!=', 'kasir')->get(),
            'suppliers' => Supplier::all(),
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
        $rules = [
            'tanggal_beli' => 'required|date',
            'users_id' => 'required|exists:users,id',
            'suppliers_id' => 'required|exists:suppliers,id'
        ];

        $validatedData = $request->validate($rules);

        DB::beginTransaction();

        try {
            $pembelian->update($validatedData);

            DB::commit();

            return redirect('/pembelians')->with('success', 'Pembelian has been updated!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
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

    public function addDetailPembelian(Barang $barang, $harga_beli) {
        $message = $this->addToCart($barang->id, $harga_beli);
        $data = $barang;
        $cart = session()->get('cart_pembelian', []);
        $data['jumlah'] = $cart[$barang->id]['jumlah'];
        $data['harga_beli'] = $cart[$barang->id]['harga_satuan'];
        return response()->json(array(
            'status'=>200,
            'message' => $message,
            'data' => $data
        ), 200);
    }

    public function addToCart($id, $harga_beli = null) {
        // $this->authorize('customer-permission');

        $barang = Barang::find($id);
        $cart = session()->get('cart_pembelian', []);

        if(!isset ($cart[$id])) {
            $cart[$id]=[
            "kode" => $barang->kode,
            "nama" => $barang->nama,
            "jumlah" => 1,
            "harga_satuan" => (int)$harga_beli,
            ];
            $message = 'Item added to cart!';
        } else {
            $cart[$id]['jumlah']++;
            $message = 'Item quantity updated!';
        }
        session()->put('cart_pembelian', $cart);

        return $message;
    }

    public function updateJumlah(Request $request) {
        // $this->authorize('customer-permission');

        $cart = session()->get('cart_pembelian', []);

        if(!isset ($cart[$request->barang_id])) {
            $message = 'Item not in cart!';
        } else {
            $cart[$request->barang_id]['jumlah'] = $request->jumlah;
            $message = 'Item quantity updated!';
        }
        session()->put('cart_pembelian', $cart);

        return redirect()->back()->with('status', $message);
    }

    public function removeFromCart($barang_id) {
        // $this->authorize('customer-permission');

        $cart = session()->get('cart_pembelian', []);

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
            session()->forget('cart_pembelian.' . $barang_id);
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

    public function cart() {
        // $this->authorize('customer-permission');

        return view('customer.cart');
    }

    // public function getDataHargaBeli(Barang $barang) {
    //     return response()->json(array(
    //         'status'=>200,
    //         'message' => $barang->harga_beli
    //     ), 200);
    // }
}
