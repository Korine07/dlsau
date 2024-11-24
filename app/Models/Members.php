<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    protected $table = 'members';
    protected $primaryKey = 'id';
    protected $fillable = ['last_name', 'first_name', 'memtyp', 'idnum'];
}
