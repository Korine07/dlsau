<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Completed extends Model
{
    protected $table = 'completed';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'address', 'mobile'];

    use HasFactory;
}
