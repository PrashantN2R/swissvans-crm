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
        // If full path already exists in DB
        if (filter_var($this->path, FILTER_VALIDATE_URL)) {
            return $this->path;
        }

        return str_contains($this->path,'/') ? url('storage',$this->path) : asset("storage/uploads/vehicles/" .$this->id."/"."images/" . $this->attachment);
    }
}
