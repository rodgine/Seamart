<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'items.product']);

        $status = $request->status;

        if ($status === null || $status === 'Pending') {
            // Default filter to Pending
            $query->where('status', 'Pending');
        } elseif ($status !== 'All') {
            // Apply filter if it's not "All"
            $query->where('status', $status);
        }
        // If status is "All", do not filter

        $orders = $query->latest()->paginate(5);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Completed,Cancelled',
        ]);

        if ($request->status === 'Completed' && $order->status !== 'Completed') {
            foreach ($order->items as $item) {
                $product = $item->product;

                if ($product && $product->stock >= $item->quantity) {
                    $product->decrement('stock', $item->quantity);
                }
            }
        }

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated!');
    }
}
