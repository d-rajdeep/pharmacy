<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
    protected $fillable = [
        'bill_id',
        'medicine_id',
        'quantity',
        'price',
        'total'
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
