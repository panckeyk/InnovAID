<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory, HasUuid;

    // The attributes that are mass assignable.
    protected $fillable = [
        'creator_id',
        'title',
        'description',
        'category',
        'goal_amount',
        'current_amount',
        'deadline',
        'status',
        'image',
        'featured',
        'views',
        'rejection_reason',
        'approved_by',
        'rejected_by',
    ];

    // Attributes that should be cast to native types.
    protected $casts = [
        // Ensure decimal values are cast to floats/strings for calculation safety
        'goal_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'deadline' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'completed_at' => 'datetime',
        'featured' => 'boolean',
    ];
    
    //-------------------------------------------------------------
    // Relationships
    //-------------------------------------------------------------

    /**
     * A Campaign belongs to a Creator (User).
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * A Campaign can have many Donations.
     */
    // public function donations(): HasMany
    // {
    //     return $this->hasMany(Donation::class);
    // }

    /**
     * The User who approved this campaign (Admin).
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * The User who rejected this campaign (Admin).
     */
    public function rejecter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    //-------------------------------------------------------------
    // Accessors
    //-------------------------------------------------------------

    /**
     * Get the percentage of the goal amount achieved.
     */
    protected function progress(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->goal_amount > 0 
                ? round(($this->current_amount / $this->goal_amount) * 100, 2) 
                : 0,
        );
    }
}