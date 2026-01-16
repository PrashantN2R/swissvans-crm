<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadNote extends Model
{
    protected $table    = 'lead_notes';

    protected $fillable = [
        'lead_id',
        'note',
        'created_by',
        'created_by_id'
    ];

    /**
     * Get the lead that owns the Lead Note
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Superadmin::class, 'created_by_id', 'id');
    }

    /**
     * Get the lead that owns the Lead Note
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }
}
