<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\TransactionLog;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(100);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'english_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'discount' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|string|max:255', 
        ]);

        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('admin-assets/assets/images/products', $filename, 'public');
                $data['image'] = $path;
            }

            Product::create($data);
            TransactionLog::create([
                'date' => now()->toDateString(),
                'description' => "New product added: <a href='javascript:void(0)' class='text-success d-block fw-normal'>{$data['name']} ({$data['english_name']})</a>"
            ]);

            return redirect()->route('admin.products.index')->with('success', 'Product added!');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'Failed to add product: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'english_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'discount' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|string|max:255',
        ]);

        try {
            if ($request->hasFile('image')) {
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }

                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('admin-assets/assets/images/products', $filename, 'public');
                $data['image'] = $path;
            } else {
                $data['image'] = $product->image;
            }

            $product->update($data);
            TransactionLog::create([
                'date' => now()->toDateString(),
                'description' => "Product updated: <a href='javascript:void(0)' class='text-success d-block fw-normal'>{$data['name']} ({$data['english_name']})</a>"
            ]);

            return redirect()->route('admin.products.index')->with('success', 'Product updated!');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        try {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();
            TransactionLog::create([
                'date' => now()->toDateString(),
                'description' => "Product deleted: <b>{$product->name}</b>"
            ]);

            return redirect()->route('admin.products.index')->with('success', 'Product deleted!');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    public function updateStock(Request $request, Product $product)
    {
        $action = $request->input('action');
        $amount = (int) $request->input('amount');

        if ($amount <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid amount.'
            ]);
        }

        if ($action === 'increase') {
            $product->stock += $amount;
        } elseif ($action === 'decrease') {
            $product->stock = max(0, $product->stock - $amount); // prevent negative stock
        }

        $product->save();
        $actionText = $action === 'increase' ? "added to" : "removed from";
        TransactionLog::create([
            'date' => now()->toDateString(),
            'description' => "{$amount} stock was {$actionText} inventory for item <b>{$product->name}</b>"
        ]);

        return response()->json([
            'success' => true,
            'stock' => $product->stock,
            'message' => 'Stock updated successfully.'
        ]);
    }

    public function updateDiscount(Request $request, Product $product)
    {
        $discount = floatval($request->input('discount'));
        $product->discount = $discount;
        $product->save();
        TransactionLog::create([
            'date' => now()->toDateString(),
            'description' => "Discount updated for <b>{$product->name}</b> to {$product->discount}%"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Discount updated successfully.'
        ]);
    }
}
