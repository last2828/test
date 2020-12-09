<?php

namespace App\Http\Controllers;

use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
  public function index()
  {
    $wallet = Wallet::with(['deposits', 'transactions'])->where('user_id', Auth::id())->first();

    return view('account.index', compact('wallet'));
    }
}
