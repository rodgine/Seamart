<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'first_name',
        'last_name',
        'middle_name',
        'address',
        'address2',
        'brgy',
        'town',
        'zip',
        'phone',
        'email',
        'default',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

