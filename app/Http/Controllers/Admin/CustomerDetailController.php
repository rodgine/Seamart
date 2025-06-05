<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerDetail;

class CustomerDetailController extends Controller
{
    public function index()
    {
        // Get only customer details with their customer account
        $customerDetails = CustomerDetail::with('customer')->paginate(10);

        return view('admin.customer-details.index', compact('customerDetails'));
    }

    public function show(string $id)
    {
        $customerDetail = CustomerDetail::with('customer')->findOrFail($id);

        return view('admin.customer-details.show', compact('customerDetail'));
    }
}
