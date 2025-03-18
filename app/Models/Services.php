<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'price'];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_services', 'service_id', 'reservation_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }


}
