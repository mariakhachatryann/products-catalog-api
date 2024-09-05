<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductProperty;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('properties');
        $properties = ProductProperty::select('property_name', 'property_value')
            ->distinct()
            ->get()
            ->groupBy('property_name');

        if ($request->has('properties')) {
            foreach ($request->input('properties') as $propertyName => $propertyValues) {
                $query->whereHas('properties', function ($q) use ($propertyName, $propertyValues) {
                    $q->where('property_name', $propertyName)
                        ->whereIn('property_value', $propertyValues);
                });
            }
        }

        $products = $query->paginate(40);
        return view('products.index', compact('products', 'properties', 'request'));
    }
}
