<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'りんご',
            'price' => 100,
            'stock' => 5
        ]);

        Product::create([
            'name' => 'みかん',
            'price' => 80,
            'stock' => 0
        ]);
    }
}
