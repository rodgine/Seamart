<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\TransactionLog;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{

    public function create()
    {
        $customer = auth()->guard('customer')->user(); 
        $addresses = Address::where('customer_id', $customer->id)->get();
        $defaultAddress = $addresses->where('default', true)->first();

        return view('checkout', compact('addresses', 'defaultAddress'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'address2' => 'nullable|string|max:500',
            'brgy' => 'required|string|max:255',
            'town' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'order_notes' => 'nullable|string',
            'cart_data' => 'required|json',
            'mode_of_payment' => 'required|string|max:255', 
        ]);

        $cartItems = json_decode($request->cart_data, true);
        if (empty($cartItems)) {
            return back()->with('error', 'Your cart is empty.');
        }

        $customerId = auth('customer')->id();

        // Check if customer has any addresses
        $existingAddresses = Address::where('customer_id', $customerId)->get();

        $inputAddress = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'address2' => $request->address2,
            'brgy' => $request->brgy,
            'town' => explode('|', $request->town)[0],
            'zip' => $request->zip,
            'phone' => $request->phone,
            'email' => $request->email,
        ];

        $addressExists = $existingAddresses->contains(function ($addr) use ($inputAddress) {
            return $addr->only(array_keys($inputAddress)) == $inputAddress;
        });

        // Case: No address at all → save automatically
        if ($existingAddresses->isEmpty()) {
            Address::create(array_merge($inputAddress, [
                'customer_id' => $customerId,
                'default' => true
            ]));
        }

        // Case: address doesn't exist and needs confirmation
        elseif (!$addressExists && $request->has('confirm_new_address')) {
            Address::create(array_merge($inputAddress, [
                'customer_id' => $customerId,
                'default' => false
            ]));
        }

        // Create Order
        $order = Order::create(array_merge($inputAddress, [
            'customer_id' => $customerId,
            'order_notes' => $request->order_notes,
            'status' => 'Pending',
            'mode_of_payment' => $request->mode_of_payment,
        ]));

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['qty'],
                'price' => $item['price'],
            ]);
        }

        // Log transaction
        $customer = auth('customer')->user();
        $itemsText = collect($cartItems)->map(fn($item) => "{$item['qty']}kg of {$item['name']}")->implode(', ');

        TransactionLog::create([
            'date' => now()->toDateString(),
            'description' => "Customer <b>{$customer->name}</b> purchased {$itemsText}.",
        ]);

        return back()->with('success', 'Order placed successfully!');
    }

    public function orders()
    {
        $orders = Order::with(['items.product'])->where('customer_id', auth('customer')->id())->latest()->get();
        return view('orders', compact('orders'));
    }
}
