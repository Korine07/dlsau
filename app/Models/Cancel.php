<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancel extends Model
{
    protected $table = 'cancel';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'address', 'mobile'];

    use HasFactory;
}
