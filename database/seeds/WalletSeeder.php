<?php

use App\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Wallet::truncate();

      $wallets = [
        [
          'user_id' => '1'
        ],
        [
          'user_id' => '2',
          'balance' => '500'
        ],
        [
          'user_id' => '3',
          'balance' => '125.55'
        ]
      ];

      foreach($wallets as $wallet)
      {
        Wallet::create($wallet);
      }

    }
}
