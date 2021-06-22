<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creiamo le categorie
        $categories = [
            'Antipasti',
            'Primi',
            'Secondi',
            'Contorni',
            'Desserts'
        ];

        foreach($categories as $category_name) {
            $new_category = new Category();
            $new_category->name = $category_name;
            /* Creiamo lo SLUG da "name" */
            $new_category->slug = Str::slug($new_category->name, '-');
            $new_category->save();
        }
    }
}
