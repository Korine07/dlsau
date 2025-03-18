<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pending extends Model
{
    protected $table = 'pending';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'address', 'mobile'];

    use HasFactory;
    
    public function venue()
{
    return $this->belongsTo(Venue::class, 'venue_id');
}

}
