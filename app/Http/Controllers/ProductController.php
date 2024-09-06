<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use GuzzleHttp\Client;
use App\Models\ProductProperty;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $properties = ProductProperty::select('property_name', 'property_value')
            ->distinct()
            ->get()
            ->groupBy('property_name');

        return view('products.index', [
            'properties' => $properties,
            'request' => $request
        ]);
    }
}
