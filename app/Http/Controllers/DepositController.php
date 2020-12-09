<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\Http\Requests\DepositRequest;
use App\Transaction;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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
     * @param  \Illuminate\Http\Request  $request
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function topUpPercents()
    {
      $deposit = new Deposit();
      $activeDeposits = $deposit->getActiveDeposits();
      $deposit->topUpWalletFromPercents($activeDeposits);

      return redirect()->route('accounts.index');

    }
}
