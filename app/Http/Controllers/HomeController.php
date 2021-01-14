<?php

namespace App\Http\Controllers;

use App\Blog;
use App\City;
use App\Lead;
use App\Listing;
use App\Post;
use App\Product;
use App\Review;
use App\Services\BlogCreator;
use App\Services\BusinessOpen;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }
    public function addbusiness()
    {
        if(auth()->user()->listing){return redirect('home');}
        return view('addbusiness');
    }
    public function claimbusiness($id = null)
    {
        if(auth()->user()->listing){return redirect('home');}
        return view('claimbusiness',compact(['id']));
    }
    public function editbusiness(Listing $listing)
    {
        if(!auth()->user()->listing){return redirect('home');}
        if(auth()->user()->listing->id != $listing->id){return redirect('home');}
        return view('editbusiness',compact(['listing']));
    }

    public function storeclaimbusiness(Listing $listing)
    {
        if(auth()->user()->listing){return redirect('home');}

        $listing->update(['user_id' => auth()->id()]);
        return redirect('/editbusiness/'.$listing->id)->withMessage('Successful. You can now edit the business details below');
    }

    public function manageComments()
    {
        $listing = auth()->user()->listing;
        abort_if(!$listing,404);
        $reviews = $listing->reviews;
        return view('managecomments',compact(['listing','reviews']));
    }

    public function managePosts()
    {
        $listing = auth()->user()->listing;
        abort_if(!$listing,404);
        $posts = $listing->posts;
        return view('manageposts',compact(['listing','posts']));
    }

    public function manageProducts()
    {
        $listing = auth()->user()->listing;
        abort_if(!$listing,404);
        $products = $listing->products;
        return view('manageproducts',compact(['listing','products']));
    }

    public function addPost()
    {
        $listing = auth()->user()->listing;
        abort_if(!$listing,404);
        return view('addpost',compact(['listing']));
    }

    public function addProduct()
    {
        $listing = auth()->user()->listing;
        abort_if(!$listing,404);
        return view('addproduct',compact(['listing']));
    }

    public function editPost(Post $post)
    {
        abort_if(($post->user_id != auth()->id())&&(auth()->id()!=1),404);
        return view('editpost',compact(['post']));
    }

    public function editProduct(Product $product)
    {
        abort_if(($product->user_id != auth()->id())&&(auth()->id()!=1),404);
        return view('editproduct',compact(['product']));
    }

    public function storeaddPost(Listing $listing,Request $request)
    {
        abort_if(($listing->owner->id != auth()->id())&&(auth()->id()!=1),404);
        $slug = \Str::slug($request->title);
        while (Post::where('slug', $slug)->where('listing_id', $listing->id)->first()) {
            // another listing already exists with that slug and city.
            $slug = $slug . '-' . rand(1, 999);
        }

        $post = $listing->post()->create([
            'title'=>$request->title,
            'body'=> $this->scriptStripper($this->linkStripper($request->body)),
            'user_id' => auth()->id(),
            'slug'=> $slug
        ]);
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $request->validate([ 'image' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->image->extension();
                $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                $request->image->storeAs('/public/external', $imagename);
                $post->data = ['content_img'=>config('my.APP_URL').'/storage/external/'.$imagename]; $post->save();
            }
        }

        return redirect($post->full_link)->withMessage('Post Created! <a href="/home">Go Back</a>&nbsp; OR &nbsp; <a href="/editpost/'.$post->id.'">Edit Post</a>');

    }

    public function storeaddProduct(Listing $listing,Request $request)
    {
        abort_if(($listing->owner->id != auth()->id())&&(auth()->id()!=1),404);
        $slug = \Str::slug($request->title);
        while (Product::where('slug', $slug)->where('listing_id', $listing->id)->first()) {
            // another listing already exists with that slug and city.
            $slug = $slug . '-' . rand(1, 999);
        }

        $product = $listing->products()->create([
            'title'=>$request->title,
            'body'=> $this->scriptStripper($this->linkStripper($request->body)),
            'slug'=> $slug
        ]);
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $request->validate([ 'image' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->image->extension();
                $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                $request->image->storeAs('/public/external', $imagename);
                $data['content_img'] = config('my.APP_URL').'/storage/external/'.$imagename;
            }
        }
        if ($request->hasFile('image2')) {
            if ($request->file('image2')->isValid()) {
                $request->validate([ 'image2' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->image2->extension();
                $image2name = $listing->id.'_'.Str::random(8).".".$extension;
                $request->image2->storeAs('/public/external', $image2name);
                $data['content_img2'] = config('my.APP_URL').'/storage/external/'.$image2name;
            }
        }
        if ($request->hasFile('image3')) {
            if ($request->file('image3')->isValid()) {
                $request->validate([ 'image3' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->image3->extension();
                $image3name = $listing->id.'_'.Str::random(8).".".$extension;
                $request->image3->storeAs('/public/external', $image3name);
                $data['content_img3'] = config('my.APP_URL').'/storage/external/'.$image3name;
            }
        }
        if ($request->hasFile('image4')) {
            if ($request->file('image4')->isValid()) {
                $request->validate([ 'image4' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->image4->extension();
                $image4name = $listing->id.'_'.Str::random(8).".".$extension;
                $request->image4->storeAs('/public/external', $image4name);
                $data['content_img4'] = config('my.APP_URL').'/storage/external/'.$image4name;
            }
        }
        if ($request->hasFile('image5')) {
            if ($request->file('image5')->isValid()) {
                $request->validate([ 'image5' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->image5->extension();
                $image5name = $listing->id.'_'.Str::random(8).".".$extension;
                $request->image5->storeAs('/public/external', $image5name);
                $data['content_img5'] = config('my.APP_URL').'/storage/external/'.$image5name;
            }
        }

        if($request->has('ownlink')){ $data['ownlink'] = $this->scriptStripper($this->linkStripper($request->ownlink)); }
        if($request->has('amazonlink')){ $data['amazonlink'] = $this->scriptStripper($this->linkStripper($request->amazonlink)); }
        if($request->has('flipkartlink')){ $data['flipkartlink'] = $this->scriptStripper($this->linkStripper($request->flipkartlink)); }
        if($request->has('indiamartlink')){ $data['indiamartlink'] = $this->scriptStripper($this->linkStripper($request->indiamartlink)); }
        if($request->has('videolink')){ $data['videolink'] = $this->scriptStripper($this->linkStripper($request->videolink)); }

        $product->data = $data; $product->save();
        return redirect($product->full_link)->withMessage('Product Created! <a href="/home">Go Back</a>&nbsp; OR &nbsp; <a href="/editproduct/'.$product->id.'">Edit Product</a>');

    }

    public function storeeditPost(Post $post,Request $request)
    {
        abort_if(($post->user_id != auth()->id())&&(auth()->id()!=1),404);

        $post->update([
            'title'=>$request->title,
            'body'=> $this->scriptStripper($this->linkStripper($request->body)),
            'slug'=>\Str::slug($request->title)
        ]);
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $request->validate([ 'image' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->image->extension();
                $imagename = ($post->listing_id).'_'.Str::random(8).".".$extension;
                $request->image->storeAs('/public/external', $imagename);
                $post->data = ['content_img'=>config('my.APP_URL').'/storage/external/'.$imagename]; $post->save();
            }
        }

        return redirect($post->full_link)->withMessage('Post Updated! <a href="/home">Home</a> &nbsp; OR &nbsp; <a href="/editpost/'.$post->id.'">Edit Post</a>');

    }

    public function storeeditProduct(Product $product,Request $request)
    {
//        dd($request->all());
        $listing = $product->listing;
        abort_if(($listing->user_id != auth()->id())&&(auth()->id()!=1),404);

        $product->update([
            'title'=>$request->title,
            'body'=> $this->scriptStripper($this->linkStripper($request->body)),
            'slug'=>\Str::slug($request->title)
        ]);

        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $request->validate([ 'image' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->image->extension();
                $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                $request->image->storeAs('/public/external', $imagename);
                $data['content_img'] = config('my.APP_URL').'/storage/external/'.$imagename;
            }
        }
        if ($request->hasFile('image2')) {
            if ($request->file('image2')->isValid()) {
                $request->validate([ 'image2' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->image2->extension();
                $image2name = $listing->id.'_'.Str::random(8).".".$extension;
                $request->image2->storeAs('/public/external', $image2name);
                $data['content_img2'] = config('my.APP_URL').'/storage/external/'.$image2name;
            }
        }
        if ($request->hasFile('image3')) {
            if ($request->file('image3')->isValid()) {
                $request->validate([ 'image3' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->image3->extension();
                $image3name = $listing->id.'_'.Str::random(8).".".$extension;
                $request->image3->storeAs('/public/external', $image3name);
                $data['content_img3'] = config('my.APP_URL').'/storage/external/'.$image3name;
            }
        }
        if ($request->hasFile('image4')) {
            if ($request->file('image4')->isValid()) {
                $request->validate([ 'image4' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->image4->extension();
                $image4name = $listing->id.'_'.Str::random(8).".".$extension;
                $request->image4->storeAs('/public/external', $image4name);
                $data['content_img4'] = config('my.APP_URL').'/storage/external/'.$image4name;
            }
        }
        if ($request->hasFile('image5')) {
            if ($request->file('image5')->isValid()) {
                $request->validate([ 'image5' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->image5->extension();
                $image5name = $listing->id.'_'.Str::random(8).".".$extension;
                $request->image5->storeAs('/public/external', $image5name);
                $data['content_img5'] = config('my.APP_URL').'/storage/external/'.$image5name;
            }
        }

        if($request->has('ownlink')){ $data['ownlink'] = $this->scriptStripper($this->linkStripper($request->ownlink)); }
        if($request->has('amazonlink')){ $data['amazonlink'] = $this->scriptStripper($this->linkStripper($request->amazonlink)); }
        if($request->has('flipkartlink')){ $data['flipkartlink'] = $this->scriptStripper($this->linkStripper($request->flipkartlink)); }
        if($request->has('indiamartlink')){ $data['indiamartlink'] = $this->scriptStripper($this->linkStripper($request->indiamartlink)); }
        if($request->has('videolink')){ $data['videolink'] = $this->scriptStripper($this->linkStripper($request->videolink)); }

        $product->data = $data; $product->save();

        return redirect($product->full_link)->withMessage('Product Updated! <a href="/home">Home</a> &nbsp; OR &nbsp; <a href="/editproduct/'.$product->id.'">Edit Product</a>');

    }

    public function storeVendorReply(Review $review, Request $request)
    {
//        dd($request->all());
        $validated = $request->validate([ 'reply'=>'required' ]);
        if($review->listing->user_id == auth()->id())
        {
            $review->update(['vendor_reply'=>$validated['reply'],'replied_at'=>now() ]);
            return redirect('/managecomments')->withMessage('Reply Saved');
        }
        return redirect('home');
    }

    public function leadgenerated(Listing $listing)
    {
        if($listing->phone) {
            \App\Jobs\smsVendorAboutLeadGenerated::dispatch($listing, auth()->user());
        }
        Lead::create(['user_id'=>auth()->id(),'listing_id'=>$listing->id]);
    }

    function scriptStripper($input)
    {
        return preg_replace('#<script(.*?)>(.*?)</script>#is', '', $input);
    }

    function linkStripper($input)
    {
        return preg_replace('#<a(.*?)>(.*?)</a>#is', '', $input);
    }





    public function storeaddbusiness(Request $request)
    {
//        dd($request->all());
        if(auth()->user()->listing){
            return redirect('home')->withMessage('You already have a listing. For more, please email us at info@wuchna.com ');
        }
        $validated = $request->validate([
            'title'=>'required',
            'city'=>'required|exists:cities,id',
            'locality'=>'required|exists:localities,id',
            'category'=>'required|exists:categories,id',
            'description'=>'required',
            'phone'=>'required|numeric|min:1000000000',
            'address'=>'required',
            'website'=>'nullable',
            'email'=>'nullable',
            'meta_title'=>'nullable',
            'meta_description'=>'nullable',
        ]);
        // check if description has links or scripts
        $curatedDescription = $this->linkStripper($this->scriptStripper( $validated['description']  ));
        $blog = Blog::where('locality_id',$validated['locality'])->where('category_id',$validated['category'])->first();
        if(!$blog){
            try {
                $blog = BlogCreator::creator($validated['city'], $validated['locality'], $validated['category']);
            }catch(\Exception $e){}
        }
        $raw = [
            'email'=>strtolower($validated['email']),
            'phone'=>ltrim(str_replace(' ','',$validated['phone']),'0'),
            'address'=>$validated['address'],
            'link'=>$validated['website'],
        ];
        $slug = Str::slug($validated['title']);
        while(Listing::where('slug',$slug)->where('city_id',$validated['city'])->first()
            || Blog::where('slug',$slug)->where('city_id',$validated['city'])->first() ){
            // another listing already exists with that slug and city.
            $slug = $slug.'-'.rand(1,999);
        }

        $meta_title = Str::words($validated['title'],5,'').': '
            . $blog->category->title .' in '.$blog->locality->title.', '.$blog->city->title;

        $meta_description = $validated['meta_description'] ??
                ''.Arr::random(['Looking for ','Are you looking for ',''])
                .Arr::random(['Contact '.Arr::random(['details ','information ']).Arr::random(['of ','about ','regarding ']),''])
                .Str::words($validated['title'],5,'').' '
                .'(' . $blog->category->title . ')'
                .' in '.$blog->locality->title.', '.$blog->city->title.'? '
                .Arr::random(['Find phone number here.','Find contact information here.']);


        $listing = Listing::create([
            'slug'=>$slug,
            'title'=>$validated['title'],
            'city_id' => $validated['city'],
            'blog_id' => $blog->id,
            'description' => $curatedDescription,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'raw'=>$raw,
            'user_id' => auth()->id(),
            'phone'=>ltrim(str_replace(' ','',$validated['phone']),'0'),
            'website'=>$validated['website'],
            'email'=>strtolower($validated['email'])
        ]);

        $data = $listing->data;

        if ($request->hasFile('logo')) {
            if ($request->file('logo')->isValid()) {
                $request->validate([ 'logo' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->logo->extension();
                $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                $request->logo->storeAs('/public/external', $imagename);
                $listing->data = ['logo_img'=>config('my.APP_URL').'/storage/external/'.$imagename];
            }
        }
        if ($request->hasFile('banner')) {
            if ($request->file('banner')->isValid()) {
                $request->validate([ 'banner' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->banner->extension();
                $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                $request->banner->storeAs('/public/external', $imagename);
                $data['banner_img'] = config('my.APP_URL').'/storage/external/'.$imagename;
            }
        }
        if ($request->hasFile('contentpic')) {
            if ($request->file('contentpic')->isValid()) {
                $request->validate([ 'contentpic' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->contentpic->extension();
                $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                $request->contentpic->storeAs('/public/external', $imagename);
                $data['content_img'] = config('my.APP_URL').'/storage/external/'.$imagename;
            }
        }
        if ($request->hasFile('contentpdf')) {
            if ($request->file('contentpdf')->isValid()) {
                $request->validate([ 'contentpdf' => 'mimes:pdf|max:3042' ]);
//                $extension = $request->contentpdf->extension();
                $pdfname = $listing->id.'_'.Str::random(8).".pdf";
                $request->contentpdf->storeAs('/public/external', $pdfname);
                $data['content_pdf'] = config('my.APP_URL').'/storage/external/'.$pdfname;
            }
        }


        if ($request->hasFile('galleryimg1')) {
            if ($request->file('galleryimg1')->isValid()) {
                $request->validate([ 'galleryimg1' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->galleryimg1->extension();
                $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                $request->galleryimg1->storeAs('/public/external', $imagename);
                $data['galleryimg1'] = config('my.APP_URL').'/storage/external/'.$imagename;
            }
        }
        if ($request->hasFile('galleryimg2')) {
            if ($request->file('galleryimg2')->isValid()) {
                $request->validate([ 'galleryimg2' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->galleryimg2->extension();
                $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                $request->galleryimg2->storeAs('/public/external', $imagename);
                $data['galleryimg2'] = config('my.APP_URL').'/storage/external/'.$imagename;
            }
        }
        if ($request->hasFile('galleryimg3')) {
            if ($request->file('galleryimg3')->isValid()) {
                $request->validate([ 'galleryimg3' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->galleryimg3->extension();
                $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                $request->galleryimg3->storeAs('/public/external', $imagename);
                $data['galleryimg3'] = config('my.APP_URL').'/storage/external/'.$imagename;
            }
        }
        if ($request->hasFile('galleryimg4')) {
            if ($request->file('galleryimg4')->isValid()) {
                $request->validate([ 'galleryimg4' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->galleryimg4->extension();
                $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                $request->galleryimg4->storeAs('/public/external', $imagename);
                $data['galleryimg4'] = config('my.APP_URL').'/storage/external/'.$imagename;
            }
        }
        if ($request->hasFile('galleryimg5')) {
            if ($request->file('galleryimg5')->isValid()) {
                $request->validate([ 'galleryimg5' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->galleryimg5->extension();
                $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                $request->galleryimg5->storeAs('/public/external', $imagename);
                $data['galleryimg5'] = config('my.APP_URL').'/storage/external/'.$imagename;
            }
        }
        if ($request->hasFile('galleryimg6')) {
            if ($request->file('galleryimg6')->isValid()) {
                $request->validate([ 'galleryimg6' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->galleryimg6->extension();
                $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                $request->galleryimg6->storeAs('/public/external', $imagename);
                $data['galleryimg6'] = config('my.APP_URL').'/storage/external/'.$imagename;
            }
        }
        if ($request->hasFile('galleryimg7')) {
            if ($request->file('galleryimg7')->isValid()) {
                $request->validate([ 'galleryimg7' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->galleryimg7->extension();
                $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                $request->galleryimg7->storeAs('/public/external', $imagename);
                $data['galleryimg7'] = config('my.APP_URL').'/storage/external/'.$imagename;
            }
        }
        if ($request->hasFile('galleryimg8')) {
            if ($request->file('galleryimg8')->isValid()) {
                $request->validate([ 'galleryimg8' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->galleryimg8->extension();
                $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                $request->galleryimg8->storeAs('/public/external', $imagename);
                $data['galleryimg8'] = config('my.APP_URL').'/storage/external/'.$imagename;
            }
        }
        if ($request->hasFile('galleryimg9')) {
            if ($request->file('galleryimg9')->isValid()) {
                $request->validate([ 'galleryimg9' => 'mimes:jpg,jpeg,png|max:1014' ]);
                $extension = $request->galleryimg9->extension();
                $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                $request->galleryimg9->storeAs('/public/external', $imagename);
                $data['galleryimg9'] = config('my.APP_URL').'/storage/external/'.$imagename;
            }
        }


        if($request->has('faq') && $request->has('faqans')&& $request->faq && $request->faqans){
            $bdata=[];
            $bdata['tags'][0]['type']= 'faq';
            $bdata['tags'][0]['ans']= $request->faqans;
            $bdata['tags'][0]['ques']= $request->faq;
            $listing->business_data = $bdata;
            $listing->save();
        }

        if($request->has('linkedinlink') && ($request->linkedinlink) ){ $data['linkedinlink'] = $this->scriptStripper($this->linkStripper($request->linkedinlink)); }
        if($request->has('facebooklink') && ($request->facebooklink)){ $data['facebooklink'] = $this->scriptStripper($this->linkStripper($request->facebooklink)); }
        if($request->has('twitterlink') && ($request->twitterlink)){ $data['twitterlink'] = $this->scriptStripper($this->linkStripper($request->twitterlink)); }
        if($request->has('instagramlink') && ($request->instagramlink)){ $data['instagramlink'] = $this->scriptStripper($this->linkStripper($request->instagramlink)); }

        if($request->has('indiamartlink') && ($request->indiamartlink)){ $data['indiamartlink'] = $this->scriptStripper($this->linkStripper($request->indiamartlink)); }
        if($request->has('justdiallink') && ($request->justdiallink)){ $data['justdiallink'] = $this->scriptStripper($this->linkStripper($request->justdiallink)); }
        if($request->has('sulekhalink') && ($request->sulekhalink)){ $data['sulekhalink'] = $this->scriptStripper($this->linkStripper($request->sulekhalink)); }
        if($request->has('magicpinlink') && ($request->magicpinlink)){ $data['magicpinlink'] = $this->scriptStripper($this->linkStripper($request->magicpinlink)); }

        if($request->has('custommap') && ($request->custommap)){ $data['custommap'] = $this->scriptStripper($this->linkStripper($request->custommap)); }
        if($request->has('mouthshutlink') && ($request->mouthshutlink)){ $data['mouthshutlink'] = $this->scriptStripper($this->linkStripper($request->mouthshutlink)); }
        if($request->has('nearbuylink') && ($request->nearbuylink)){ $data['nearbuylink'] = $this->scriptStripper($this->linkStripper($request->nearbuylink)); }
        if($request->has('tripadvisorlink') && ($request->tripadvisorlink)){ $data['tripadvisorlink'] = $this->scriptStripper($this->linkStripper($request->tripadvisorlink)); }

        if($request->has('zomatolink') && ($request->zomatolink)){ $data['zomatolink'] = $this->scriptStripper($this->linkStripper($request->zomatolink)); }
        if($request->has('swiggylink') && ($request->swiggylink)){ $data['swiggylink'] = $this->scriptStripper($this->linkStripper($request->swiggylink)); }
        if($request->has('eazydinerlink') && ($request->eazydinerlink)){ $data['eazydinerlink'] = $this->scriptStripper($this->linkStripper($request->eazydinerlink)); }
        if($request->has('dineoutlink') && ($request->dineoutlink)){ $data['dineoutlink'] = $this->scriptStripper($this->linkStripper($request->dineoutlink)); }

        if($request->has('practolink') && ($request->practolink)){ $data['practolink'] = $this->scriptStripper($this->linkStripper($request->practolink)); }
        if($request->has('youtubelink') && ($request->youtubelink)){ $data['youtubelink'] = str_replace('https://youtu.be/','https://www.youtube && .com/watch?v=',$this->scriptStripper($this->linkStripper($request->youtubelink))); }


        if(! $request->has('noworkinghours')) {
            $hours = [];
            array_push($hours, ["name" => "Monday", "value" => BusinessOpen::finalValueToAssign($request->monday,$request->mondaystart,$request->mondayclose)]);
            array_push($hours, ["name" => "Tuesday", "value" => BusinessOpen::finalValueToAssign($request->tuesday,$request->tuesdaystart,$request->tuesdayclose)]);
            array_push($hours, ["name" => "Wednesday", "value" => BusinessOpen::finalValueToAssign($request->wednesday,$request->wednesdaystart,$request->wednesdayclose)]);
            array_push($hours, ["name" => "Thursday", "value" => BusinessOpen::finalValueToAssign($request->thursday,$request->thursdaystart,$request->thursdayclose)]);
            array_push($hours, ["name" => "Friday", "value" => BusinessOpen::finalValueToAssign($request->friday,$request->fridaystart,$request->fridayclose)]);
            array_push($hours, ["name" => "Saturday", "value" => BusinessOpen::finalValueToAssign($request->saturday,$request->saturdaystart,$request->saturdayclose)]);
            array_push($hours, ["name" => "Sunday", "value" => BusinessOpen::finalValueToAssign($request->sunday,$request->sundaystart,$request->sundayclose)]);
            $data['knowledge_graph']['hours'] = $hours;
        }

        // remove old keywords, if any
        if($listing->keywords){
            foreach ($listing->keywords as $oldk){ $oldk->delete(); }
        }
        if($request->keywords){
            // add new keywords
            $ks = $this->linkStripper($this->scriptStripper($request->keywords));
            foreach (explode(',',$ks) as $k){
                if(trim($k)) {
                    $listing->keyword()->create(['title' => trim($k)]);
                }
            }
        }

        try {
            $listing->data = $data; $listing->save();
            $blog = $listing->blog;
            $blog->save(); // so it resets algolia search with the listing name
        }catch(\Exception $e){}


        return redirect('home')->withMessage('Your listing has been created.');
    }

    public function storeeditbusiness(Request $request)
    {
//        dd($request->all());
        $validated = $request->validate([
            'title'=>'required',
            'city'=>'required|exists:cities,id',
            'locality'=>'required|exists:localities,id',
            'category'=>'required|exists:categories,id',
            'description'=>'required',
            'address'=>'required',
            'website'=>'nullable',
            'phone'=>'required|numeric|min:1000000000',
            'email'=>'nullable|email',
            'meta_title'=>'nullable',
            'meta_description'=>'nullable',
            'listing_id'=>'required|exists:listings,id'
        ]);
        $curatedDescription = $this->linkStripper($this->scriptStripper( $validated['description']  ));

        $listing = Listing::findOrFail($validated['listing_id']);
        if($listing->user_id == auth()->id()) {
            $newblog = Blog::where('city_id', $validated['city'])->where('locality_id', $validated['locality'])->where('category_id', $validated['category'])->first();
            if(!$newblog){
                $newblog = BlogCreator::creator($validated['city'],$validated['locality'],$validated['category']);
            }

            $meta_title = Str::words($validated['title'],5,'').': '
                . $newblog->category->title .' in '.$newblog->locality->title.', '.$newblog->city->title;

            $meta_description = $validated['meta_description'] ??
                ''.Arr::random(['Looking for ','Are you looking for ',''])
                .Arr::random(['Contact '.Arr::random(['details ','information ']).Arr::random(['of ','about ','regarding ']),''])
                .Str::words($validated['title'],5,'').' '
                .'(' . $newblog->category->title . ')'
                .' in '.$newblog->locality->title.', '.$newblog->city->title.'? '
                .Arr::random(['Find phone number here.','Find contact information here.']);

//            if there is a change in name, then:
            $slug = \Str::slug($validated['title']);
            if(auth()->user()->listing->title != $validated['title']) {
                while (Listing::where('slug', $slug)->where('city_id', $validated['city'])->first()
                    || Blog::where('slug', $slug)->where('city_id', $validated['city'])->first()) {
                    // another listing already exists with that slug and city.
                    $slug = $slug . '-' . rand(1, 999);
                }
                \App\Redirect::create([
                    'from'=>auth()->user()->listing->city->slug.'/'.auth()->user()->listing->slug,
                    'to'=>City::find($validated['city'])->slug.'/'.$slug
                ]);
                $listing->update(['slug'=>$slug]);
            }


            $listing->update([
                'title' => $validated['title'],
                'city_id' => $validated['city'],
                'blog_id' => $newblog->id,
                'description' => $curatedDescription,
                'meta_title' => $meta_title,
                'meta_description' => $meta_description,
                'phone'=>ltrim(str_replace(' ','',$validated['phone']),'0'),
                'website'=>$validated['website'],
                'email'=>strtolower($validated['email'])
            ]);

            $raw = $listing->raw;
            $finalwebsite = $validated['website'];
            if(\Str::startsWith($validated['website'],'www.')) {
                $finalwebsite = str_replace('www.','',$validated['website']);
            }
            $raw['link'] = $finalwebsite;
            $raw['phone'] = $validated['phone'];
            $raw['address'] = $validated['address'];
            $raw['email'] = $validated['email'];
            $listing->update(['raw'=>$raw]);

            $data = $listing->data;
            $bdata=[];

            if ($request->hasFile('logo')) {
                if ($request->file('logo')->isValid()) {
                    $request->validate([ 'logo' => 'mimes:jpg,jpeg,png|max:1014' ]);
                    $extension = $request->logo->extension();
                    $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                    $request->logo->storeAs('/public/external', $imagename);
                     $data['logo_img'] = config('my.APP_URL').'/storage/external/'.$imagename;
                }
            }
            if ($request->hasFile('banner')) {
                if ($request->file('banner')->isValid()) {
                    $request->validate([ 'banner' => 'mimes:jpg,jpeg,png|max:1014' ]);
                    $extension = $request->banner->extension();
                    $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                    $request->banner->storeAs('/public/external', $imagename);
                     $data['banner_img'] = config('my.APP_URL').'/storage/external/'.$imagename;
                }
            }
            if ($request->hasFile('contentpdf')) {
                if ($request->file('contentpdf')->isValid()) {
                    $request->validate([ 'contentpdf' => 'mimes:pdf|max:3042' ]);
                    $pdfname = $listing->id.'_'.Str::random(8).".pdf";
                    $request->contentpdf->storeAs('/public/external', $pdfname);
                     $data['content_pdf'] = config('my.APP_URL').'/storage/external/'.$pdfname;
                }
            }
            if ($request->hasFile('contentpic')) {
                if ($request->file('contentpic')->isValid()) {
                    $request->validate([ 'contentpic' => 'mimes:jpg,jpeg,png|max:1014' ]);
                    $extension = $request->contentpic->extension();
                    $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                    $request->contentpic->storeAs('/public/external', $imagename);
                    $data['content_img'] = config('my.APP_URL').'/storage/external/'.$imagename;
                }
            }


            if ($request->hasFile('galleryimg1')) {
                if ($request->file('galleryimg1')->isValid()) {
                    $request->validate([ 'galleryimg1' => 'mimes:jpg,jpeg,png|max:1014' ]);
                    $extension = $request->galleryimg1->extension();
                    $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                    $request->galleryimg1->storeAs('/public/external', $imagename);
                     $data['galleryimg1'] = config('my.APP_URL').'/storage/external/'.$imagename;
                }
            }
            if ($request->hasFile('galleryimg2')) {
                if ($request->file('galleryimg2')->isValid()) {
                    $request->validate([ 'galleryimg2' => 'mimes:jpg,jpeg,png|max:1014' ]);
                    $extension = $request->galleryimg2->extension();
                    $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                    $request->galleryimg2->storeAs('/public/external', $imagename);
                    $data['galleryimg2'] = config('my.APP_URL').'/storage/external/'.$imagename;
                }
            }
            if ($request->hasFile('galleryimg3')) {
                if ($request->file('galleryimg3')->isValid()) {
                    $request->validate([ 'galleryimg3' => 'mimes:jpg,jpeg,png|max:1014' ]);
                    $extension = $request->galleryimg3->extension();
                    $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                    $request->galleryimg3->storeAs('/public/external', $imagename);
                     $data['galleryimg3'] = config('my.APP_URL').'/storage/external/'.$imagename;
                }
            }
            if ($request->hasFile('galleryimg4')) {
                if ($request->file('galleryimg4')->isValid()) {
                    $request->validate([ 'galleryimg4' => 'mimes:jpg,jpeg,png|max:1014' ]);
                    $extension = $request->galleryimg4->extension();
                    $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                    $request->galleryimg4->storeAs('/public/external', $imagename);
                     $data['galleryimg4'] = config('my.APP_URL').'/storage/external/'.$imagename;
                }
            }
            if ($request->hasFile('galleryimg5')) {
                if ($request->file('galleryimg5')->isValid()) {
                    $request->validate([ 'galleryimg5' => 'mimes:jpg,jpeg,png|max:1014' ]);
                    $extension = $request->galleryimg5->extension();
                    $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                    $request->galleryimg5->storeAs('/public/external', $imagename);
                     $data['galleryimg5'] = config('my.APP_URL').'/storage/external/'.$imagename;
                }
            }
            if ($request->hasFile('galleryimg6')) {
                if ($request->file('galleryimg6')->isValid()) {
                    $request->validate([ 'galleryimg6' => 'mimes:jpg,jpeg,png|max:1014' ]);
                    $extension = $request->galleryimg6->extension();
                    $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                    $request->galleryimg6->storeAs('/public/external', $imagename);
                     $data['galleryimg6'] = config('my.APP_URL').'/storage/external/'.$imagename;
                }
            }
            if ($request->hasFile('galleryimg7')) {
                if ($request->file('galleryimg7')->isValid()) {
                    $request->validate([ 'galleryimg7' => 'mimes:jpg,jpeg,png|max:1014' ]);
                    $extension = $request->galleryimg7->extension();
                    $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                    $request->galleryimg7->storeAs('/public/external', $imagename);
                     $data['galleryimg7'] = config('my.APP_URL').'/storage/external/'.$imagename;
                }
            }
            if ($request->hasFile('galleryimg8')) {
                if ($request->file('galleryimg8')->isValid()) {
                    $request->validate([ 'galleryimg8' => 'mimes:jpg,jpeg,png|max:1014' ]);
                    $extension = $request->galleryimg8->extension();
                    $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                    $request->galleryimg8->storeAs('/public/external', $imagename);
                     $data['galleryimg8'] = config('my.APP_URL').'/storage/external/'.$imagename;
                }
            }
            if ($request->hasFile('galleryimg9')) {
                if ($request->file('galleryimg9')->isValid()) {
                    $request->validate([ 'galleryimg9' => 'mimes:jpg,jpeg,png|max:1014' ]);
                    $extension = $request->galleryimg9->extension();
                    $imagename = $listing->id.'_'.Str::random(8).".".$extension;
                    $request->galleryimg9->storeAs('/public/external', $imagename);
                     $data['galleryimg9'] = config('my.APP_URL').'/storage/external/'.$imagename;
                }
            }



            if($request->has('faq') && $request->has('faqans') && $request->faq && $request->faqans){
                $bdata['tags'][0]['type']= 'faq';
                $bdata['tags'][0]['ans']= $request->faqans;
                $bdata['tags'][0]['ques']= $request->faq;
            }

            if($request->has('linkedinlink')){ $data['linkedinlink'] = $this->scriptStripper($this->linkStripper($request->linkedinlink)); }
            if($request->has('facebooklink')){ $data['facebooklink'] = $this->scriptStripper($this->linkStripper($request->facebooklink)); }
            if($request->has('twitterlink')){ $data['twitterlink'] = $this->scriptStripper($this->linkStripper($request->twitterlink)); }
            if($request->has('instagramlink')){ $data['instagramlink'] = $this->scriptStripper($this->linkStripper($request->instagramlink)); }

            if($request->has('indiamartlink')){ $data['indiamartlink'] = $this->scriptStripper($this->linkStripper($request->indiamartlink)); }
            if($request->has('justdiallink')){ $data['justdiallink'] = $this->scriptStripper($this->linkStripper($request->justdiallink)); }
            if($request->has('sulekhalink')){ $data['sulekhalink'] = $this->scriptStripper($this->linkStripper($request->sulekhalink)); }
            if($request->has('magicpinlink')){ $data['magicpinlink'] = $this->scriptStripper($this->linkStripper($request->magicpinlink)); }

            if($request->has('custommap')){ $data['custommap'] = $this->scriptStripper($this->linkStripper($request->custommap)); }
            if($request->has('mouthshutlink')){ $data['mouthshutlink'] = $this->scriptStripper($this->linkStripper($request->mouthshutlink)); }
            if($request->has('nearbuylink')){ $data['nearbuylink'] = $this->scriptStripper($this->linkStripper($request->nearbuylink)); }
            if($request->has('tripadvisorlink')){ $data['tripadvisorlink'] = $this->scriptStripper($this->linkStripper($request->tripadvisorlink)); }

            if($request->has('zomatolink')){ $data['zomatolink'] = $this->scriptStripper($this->linkStripper($request->zomatolink)); }
            if($request->has('swiggylink')){ $data['swiggylink'] = $this->scriptStripper($this->linkStripper($request->swiggylink)); }
            if($request->has('eazydinerlink')){ $data['eazydinerlink'] = $this->scriptStripper($this->linkStripper($request->eazydinerlink)); }
            if($request->has('dineoutlink')){ $data['dineoutlink'] = $this->scriptStripper($this->linkStripper($request->dineoutlink)); }

            if($request->has('practolink')){ $data['practolink'] = $this->scriptStripper($this->linkStripper($request->practolink)); }
            if($request->has('youtubelink')){ $data['youtubelink'] = str_replace('https://youtu.be/','https://www.youtube.com/watch?v=',$this->scriptStripper($this->linkStripper($request->youtubelink))); }


            if(isset($data['knowledge_graph']['hours'])) {
                if($request->has('noworkinghours')){
                    // hours are set in listing already but the user does not want them anymore
                    unset($data['knowledge_graph']['hours']);
                }else{
                    // hours are set in listing and user is editing them
                    $hours = $data['knowledge_graph']['hours'];
//dd($request->all());
                    $c = collect($hours);

                    if ($request->has('monday')) {
                        $monday = $c->filter(function ($item) { return $item['name'] == 'Monday'; });
                        if ($monday) {
                            $key = $monday->keys()[0];
                            $hours[$key]['value'] = BusinessOpen::finalValueToAssign($request->monday,$request->mondaystart,$request->mondayclose);
                        }
                    }
                    if ($request->has('tuesday')) {
                        $tuesday = $c->filter(function ($item) { return $item['name'] == 'Tuesday'; });
                        if ($tuesday) {
                            $key = $tuesday->keys()[0];
                            $hours[$key]['value'] = BusinessOpen::finalValueToAssign($request->tuesday,$request->tuesdaystart,$request->tuesdayclose);
                        }
                    }
                    if ($request->has('wednesday')) {
                        $wednesday = $c->filter(function ($item) { return $item['name'] == 'Wednesday'; });
                        if ($wednesday) {
                            $key = $wednesday->keys()[0];
                            $hours[$key]['value'] = BusinessOpen::finalValueToAssign($request->wednesday,$request->wednesdaystart,$request->wednesdayclose);
                        }
                    }
                    if ($request->has('thursday')) {
                        $thursday = $c->filter(function ($item) { return $item['name'] == 'Thursday'; });
                        if ($thursday) {
                            $key = $thursday->keys()[0];
                            $hours[$key]['value'] = BusinessOpen::finalValueToAssign($request->thursday,$request->thursdaystart,$request->thursdayclose);
                        }
                    }
                    if ($request->has('friday')) {
                        $friday = $c->filter(function ($item) { return $item['name'] == 'Friday'; });
                        if ($friday) {
                            $key = $friday->keys()[0];
                            $hours[$key]['value'] = BusinessOpen::finalValueToAssign($request->friday,$request->fridaystart,$request->fridayclose);
                        }
                    }
                    if ($request->has('saturday')) {
                        $saturday = $c->filter(function ($item) { return $item['name'] == 'Saturday'; });
                        if ($saturday) {
                            $key = $saturday->keys()[0];
                            $hours[$key]['value'] = BusinessOpen::finalValueToAssign($request->saturday,$request->saturdaystart,$request->saturdayclose);
                        }
                    }
                    if ($request->has('sunday')) {
                        $sunday = $c->filter(function ($item) { return $item['name'] == 'Sunday'; });
                        if ($sunday) {
                            $key = $sunday->keys()[0];
                            $hours[$key]['value'] = BusinessOpen::finalValueToAssign($request->sunday,$request->sundaystart,$request->sundayclose);
                        }
                    }

                    $data['knowledge_graph']['hours'] = $hours;
                }

            }else{

                if($request->has('noworkinghours')){
                    // hours are not set in the business and the user does not want them as well
                    // do nothing in this case
                }else{
                    // hours are not set in the business BUT the user wants to add them
                    $hours = [];
                    array_push($hours, ["name" => "Monday", "value" => BusinessOpen::finalValueToAssign($request->monday,$request->mondaystart,$request->mondayclose)]);
                    array_push($hours, ["name" => "Tuesday", "value" => BusinessOpen::finalValueToAssign($request->tuesday,$request->tuesdaystart,$request->tuesdayclose)]);
                    array_push($hours, ["name" => "Wednesday", "value" => BusinessOpen::finalValueToAssign($request->wednesday,$request->wednesdaystart,$request->wednesdayclose)]);
                    array_push($hours, ["name" => "Thursday", "value" => BusinessOpen::finalValueToAssign($request->thursday,$request->thursdaystart,$request->thursdayclose)]);
                    array_push($hours, ["name" => "Friday", "value" => BusinessOpen::finalValueToAssign($request->friday,$request->fridaystart,$request->fridayclose)]);
                    array_push($hours, ["name" => "Saturday", "value" => BusinessOpen::finalValueToAssign($request->saturday,$request->saturdaystart,$request->saturdayclose)]);
                    array_push($hours, ["name" => "Sunday", "value" => BusinessOpen::finalValueToAssign($request->sunday,$request->sundaystart,$request->sundayclose)]);
                    $data['knowledge_graph']['hours'] = $hours;
                }

            }

            // remove old keywords, if any
            if($listing->keywords){
                foreach ($listing->keywords as $oldk){ $oldk->delete(); }
            }
            if($request->keywords){
                // add new keywords
                $ks = $this->linkStripper($this->scriptStripper($request->keywords));
                foreach (explode(',',$ks) as $k){
                    if(trim($k)) {
                        $listing->keyword()->create(['title' => trim($k)]);
                    }
                }
            }


            try{
                $listing->business_data = $bdata;
                $listing->data = $data;
                $listing->save();
                $blog = $listing->blog;
                $blog->save(); // so it resets algolia search with the listing name
                // try changing the slug in a try catch block, since operation could fail
//                $listing->update(['slug'=>\Str::slug($validated['title'])]);
            }catch(\Exception $e){}

            return redirect('/home')->withMessage('Listing Updated');
            // update the raw address, website, phone, email
        }
        return redirect('home');
    }


}