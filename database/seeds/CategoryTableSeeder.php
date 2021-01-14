<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['title'=>'Restaurant','slug'=>'restaurant','data'=>[
            'banner_img'=>'https://m1.wuchna.com/images/1920x800/restaurant.jpg',
            'avatar_img'=>'https://m3.wuchna.com/images/320x320/person-in-pain.jpg',
        ],
            'description'=>'<h1>This is the description of the Restaurant page</h1><p>This goes on the /restaurant page</p>'
        ]);
        Category::create(['title'=>'Technology','slug'=>'tech','data'=>[
            'banner_img'=>'https://m1.wuchna.com/images/1920x800/restaurant.jpg',
            'avatar_img'=>'https://m3.wuchna.com/images/320x320/person-in-pain.jpg'
        ],
            'description'=>'<h1>This is the description of the Technology page</h1><p>This goes on the /tech page</p>'
        ]);
    }
}
