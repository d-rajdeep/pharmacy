<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'invoice_no',
        'customer_name',
        'customer_phone',
        'subtotal',
        'discount',
        'tax',
        'total',
        'created_at'
    ];

    public function items()
    {
        return $this->hasMany(BillItem::class);
    }
}
