<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tip extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tips';

    protected $fillable = [
        'title',
        'thumbnail',
        'url'
    ];
}
