<?php

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
        Category::create([
            'order' => 1,
            'name' => 'Directives',
        ]);

        Category::create([
            'order' => 2,
            'name' => 'Magic Properties',
        ]);

        Category::create([
            'order' => 3,
            'name' => 'Nav',
        ]);

        Category::create([
            'order' => 4,
            'name' => 'Form',
        ]);

        Category::create([
            'order' => 4,
            'name' => 'Images Galery',
        ]);
    }
}
