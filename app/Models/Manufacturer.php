<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $table = 'manufacturers';

    protected $primaryKey = 'id';
    public $incrementing = false; // because id is assigned manually
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'cap_id',
        'name',
        'delivery_charge',
        'status',
    ];

    /** Manufacturer has many models */
    public function models()
    {
        return $this->hasMany(Model::class, 'manufacturer', 'id');
    }
}
