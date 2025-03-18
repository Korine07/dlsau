<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'reason'];

    public function getDateAttribute($value)
{
    return Carbon::parse($value)->timezone('Asia/Manila')->format('Y-m-d');
}
}
