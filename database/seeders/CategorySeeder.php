<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            "id" =>1,
            "name" => 'PHP'
        ]);

        Category::create([
            "id" =>2,
            "name" => 'Javascript'
        ]);
        Category::create([
            "id" =>3,
            "name" => 'CSS'
        ]);
    }
}
