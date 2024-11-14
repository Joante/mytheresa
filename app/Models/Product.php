<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $fillable = [
        'sku', 'name', 'category', 'price', 'currency',
    ];

    // Accessor to calculate the discounted price and format the response.
    public function getPriceWithDiscountAttribute()
    {
        // Retrieves the highest discount percentage for the product directly from the 'discounts' table.
        $highestDiscount = DB::table('discounts')
            ->where('product_id', $this->id)
            ->max('discount');

        // Calculate the final price after applying the discount, if any.
        $originalPrice = $this->price;
        $finalPrice = $highestDiscount ? $originalPrice * (1 - $highestDiscount / 100) : $originalPrice;

        // Set discount percentage as a formatted string if applicable, otherwise null.
        $discountPercentage = $highestDiscount ? "{$highestDiscount}%" : null;

        // Return the pricing details as an associative array, including currency information.
        return [
            'original' => $originalPrice,
            'final' => round($finalPrice),
            'discount_percentage' => $discountPercentage,
            'currency' => $this->currency,
        ];
    }

    // Override toArray to include the price with discount information directly in the product's JSON representation.
    public function toArray()
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'category' => $this->category,
            'price' => $this->price_with_discount, // Calls the accessor 'getPriceWithDiscountAttribute'
        ];
    }
}
