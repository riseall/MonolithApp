<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class perusahaan extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'perusahaan';

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [
        'nama',
        'email',
        'alamat'
    ];

    public function magang(): HasMany
    {
        return $this->hasMany(magang::class);
    }
}
