<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    use HasUuids; // Required because 'id' in the migration is a UUID

    /**
     * The attributes that are mass assignable.
     * These match the columns you set in the migration.
     */
    protected $fillable = [
        'campaign_id',
        'donor_id',
        'amount',
        'processor_fee',
        'net_amount',
        'refunded_amount',
        'transaction_id',
        'payment_method',
        'payment_processor',
        'payment_status',
        'anonymous',
        'message',
        'refunded_at',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'anonymous' => 'boolean',
        'refunded_at' => 'datetime',
        'amount' => 'decimal:2',
        'processor_fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'refunded_amount' => 'decimal:2',
    ];

    // --- Relationships ---

    /**
     * Get the campaign that received the donation.
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Get the user who made the donation (the donor).
     */
    public function donor(): BelongsTo
    {
        // Explicitly set the foreign key as 'donor_id'
        return $this->belongsTo(User::class, 'donor_id');
    }
}