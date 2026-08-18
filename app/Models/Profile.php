<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nip',
        'no_hp',
        'jabatan',
        'instansi',
        'alamat',
        'foto',
    ];

    /**
     * Profile dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}