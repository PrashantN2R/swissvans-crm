<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as ModelX;

class Model extends ModelX
{
    protected $table = 'models';

    protected $primaryKey = 'id';

    protected $fillable = [
        'cap_id',
        'manufacturer',
        'capmod_id',
        'introduced',
        'discount_percent',
        'profit_percent',
        'profit',
        'name',
        'status',
    ];

    /** Optionally: link to Manufacturer table (matching name) */
    public function manufacturerData()
    {
        return $this->belongsTo(Manufacturer::class, 'cap_id', 'id');
    }

    /** Model has many Derivatives */
    public function derivatives()
    {
        return $this->hasMany(Derivative::class, 'capmod_id', 'capmod_id');
    }
}
