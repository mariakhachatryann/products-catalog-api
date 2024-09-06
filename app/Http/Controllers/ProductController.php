<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use GuzzleHttp\Client;
use App\Models\ProductProperty;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $client = new Client();

        $queryParams = $request->has('properties') ? [
            'properties' => $request->input('properties')
        ] : [];

        $response = $client->request('GET', 'http://products-catalog.loc/api/products', [
            'query' => $queryParams
        ]);

        $products = json_decode($response->getBody()->getContents(), true);

        $productData = collect($products ?? []);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 40;
        $currentItems = $productData->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginatedProducts = new LengthAwarePaginator(
            $currentItems,
            $productData->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $properties = ProductProperty::select('property_name', 'property_value')
            ->distinct()
            ->get()
            ->groupBy('property_name');

        return view('products.index', [
            'products' => $paginatedProducts,
            'properties' => $properties,
            'request' => $request
        ]);
    }
}
