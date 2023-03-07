<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelamar extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'namalengkap',
        'email',
        'nohp',
        'noktp',
        'ttl',
        'alamat',
        'jk',
        'cv',
        'posisi',
        'keahlian',
        'status'
    ];
}


