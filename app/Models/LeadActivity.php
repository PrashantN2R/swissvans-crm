<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadActivity extends Model
{
    protected $table    = 'lead_activities';

    protected $fillable = [
        'lead_id',
        'type',
        'created_by',
        'created_by_id',
        'old_status',
        'new_status',
        'lead_note_id'
    ];

    /**
     * Get the lead that owns the Lead Attachment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Superadmin::class, 'created_by_id', 'id');
    }
}
