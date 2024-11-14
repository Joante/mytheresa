<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        
        foreach($products as $product){
            if($product->category == 'boots'){
                DB::table('discounts')->insert([
                    'product_id' => $product->id,
                    'discount' => 30
                ]);
            }
            if($product->sku == '000003'){
                DB::table('discounts')->insert([
                    'product_id' => $product->id,
                    'discount' => 15
                ]);
            }
        }
        
    }
}
