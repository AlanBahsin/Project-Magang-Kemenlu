<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kredensial extends Model
{
    protected $fillable = [
        'negara',
        'username',
        'password',
        'status',
        'tanggal',
        'submitted_by'
    ];
}