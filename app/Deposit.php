<?php

namespace App;

use App\Interfaces\InterfaceTransaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Deposit extends Model
{
  protected $fillable = [
    'user_id',
    'wallet_id',
    'invested',
    'percent',
    'active',
    'duration',
    'accrue_times',
  ];

  private $percent = 20;
  private $duration = 10;
  private $active = 1;

  private $typeTransactionCreateDeposit = 'create_deposit';
  private $typeTransactionAccrue = 'accrue';
  private $typeTransactionCloseDeposit = 'close_deposit';

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function wallet()
  {
    return $this->belongsTo(Wallet::class);
  }

  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }

  public function createDeposit($wallet, $invested, InterfaceTransaction $transaction)
  {
    $transaction->createTransaction($wallet, $invested, $this->typeTransactionCreateDeposit);

    $depositData = [
      'user_id' => $wallet->user->id,
      'wallet_id' => $wallet->id,
      'invested' => $invested,
      'active' => $this->active,
      'percent' => self::percentageOf($this->percent, $invested),
      'duration' => $this->duration,
    ];

    self::create($depositData);

    return true;
  }

  public static function percentageOf($percent, $invested, $decimals = 2)
  {
    return round($invested / 100 * $percent, $decimals);
  }

  public static function topUpPercents()
  {
    $deposit = new Deposit();
    $activeDeposits = $deposit->getActiveDeposits();
    $deposit->topUpWalletFromPercents($activeDeposits);

    return true;
  }

  public function getActiveDeposits()
  {
    $time = Carbon::now()->subMinute()->toDateTimeString();

    $activeDeposits = Deposit::with('wallet')
      ->where('active', true)
      ->where('created_at', '<', $time)
      ->get();

    return $activeDeposits;
  }

  public function topUpWalletFromPercents($activeDeposits)
  {
    foreach($activeDeposits as $deposit)
    {
      if($deposit->accrue_times < 9)
      {
        $transactionType = $this->typeTransactionAccrue;
      }elseif($deposit->accrue_times === 9){
        $transactionType = $this->typeTransactionCloseDeposit;
      }

      Transaction::createTransaction($deposit->wallet, $deposit['percent'], $transactionType);

      $walletData['balance'] = $deposit['percent'] + $deposit->wallet->balance;
      $deposit->wallet->update($walletData);

      $deposit->updateDeposit($deposit);

    }

    return true;
  }

  public function updateDeposit($deposit)
  {
    if($deposit->accrue_times < 9){
      $depositData['accrue_times'] = $deposit->accrue_times + 1;
    }elseif($deposit->accrue_times === 9){
      $depositData['accrue_times'] = $deposit->accrue_times + 1;
      $depositData['active'] = 0;
    }

    $deposit->update($depositData);

    return true;
  }

}
