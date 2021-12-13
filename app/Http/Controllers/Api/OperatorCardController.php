<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OperatorCard;

class OperatorCardController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit') !== null ? $request->query('limit') : 10;

        $operatorCards = OperatorCard::with('dataPlans')
                        ->where('status', 'active')->paginate($limit);

        $operatorCards->getCollection()->transform(function ($item) {
            $item->thumbnail = $item->thumbnail ? 
                url($item->thumbnail) : "";
            return $item;
        });

        return response()->json($operatorCards);
    }
}
