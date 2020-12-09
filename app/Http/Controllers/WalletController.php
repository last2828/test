<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletRequest;
use App\Transaction;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
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
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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
}
