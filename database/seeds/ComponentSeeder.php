<?php

use App\Models\File;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $introCategory = Category::where('name', 'Introduction')->get()->first();

        $xIfComponent = $introCategory->components()->create([
            'name' => 'x-if',
            'description' => 'hello',
        ]);

        $introCategory->components->first()->files()->createMany([
            [
                'path' => '',
                'extension' => File::JS,
            ],
            [
                'path' => '',
                'extension' => File::HTML,
            ],
        ]);
    }
}
