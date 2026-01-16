<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $table = "tasks";

    protected $fillable = [
        'lead_id',
        'type',
        'task',
        'due_date',
        'priority',
        'status',
        'created_by',
        'created_by_id',
        'assigned_to'
    ];

    /**
     * Get the lead that owns the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }

    /**
     * Get the creator that owns the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Superadmin::class, 'created_by_id', 'id');
    }

    /**
     * Get the assignee that owns the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(Superadmin::class, 'assigned_to', 'id');
    }
}
