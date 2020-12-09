<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\Http\Requests\DepositRequest;
use App\Transaction;
use App\Wallet;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      try{
        $wallet = Wallet::where('user_id', Auth::id())->firstOrFail();

        return view('account.create-deposit', compact('wallet'));

      }catch(\Exception $e){

        return redirect()->back()->withErrors(['error' => $e->getMessage()]);

      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DepositRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepositRequest $request)
    {
      $validated = $request->validated();
      $invested = $request->invested;

      try{

        $wallet = Wallet::with('user')->where('user_id', Auth::id())->firstOrFail();

        if(!(Auth::id() === $wallet->user->id))
        {
          throw new \Exception('Access Denied');
        }

        $result = $wallet->checkBalanceForAvailability($invested);

        if(!$result)
        {
          throw new \Exception('Top up you wallet');
        }

        $wallet->withdraw($invested);

        $deposit = new Deposit();
        $deposit->createDeposit($wallet, $invested, new Transaction);

        return redirect()->route('accounts.index');

      }catch(\Exception $e){

        return redirect()->back()->withErrors(['error' => $e->getMessage()]);

      }
    }
}
