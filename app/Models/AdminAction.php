<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminAction extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_actions';

    /**
     * The attributes that are mass assignable.
     * We exclude 'created_at' as it is handled automatically.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',             // UUID primary key
        'admin_id',       // Foreign key to users table
        'action_type',    // ENUM: approve_campaign, reject_campaign, etc.
        'target_type',    // e.g., 'campaign', 'user', 'comment'
        'target_id',      // ID of the target entity
        'reason',         // TEXT, used for rejection reason, etc.
        'metadata',       // JSON data field
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'array', // Automatically casts JSON column to PHP array
    ];

    /**
     * Define the relationship with the Admin user who performed the action.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}