<?php

use App\Blog;
use App\Listing;
use App\Product;
use Illuminate\Support\Facades\Route;


Auth::routes();
// Auth Pages - UserController
Route::post('/loginviaotp','UserController@loginviaotp')->middleware('throttle:5,1');
Route::post('/clicktocall','UserController@clicktocall')->middleware('throttle:5,1');
Route::post('/clicktocallotp','UserController@clicktocallotp');
Route::post('/enterotp','UserController@enterotp');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');


// Public Pages - PagesController
Route::get('/', 'PagesController@welcome');
Route::view('/allcities', 'allcities');
Route::view('/allcategories', 'allcategories');
Route::get('/badge/{slugorid}','PagesController@badge');
Route::get('{city}/{listing}/posts/{post}','PagesController@showpost');
Route::get('{city}/{listing}/products/{product}','PagesController@showproduct');

Route::post('/reportlisting/{id}', 'PagesController@reportlisting')->middleware('throttle:3,1');
Route::post('/otpsubmit/{id}', 'PagesController@reportlistingotpsubmit');
Route::post('/reviews', 'PagesController@createreview');
Route::post('/reviewotpsubmit/{id}', 'PagesController@reviewotp')->middleware('throttle:3,1');
Route::post('/foundreviewhelpful/{review:id}', 'PagesController@foundreviewhelpful')->middleware('throttle:15,1');

// Lead pages
Route::post('/seo-company-lead', 'PagesController@seolead')->middleware('throttle:15,1');
Route::post('/software-development-lead', 'PagesController@softwaredevelopmentlead')->middleware('throttle:15,1');
Route::post('/website-development-lead', 'PagesController@websitedevelopmentlead')->middleware('throttle:15,1');
Route::post('/digital-marketing-lead', 'PagesController@digitalmarketinglead')->middleware('throttle:15,1');
Route::post('/social-media-marketing-lead', 'PagesController@socialmediamarketinglead')->middleware('throttle:15,1');



//SiteMap
Route::get('lps/{city}', 'PagesController@blogsitemapbycity');
Route::get('placessitemap/{city}', 'PagesController@listingsitemapbycity');
Route::get('categorysitemap/{category:id}', 'PagesController@blogsitemapbycategory');
Route::get('/sitemap.xml', 'PagesController@sitemap');

//Convenience Routes
Route::get('/product/{id}', function($id){ $p = Product::find($id); abort_if(! $p, 404); return redirect($p->full_link); })->where('id', '[0-9]+')->middleware('auth','admin');
Route::get('/productdata/{id}', function($id){ $p = Product::find($id); abort_if(! $p, 404); dd($p->data); })->where('id', '[0-9]+')->middleware('auth','admin');
Route::get('/listing/{id}', function($id){ $l = Listing::find($id); abort_if(! $l, 404); return redirect($l->full_link); })->where('id', '[0-9]+')->middleware('auth','admin');
Route::get('/phone/{id}', function($id){ $l = Listing::where('phone',$id)->get(); abort_if(! $l, 404);

    if($l->count() > 1){
        $toprint = "<br><br><h1>Multiple Listings found.</h1><br>";
        foreach ($l as $listing)
        {
            $toprint = $toprint."<br><a href='".$listing->full_link."' target='_blank' >".$listing->full_link."</a><br>";
        }
        return $toprint;
    }
    return redirect($l->full_link);
})->where('id', '[0-9]+')->middleware('auth','admin');
Route::get('/listingdata/{id}', function($id){ $l = Listing::find($id); abort_if(! $l, 404); dd($l->data); })->where('id', '[0-9]+')->middleware('auth','admin');
Route::get('/blog/{id}', function($id){ $b = Blog::find($id); abort_if(!$b,404); return redirect($b->full_link); })->where('id', '[0-9]+')->middleware('auth','admin');

// Private Pages - HomeController (middleware:auth)
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/addbusiness', 'HomeController@addbusiness');
Route::get('/claimbusiness/{id?}', 'HomeController@claimbusiness');
Route::get('/editbusiness/{listing:id}', 'HomeController@editbusiness');
Route::get('/managecomments', 'HomeController@manageComments');
Route::get('/manageposts', 'HomeController@managePosts');
Route::get('/manageproducts', 'HomeController@manageProducts');
Route::get('/addpost', 'HomeController@addPost');
Route::get('/addproduct', 'HomeController@addProduct');
Route::get('/editpost/{post:id}', 'HomeController@editPost');
Route::get('/editproduct/{product:id}', 'HomeController@editProduct');
Route::post('/addpost/{listing:id}', 'HomeController@storeaddPost');
Route::post('/addproduct/{listing:id}', 'HomeController@storeaddProduct');
Route::post('/editpost/{post:id}', 'HomeController@storeeditPost');
Route::post('/editproduct/{product:id}', 'HomeController@storeeditProduct');
Route::post('/addbusiness', 'HomeController@storeaddbusiness');
Route::post('/claimbusiness/{listing:id}', 'HomeController@storeclaimbusiness');
Route::post('/editbusiness', 'HomeController@storeeditbusiness');
Route::post('/vendorreply/{review}', 'HomeController@storeVendorReply');
Route::post('/leadgenerated/{listing:id}', 'HomeController@leadgenerated');


//Admin Actions - AdminController
Route::get('/latestleads','AdminController@latestleads');
Route::get('/admineditbusiness/{listing:id}', 'AdminController@editbusiness');
Route::get('/admineditblog/{blog:id}', 'AdminController@editblog');
Route::post('/admineditblog/{blog:id}', 'AdminController@storeeditblog');
Route::get('/adminleadsanalysis/{listing:id}', 'AdminController@leadsAnalysis');
Route::get('/admindeletebusiness/{listing:id}', 'AdminController@deletebusiness');
Route::get('/admindeleteblog/{blog:id}', 'AdminController@deleteblog');
Route::get('/admindeletereference/{reference:id}', 'AdminController@deletereference');
Route::post('/admineditbusiness', 'AdminController@storeeditbusiness');
Route::post('/admindeleteandredirectlisting/{listing:id}', 'AdminController@admindeleteandredirectlisting');
Route::post('/adminaddlistingmeta', 'AdminController@addlistingmeta');
Route::post('/adminaddblogmeta', 'AdminController@addblogmeta');
Route::get('/approvereview/{review}','AdminController@approveReview');
Route::get('/deletereview/{review}','AdminController@deleteReview');
Route::get('/rejectreview/{review}','AdminController@rejectReview');
Route::get('/editreview/{review}','AdminController@editReview');
Route::post('/editreview/{review}','AdminController@storeeditReview');
Route::post('/redirecttovendor','AdminController@redirecttovendor');
Route::post('/addleadinteraction/{listing:id}','AdminController@addleadinteraction');
Route::get('/nowhatsapp/{listing:id}','AdminController@nowhatsapp');
Route::get('/deletephone/{listing:id}','AdminController@deletephone');

// City or category redirects
Route::get('/bangalore',function (){return redirect('/bengaluru');});


// Public Catchall Pages - PagesController
Route::get('/amp/{city}/{listing}','PagesController@amplisting');
Route::get('/ampb/{city}/{blog}','PagesController@ampblog');
Route::get('/{slug1}', 'PagesController@cityorcategory');
Route::get('/{slug1}/{slug2}', 'PagesController@index');


