<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'check_in_date',
        'check_out_date',
        'memtyp',
        'total_price',
        'status',
    ];
}
