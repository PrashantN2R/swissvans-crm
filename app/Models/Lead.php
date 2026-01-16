<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    protected $table    = 'leads';

    protected $fillable = [
        'name',
        'designation',
        'company',
        'email',
        'phone',
        'budget',
        'event_type',
        'event_date',
        'source',
        'description',
        'location',
        'meta',
        'status',
        'created_by',
        'assigned_to',
    ];

    /**
     * Get the creator that owns the Lead
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Superadmin::class, 'created_by', 'id');
    }

    /**
     * Get the assignee that owns the Lead
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(Superadmin::class, 'assigned_to', 'id');
    }

    /**
     * Get all of the attachments for the Lead
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(LeadAttachment::class, 'lead_id', 'id');
    }

    /**
     * Get all of the notes for the Lead
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes(): HasMany
    {
        return $this->hasMany(LeadNote::class, 'lead_id', 'id');
    }

    /**
     * Get all of the activities for the Lead
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities(): HasMany
    {
        return $this->hasMany(LeadActivity::class, 'lead_id', 'id');
    }

    public function history(): HasMany
    {
        return $this->hasMany(LeadActivity::class, 'lead_id', 'id')->where('type', 'Status Changed')->orderBy('id', 'desc');
    }
}
