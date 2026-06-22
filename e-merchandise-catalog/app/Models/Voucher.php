<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code', 'name', 'description', 'type', 'value', 'min_order',
        'max_discount', 'usage_limit', 'used_count',
        'valid_from', 'valid_until', 'is_active'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isAvailable()
    {
        if (!$this->is_active) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        if ($this->valid_from && now() < $this->valid_from) return false;
        if ($this->valid_until && now() > $this->valid_until) return false;
        return true;
    }

    public function calculateDiscount($total)
    {
        if ($this->min_order && $total < $this->min_order) return 0;

        $discount = 0;
        if ($this->type === 'percentage') {
            $discount = $this->value / 100 * $total;
        } else {
            $discount = $this->value;
        }

        if ($this->max_discount && $discount > $this->max_discount) {
            $discount = $this->max_discount;
        }

        return $discount;
    }
}
