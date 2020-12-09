<?php

namespace App;

use App\Interfaces\InterfaceTransaction;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
  protected $fillable = [
    'user_id',
    'balance',
  ];

  private $typeTransactionEnter = 'enter';

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function deposits()
  {
    return $this->hasMany(Deposit::class);
  }

  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }

  public function topUpBalance($wallet, $amount, InterfaceTransaction $transaction)
  {
    $transaction->createTransaction($wallet, $amount, $this->typeTransactionEnter);

    $walletData['balance'] = $amount + $wallet->balance;

    self::update($walletData);

    return true;
  }

  public function checkBalanceForAvailability($amount)
  {
    $currentBalance = self::only('balance');

    if($amount > $currentBalance['balance']){

      return false;

    }

    return true;
  }

  public function withdraw($amount)
  {
    $currentBalance = self::only('balance');

    $newBalance['balance'] = $currentBalance['balance'] - $amount;

    self::update($newBalance);

    return true;
  }


}
