<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReadingHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'post_id',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function post()
    {
        return $this->belongsTo(Berita::class, 'post_id');
    }
}

