<?php

use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;

function pinChecker($pin) {
    $userId = auth()->user()->id;
    $wallet = Wallet::find($userId);

    if (Hash::check($pin, $wallet->pin)) return true;
    return false;
}