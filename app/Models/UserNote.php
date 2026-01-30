<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNote extends Model
{
    protected $table    = 'user_notes';

    protected $fillable = [
        'user_id',
        'note',
        'created_by',
        'created_by_id'
    ];

    /**
     * Get the creator that owns the Customer Note
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Superadmin::class, 'created_by_id', 'id');
    }

    /**
     * Get the customer that owns the Customer Note
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'user_id', 'id');
    }
}
