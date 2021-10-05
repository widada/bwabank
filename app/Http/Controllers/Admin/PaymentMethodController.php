<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::all();

        return view('payment-method', ['payment_methods' => $paymentMethods]);
    }

    public function create()
    {
        return view('payment-method-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,svg',
            'code' => 'required|string',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->except('thumbnail');

        $image = $request->thumbnail;

        $imageName = Str::random(10).'.'.$image->extension();
        
        $uploadImage = $image->storeAs('public', $imageName);
        
        $data['thumbnail'] = $imageName;

        PaymentMethod::create($data);

        return redirect()->route('admin.payment_methods.index')
                ->with('success', 'Payment method created');
    }

    public function edit(Request $request, $id)
    {
        $paymentMethod = PaymentMethod::find($id);

        return view('payment-method-edit', ['payment_method' => $paymentMethod]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,svg',
            'code' => 'required|string',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->except('thumbnail');

        $paymentMethod = PaymentMethod::find($id);

        if ($request->thumbnail) {
            $image = $request->thumbnail;

            $imageName = Str::random(10).'.'.$image->extension();
            
            $uploadImage = $image->storeAs('public', $imageName);
            
            $data['thumbnail'] = $imageName;

            Storage::delete('public/'.$paymentMethod->thumbnail);
        }

        $paymentMethod->update($data);

        return redirect()->route('admin.payment_methods.index')
                ->with('success', 'Payment method updated');
    }

    public function destroy(Request $request, $id)
    {

        $paymentMethod = PaymentMethod::find($id)->delete();

        return redirect()->route('admin.payment_methods.index')
                ->with('success', 'Payment method deleted');
    }
}
