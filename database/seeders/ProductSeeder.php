<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'sku' => "000001",
            'name' => "BV Lean leather ankle boots",
            'category' => "boots",
            'price' => 89000,
            'currency' => 'EUR'
        ]);
        DB::table('products')->insert([
            'sku' => "000002",
            'name' => "BV Lean leather ankle boots",
            'category' => "boots",
            'price' => 99000,
            'currency' => 'EUR'
        ]);
        DB::table('products')->insert([
            'sku' => "000003",
            'name' =>  "Ashlington leather ankle boots",
            'category' => "boots",
            'price' => 71000,
            'currency' => 'EUR'
        ]);
        DB::table('products')->insert([
            'sku' => "000004",
            'name' => "Naima embellished suede sandals",
            'category' => "sandals",
            'price' => 79500,
            'currency' => 'EUR'
        ]);
        DB::table('products')->insert([
            'sku' => "000005",
            'name' =>  "Nathane leather sneakers",
            'category' => "sneakers",
            'price' => 59000,
            'currency' => 'EUR'
        ]);
    }
}
