<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPlanHistory extends Model
{
    use HasFactory;

    protected $table = 'data_plan_histories';

    protected $fillable = [
        'data_plan_id',
        'transaction_id',
        'phone_number'
    ];
}
