<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id', 
        'first_name', 
        'last_name', 
        'address', 
        'address2',
        'brgy', 
        'town', 
        'zip', 
        'phone', 
        'email', 
        'order_notes', 
        'status',
        'mode_of_payment'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
