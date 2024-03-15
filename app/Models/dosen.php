<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class dosen extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dosen';

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [
        'nip',
        'nama',
        'telepon',
        'alamat'
    ];

    public function magang(): HasMany
    {
        return $this->hasMany(magang::class);
    }
}
