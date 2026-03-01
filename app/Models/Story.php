<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'e_provider_id',
        'media_url',
        'media_type',
        'expires_at',
        'views_count',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function eProvider()
    {
        return $this->belongsTo(EProvider::class);
    }
}
