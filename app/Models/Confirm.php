<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confirm extends Model
{
    protected $table = 'confirm';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'address', 'mobile'];

    use HasFactory;
}
