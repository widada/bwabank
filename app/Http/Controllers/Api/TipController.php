<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tip;

class TipController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit') !== null ? $request->query('limit') : 10;

        $tips = Tip::select('id', 'title', 'url', 'thumbnail')->paginate($limit);

        $tips->getCollection()->transform(function ($item) {
            $item->thumbnail = $item->thumbnail ? 
                url('storage/'.$item->thumbnail) : "";
            return $item;
        });
        
        return response()->json($tips);
    }
}
