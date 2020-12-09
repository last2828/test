<?php

namespace App;

use App\Interfaces\InterfaceTransaction;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model implements InterfaceTransaction
{
  protected $fillable = [
    'type',
    'user_id',
    'wallet_id',
    'deposit_id',
    'amount',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function wallet()
  {
    return $this->belongsTo(Wallet::class);
  }

  public function deposit()
  {
    return $this->belongsTo(Deposit::class);
  }

  public static function createTransaction($wallet, $amount, $type)
  {
    $transactionData = [
      'type' => $type,
      'user_id' => $wallet->user->id,
      'wallet_id' => $wallet->id,
      'amount' => $amount,
    ];

    self::create($transactionData);

    return true;
  }

}
