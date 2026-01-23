<?php

namespace App\Models;

use App\Models\Model as ModelsModel;
use Illuminate\Database\Eloquent\Model;

class Derivative extends Model
{
    protected $table = 'derivatives';

    protected $primaryKey = 'id';
    public $incrementing = true;      // MUST be true unless you manually set ID
    protected $keyType = 'int';       // Standard integer autoincrement

    protected $fillable = [
        'derivative_id',      // CAP derivative ID
        'cap_id',             // Manufacturer CAP ID
        'manufacturer',       // Manufacturer name
        'capmod_id',          // Model CAP ID
        'model',              // Model name
        'introduced',
        'last_spec_date',
        'model_ref_year',
        'discount_percent',
        'profit_percent',
        'profit',
        'name',
        'status',
    ];

    /** Manufacturer Relation */
    public function manufacturerData()
    {
        return $this->belongsTo(Manufacturer::class, 'cap_id', 'cap_id');
    }

    /** Model Relation */
    public function modelData()
    {
        return $this->belongsTo(ModelsModel::class, 'capmod_id', 'capmod_id');
    }
}
