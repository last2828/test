<?php

namespace App\Interfaces;

interface InterfaceTransaction
{
  public static function createTransaction($wallet, $amount, $type);
}