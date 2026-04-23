<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\AutoReply;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technical = Category::create(['name' => 'Technical']);
        $billing   = Category::create(['name' => 'Billing']);

        AutoReply::insert([
            [
                'category_id' => $technical->id,
                'message' => 'Silakan coba restart aplikasi terlebih dahulu.'
            ],
            [
                'category_id' => $technical->id,
                'message' => 'Pastikan koneksi internet stabil.'
            ]
        ]);
    }
}
