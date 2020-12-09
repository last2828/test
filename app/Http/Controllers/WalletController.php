<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletRequest;
use App\Transaction;
use App\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
      try{
        $wallet = Wallet::where('user_id', Auth::id())->firstOrFail();

        return view('account.top-up-balance', compact('wallet'));

      }catch(\Exception $e){

        return redirect()->back()->withErrors(['error' => $e->getMessage()]);

      }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\WalletRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(WalletRequest $request)
    {
      $validated = $request->validated();

      $amount = $request->balance;

      try{

        $wallet = Wallet::with('user')->where('user_id', Auth::id())->firstOrFail();

        if(!(Auth::id() === $wallet->user->id))
        {
          throw new \Exception('Access Denied');
        }

        $wallet->topUpBalance($wallet, $amount, new Transaction);

        return redirect()->route('accounts.index');

      }catch(\Exception $e){

        return redirect()->back()->withErrors(['error' => $e->getMessage()]);

      }
    }

}
