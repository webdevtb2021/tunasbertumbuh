<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;
use App\Models\ArticleImage;


class UserArticleImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('article_images')->delete();
        \DB::table('articles')->delete();
        \DB::table('users')->delete();

        User::factory(30)->create()->each(function($u) {
            $u->articles()
              ->saveMany(
                  Article::factory(rand(1, 3))->make()
              )
              ->each(function ($a) {
                $a->articleImages()->saveMany(ArticleImage::factory(rand(1, 3))->make());
              });
        });  
    }
}
