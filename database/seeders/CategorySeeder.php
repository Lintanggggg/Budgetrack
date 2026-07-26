<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Makan',
            'Transportasi',
            'Pulsa & Internet',
            'Kos',
            'Kuliah',
            'Hiburan',
            'Kesehatan',
            'Lainnya',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }
}