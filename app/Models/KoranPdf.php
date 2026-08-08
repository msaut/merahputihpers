<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KoranPdf extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'file',
        'tanggal',
        'is_active',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_active' => 'boolean',
    ];
}
