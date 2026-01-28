<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleImage extends Model
{

    protected $appends = ['full_path'];
    protected $fillable = [
        'vehicle_id',
        'attachment',
        'extension',
        'path',
        'alt',
        'sort_order'
    ];



    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }


    public function getFullPathAttribute()
    {
        return isset($this->attachment) ? asset("storage/uploads/vehicles/" .$this->vehicle_id."/"."images/" . $this->attachment) : null;
    }
}
