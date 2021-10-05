<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransactionType;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TransactionTypeController extends Controller
{
    public function index()
    {
        $transactionTypes = TransactionType::all();

        return view('transaction-type', ['transaction_types' => $transactionTypes]);
    }

    public function create()
    {
        return view('transaction-type-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,svg',
            'code' => 'required|string',
            'action' => 'required|in:cr,dr'
        ]);

        $data = $request->except('thumbnail');

        $image = $request->thumbnail;

        $imageName = Str::random(10).'.'.$image->extension();
        
        $uploadImage = $image->storeAs('public', $imageName);
        
        $data['thumbnail'] = $imageName;

        TransactionType::create($data);

        return redirect()->route('admin.transaction_types.index')
                ->with('success', 'Transaction type created');
    }

    public function edit(Request $request, $id)
    {
        $transactionType = TransactionType::find($id);

        return view('transaction-type-edit', ['transaction_type' => $transactionType]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,svg',
            'code' => 'required|string',
            'action' => 'required|in:cr,dr'
        ]);

        $data = $request->except('thumbnail');

        $transactionType = TransactionType::find($id);

        if ($request->thumbnail) {
            $image = $request->thumbnail;

            $imageName = Str::random(10).'.'.$image->extension();
            
            $uploadImage = $image->storeAs('public', $imageName);
            
            $data['thumbnail'] = $imageName;

            Storage::delete('public/'.$transactionType->thumbnail);
        }

        $transactionType->update($data);

        return redirect()->route('admin.transaction_types.index')
                ->with('success', 'Transaction type updated');
    }

    public function destroy(Request $request, $id)
    {

        TransactionType::find($id)->delete();

        return redirect()->route('admin.transaction_types.index')
                ->with('success', 'Transaction type deleted');
    }
}
