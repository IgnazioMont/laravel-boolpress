<?php

use Illuminate\Database\Seeder;
use App\Tag;
/* Importiamo lo use per lo slug */
use Illuminate\Support\Str;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Creiamo una lista di TAG */
        $tags = [
            'Gluten Free',
            'Veggy',
            'Fast & easy',
            'Traditional'
        ];

        /* Popoliamo */
        foreach($tags as $tag_name) {
            $new_tag = new Tag();
            $new_tag->name = $tag_name;
            $new_tag->slug = Str::slug($new_tag->name, '-');
            $new_tag->save();
        }
    }
}
