<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    public const RELIGIONS = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
    public const GENDERS   = ['L' => 'Laki-laki', 'P' => 'Perempuan'];
    public const STATUSES  = ['aktif' => 'Aktif', 'lulus' => 'Lulus', 'pindah' => 'Pindah'];

    protected $fillable = [
        'nis', 'nisn', 'name', 'gender', 'birth_place', 'birth_date', 'religion',
        'class_id', 'major_id', 'entry_year', 'address', 'phone',
        'parent_name', 'parent_phone', 'email', 'photo', 'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    /** Pencarian + filter: q, class_id, major_id, gender, status */
    public function scopeFilter(Builder $query, array $f): Builder
    {
        return $query
            ->when($f['q'] ?? null, function ($q, $s) {
                $q->where(fn ($w) => $w->where('name', 'like', "%{$s}%")
                    ->orWhere('nis', 'like', "%{$s}%")
                    ->orWhere('nisn', 'like', "%{$s}%"));
            })
            ->when($f['class_id'] ?? null, fn ($q, $v) => $q->where('class_id', $v))
            ->when($f['major_id'] ?? null, fn ($q, $v) => $q->where('major_id', $v))
            ->when($f['gender'] ?? null, fn ($q, $v) => $q->where('gender', $v))
            ->when($f['status'] ?? null, fn ($q, $v) => $q->where('status', $v));
    }

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo ? asset('storage/' . $this->photo) : asset('images/avatar.svg');
    }

    public function getGenderLabelAttribute(): string
    {
        return self::GENDERS[$this->gender] ?? '-';
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? '-';
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'aktif'  => 'badge-soft-success',
            'lulus'  => 'badge-soft-primary',
            'pindah' => 'badge-soft-warning',
            default  => 'badge-soft-secondary',
        };
    }
}
