<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable = ['start_date', 'end_date', 'reason'];

    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->timezone('Asia/Manila')->format('Y-m-d');
    }

    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value)->timezone('Asia/Manila')->format('Y-m-d');
    }
}
