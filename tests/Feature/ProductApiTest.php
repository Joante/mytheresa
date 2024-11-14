<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Discount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test to fetch products with no filters and apply discounts.
     *
     * @return void
     */
    public function test_get_products_with_no_filters_and_discounts()
    {
        // Create products with no filters
        $product1 = Product::create([
            'sku' => '000001',
            'name' => 'BV Lean leather ankle boots',
            'category' => 'boots',
            'price' => 89000,  // 89000 EUR
            'currency' => 'EUR',
        ]);
        $product2 = Product::create([
            'sku' => '000002',
            'name' => 'Naima embellished suede sandals',
            'category' => 'sandals',
            'price' => 99000,  // 99000 EUR
            'currency' => 'EUR',
        ]);

        // Apply a discount to product1
        Discount::create(['product_id' => $product1->id, 'discount' => 30]);  // 30% discount

        // Call the API
        $response = $this->getJson('/api/products');

        // Assert the correct discounts are applied and check the response
        $response->assertJsonFragment([
            'sku' => $product1->sku,
            'price' => [
                'original' => 89000,
                'final' => 62300,
                'discount_percentage' => '30%',
                'currency' => 'EUR',
            ],
        ]);

        // Assert product2 has no discount
        $response->assertJsonFragment([
            'sku' => $product2->sku,
            'price' => [
                'original' => 99000,
                'final' => 99000,
                'discount_percentage' => null,
                'currency' => 'EUR',
            ],
        ]);
    }

    /**
     * Test to filter products by category.
     *
     * @return void
     */
    public function test_filter_products_by_category()
    {
        // Create products with categories
        $product1 = Product::create([
            'sku' => '000001',
            'name' => 'BV Lean leather ankle boots',
            'category' => 'boots',
            'price' => 89000,
            'currency' => 'EUR',
        ]);
        $product2 = Product::create([
            'sku' => '000002',
            'name' => 'Naima embellished suede sandals',
            'category' => 'sandals',
            'price' => 79000,
            'currency' => 'EUR',
        ]);

        // Apply discount to product1
        Discount::create(['product_id' => $product1->id, 'discount' => 30]);

        // Call the API with category filter
        $response = $this->getJson('/api/products?category=boots');

        // Assert the correct products are returned based on category
        $response->assertJsonFragment([
            'sku' => $product1->sku,
            'category' => 'boots',
        ]);

        $response->assertJsonMissing([
            'sku' => $product2->sku,
            'category' => 'sandals',
        ]);
    }

    /**
     * Test to filter products by price before applying discounts.
     *
     * @return void
     */
    public function test_filter_products_by_price_less_than()
    {
        // Create products with different prices
        $product1 = Product::create([
            'sku' => '000001',
            'name' => 'BV Lean leather ankle boots',
            'category' => 'boots',
            'price' => 89000,
            'currency' => 'EUR',
        ]);
        $product2 = Product::create([
            'sku' => '000002',
            'name' => 'Naima embellished suede sandals',
            'category' => 'sandals',
            'price' => 99000,
            'currency' => 'EUR',
        ]);

        // Apply a discount to product1
        Discount::create(['product_id' => $product1->id, 'discount' => 20]);  // 20% discount

        // Call the API with price filter
        $response = $this->getJson('/api/products?priceLessThan=90000');

        // Assert the correct products are returned based on price
        $response->assertJsonFragment([
            'sku' => $product1->sku,
            'price' => [
                'original' => 89000,
                'final' => 71200,
                'discount_percentage' => '20%',
                'currency' => 'EUR',
            ],
        ]);

        $response->assertJsonMissing([
            'sku' => $product2->sku,
        ]);
    }

    /**
     * Test to check if the discount with the highest percentage is applied.
     *
     * @return void
     */
    public function test_apply_highest_discount()
    {
        // Create product with no discount initially
        $product = Product::create([
            'sku' => '000003',
            'name' => 'Ashlington leather ankle boots',
            'category' => 'boots',
            'price' => 71000,
            'currency' => 'EUR',
        ]);

        // Apply two discounts, one at 20% and another at 30%
        Discount::create(['product_id' => $product->id, 'discount' => 20]);  // 20% discount
        Discount::create(['product_id' => $product->id, 'discount' => 30]);  // 30% discount

        // Call the API
        $response = $this->getJson('/api/products');

        // Assert that the 30% discount is applied
        $response->assertJsonFragment([
            'sku' => $product->sku,
            'price' => [
                'original' => 71000,
                'final' => 49700,  // After 30% discount
                'discount_percentage' => '30%',
                'currency' => 'EUR',
            ],
        ]);
    }
}
