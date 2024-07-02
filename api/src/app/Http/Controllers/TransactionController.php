<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $transaction = DB::connection('mysql')->table('transactions')->get();
        return response()->json($transaction);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'product_id' => 'required|integer',
            'qty' => 'required|integer',
        ]);

        // Ambil data produk dari database
        $product = DB::connection('mysql')->table('products')->where('id', $request->input('product_id'))->first();

        $qty = $request->input('qty');

        // Periksa apakah stok cukup
        if ((int) $product->qty < (int) $qty) {
            return response()->json([
                'message' => 'Stock qty is not enough',
            ])->setStatusCode(400);
        }

        // Kurangi stok produk di tabel 'products'
        DB::connection('mysql')->table('products')->where('id', $request->input('product_id'))->update([
            'qty' => (int) $product->qty - (int) $qty
        ]);

        // Hitung total transaksi
        $total = (int) $product->price * (int) $qty;

        // Simpan data transaksi ke tabel 'transactions'
        $transaction = [
            'product_id' => $request->input('product_id'),
            'total_transaksi' => $total,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $storeID = DB::connection('mysql')->table('transactions')->insertGetId($transaction);

        // Ambil data transaksi yang baru disimpan
        $data = DB::connection('mysql')->table('transactions')->where('id', $storeID)->first();

        // Buat response
        $response = [
            'success' => true,
            'message' => 'Transaction Added',
            'transaction' => $data,
        ];

        // Kembalikan response dalam format JSON
        return response()->json($response);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $transaction = DB::connection('mysql')->table('transactions')->get();
        return response()->json($transaction);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'product_id' => 'required|integer',
            'qty' => 'required|integer',
        ]);

        $product = DB::connection('mysql')->table('products')->where('id', $request->input('product_id'))->first();
        $qty = $request->input('qty');

        $total = (int) $product->price * (int) $qty;

        $transaction = [
            'id' => $id,
            'product_id' => $request->input('product_id'),
            'total_transaksi' => $total,
        ];

        DB::connection('mysql')->table('transactions')->where('id', $id)->update($transaction);

        $data = DB::connection('mysql')->table('transactions')->where('id', $id)->first();

        $response = [
            'success' => True,
            'message' => 'Transaction Added',
            'transaction' => $data,
        ];



        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
