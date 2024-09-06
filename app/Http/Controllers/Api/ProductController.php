<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        $products = $query->get();

        return response()->json([
            'data' => $products,
            'meta' => [
            'current_page' => 1, // adjust as necessary
            'last_page' => 1, // adjust as necessary
            'prev_page_url' => null, // adjust as necessary
            'next_page_url' => null, // adjust as necessary
            ]
        ]);
    }
}
