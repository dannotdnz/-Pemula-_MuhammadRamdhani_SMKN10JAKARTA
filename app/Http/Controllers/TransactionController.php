<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function addToCart(Request $request)
    {
        $user_id = $request->user_id;
        $product_id = $request->product_id;
        $status = 'dikeranjang';
        $price = $request->price;
        $quantity = $request->quantity;

        Transaction::create([
            'user_id'=>$user_id,
            'product_id'=>$product_id,
            'status'=>$status,
            'price'=>$price,
            'quantity'=>$quantity,
        ]);

        return redirect()->back()->with('status', 'Berhasil Menambah Keranjang');
     }

     public function payNow(Request $request)
     {
        $product = Product::find($request->product_id);

        $status = 'dibayar';
        $order_code = 'INV_' . Auth::user()->id . date('YMdHis');

        $carts = Transaction::where('user_id', Auth::user()->id)->where('status', 'dikeranjang')->get();
        $total_debit = 0;

        foreach($carts as $cart)
        {
            Transaction::find($cart->id)->update([
                'status' => $status,
                'order_code' => $order_code
            ]);

            Product::find($cart->product->id)->update([
                'stock' => $cart->product->stock - $cart->quantity
            ]);
        }

        Wallet::create([
            'user_id' => Auth::user()->id,
            'debit' => $total_debit,
            'description' => 'pembelian produk'
        ]);

        foreach($carts as $cart)
        {
            Transaction::find($cart->id)->update([
                'status' => $status,
                'order_code' => $order_code
            ]);
        }

        return redirect()->back()->with('status', 'Berhasil Membayar Transaksi');
     }
     public function download($order_code)
     {
        $transactions = Transaction::where('order_code', $order_code)->get();

        $total_biaya = 0;

        foreach($transactions as $transaction){
            $total_price = $transaction->price * $transaction->quantity;

            $total_biaya += $total_price;
        }
        return view('receipt', compact('transactions', 'total_biaya'));
     }

}