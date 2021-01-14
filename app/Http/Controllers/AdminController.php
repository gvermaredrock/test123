<?php

namespace App\Http\Controllers;

use App\Blog;
use App\City;
use App\Lead;
use App\Listing;
use App\Reference;
use App\Review;
use App\Services\BlogCreator;
use App\Services\BusinessOpen;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function approveReview(Review $review)
    {
        $data = $review->data;
        $data['status']='Approved by Admin';
        $review->update(['data'=>$data]);
        return 'Review Approved';
    }

    public function deleteReview(Review $review)
    {
        $review->delete();
        return 'Review Deleted';
    }

    public function rejectReview(Review $review)
    {
        $data = $review->data;
        $data['status']='Rejected by Admin';
        $review->update(['data'=>$data]);
        return redirect()->back()->withMessage('Review Rejected');
    }

    public function editReview(Review $review)
    {
        return view('editreview',compact(['review']));
    }

    public function deletephone(Listing $listing)
    {

        $listing->phone = null; $listing->save(); return redirect()->back()->withMessage('Phone deleted for '.$listing->title);
    }

    public function nowhatsapp(Listing $listing)
    {
        $data = $listing->data;
        $data['nowhatsapp'] = true;
        $listing->data = $data; $listing->save();
        return redirect()->back()->withMessage('Nowhatsapp saved for '.$listing->title);
    }

    public function addleadinteraction(Request $request, Listing $listing)
    {
        $data = $listing->data;
        $data['relationshipstage'] = $request->relationshipstage;
        $listing->data = $data; $listing->save();
        if($request->body) {
            $listing->interactions()->create(['body' => $request->body]);
        }
        return redirect()->back()->withMessage('Interaction saved ');
    }

    public function redirecttovendor(Request $request)
    {

        $listing = Listing::where('phone',str_replace([' ','+91'],'',$request->phone))->first();
        if($listing) {
            return redirect($listing->full_link);
        }
        return redirect('/latestleads')->withMessage('No such vendor found with mobile number '.$request->phone);
    }

    public function storeeditReview(Review $review, Request $request)
    {
        $review->update(['body'=>$request->body]);
        return redirect('/editreview/'.$review->id)->withMessage('Review updated');
    }

    public function latestleads()
    {
//        if(isset($_GET['cat']) && isset($_GET['city'])){
////            dd('cat is set');
//            $latestleads = Lead::whereHas('category',function($q){$q->where('categories.id',$_GET['cat']);})->whereHas('city',function($q){$q->where('cities.id',$_GET['city']);})->with('user')->latest()->take(30)->get();
//        }
//        elseif(isset($_GET['cat'])) {
//            $latestleads = Lead::whereHas('category', function ($q) {$q->where('categories.id', $_GET['cat']);})->with('user')->latest()->take(30)->get();
//        }
//        elseif(isset($_GET['city'])) {
//            $latestleads = Lead::whereHas('city', function ($q) {
//                $q->where('cities.id', $_GET['city']);
//            })->with('user')->latest()->take(30)->get();
//        }
//        else{
        $latestleads = Lead::with('listing')->with('user')->latest()->simplepaginate(10);
//        }

        $latestlistings = \App\Listing::with('blog')->latest()->simplepaginate(10);

        $latestreviews = \App\Review::with('listing')->latest()->simplepaginate(10);


        return view('admin.latestleads',compact(['latestleads','latestlistings','latestreviews']));
    }

    public function editbusiness(Listing $listing)
    {
        return view('admin.editbusiness',compact(['listing']));
    }



    public function editblog(Blog $blog)
    {
        return view('admin.editblog',compact(['blog']));
    }



    public function storeeditblog(Blog $blog,Request $request)
    {
        try {
            $blog->update([
                'title' => $request->title,
                'description' => $request->description,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description
            ]);
        }catch(\Exception $e){}
        return redirect($blog->full_link)->withMessage('Blog updated');
    }

    public function leadsAnalysis(Listing $listing)
    {
        return view('admin.leadsanalysis',compact(['listing']));
    }

    public function deletebusiness(Listing $listing)
    {
        $listing->delete();
        return('business deleted');
    }

    public function deleteblog(Blog $blog)
    {
        $blog->delete();
        return('blog deleted');
    }

    public function deletereference(Reference $reference)
    {
        $reference->delete();
        return('reference deleted');
    }

    public function addlistingmeta(Request $request)
    {
        $l = Listing::find($request->listing_id);
        $l->keywords()->create(['title'=>$request->title]);
        return redirect($l->full_link)->withMessage('Meta Added');
    }

    public function addblogmeta(Request $request)
    {
        $b = Blog::find($request->blog_id);
        $b->keywords()->create(['title'=>$request->title]);
        return redirect($b->full_link)->withMessage('Meta Added');
    }

    function scriptStripper($input)
    {
        return preg_replace('#<script(.*?)>(.*?)</script>#is', '', $input);
    }

    function linkStripper($input)
    {
        return preg_replace('#<a(.*?)>(.*?)</a>#is', '', $input);
    }

    public function admindeleteandredirectlisting(Listing $listing,Request $request)
    {
        $from = $listing->half_link;
        $to = str_replace('https://my.wuchna.com/','',$request->to);
        \App\Redirect::create(['from'=>$from,'to'=>$to]);
        $blog = $listing->blog;
        $listing->delete();
        try{
            $blog->save();
        }catch(\Exception $e){}
        return redirect('/home')->withMessage('Deleted and redirected');
    }


    public function storeeditbusiness(Request $request)
    {
//        dd($request->all());
        $validated = $request->validate([
            'title'=>'required',
            'city'=>'required|exists:cities,id',
            'locality'=>'required|exists:localities,id',
            'category'=>'required|exists:categories,id',
// description is nullable for admin
            'description'=>'nullable',
            'address'=>'nullable',
            'website'=>'nullable',
// phone is nullable for admin
            'phone'=>'nullable',
            'email'=>'nullable|email',
            'meta_title'=>'nullable',
            'meta_description'=>'nullable',
            'listing_id'=>'required|exists:listings,id',
            'keywords'=>'nullable|string'
        ]);

        $curatedDescription = $this->linkStripper($this->scriptStripper( $validated['description']  ));

        $listing = Listing::findOrFail($validated['listing_id']);
//        if($listing->user_id == auth()->id()) {
            $newblog = Blog::where('city_id', $validated['city'])->where('locality_id', $validated['locality'])->where('category_id', $validated['category'])->first();
            if(!$newblog){
                $newblog = BlogCreator::creator($validated['city'],$validated['locality'],$validated['category']);
            }

        $meta_title = $validated['meta_title'] ?? Str::words($validated['title'],5,'').': '
            . $newblog->category->title .' in '.$newblog->locality->title.', '.$newblog->city->title;

        $meta_description = $validated['meta_description'] ??
            ''.Arr::random(['Looking for ','Are you looking for ',''])
            .Arr::random(['Contact '.Arr::random(['details ','information ']).Arr::random(['of ','about ','regarding ']),''])
            .Str::words($validated['title'],5,'').' '
            .'(' . $newblog->category->title . ')'
            .' in '.$newblog->locality->title.', '.$newblog->city->title.'? '
            .Arr::random(['Find phone number here.','Find contact information here.']);

        //in admin case, slug is updated separately here

        $slug = \Str::slug($validated['title']);
        if($listing->city_id!=$validated['city'] || $listing->title != $validated['title']) {
            while (Listing::where('slug', $slug)->where('city_id', $validated['city'])->first()
                || Blog::where('slug', $slug)->where('city_id', $validated['city'])->first()) {
                // another listing already exists with that slug and city.
                $slug = $slug . '-' . rand(1, 999);
            }
            \App\Redirect::create([
                'from' => $listing->city->slug . '/' . $listing->slug,
                'to' => City::find($validated['city'])->slug . '/' . $slug
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

        $data = $listing->data;

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

        if ($request->hasFile('logo')) {
            if ($request->file('logo')->isValid()) {
                $request->validate([ 'image' => 'mimes:jpeg,png|max:1014' ]);
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


        if($request->has('faq') && $request->has('faqans') && $request->faq && $request->faqans){
            $bdata=[];
            $bdata['tags'][0]['type']= 'faq';
            $bdata['tags'][0]['ans']= $request->faqans;
            $bdata['tags'][0]['ques']= $request->faq;
            $listing->business_data = $bdata;
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

        try {
            $listing->data = $data; $listing->save();
            $blog = $listing->blog;
            $blog->save(); // so it resets algolia search with the listing name
        }catch(\Exception $e){}

        return redirect($listing->full_link)->withMessage('updated');

    }




}
