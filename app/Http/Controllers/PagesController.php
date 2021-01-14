<?php

namespace App\Http\Controllers;

use App\Category;
use App\City;
use App\HTMLs;
use App\Http\Resources\ListingApiResource;
// use App\Jobs\SMSOTP;
// use App\Jobs\smsVendorReviewReplyLink;
use App\Listing;
use App\Blog;
use App\Mail\DigitalMarketingLead;
use App\Mail\SeoLead;
use App\Mail\SocialMediaMarketingLead;
use App\Mail\SoftwareDevelopmentLead;
use App\Mail\tellVendorAboutCustomerReview;
use App\Mail\WebsiteDevelopmentLead;
use App\Post;
use App\Product;
use App\Redirect;
use App\ReportCase;
use App\Review;
use App\SidebarHTMLs;
use App\User;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Mail;
use Spatie\ArrayToXml\ArrayToXml;

class PagesController extends Controller
{
    function isMobile(){
        if(isset($_SERVER["HTTP_USER_AGENT"])) {
            return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
        }
        return false;
    }

    public function welcome()
    {
        $ismobile = $this->isMobile();

        $todaylistings = Cache::remember('todaylistings',300,function(){
            return \App\Listing::latest()->with('blog')->take(10)->get()
                ->filter(function($item){ return strip_tags($item->description); })
            ;})->take(6);

        $todayreviews = Cache::remember('todayreviews',300,function(){
            return \App\Review::latest()->where('user_id','!=',1)->with('listing')->with('blog')->take(4)->get();
        });

        $allprioritylistings = Cache::remember('allprioritylistings',config('my.CACHE_HEAVY_DURATION'),function(){return \App\Listing::where('priority',true)->get();});

        $allpriorityblogs = Cache::remember('allpriorityblogs',config('my.CACHE_HEAVY_DURATION'),function(){return \App\Blog::where('priority',true)->get();});


        return view('welcome',compact(['ismobile','todaylistings','todayreviews','allprioritylistings','allpriorityblogs']));
    }

    function userip(){
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
//whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
//whether ip is from remote address
        else
        {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
        return $ip_address;
    }

    function showblog(City $city,Blog $blog){
        $ismobile = $this->isMobile();
        $category = $blog->category;
        $city = $blog->city()->withCount('locality')->first();
        $htmlsections = [];
        if(isset($blog->data['content-top'])){
            $htmlsections['content-top'] = HTMLs::find($blog->data['content-top'])->content;
        }
        if(isset($blog->data['content-bottom'])){
            $htmlsections['content-bottom'] = HTMLs::find($blog->data['content-bottom'])->content;
        }
//        if(isset($blog->data['aside-1'])){
//            $htmlsections['aside-1'] = SidebarHTMLs::find($blog->data['aside-1'])->content;
//        }
//        if(isset($blog->data['aside-2'])){
//            $htmlsections['aside-2'] = SidebarHTMLs::find($blog->data['aside-2'])->content;
//        }
//        if(isset($blog->data['aside-3'])){
//            $htmlsections['aside-3'] = SidebarHTMLs::find($blog->data['aside-3'])->content;
//        }
        $listings = Cache::remember('listings_of_blog_'.$blog->id,config('my.CACHE_HEAVY_DURATION'),function()use($blog){
            $alllistings = Listing::with('reviews')->withCount('reviews')->where('blog_id',$blog->id)->get();
            return $alllistings
//                ->reject(function($listing){return ! $listing->reviews_count;})
                ->sortByDesc('reviews_count')
                ->take(12);
        });
        $locality = $blog->locality;
        $relatedblogs = Cache::remember('blogs_in_locality_'.$locality->id,config('my.CACHE_HEAVY_DURATION'),function()use($locality){ return $locality->blogs;});
        $nearbyplaces = Cache::remember('nearbyplaces_'.$blog->id,config('my.CACHE_HEAVY_DURATION'),function()use($blog){
            if($blog->locality->nearbyplaces){
            return \App\Blog::whereIn('locality_id',$blog->locality->nearbyplaces)->where('category_id',$blog->category_id)->take(5)->get();}else{return collect([]);}
        });

        $catid = $blog->category_id;
        $categoryposts = Cache::remember('posts_of_category_'.$catid,config('my.HEAVY_LIGHT_DURATION'),function()use($catid){
             $ids = Post::latest()->take(50)->get()->filter(function($item)use($catid){return ($item->listing) && ($item->listing->category_id == $catid);  })->pluck('id');
             if($ids->count()) {
                 return Post::whereIn('id', $ids)->with('listing')->whereNotNull('data->content_img')->take(3)->get();
             }else{
                 return collect([]);
             }
        });
//
//        $blog->posts()->latest()->whereNotNull('posts.data->content_img')->take(3)->get();
        return view('blog', compact(['blog', 'category','city', 'ismobile','htmlsections','listings','locality','relatedblogs','nearbyplaces','categoryposts']));
    }

    function showlisting(City $city,Listing $listing){
        $ismobile = $this->isMobile();
        // For special pages, I can have special templates if needed  if($slug == 'xyz') {return 'hi';}

        // else: prepare for listing.blade:
        $htmlsections = [];
        if(isset($listing->data['content-top'])){
            $htmlsections['content-top'] = HTMLs::find($listing->data['content-top'])->content;
        }
        if(isset($listing->data['content-between'])){
            $htmlsections['content-between'] = HTMLs::find($listing->data['content-between'])->content;
        }
        if(isset($listing->data['content-bottom'])){
            $htmlsections['content-bottom'] = HTMLs::find($listing->data['content-bottom'])->content;
        }
//        if(isset($listing->data['aside-1'])){
//            $htmlsections['aside-1'] = SidebarHTMLs::find($listing->data['aside-1'])->content;
//        }
//        if(isset($listing->data['aside-2'])){
//            $htmlsections['aside-2'] = SidebarHTMLs::find($listing->data['aside-2'])->content;
//        }
//        if(isset($listing->data['aside-3'])){
//            $htmlsections['aside-3'] = SidebarHTMLs::find($listing->data['aside-3'])->content;
//        }
        $blog = $listing->blog;
        $locality = $listing->locality;
        $category = null;
        $categoryposts = collect([]);
        if($blog && $blog->category) {
            $category = $listing->blog->category;

            $catid = $category->id;
            $categoryposts = Cache::remember('posts_of_category_' . $catid, config('my.HEAVY_LIGHT_DURATION'), function () use ($catid) {
                $ids = Post::latest()->take(50)->get()->filter(function ($item) use ($catid) {
                    return ($item->listing) && ($item->listing->category_id == $catid);
                })->pluck('id');
                if ($ids->count()) {
                    return Post::whereIn('id', $ids)->with('listing')->whereNotNull('data->content_img')->take(3)->get();
                } else {
                    return collect([]);
                }
            });
        }

        return view('listing',compact(['listing','ismobile','city','htmlsections','blog','locality','category','categoryposts']));
    }

    function showcategoryblog(Category $category, Blog $blog){

        $ismobile = $this->isMobile();
        $city = $blog->city;
        $htmlsections = [];
        if(isset($blog->data['content-top'])){
            $htmlsections['content-top'] = HTMLs::find($blog->data['content-top'])->content;
        }
        if(isset($blog->data['content-bottom'])){
            $htmlsections['content-bottom'] = HTMLs::find($blog->data['content-bottom'])->content;
        }
//        if(isset($blog->data['aside-1'])){
//            $htmlsections['aside-1'] = SidebarHTMLs::find($blog->data['aside-1'])->content;
//        }
//        if(isset($blog->data['aside-2'])){
//            $htmlsections['aside-2'] = SidebarHTMLs::find($blog->data['aside-2'])->content;
//        }
//        if(isset($blog->data['aside-3'])){
//            $htmlsections['aside-3'] = SidebarHTMLs::find($blog->data['aside-3'])->content;
//        }
        $listings = $blog->listings()->with('reviews')->get();
        $locality = $blog->locality;
        $relatedblogs = $nearbyplaces = collect([]);
        return view('blog', compact(['blog', 'locality','category','city', 'ismobile','htmlsections','listings','relatedblogs','nearbyplaces']));
    }


    public function index($slug1, $slug2)
    {
        if($slug1 == 'bangalore'){return redirect(config('my.APP_URL').'/bengaluru/'.$slug2, 301);}
        if($slug1 == 'vijayawada'){return redirect(config('my.APP_URL').'/vijaywada/'.$slug2, 301);}

        $city = City::where('slug',$slug1)->first();
        if($city){
            $blog = $city->blogs()->whereNotNull('locality_id')->where('slug', $slug2)->first();
            if($blog){
                // a location-focused blog must have listings. No. you could have a delhi-focused blog, right?
//                abort_if( !$blog->listings->count()   ,404);
//                $blog->updateViews();
                return $this->showblog($city,$blog);
            }else{
                $listing = $city->listings()->where('slug', $slug2)->first();
                if(!$listing){
                    $category = Category::where('slug',$slug2)->first();
                    if($category){
                        // delhi/restaurant
                        // if there is only one locality in city, redirect the page
                        // for example, tanuku/web-service should be redirected to tanuku/web-service-in-tanuku

                        if($city->localities->count() == 1){
                            $b = Blog::where('city_id',$city->id)->where('category_id',$category->id)->first();
                            if($b){return redirect($b->full_link);}
                            abort(404);
                        }
                        $blogs = Blog::where('city_id',$city->id)->whereNotNull('locality_id')->where('category_id',$category->id)->cursor();
                        $categoryOfCityBlog = Blog::whereNull('locality_id')->whereNotNull('city_id')->where('city_id',$city->id)->where('category_id',$category->id)->first();
                        return view('categoryOfCity',compact(['category','blogs','city','categoryOfCityBlog']));
                    }
                    $r = \App\Redirect::find($slug1.'/'.$slug2);
                    if($r){
                        return redirect($r->to,301);
                    }
                    // a blog page where locality is null, and has city and category - to serve as content holder for /delhi/restaurant
                    $newb = Blog::where('city_id',$city->id)->whereNull('locality_id')->where('slug',$slug2)->first();
                    if($newb){return redirect($city->slug . '/' . $newb->category->slug);}
                    abort(404);
                }
//                $listing->updateViews();
                if(isset($listing->business_data['websitedesign'])){
                    return view('webso.'.$listing->business_data['websitedesign'].'.index',compact(['listing']));
                }
                return $this->showlisting($city,$listing);
            }
        }
        else{
            $category = Category::where('slug',$slug1)->first();
            abort_if(!$category,404);
            $blog = $category->blog()->where('slug',$slug2)->first();
            abort_if(!$blog,404);
//            $blog->updateViews();
            return $this->showcategoryblog($category,$blog);
        }

    }

    public function getreviews(Listing $listing){
        return $listing->reviews;
    }


    public function amplisting(City $city, Listing $listing)
    {
        $blog = $listing->blog;
        $reviews = $listing->reviews;
        return view('amplisting',compact(['listing','blog','reviews']));
    }

    public function ampblog(City $city, Blog $blog)
    {
        $listings = Cache::remember('listings_of_blog_'.$blog->id,config('my.CACHE_HEAVY_DURATION'),function()use($blog){
            $alllistings = Listing::with('reviews')->withCount('reviews')->where('blog_id',$blog->id)->get();
            return $alllistings
//                ->reject(function($listing){return ! $listing->reviews_count;})
                ->sortByDesc('reviews_count')
                ->take(12);
        });

        $listings = Listing::with('reviews')->where('blog_id',$blog->id)->get();
        $category = $blog->category;

        return view('ampblog',compact(['city','blog','listings','category']));
    }

    public function cityorcategory($slug1)
    {
        $city = City::where('slug',$slug1)->first();
        if($city){return view('city',compact(['city']));}
        $category = Category::where('slug',$slug1)->first();
        if($category){return view('category',compact(['category']));}
        abort(404);
    }

    public function blog(Category $category, Blog $blog)
    {
        $city = $blog->city;
        $htmlsections = [];
        if(isset($blog->data['content-top'])){
            $htmlsections['content-top'] = HTMLs::find($blog->data['content-top'])->content;
        }
        if(isset($blog->data['content-bottom'])){
            $htmlsections['content-bottom'] = HTMLs::find($blog->data['content-bottom'])->content;
        }
        if(isset($blog->data['aside-1'])){
            $htmlsections['aside-1'] = SidebarHTMLs::find($blog->data['aside-1'])->content;
        }
        if(isset($blog->data['aside-2'])){
            $htmlsections['aside-2'] = SidebarHTMLs::find($blog->data['aside-2'])->content;
        }
        if(isset($blog->data['aside-3'])){
            $htmlsections['aside-3'] = SidebarHTMLs::find($blog->data['aside-3'])->content;
        }
        $listings = $blog->listings()->with('reviews')->get();
        return view('blog', compact(['blog', 'category','city', 'ismobile','htmlsections','listings']));
    }

    public function reportlisting($id, Request $request)
    {
        $validated = $request->validate([
            'reason'=>'required',
            'email'=>'required|email'
        ]);

        if(\Auth::check() && auth()->user()->email){
            $case = ReportCase::create([
                'listing_id'=>$id,
                'body'=>$validated['reason'],
                'user_id'=>auth()->id(),
                'data'=>['status'=>'Under Review','user_email'=>auth()->user()->email,'user_ip'=>$this->userip()]
            ]);
            return 'finished';
        }

        $otp = rand(100000,999999);
        // send OTP via SMS
        // SMSOTP::dispatch($otp,ltrim($validated['phone'],'0'))
        //     ->delay(now()->addSeconds(1));

        Mail::to($validated['email'])->queue(new otpSender($otp));

        $case = ReportCase::create([
            'listing_id'=>$id,
            'body'=>$validated['reason'],
            'data'=>['status'=>'unverified','user_email'=>$validated['email'],'user_ip'=>$this->userip(),'otpsent'=>$otp]
        ]);
        return $case->id;
    }

    public function reportlistingotpsubmit($id, Request $request)
    {
        $validated = $request->validate(['otp'=>'required|numeric|min:100000', 'email'=>'required|email|unique']);
        $case = ReportCase::findOrFail($id);

        if( ($case->data['user_email'] == $validated['email']) && ($case->data['otpsent'] == $validated['otp'])){
            // save the ReportCase
            $case->data=['status'=>'Under Review','user_email'=>$validated['email']];
            $case->save();

            try {
                // make a user
                $user = User::create([
                    'name'=>$validated['email'],
                    'email' => $validated['email'],
                    'password'=>bcrypt(Str::random('12')),
                    'phone'=>NULL,
                    'phone_verified_at'=>now()
                ]);
                // login the user
                Auth::login($user, true);
                $case->user_id = $user->id;
                $case->save();
                return 'finished';
            }catch(\Exception $e){
                $user = User::where('email',$validated['email'])->firstOrFail();
                Auth::login($user, true);
                $case->update(['user_id'=>$user->id]);
                return 'finished';
            }
        }else{
            return 'otpmismatch';
        }

    }

    public function createreview(Request $request)
    {
    //    dd($request->all());

        if(Auth::check()){
            $validated = $request->validate([
                'rating'=>'required',
                'review'=>'required',
                'listing_id'=>'required'
            ]);
            $listing = Listing::findOrFail($validated['listing_id']);
            $listing->review()->create([
                'user_id'=>auth()->id(),
                'user_name'=> auth()->user()->display_name,
                'body'=>strip_tags($validated['review']),
                'rating'=>$validated['rating'],
                'data'=> ['status'=>'Under Review','user_email'=>auth()->user()->email]
            ]);

            // send the vendor the link to review the comment
            $link = $listing->full_link;
//            smsVendorReviewReplyLink::dispatch($link,ltrim(str_replace(' ','',$listing->raw['phone']),'0'))
//                ->delay(now()->addSeconds(1));

            if($listing->email) {
                Mail::to($listing->email)->bcc('info@wuchna.com')
                    ->queue(new tellVendorAboutCustomerReview($listing,auth()->user()));
            }
            return 'thanks';
        }
        else{
            $validated = $request->validate([
                'user_name'=>'required',
                'user_email'=>'required|email',
                'rating'=>'required',
                'review'=>'required',
                'listing_id'=>'required'
            ]);

            $otp = rand(100000,999999);
            // send OTP via SMS
            $listing = Listing::findOrFail($validated['listing_id']);
            $review = $listing->review()->create([
                'data'=>['status'=>'unverified','user_name'=> $validated['user_name'],'user_email'=> $validated['user_email'], 'otpsent'=>$otp ],
                'user_name'=> $validated['user_name'],
                'body'=>strip_tags($validated['review']),
                'rating'=>$validated['rating']
            ]);

            // SMSOTP::dispatch($otp,ltrim($validated['user_email'],'0'))
            //     ->delay(now()->addSeconds(1));

            Mail::to($validated['user_email'])->queue(new otpSender($otp));

            Mail::to($listing->email)->bcc('info@wuchna.com')
                    ->queue(new tellVendorAboutCustomerReview($listing,auth()->user()));


            return $review->id;

        }


    }

    public function reviewotp($id, Request $request)
    {
        $validated = $request->validate([
            'otp'=>'required|numeric|min:100000',
            'user_email'=>'required|email'
        ]);
        $review = Review::withoutGlobalScope('verified')->findOrFail($id);

        if( ($review->data['user_email'] == $validated['user_email']) && ($review->data['otpsent'] == $validated['otp'])){
            // save the ReportCase
            $review->data=['status'=>'Under Review','user_email'=>$validated['user_email']];
            $review->save();
            $user = User::where('email',$validated['user_email'])->first();
            if(!$user){
                try {
                    // make a user
                    $user = User::create([
                        'name'=>$validated['user_email'],
                        'email' => $validated['user_email'],
                        'password'=>bcrypt(Str::random('12')),
                        'phone'=>NULL,
                        'phone_verified_at'=>now()
                    ]);
                    // login the user
                }catch(\Exception $e){
                    $review->update(['user_id'=>$user->id]);
                    return 'review-ok-but-no-login';
//                    $user = User::where('email',$validated['user_email'])->firstOrFail();
                }
            }


            Auth::login($user, true);
            $review->update(['user_id'=>$user->id]);
            // send the vendor the link to review the comment
            //    if(isset($review->listing->raw['phone'])) {
                //    $link = $review->listing->full_link;
                //    smsVendorReviewReplyLink::dispatch($link, ltrim(str_replace(' ', '', $review->listing->raw['phone']), '0'))
                //        ->delay(now()->addSeconds(1));
            //    }
            if($review->listing->email) {
                Mail::to($review->listing->email)->bcc('info@wuchna.com')
                    ->queue(new tellVendorAboutCustomerReview($review->listing,auth()->user()));
            }
            return 'finished';
        }else{
            return 'otpmismatch';
        }

    }

    public function foundreviewhelpful(Review $review)
    {
        $data = $review->data;
        if(isset($data['helpfulcount'])){$data['helpfulcount']++;}else{$data['helpfulcount'] = 1;}
        $review->update(['data'=>$data]);
        return 'thanks';
    }

    public function localitiesApi(City $city)
    {
        return (\Cache::remember('localities_of_city_'.$city->title, config('my.CACHE_HEAVY_DURATION'), function()use($city){ return $city->localities()->orderBy('title')->select('title','id')->get();}) );
    }

    public function listingsApi(Listing $listing)
    {
        return new ListingApiResource($listing);
    }

    public function blogsitemapbycity(City $city)
    {
        $array=[];
        $array = Cache::remember($city->slug.'-blog-sitemap', config('my.CACHE_HEAVY_DURATION'), function() use($city){
            $array['url'] = Blog::where('city_id',$city->id)->selectRaw("CONCAT('".config('my.APP_URL')."/','".$city->slug."','/',slug) as loc, to_char(updated_at::TIMESTAMP,'YYYY-MM-DD\"T\"HH:MI:SS+05:30') as lastmod,'daily' as changefreq,'0.9' as priority")->cursor()->toArray();
            return $array;
        });

        $content =  ArrayToXml::convert($array, [
            'rootElementName' => 'urlset',
            '_attributes' => [
                'xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
                'xmlns:xhtml'=>'http://www.w3.org/1999/xhtml',
                'xmlns:image'=>'http://www.google.com/schemas/sitemap-image/1.1',
                'xmlns:video'=>'http://www.google.com/schemas/sitemap-video/1.1'
            ],
        ], true, 'UTF-8');

        return Response::make($content, '200')->header('Content-Type', 'text/xml');

    }

    public function blogsitemapbycategory(Category $category)
    {
        $array=[];
        $array = Cache::remember($category->slug.'-blogs-sitemap', config('my.CACHE_HEAVY_DURATION'), function() use($category){
            $array['url'] = Blog::whereNull('city_id')->where('category_id',$category->id)->selectRaw("CONCAT('".config('my.APP_URL')."/','".$category->slug."','/',slug) as loc, to_char(updated_at::TIMESTAMP,'YYYY-MM-DD\"T\"HH:MI:SS+05:30') as lastmod,'daily' as changefreq,'0.9' as priority")->cursor()->toArray();
            return $array;
        });

        $content =  ArrayToXml::convert($array, [
            'rootElementName' => 'urlset',
            '_attributes' => [
                'xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
                'xmlns:xhtml'=>'http://www.w3.org/1999/xhtml',
                'xmlns:image'=>'http://www.google.com/schemas/sitemap-image/1.1',
                'xmlns:video'=>'http://www.google.com/schemas/sitemap-video/1.1'
            ],
        ], true, 'UTF-8');

        return Response::make($content, '200')->header('Content-Type', 'text/xml');

    }

    public function listingsitemapbycity(City $city)
    {
        $array=[];
        $array = Cache::remember($city->slug.'-listing-sitemap', config('my.CACHE_HEAVY_DURATION'), function() use($city){
            $array['url'] = Listing::where('city_id',$city->id)->selectRaw("CONCAT('".config('my.APP_URL')."/','".$city->slug."','/',slug) as loc, to_char(updated_at::TIMESTAMP,'YYYY-MM-DD\"T\"HH:MI:SS+05:30') as lastmod,'daily' as changefreq,'0.9' as priority")->cursor()->toArray();
            return $array;
        });

        $content =  ArrayToXml::convert($array, [
            'rootElementName' => 'urlset',
            '_attributes' => [
                'xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
                'xmlns:xhtml'=>'http://www.w3.org/1999/xhtml',
                'xmlns:image'=>'http://www.google.com/schemas/sitemap-image/1.1',
                'xmlns:video'=>'http://www.google.com/schemas/sitemap-video/1.1'
            ],
        ], true, 'UTF-8');

        return Response::make($content, '200')->header('Content-Type', 'text/xml');

    }

    public function sitemap()
    {
        $array=[];
        $part=[];
        $regionsinlistings = City::get()->pluck('slug');
        $array = Cache::remember('wuchna-sitemap', config('my.CACHE_HEAVY_DURATION'), function() use ($regionsinlistings){
            $lastmod = Blog::latest()->selectRaw("to_char(updated_at::TIMESTAMP,'YYYY-MM-DD\"T\"HH:MI:SS+05:30') as lastmod")->first()->lastmod;
            foreach($regionsinlistings as $region)
            {
                $part[] = [
                    'loc'=>config('my.APP_URL').'/lps/'.$region,
                    'lastmod' => $lastmod
                ];
                $part[] = [
                    'loc'=>config('my.APP_URL').'/placessitemap/'.$region,
                    'lastmod' => $lastmod
                ];
            }

            foreach(Blog::whereNull('city_id')->pluck('category_id')->unique() as $category)
            {
                $part[] = [
                    'loc'=>config('my.APP_URL').'/categorysitemap/'.$category,
                    'lastmod' => $lastmod
                ];
            }

            $array['sitemap'] = $part;
            return $array;

        });


        $content =  ArrayToXml::convert($array, [
            'rootElementName' => 'sitemapindex',
            '_attributes' => [
                'xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9'
            ],
        ], true, 'UTF-8');

        return Response::make($content, '200')->header('Content-Type', 'text/xml');

    }


    public function seolead(Request $request)
    {
        $validated = $request->validate([
            'mobile'=>'required|numeric|min:1000000000'
        ]);
        \Mail::queue(new SeoLead($validated['mobile']));
        return back()->withMessage('Thanks, we will get back to you very soon.');
    }

    public function websitedevelopmentlead(Request $request)
    {
        $validated = $request->validate([
            'mobile'=>'required|numeric|min:1000000000'
        ]);
        \Mail::queue(new WebsiteDevelopmentLead($validated['mobile']));
        return back()->withMessage('Thanks, we will get back to you very soon.');
    }

    public function digitalmarketinglead(Request $request)
    {
        $validated = $request->validate([
            'mobile'=>'required|numeric|min:1000000000'
        ]);
        \Mail::queue(new DigitalMarketingLead($validated['mobile']));
        return back()->withMessage('Thanks, we will get back to you very soon.');
    }

    public function socialmediamarketinglead(Request $request)
    {
        $validated = $request->validate([
            'mobile'=>'required|numeric|min:1000000000'
        ]);
        \Mail::queue(new SocialMediaMarketingLead($validated['mobile']));
        return back()->withMessage('Thanks, we will get back to you very soon.');
    }

    public function softwaredevelopmentlead(Request $request)
    {
        $validated = $request->validate([
            'mobile'=>'required|numeric|min:1000000000'
        ]);
        \Mail::queue(new SoftwareDevelopmentLead($validated['mobile']));
        return back()->withMessage('Thanks, we will get back to you very soon.');
    }

    public function badge($slugorid)
    {
        $listing = Listing::where('slug',$slugorid)->first();
        if(! $listing) {
            $listing = Listing::find($slugorid);
            abort_if($listing == null, 404);
        }
        if(!$listing->user){return 'You are not verified yet';}

//        dd($listing);
        $ismobile = false;
        return view('badge',compact(['listing','ismobile']));
    }

    public function showpost(City $city,Listing $listing,Post $post)
    {
        return view('post',compact(['post','listing']));
    }

    public function showproduct(City $city,Listing $listing,Product $product)
    {
        return view('product',compact(['product','listing']));
    }

}
