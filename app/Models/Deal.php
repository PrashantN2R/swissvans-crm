<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'deal_number',
        'user_id',
        'vehicle_id',
        'salesperson_id',
        'type',
        'status',
        'price',
        'sale_price',
        'is_business_lease',
        'business_lease_price',
        'business_lease_discount_price',
        'is_hire_purchase',
        'hire_purchase_price',
        'hire_purchase_discount_price',
        'commission_amount',
        'vat',
        'interest_rate',
        'is_immutable',
        'completed_at',
        'notes'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_business_lease' => 'boolean',
        'is_hire_purchase' => 'boolean',
        'is_immutable' => 'boolean',
        'completed_at' => 'datetime',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
    ];

    /**
     * Boot function to enforce Immutability
     */
    protected static function booted()
    {
        // Prevent updates if the deal is completed
        static::updating(function ($deal) {
            if ($deal->getOriginal('status') === 'Completed' || $deal->is_immutable) {
                abort(403, 'This deal is finalized and cannot be modified.');
            }
        });

        // Prevent deletion if the deal is completed
        static::deleting(function ($deal) {
            if ($deal->status === 'Completed') {
                abort(403, 'Completed deals cannot be deleted.');
            }
        });
    }

    /**
     * RELATION: The Customer (Linked User)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * RELATION: The Vehicle
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    /**
     * RELATION: The Salesperson (Superadmin)
     */
    public function salesperson(): BelongsTo
    {
        return $this->belongsTo(Superadmin::class, 'salesperson_id');
    }

    /**
     * ACCESSOR: Standard Sale Margin
     */
    public function getStandardMarginAttribute(): float
    {
        return (float)($this->sale_price - $this->price);
    }

    /**
     * ACCESSOR: Business Lease Margin
     * Calculated from the discounted price vs the base lease price
     */
    public function getBusinessLeaseMarginAttribute(): float
    {
        if (!$this->is_business_lease) return 0.00;
        return (float)($this->business_lease_price - $this->business_lease_discount_price);
    }

    /**
     * ACCESSOR: Hire Purchase Margin
     */
    public function getHirePurchaseMarginAttribute(): float
    {
        if (!$this->is_hire_purchase) return 0.00;
        return (float)($this->hire_purchase_price - $this->hire_purchase_discount_price);
    }
}
