<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tip;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TipController extends Controller
{
    public function index()
    {
        $tips = Tip::all();

        return view('tip', ['tips' => $tips]);
    }

    public function create()
    {
        return view('tip-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg',
            'url' => 'required|url',
        ]);

        $data = $request->except('thumbnail');

        $image = $request->thumbnail;

        $imageName = Str::random(10).'.'.$image->extension();
        
        $uploadImage = $image->storeAs('public', $imageName);
        
        $data['thumbnail'] = $imageName;

        Tip::create($data);

        return redirect()->route('admin.tips.index')
                ->with('success', 'Tip created');
    }

    public function edit(Request $request, $id)
    {
        $tip = Tip::find($id);

        return view('tip-edit', ['tip' => $tip]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'thumbnail' => 'image|mimes:jpeg,png,jpg',
            'url' => 'required|url',
        ]);

        $data = $request->except('thumbnail');

        $tip = Tip::find($id);

        if ($request->thumbnail) {

            $image = $request->thumbnail;

            $imageName = Str::random(10).'.'.$image->extension();
            
            $uploadImage = $image->storeAs('public', $imageName);
            
            $data['thumbnail'] = $imageName;

            Storage::delete('public/'.$tip->thumbnail);
        }

        $tip->update($data);

        return redirect()->route('admin.tips.index')
                ->with('success', 'Tip updated');
    }

    public function destroy(Request $request, $id)
    {
        Tip::find($id)->delete();

        return redirect()->route('admin.tips.index')
                ->with('success', 'Tip deleted');
    }
}
