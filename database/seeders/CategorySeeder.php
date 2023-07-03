<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Telefon',
            ],
            [
                'name' => 'Bilgisayar',
            ],
            [
                'name' => 'Oyunculara Özel',
            ],
            [
                'name' => 'Kamera',
            ],
            [
                'name' => 'Diğer'
            ]
        ];

        foreach ($categories as $key => $category) {
            $categories[$key]['created_at'] = now()->addMinute($key)->addSecond($key);
        }

        Category::insert($categories);
    }
}
