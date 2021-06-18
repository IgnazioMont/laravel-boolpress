<?php

use Illuminate\Database\Seeder;
use App\Post;
use Faker\Generator as Faker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        /* Usiamo FAKER per risultati random */
        for($count = 0; $count < 5; $count++) {
            $new_post = new Post();
            $new_post->title = $faker->words(4, true);
            $new_post->content = $faker->paragraphs(4, true);
            $new_post->slug = Str::slug($new_post->title, '-');
            $new_post->save();
        }
    }
}