<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadAttachment extends Model
{
    protected $table    = 'lead_attachments';

    protected $fillable = [
        'lead_id',
        'attachment',
        'extension',
        'size',
        'path',
        'created_by',
        'created_by_id'
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

    /**
     * Get the lead that owns the Lead Attachment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }
}
