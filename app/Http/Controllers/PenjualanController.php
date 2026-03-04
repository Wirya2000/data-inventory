<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\DetailPembelian;
use App\Models\DetailPenjualanBatch;
use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    private function insertBarangTransaction($cart, $penjualan)
    {
        $total = 0;
        $totalModal = 0;

        foreach ($cart as $id => $detail) {

            $subtotal = $detail['harga_satuan'] * $detail['jumlah'];
            $total += $subtotal;

            $detailPenjualan = DetailPenjualan::create([
                'penjualan_id' => $penjualan->id,
                'barang_id' => $id,
                'jumlah' => $detail['jumlah'],
                'harga_jual' => $detail['harga_satuan'],
                'subtotal' => $subtotal,
                'total_modal' => 0
            ]);

            $modal = $this->prosesFIFO($id, $detail['jumlah'], $detailPenjualan->id);

            $detailPenjualan->update([
                'total_modal' => $modal
            ]);

            $totalModal += $modal;

            $barang = Barang::findOrFail($id);
            $barang->stock -= $detail['jumlah'];
            $barang->save();
        }

        return [
            'total' => $total,
            'modal' => $totalModal
        ];
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

        DB::beginTransaction();

        try {

            $penjualan = Penjualan::create([
                'users_id' => $validatedData['users_id'],
                'customers_id' => $validatedData['customers_id'],
                'nama_customer' => $validatedData['nama_customer'],
                'tanggal' => now(),
                'discount' => $validatedData['discount'],
                'total' => 0,
                'grand_total' => 0,
                'total_modal' => 0,
                'total_laba' => 0
            ]);

            $result = $this->insertBarangTransaction($cart, $penjualan);

            $total = $result['total'];
            $modal = $result['modal'];

            $grandTotal = $total - ($total * ($validatedData['discount']/100));

            $laba = $grandTotal - $modal;

            $penjualan->update([
                'total' => $total,
                'grand_total' => $grandTotal,
                'total_modal' => $modal,
                'total_laba' => $laba
            ]);

            DB::commit();

            session()->forget('cart_penjualan');

            return redirect('/penjualans')->with('success', 'Penjualan berhasil disimpan!');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->withErrors([
                'message' => $e->getMessage()
            ]);
        }
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

    private function prosesFIFO($barang_id, $qty, $detailPenjualanId)
    {
        $totalModal = 0;

        $batches = DetailPembelian::where('barang_id', $barang_id)
            ->where('sisa_qty', '>', 0)
            ->orderBy('id', 'asc')
            ->lockForUpdate()
            ->get();

        foreach ($batches as $batch) {

            if ($qty <= 0) break;

            $ambil = min($batch->sisa_qty, $qty);

            $subtotalModal = $ambil * $batch->harga_satuan;

            DetailPenjualanBatch::create([
                'detail_penjualan_id' => $detailPenjualanId,
                'detail_pembelian_id' => $batch->id,
                'qty_diambil' => $ambil,
                'harga_beli' => $batch->harga_satuan,
                'subtotal_modal' => $subtotalModal
            ]);

            $batch->sisa_qty -= $ambil;
            $batch->save();

            $totalModal += $subtotalModal;
            $qty -= $ambil;
        }

        if ($qty > 0) {
            throw new \Exception("Stock batch tidak cukup");
        }

        return $totalModal;
    }
}
