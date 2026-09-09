<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'gambar',
        'link',
        'posisi',
        'target',
        'status',
        'urutan',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi',
        'alt_text',
        'views',
        'clicks',
        'validation_mode',
    ];

    protected $casts = [
        'urutan' => 'integer',
        'views' => 'integer',
        'clicks' => 'integer',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('tanggal_mulai')->orWhereDate('tanggal_mulai', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('tanggal_selesai')->orWhereDate('tanggal_selesai', '>=', now());
            });
    }

    public function scopePosition(Builder $query, string $position): Builder
    {
        return $query->where('posisi', $position);
    }

    public static function sizeConfig(): array
    {
        return config('banner.positions', []);
    }

    public static function sizeFor(string $position): ?array
    {
        return static::sizeConfig()[$position] ?? null;
    }

    public function isVisible(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        $now = now()->toDateString();

        if (!empty($this->tanggal_mulai) && $this->tanggal_mulai->toDateString() > $now) {
            return false;
        }

        if (!empty($this->tanggal_selesai) && $this->tanggal_selesai->toDateString() < $now) {
            return false;
        }

        return true;
    }
}
