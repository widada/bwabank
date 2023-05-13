<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createOrder(Request $request)
{
    // Validasi input
    $validatedData = $request->validate([
        'customer_name' => 'required|string|max:255',
        'product_name' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
    ]);

    

    // Buat order baru
    $order = new Order();
    $order->customer_name = $validatedData['customer_name'];
    $order->product_name = $validatedData['product_name'];
    $order->quantity = $validatedData['quantity'];
    $order->price = $validatedData['price'];
    $order->save();

    // Redirect ke halaman yang menampilkan detail order
    return redirect()->route('order.show', ['id' => $order->id]);
}
}
