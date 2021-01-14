<?php

use Illuminate\Database\Seeder;

use App\Review;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Review::create([
            'listing_id'=>1,
            'user_name'=>'Some Random',
            'body'=>'This is a rgeat restaruant',
            'rating'=>4,
            'data'=>['status'=>'unverified','user_name'=> 'Some Random','user_phone'=> 9871002345, 'otpsent'=>123456 ],
        ]);

        Review::create([
            'listing_id'=>1,
            'user_id'=>1,
            'body'=>'This is a rgeat restaruant 2',
            'rating'=>3,
            'data'=>['status'=>'Under Review','user_phone'=>9871002345]
        ]);
    }
}
