<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public $incrementing = false;
    use HasFactory;

    protected $fillable = [
        'id',
        'make',
        'model',
        'year',
        'price_per_day',
        'availability_status'
    ];

    protected $hidden = ['password'];
}
