<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\TransactionLog;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.customer-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('customer')->attempt($request->only('email', 'password'))) {
            return back()->with('success', 'Successfully Logged in');
        }

        return back()->with('error', 'Invalid credentials.');
    }

    public function showRegisterForm()
    {
        return view('auth.customer-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
            'password' => 'required|confirmed|min:6',
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        TransactionLog::create([
            'date' => now()->toDateString(),
            'description' => "Customer registered: <a href='javascript:void(0)' class='text-success d-block fw-normal'>{$customer->name} ({$customer->email})</a>",
        ]);

        return back()->with('success', 'Registration successful. Please login.');
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect('/');
    }
}
