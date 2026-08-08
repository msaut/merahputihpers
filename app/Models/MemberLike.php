<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberLike extends Model
{
    use HasFactory;

    protected $table = 'member_likes';

    protected $fillable = [
        'member_id',
        'post_id',
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

