<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Vehicle extends Model
{
    use HasSlug;
    protected $appends = ['thumbnail_path'];
    protected $fillable = [
        'user_id', 'title', 'slug', 'registration', 'vin', 'model', 'year',
        'short_description', 'description', 'price', 'sale_price', 'vat',
        'interest_rate', 'is_business_lease', 'business_lease_price',
        'business_lease_discount_price', 'is_hire_purchase', 'hire_purchase_price',
        'hire_purchase_discount_price', 'van_type', 'hpi_mancode', 'hpi_modcode',
        'hpi_derivative', 'thumbnail', 'meta_title', 'meta_description',
        'meta_keywords', 'status', 'stock_status'
    ];

    protected $casts = [
        'is_business_lease' => 'boolean',
        'is_hire_purchase' => 'boolean',
        'status' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the manufacturer that owns the Vehicle
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manufacturerData(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, 'hpi_mancode', 'cap_id');
    }

     /**
     * Get the model that owns the Vehicle
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modelData(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Model::class, 'hpi_modcode', 'capmod_id');
    }

    public function variantData(): BelongsTo
    {
        return $this->belongsTo(Derivative::class, 'hpi_derivative', 'derivative_id');
    }

    /**
     * Get the user that owns the vehicle.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the images for the vehicle.
     */
    public function images(): HasMany
    {
        return $this->hasMany(VehicleImage::class);
    }

     public function getThumbnailPathAttribute()
    {
        // If full path already exists in DB
        if (filter_var($this->path, FILTER_VALIDATE_URL)) {
            return $this->path;
        }

        return asset("storage/uploads/vehicles/" .$this->id."/"."thumbnail/" . $this->thumbnail);
    }
}
