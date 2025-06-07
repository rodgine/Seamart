<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Category;
use App\Models\TransactionLog;
use Illuminate\Support\Facades\DB;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/admin/dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    public function dashboard()
    {
        $products = Product::with('category')->latest()->take(6)->get();
        // Top 4 best-selling products
        $bestSellingProducts = Product::select('products.id', 'products.name', 'products.price', 'products.discount', 'products.image')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->selectRaw('COUNT(order_items.product_id) as order_count')
            ->groupBy('products.id', 'products.name', 'products.price', 'products.discount', 'products.image')
            ->orderByDesc('order_count')
            ->take(4)
            ->get();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalCustomers = Customer::count();
        $logs = TransactionLog::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalOrders', 
            'totalCustomers', 
            'logs', 
            'products', 
            'bestSellingProducts'
        ));
    }
}
