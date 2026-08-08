<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'post_id',
        'isi',
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

