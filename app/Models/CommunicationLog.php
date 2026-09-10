<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunicationLog extends Model
{
    public $table = 'communication_logs';

    public $fillable = [
        'booking_id',
        'caller_id',
        'receiver_id',
        'e_provider_id',
        'type',
        'caller_role',
        'phone_dialed',
        'status',
        'note',
        'metadata',
    ];

    protected $casts = [
        'booking_id' => 'integer',
        'caller_id' => 'integer',
        'receiver_id' => 'integer',
        'e_provider_id' => 'integer',
        'type' => 'string',
        'caller_role' => 'string',
        'phone_dialed' => 'string',
        'status' => 'string',
        'note' => 'string',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function caller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'caller_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function eProvider(): BelongsTo
    {
        return $this->belongsTo(EProvider::class, 'e_provider_id');
    }
}
