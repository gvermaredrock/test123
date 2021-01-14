<?php

use Illuminate\Database\Seeder;
use App\Locality;
use App\City;

class LocalityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Locality::create([ 'slug'=>'janakpuri','title'=>'Janakpuri', 'city_id'=> City::where('slug','delhi')->first()->id,
            "nearbyplaces"=>[2,3]
        ]);
        Locality::create([ 'title'=>'Kalkaji','slug'=>'kalkaji', 'city_id'=> City::where('slug','delhi')->first()->id,'nearbyplaces'=>[1,3] ]);
        Locality::create([ 'title'=>'South Ex','slug'=>'south-ex', 'city_id'=> City::where('slug','delhi')->first()->id,'nearbyplaces'=>[2,1] ]);
        Locality::create([ 'title'=>'Mumbai 1','slug'=>'mumbai-1', 'city_id'=> City::where('slug','mumbai')->first()->id ]);
        Locality::create([ 'title'=>'Mumbai 2','slug'=>'mumbai-2', 'city_id'=> City::where('slug','mumbai')->first()->id ]);
        Locality::create([ 'title'=>'Mumbai 3','slug'=>'mumbai-3', 'city_id'=> City::where('slug','mumbai')->first()->id ]);
    }
}
