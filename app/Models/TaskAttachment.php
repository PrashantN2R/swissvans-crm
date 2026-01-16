<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskAttachment extends Model
{
     protected $table    = 'task_attachments';

    protected $fillable = [
        'task_id',
        'attachment',
        'extension',
        'size',
        'path',
        'created_by',
        'created_by_id'
    ];

    /**
     * Get the lead that owns the Task Attachment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Superadmin::class, 'created_by_id', 'id');
    }

    /**
     * Get the task that owns the Task Attachment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}
