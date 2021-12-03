<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransferHistory;

class TransferHistoryController extends Controller
{
    public function index(Request $request)
    {

        $limit = $request->query('limit') !== null ? $request->query('limit') : 10;

        $transferHistories = TransferHistory::with('receiverUser:id,name,username,verified,profile_picture')
                            ->groupBy('receiver_id')
                            ->paginate($limit);

        $transferHistories->getCollection()->transform(function ($item) {
            $receiverUser = $item->receiverUser;
            $item->receiverUser->profile_picture =  $receiverUser->profile_picture ? 
                url('storage/'.$receiverUser->profile_picture) : "";
            return $item;
        });
        
        return response()->json($transferHistories);

    }
}
