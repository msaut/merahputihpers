<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'isi',
        'gambar',
        'kategori_id',
        'user_id',
        'views',
        'gambar_base64',
        'status',
        'publish_at',
        'published_at'
    ];

    protected $casts = [
        'publish_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }

    // Relasi Member (modular, additive)
    public function memberBookmarks()
    {
        return $this->hasMany(Bookmark::class, 'post_id');
    }

    public function memberLikes()
    {
        return $this->hasMany(MemberLike::class, 'post_id');
    }

    public function memberReadingHistories()
    {
        return $this->hasMany(ReadingHistory::class, 'post_id');
    }

    public function memberComments()
    {
        return $this->hasMany(MemberComment::class, 'post_id');
    }

    // Relasi balik ke Member lewat pivot
    public function bookmarkedBy()
    {
        return $this->belongsToMany(Member::class, 'bookmarks', 'post_id', 'member_id')
            ->withTimestamps();
    }

    public function likedBy()
    {
        return $this->belongsToMany(Member::class, 'member_likes', 'post_id', 'member_id')
            ->withTimestamps();
    }

}

