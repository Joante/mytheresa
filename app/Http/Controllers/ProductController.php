<?php

// In app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve products with optional filtering by category and/or price.
        $products = Product::when($request->has('category'), function ($query) use ($request) {
                                // Apply category filter only if 'category' is provided in the request.
                                $query->where('category', $request->query('category'));
                            })
                           ->when($request->has('priceLessThan'), function ($query) use ($request) {
                                // Apply price filter only if 'price' is provided in the request.
                                $query->where('price', '<=', $request->query('priceLessThan'));
                            })
                            ->limit(5)
                           ->get();

        // Return the filtered product list as a JSON response.
        return response()->json($products);
    }
}
