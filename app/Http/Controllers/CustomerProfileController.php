<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerDetail;
use App\Models\Order;

class CustomerProfileController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user(); 
        $profile = CustomerDetail::where('customer_id', $customer->id)->first();

        $orders = Order::with(['items.product'])->where('customer_id', auth('customer')->id())->latest()->take(3)->get();

        return view('profile', compact('profile', 'orders', 'customer'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'picture' => 'nullable|image|max:2048',
            'lname' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
        ]);

        try {
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('admin-assets/assets/images/profiles', $filename, 'public');
                $data['picture'] = $path;
            }

            CustomerDetail::create($data);

            return redirect()->back()->with('success', 'Profile added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add profile: ' . $e->getMessage());
        }
    }

    public function update(Request $request, CustomerDetail $profile)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'picture' => 'nullable|image|max:2048',
            'lname' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
        ]);

        try {
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('admin-assets/assets/images/customers', $filename, 'public');
                $data['picture'] = $path;

                // Optionally delete old image if exists
                if ($profile->picture && \Storage::disk('public')->exists($profile->picture)) {
                    \Storage::disk('public')->delete($profile->picture);
                }
            }

            $profile->update($data);

            return back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }
}
