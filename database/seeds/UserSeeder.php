<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      User::truncate();

      $users = [
        [
          'login' => 'user1',
          'email' => 'user1@email.com',
          'password' => Hash::make('password'),
        ],
        [
          'login' => 'user2',
          'email' => 'user2@email.com',
          'password' => Hash::make('password'),
        ],
        [
          'login' => 'user3',
          'email' => 'user3@email.com',
          'password' => Hash::make('password'),
        ]
      ];

      foreach($users as $user)
      {
        User::create($user);
      }
    }
}
