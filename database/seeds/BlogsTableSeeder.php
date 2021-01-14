<?php

use Illuminate\Database\Seeder;
use App\Blog;
use App\City;
use App\Locality;
use App\Category;

class BlogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Blog::create([
            'meta_title'=>'Looking for the best Restaurants near Janakpuri, Delhi?',
            'meta_description'=>'Looking for the best Restaurants near Janakpuri, Delhi? Find a compiled list here with phone numbers, address, ratings, reviews.',
            'slug'=>'restaurant-in-janakpuri',
            'title'=>'The best Restaurants near Janakpuri are here.',
            'description'=>'<p>Searching for Restaurants around Janakpuri, Delhi? Find their compiled list here with addresses, mobile numbers, and reviews.</p><div class=wuchna-featured-snippet><h2 class=h4>The Highest Rated Restaurants in Janakpuri, Delhi</h2><ol><li>Odissy</li><li>Musclefood - Healthy Food: Health Food Restaurant</li><li>Punjabi Angithi: Punjabi Restaurant</li><li>Barbeque Nation Janakpuri: Barbecue Restaurant</li><li>Q Bistro Café: Modern French Restaurant</li></ol></div><p>Other areas near Janakpuri are Tilak Nagar, Hari Nagar, Vikaspuri and Uttam Nagar, scroll down to see their Restaurants as well.</p>',
            'city_id'=>City::where('slug','delhi')->first()->id,
            'locality_id'=>Locality::where('title','Janakpuri')->first()->id,
            'category_id'=>Category::where('title','Restaurant')->first()->id,
            'data'=> ["content-top"=> 1, "content-bottom"=> 2,"aside-1"=>1,"aside-2"=>2,"aside-3"=>3,"logo_img"=>"https://m3.wuchna.com/images/1920x800/healthy-food-1.jpg"]
        ]);

        Blog::create([
            'meta_title'=>'Something technology related',
            'meta_description'=>'Looking for the best Restaurants near Janakpuri, Delhi? Find a compiled list here with phone numbers, address, ratings, reviews.',
            'slug'=>'something-tech-related',
            'title'=>'Something technology related',
            'description'=>'<p>Searching for Restaurants around Janakpuri, Delhi? Find their compiled list here with addresses, mobile numbers, and reviews.</p><div class=wuchna-featured-snippet><h2 class=h4>The Highest Rated Restaurants in Janakpuri, Delhi</h2><ol><li>Odissy</li><li>Musclefood - Healthy Food: Health Food Restaurant</li><li>Punjabi Angithi: Punjabi Restaurant</li><li>Barbeque Nation Janakpuri: Barbecue Restaurant</li><li>Q Bistro Café: Modern French Restaurant</li></ol></div><p>Other areas near Janakpuri are Tilak Nagar, Hari Nagar, Vikaspuri and Uttam Nagar, scroll down to see their Restaurants as well.</p>',
//            'city_id'=>City::where('slug','delhi')->first()->id,
//            'locality_id'=>Locality::where('title','Janakpuri')->first()->id,
            'category_id'=>Category::where('slug','tech')->first()->id,
            'data'=> ["content-top"=> 1, "content-bottom"=> 2,"aside-1"=>1,"aside-2"=>2,"aside-3"=>3]
        ]);
    }
}
