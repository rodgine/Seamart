<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'picture',
        'lname',
        'fname',
        'mname',
        'contact_number',
        'email',
        'address',
    ];

    // Relationship back to customer (auth)
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
