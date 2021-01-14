<?php
namespace App\Services;

use App\Blog;
use App\Category;
use App\City;
use App\Listing;
use App\Locality;
use Arr;
use Str;

class BlogCreator
{
    public static function creator($city_id, $locality_id, $category_id)
    {
        function str_lreplace($search, $replace, $subject)
        {
            $pos = strrpos($subject, $search);

            if($pos !== false)
            {
                $subject = substr_replace($subject, $replace, $pos, strlen($search));
            }

            return $subject;
        }


        function generateLPMeta($category,$locality,$city)
        {
//            $slugcategory = $category->slug;
//            $sluglocality = $locality->slug;

            $title =
                Arr::random(['Looking for ','Are you looking for ','Are you searching for ','Searching for '])
                .Arr::random(['contact '
                    .Arr::random(['details ','information '])
                    .Arr::random(['of ','about ','regarding '])
                    ,''])
                .Arr::random(['the best ','','the top '])
                .Str::plural($category->title)
                .' near '
                .$locality->title
                .', '
                .$city->title
                .'? ';



            $finaltitle = ''.
                Arr::random([

                    str_replace(['contact details regarding ', 'contact details about ', 'contact information regarding '],'',$title),

                    str_replace(['contact details regarding ', 'contact details about ', 'contact information regarding '],'',$title),

                    str_replace(['contact details regarding ', 'contact details about ', 'contact information regarding '],'',$title),

                    Arr::random(['The best ','','The top '])
                    .Str::plural($category->title)
                    .' near '
                    .$locality->title
                    .' are here'
                    .Arr::random(['.','!','!!','!!!']),

                    'A '
                    .Arr::random(['compiled ',''])
                    .'list of '
                    .Arr::random(['the best ','','the top '])
                    .Str::plural($category->title)
                    .' near '
                    .$locality->title
                    .', '
                    .$city->title
                    .'.'  ,

                    'A '
                    .Arr::random(['compiled ',''])
                    .'list of '
                    .Arr::random(['the best ','','the top '])
                    .Str::plural($category->title)
                    .' near '
                    .$locality->title
                    .', '
                    .$city->title
                    .'.'


                ]);


            $description = $title
                .'Find '
                .Arr::random(['their ','a '])
                .Arr::random(['compiled ',''])
                .'list here '
                .Arr::random([
                    '- '
                    .Arr::random(['each ','which '])
                    .Arr::random(['contains ','has '])
                    ,'with '])
                .Arr::random([
                    'phone numbers, address, ratings, reviews.',
                    'address, ratings, reviews and contact info.',
                    'ratings, reviews, contact information, and map location.',
                    'reviews, ratings, phone number and address link.',
                    'ratings and reviews so you can compare them, and map location and phone number so you can contact them easily.',
                    'addresses, mobile numbers, and reviews.',
                    'ratings, phone numbers, addresses and detailed information.',
                    'mobile numbers and reviews so you can contact them easily.',
                    'map location, direct phone number, ratings and reviews so you can compare them and reach out.',
                    'map location link, direct mobile number and reviews so you can compare and reach them easily.'

                ])
            ;

            $contenttitle =
                Arr::random(['Looking for ','Are you looking for ','Are you searching for ','Searching for '])
                .Arr::random(['contact '
                    .Arr::random(['details ','information '])
                    .Arr::random(['of ','about ','regarding '])
                    ,''])
                .Arr::random(['the best ','','the top '])
                .Str::plural($category->title)." "
                .Arr::random(['around ',' near ','close to ','nearby ','very close to '])
                .$locality->title
                .', '
                .$city->title
                .'? ';

            $contentfinaltitle = ''.
                Arr::random([

                    str_replace(['contact details regarding ', 'contact details about ', 'contact information regarding '],'',$contenttitle),

                    str_replace(['contact details regarding ', 'contact details about ', 'contact information regarding '],'',$title),

                    str_replace(['contact details regarding ', 'contact details about ', 'contact information regarding '],'',$contenttitle),

                    Arr::random(['The best ','','The top '])
                    .Str::plural($category->title)
                    .' near '
                    .$locality->title
                    .' are here'
                    .Arr::random(['.','!','!!','!!!']),

                    'A '
                    .Arr::random(['compiled ',''])
                    .'list of '
                    .Arr::random(['the best ','','the top '])
                    .Str::plural($category->title)
                    .' in '
                    .$locality->title
                    .', '
                    .$city->title
                    .'.'  ,

                    'A '
                    .Arr::random(['compiled ',''])
                    .'list of '
                    .Arr::random(['the best ','','the top '])
                    .Str::plural($category->title)
                    .' in '
                    .$locality->title
                    .', '
                    .$city->title
                    .'.'


                ]);


            $content = '<h1>'.$contentfinaltitle.'</h1><p>'.$contenttitle
                .'Find '
                .Arr::random(['their ','a '])
                .Arr::random(['compiled ',''])
                .'list here '
                .Arr::random([
                    '- '
                    .Arr::random(['each ','which '])
                    .Arr::random(['contains ','has '])
                    ,'with '])
                .Arr::random([
                    'phone numbers, address, ratings, reviews.',
                    'address, ratings, reviews and contact info.',
                    'ratings, reviews, contact information, and map location.',
                    'reviews, ratings, phone number and address link.',
                    'ratings and reviews so you can compare them, and map location and phone number so you can contact them easily.',
                    'addresses, mobile numbers, and reviews.',
                    'ratings, phone numbers, addresses and detailed information.',
                    'mobile numbers and reviews so you can contact them easily.',
                    'map location, direct phone number, ratings and reviews so you can compare them and reach out.',
                    'map location link, direct mobile number and reviews so you can compare and reach them easily.'

                ])
                .'</p>';

//            $nearbyplaces = App\Geocoding::where('placename',$sluglocality)->first()->nearbyplaces;

//            $finalnearbyplaces = [];
//            $i = 1;
//            foreach($nearbyplaces as $nearbyplace){
//                if($i <5){
//                    if($nearbyplace !== $sluglocality){
//                        if(\App\ListingsPage::where('city',$lp->city)->where('slug',$slugcategory.'-in-'.$nearbyplace)->first()){
//                            $finalnearbyplaces[] = $nearbyplace;
//                        } // if ends
//                        $i++;
//                    } // if ends of not equal to
//                } // ends if i<5
//            } // foreach ends

//            if(! count($finalnearbyplaces)){
//
//                foreach($nearbyplaces as $nearbyplace){
//                    if($i <5){
//                        if($nearbyplace !== $sluglocality){
//                            if(\App\ListingsPage::where('slug',$slugcategory.'-in-'.$nearbyplace)->first()){
//                                $finalnearbyplaces[] = $nearbyplace;
//                            } // if ends
//                            $i++;
//                        } // if ends of not equal to
//                    } // ends if i<5
//                } // foreach ends
//            }


//            if(sizeof($finalnearbyplaces)){
//                $content = $content."<p>".
//                    Arr::random([
//                        "Other areas near "
//                        .ucwords(str_replace('-',' ',$sluglocality))
//                        ." are "
//                        .str_lreplace(',', ' and', ucwords(str_replace('-',' ',implode(', ',$finalnearbyplaces))))
//                        .", scroll down to see their "
//                        .Str::plural(ucwords(str_replace('-',' ',$slugcategory)))
//                        ." as well."  ,
//
//                        Arr::random(["Areas ","Localities ",''])
//                        .str_lreplace(',', ' and', ucwords(str_replace('-',' ',implode(', ',$finalnearbyplaces))))
//                        ." are located "
//                        .Arr::random(['very ',''])
//                        .Arr::random(['near ','close to ', 'near to '])
//                        .ucwords(str_replace('-',' ',$sluglocality))
//                        .Arr::random([" as well. "," also. "])
//                        .Arr::random(['This page shows ', 'This page includes ', 'We have listed '])
//                        ."their "
//                        .Str::plural(ucwords(str_replace('-',' ',$slugcategory)))
//                        .Arr::random([" also, ", " as well, "])
//                        .Arr::random(['so you can choose easily.','for your convenience.'])
//                        ,
//
//                        Arr::random(["This page lists ","Below we present to you a list of ","Below you can find a list of the top "])
//                        .Str::plural(ucwords(str_replace('-',' ',$slugcategory)))." "
//                        .Arr::random(['in ','around ','near ','nearby '])
//                        .ucwords(str_replace('-',' ',$sluglocality))
//                        .Arr::random([", as well as ",", and also ", " alongwith "])
//                        .Str::plural(ucwords(str_replace('-',' ',$slugcategory)))
//                        .Arr::random([" in "," near "])
//                        .str_lreplace(',', ' and', ucwords(str_replace('-',' ',implode(', ',$finalnearbyplaces))))
//                        .", which are "
//                        .Arr::random(["located ","","situated "])
//                        .Arr::random(["right next ","quite close ","adjacent "])
//                        ."to "
//                        .ucwords(str_replace('-',' ',$sluglocality))
//                        .", so you can "
//                        .Arr::random(["contact ","see ","compare ","refer to "])
//                        ."them as well. "
//                    ])
//                    ."</p>";
//
//            }

            return ['title'=>$finaltitle , 'description' => $description , 'content' => $content ];
        }


        $city = City::find($city_id);
        $locality = Locality::find($locality_id);
        $category = Category::find($category_id);
        $meta_data = generateLPMeta($category,$locality,$city);
        $slug = \Str::slug($category->slug . '-in-' . $locality->slug);

        while(Listing::where('slug',$slug)->where('city_id',$city_id)->first()
            || Blog::where('slug',$slug)->where('city_id',$city_id)->first() ){
            // another listing already exists with that slug and city.
            $slug = $slug.'-'.rand(1,999);
        }
        try {
            $blog = Blog::create([
                'slug' => $slug,
                'meta_title' => $meta_data['title'],
                'meta_description' => $meta_data['description'],
                'title' => $meta_data['title'],
                'description' => '<h1>' . $meta_data['title'] . '</h1><p>' . $meta_data['description'] . '</p>',
                'city_id' => $city_id,
                'locality_id' => $locality_id,
                'category_id' => $category_id,
            ]);
            return $blog;
        }catch(\Exception $e){}
        return redirect('/home');
    }
}
