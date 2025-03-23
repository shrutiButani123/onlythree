<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\SubCategory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $electronics = Category::create(['name' => 'Electronics']);
        $cloths = Category::create(['name' => 'Cloths']);

        if($electronics){
            SubCategory::create(['name' => 'Mobile', 'category_id' => $electronics->id]);
            SubCategory::create(['name' => 'Laptop', 'category_id' => $electronics->id]);
        }

        if($cloths){
            SubCategory::create(['name' => 'Shirt', 'category_id' => $cloths->id]);
            SubCategory::create(['name' => 'Jeans', 'category_id' => $cloths->id]);
        }
    }
}
