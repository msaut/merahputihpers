<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'beritas';
    protected $fillable = [
        'judul',
        'slug',
        'isi',
        'id',
    ];
}
