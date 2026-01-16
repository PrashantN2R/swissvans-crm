<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadReminder extends Model
{
    protected $table    = 'lead_reminders';

    protected $fillable = [
        'lead_id',
        'datetime',
        'comment',
        'seen',
        'sender',
        'receiver'
    ];

    /**
     * Get the sender that sends the Lead Reminder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(Superadmin::class, 'sender', 'id');
    }

    /**
     * Get the receiver that sends the Lead Reminder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Superadmin::class, 'receiver', 'id');
    }

    /**
     * Get the lead that owns the Lead Reminder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }
}
