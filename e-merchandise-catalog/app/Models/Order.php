<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'voucher_id', 'customer_type',
        'customer_name', 'customer_phone', 'customer_email',
        'customer_address', 'customer_class', 'subtotal', 'discount',
        'total', 'payment_method', 'payment_status', 'order_status',
        'midtrans_order_id', 'midtrans_response', 'qr_code',
        'is_picked_up', 'picked_up_at', 'picked_up_by'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'midtrans_response' => 'array',
        'is_picked_up' => 'boolean',
        'picked_up_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function pickedUpBy()
    {
        return $this->belongsTo(User::class, 'picked_up_by');
    }

    public static function generateOrderNumber()
    {
        return 'CMB-' . date('Ymd') . '-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    }

    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'pending' => ['text' => 'Menunggu', 'class' => 'badge-warning'],
            'paid' => ['text' => 'Dibayar', 'class' => 'badge-success'],
            'processing' => ['text' => 'Diproses', 'class' => 'badge-info'],
            'completed' => ['text' => 'Selesai', 'class' => 'badge-success'],
            'cancelled' => ['text' => 'Dibatalkan', 'class' => 'badge-danger']
        ];
        return $statuses[$this->order_status] ?? ['text' => $this->order_status, 'class' => 'badge-secondary'];
    }
}
