<?php

use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use Melihovv\Base64ImageDecoder\Base64ImageDecoder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

function pinChecker($pin) {
    $userId = auth()->user()->id;
    $wallet = Wallet::find($userId);

    if ($wallet == null) return false;

    if (Hash::check($pin, $wallet->pin)) return true;
    return false;
}

function uploadBase64Image($base64Image) {
    $decoder = new Base64ImageDecoder($base64Image, $allowedFormats = ['jpeg', 'png', 'jpg']);
    $decodedContent = $decoder->getDecodedContent();
    $format = $decoder->getFormat();
    $image = Str::random(10).'.'.$format;
    Storage::disk('public')->put($image, $decodedContent);

    return $image;
}