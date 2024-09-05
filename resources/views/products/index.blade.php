<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form {
            margin-bottom: 20px;
        }
        form div {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .product {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
        }
        .product h2 {
            margin-top: 0;
        }
        .pagination {
            text-align: center;
            margin: 20px 0;
            display: flex;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            padding: 8px 12px;
            margin: 0 4px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #007bff;
        }


        .pagination a:hover {
            background-color: #f8f9fa;
        }

        .pagination .active {
            font-weight: bold;
            color: #0056b3;
            background-color: #e9ecef;
            border-color: #ddd;
        }

        .pagination .disabled {
            color: #6c757d;
            border-color: #ddd;
            cursor: not-allowed;
        }

        .pagination li {
            list-style: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Product Catalog</h1>

    <form method="GET" action="{{ route('products.index') }}">
        @foreach($properties as $propertyName => $options)
            <div>
                <label for="{{ $propertyName }}">{{ ucfirst($propertyName) }}</label>
                <select name="properties[{{ $propertyName }}][]" id="{{ $propertyName }}" multiple>
                    @foreach($options as $option)
                        <option value="{{ $option->property_value }}"
                            {{ is_array(request('properties.' . $propertyName)) && in_array($option->property_value, request('properties.' . $propertyName)) ? 'selected' : '' }}>
                            {{ ucfirst($option->property_value) }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endforeach

        <button type="submit">Apply Filters</button>
    </form>

    @if($products->isNotEmpty())
        <div>
            @foreach($products as $product)
                <div class="product">
                    <h2>{{ $product->name }}</h2>
                    <p>Price: ${{ $product->price }}</p>
                    <p>Quantity: {{ $product->quantity }}</p>
                    <ul>
                        @foreach($product->properties as $property)
                            <li>{{ $property->property_name }}: {{ $property->property_value }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        {{ $products->links('pagination::default') }}
    @else
        <p>No products found.</p>
    @endif
</div>
</body>
</html>
