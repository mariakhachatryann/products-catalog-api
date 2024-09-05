<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductProperty;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(10)->create()->each(function ($product) {
            ProductProperty::factory(3)->create([
                'product_id' => $product->id,
            ]);
        });
    }
}
