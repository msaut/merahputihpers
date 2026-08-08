<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'avatar_base64',
        'status',
        'subscription_start',
        'subscription_end',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'subscription_start' => 'datetime',
            'subscription_end' => 'datetime',
        ];
    }

    // ===== Fitur Premium (Modular) =====

    // Apakah member punya langganan aktif?
    public function isActive(): bool
    {
        return $this->status === 'active'
            && $this->subscription_end
            && $this->subscription_end->isFuture();
    }

    // Relasi: Member -> Payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Relasi: Member -> Bookmark
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    // Relasi: Member -> Like
    public function likes()
    {
        return $this->hasMany(MemberLike::class);
    }

    // Relasi: Member -> Riwayat Baca
    public function readingHistories()
    {
        return $this->hasMany(ReadingHistory::class);
    }

    // Relasi: Member -> Komentar
    public function comments()
    {
        return $this->hasMany(MemberComment::class);
    }

    // Berita yang dibookmark member
    public function bookmarkedPosts()
    {
        return $this->belongsToMany(Berita::class, 'bookmarks', 'member_id', 'post_id')
            ->withTimestamps();
    }

    // Berita yang di-like member
    public function likedPosts()
    {
        return $this->belongsToMany(Berita::class, 'member_likes', 'member_id', 'post_id')
            ->withTimestamps();
    }
}

