<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EProviderLocation extends Model
{
    use HasFactory;

    protected $fillable = ['e_provider_id','booking_id', 'latitude', 'longitude'];
    public static array $rules = [
        'e_provider_id' => 'required|exists:e_providers,id',
        'booking_id' => 'required|exists:bookings,id',
        'latitude' => 'required|numeric|min:-200|max:200',
        'longitude' => 'required|numeric|min:-200|max:200',
    ];

    public function eProvider(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EProvider::class, 'e_provider_id', 'id');
    }


}
