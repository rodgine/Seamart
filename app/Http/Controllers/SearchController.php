<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SearchController extends Controller
{
    public function results(Request $request)
    {
        $query = $request->input('search');
        $results = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('tags', 'LIKE', "%{$query}%")
            ->take(10)
            ->get();

        $featured = Product::where('tags', 'LIKE', '%Best Seller%')->take(8)->get();

        if ($request->ajax()) {
            return view('partials.search-results', compact('results', 'featured', 'query'));
        }

        return redirect()->back()->with('message', 'Search overlay only');
    }
}

