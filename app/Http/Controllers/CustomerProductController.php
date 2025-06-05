<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CustomerProductController extends Controller
{
    public function allProducts(Request $request)
    {
        $sort = $request->query('sort');

        $query = Product::with('category');

        switch ($sort) {
            case 'popularity':
                $query->orderByRaw("CASE WHEN tags LIKE '%Best Seller%' THEN 0 ELSE 1 END")
                    ->orderBy('created_at', 'desc'); // Tie-breaker
                break;
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->get();

        return view('allproducts', compact('products'));
    }

    public function welcome()
    {
        $products = Product::orderBy('created_at', 'desc')->take(4)->get();
        return view('welcome', compact('products'));
    }

    public function featuredProducts()
    {
        $products = Product::orderBy('created_at', 'desc')->get(); 
        return view('featured', compact('products'));
    }

    public function discountedProducts()
    {
        $products = Product::where('discount', '!=', 0)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('sale', compact('products'));
    }
}
