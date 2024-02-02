<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function TopUpNow(Request $request)
    {
        $user_id = Auth::user()->id;
        $credit = $request->credit;
        $status = "proses";
        $description = "Top Up Saldo";

        Wallet::create([
            'user_id' => $user_id,
            'credit' => $credit,
            'status' => $status,
            'description' => $description
        ]);

        return redirect()->back()->with('status','Berhasil Top Up, Silahkan Menunggu Konfirmasi');
    }

    public function withdrawNow(Request $request)
    {
        $user_id = Auth::user()->id;
        $debit = $request->debit;
        $status = "proses";
        $description = 'narik uang';

        Wallet::create([
            'user_id' => $user_id,
            'debit' => $debit,
            'status' => $status,
            'description' => $description
        ]);

        return redirect()->back()->with('status', 'Berhasil withdraw, Silahkan Menunggu Konfirmasi');
    }

    public function topupFromBank(Request $request){
        Wallet::create([
            'credit' => $request->credit,
            'status' => 'selesai',
            'user_id' => $request->user_id,
            'description' => 'topup'

        ]);
        return redirect()->back()->with('status', 'berhasil');
    }

    public function withdrawFromBank(Request $request){
        Wallet::create([
            'debit' => $request->debit,
            'status' => 'selesai',
            'user_id' => $request->user_id,
            'description' => 'withdraw'

        ]);

        return redirect()->back()->with('status', 'berhasil');
    }

    public function request_topup(Request $request, string $id)
    {
        Wallet::find($id)->update([
            'status' => 'selesai'
        ]);

        return redirect()->back()->with('status','Berhasil Konfirmasi');
    }

    public function topup()
    {
        $wallets = Wallet::with('user')->where('status', 'selesai')->get();
        return view('topup', compact('wallets'));
    }
    public function withdraw()
    {
        $wallets = Wallet::with('user')->where('status', 'selesai')->get();
        return view('withdraw', compact('wallets'));
    }
}
