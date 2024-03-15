<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Mahasiswa extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'mahasiswa';

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'foto',
        'nama',
        'nim',
        'kelas',
        'telepon',
        'email',
        'alamat'
    ];

    public function absenMasuk(): HasMany
    {
        return $this->hasMany(AbsenMasuk::class);
    }

    public function absenKeluar(): HasMany
    {
        return $this->hasMany(AbsenKeluar::class);
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(laporan::class);
    }

    public function magang(): HasMany
    {
        return $this->hasMany(magang::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}