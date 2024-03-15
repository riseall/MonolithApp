<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class magang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'magang';

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'mahasiswa_id',
        'perusahaan_id',
        'periode',
        'posisi',
        'dosen_id',
        'laporan_id'
    ];

    protected $dates = ['periode'];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(perusahaan::class);
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(dosen::class);
    }

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(laporan::class);
    }
}
