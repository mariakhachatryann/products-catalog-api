<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('properties');

        if ($request->has('properties')) {
            foreach ($request->input('properties') as $propertyName => $propertyValues) {
                $query->whereHas('properties', function ($q) use ($propertyName, $propertyValues) {
                    $q->where('property_name', $propertyName)
                        ->whereIn('property_value', $propertyValues);
                });
            }
        }

        $products = $query->paginate(40);

        return response()->json($products);
    }
}
