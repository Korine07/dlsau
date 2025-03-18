<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'expected_guests',
        'check_in_date',
        'check_out_date',
        'check_in_time',
        'check_out_time',
        'memtyp',
        'activity_nature',
        'total_hours',
        'total_price',
        'status',
    ];
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
    public function services()
    {
        return $this->belongsToMany(Services::class, 'reservation_services', 'reservation_id', 'service_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

}
