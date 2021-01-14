@if($listing) <input type="hidden" value="{{$listing->id}}" name="listing_id"/>@endif
<div class="form-group col-3 pb-4">
    <label for="title" class="text-danger">Name / Title of the Business *</label>
    <input type="text" class="form-control" id="title" name="title" placeholder="MyBusiness Technologies" required @if($listing) value="{{$listing->title}}" @endif>
</div>
<div class="form-group col-3">
    <label for="city" class="text-danger">Choose City <span>*</span></label>
    <select ref="city" class="form-control" id="city" name="city" @change="cityselected">
        @if(!$listing) <option selected disabled>Select City</option> @endif
        @foreach(\App\City::orderBy('title')->cursor() as $city)
        <option value="{{$city->id}}" @if($listing) @if($city->id == $listing->city_id) selected="selected" @endif @endif>{{$city->title}}</option>
        @endforeach
    </select>
</div>
<div class="form-group col-3" v-if="localities">
    <label for="locality" class="text-danger">Choose Locality <span>*</span></label>
        <select ref="phplocalityselect" class="form-control" name="locality" v-if="!vuecityselected">
        @if($listing && $listing->blog && $listing->blog->city)
            @foreach($listing->blog->city->localities()->orderBy('title')->cursor() as $locality)
                <option value="{{$locality->id}}" @if($listing && $listing->blog) @if($locality->id == $listing->blog->locality_id) selected="selected" @endif @endif>{{$locality->title}}</option>
            @endforeach
        @endif
        </select>
    <select ref="phplocalityselect" class="form-control" name="locality" @if($listing) v-if="vuecityselected" @endif>
        <option v-for="locality in localities" :value="locality.id" @verbatim>{{locality.title}}@endverbatim</option>
    </select>
</div>
<div class="form-group col-3">
    <label for="category" class="text-danger">Choose Category <span>*</span></label>
    <select class="form-control" id="category" name="category">
        @foreach(\App\Category::orderBy('title')->cursor() as $category)
        <option value="{{$category->id}}" @if($listing && $listing->blog) @if($category->id == $listing->blog->category_id) selected="selected" @endif @endif  >{{$category->title}}</option>
        @endforeach
    </select>
</div>


<div class="form-group col-8 pb-12" v-pre>
    <label for="description" class="text-danger">Some description text / content <span class="text-danger">*</span></label>
    <div id="standalone-container">
        <div id="toolbar-container">
                                            <span class="ql-formats">
                                              <select class="ql-size"></select>
                                            </span>
            <span class="ql-formats">
                                              <button class="ql-bold"></button>
                                              <button class="ql-italic"></button>
                                              <button class="ql-underline"></button>
                                              <button class="ql-strike"></button>
                                            </span>
            <span class="ql-formats">
                                              <select class="ql-color"></select>
                                            </span>
            <span class="ql-formats">
                                              <button class="ql-list" value="ordered"></button>
                                              <button class="ql-list" value="bullet"></button>
                                              <button class="ql-indent" value="-1"></button>
                                              <button class="ql-indent" value="+1"></button>
                                            </span>
            <span class="ql-formats">
                                              <select class="ql-align"></select>
                                            </span>
            <span class="ql-formats">
                                              <button class="ql-image"></button>
                                            </span>
        </div>
        <div id="editor" style="height: 86px">@if($listing) @if($listing->description){!! $listing->description !!}@endif @endif
        </div>
    </div>
</div>
    <textarea class="d-none" id="description" name="description" ref="description" rows="3"></textarea>
<div class="form-group col-4 pb-4">
    <label for="address" class="text-danger">Business Address *</label>
    <textarea class="form-control" id="address" name="address" rows="4"  @if(Auth::check() && auth()->id() == 1) @else required @endif
    placeholder="3rd Floor, House 9, Block 19, Kalkaji, New Delhi">@if($listing)@if(isset($listing->raw['address'])){{$listing->raw['address']}} @endif @endif</textarea>
</div>
<div class="form-group col-4 pb-4  border-bottom">
    <label for="website">Business Website Link (if you want shown on your listing)</label>
    <input type="text" class="form-control" id="website" name="website" placeholder="www.mybusiness.com" @if($listing && isset($listing->raw['link']))value="{{$listing->raw['link']}}" @endif>
    <label class="text-danger">Only sites with owned domains are shown (NOT .business.site, facebook.com, wix.com etc.)</label>
</div>

<div class="form-group col-4  pb-4  border-bottom">
    <label for="phone" class="text-danger">Business Mobile Number (at which you want leads to come) *</label>
    <input type="text" class="form-control" id="phone" name="phone" placeholder="9871002345" @if(Auth::check() && auth()->id() == 1) @else required @endif @if($listing && ($listing->phone || isset($listing->raw['phone']) )) value="{{$listing->phone ?? $listing->raw['phone']}}" @endif>
</div>
<div class="form-group col-4  pb-4 border-bottom">
    <label for="email">Business Email address (at which you want leads to come)</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="myname@mybusiness.com" @if($listing && isset($listing->raw['email']))value="{{$listing->raw['email']}}" @endif>
</div>
<div class="form-group col-12">
    <h6 class="text-info">SEO Information</h6>
</div>
<div class="form-group col-6 pb-4">
    <label for="meta_title">SEO Meta Title of your Listing</label>
    <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="MyBusiness Technologies: Leading IT Company in New Delhi" @if($listing && $listing->meta_title) value="{{$listing->meta_title}}" @endif>
</div>
<div class="form-group col-6 pb-4">
    <label for="address">SEO Meta Description of your Listing</label>
    <textarea class="form-control" id="meta_description" name="meta_description" rows="2" placeholder="Looking for Website Development in South Delhi? Call us to get best quote">@if($listing && $listing->meta_description){{$listing->meta_description}} @endif</textarea>
</div>
<div class="form-group col-12 pb-4">
    <label>Enter Keywords for searching this business (add <span class="text-danger font-weight-bold">comma , </span>between multiple keywords)</label>
    <textarea type="text" class="form-control" id="keywords" name="keywords" placeholder="SEO Company in New York, Digital Marketing in Manhattan, Online Marketer near Manhattan">@if($listing && $listing->keywords->count())@foreach($listing->keywords as $k){{$k->title}}@unless($loop->last),@endunless @endforeach @endif</textarea>
</div>

<div class="form-group col-12 border-top">
    <h6 class="text-info mt-3">FAQs Information (shown as Google schema)</h6>
</div>
<div class="form-group col-6 pb-4">
    <label for="meta_title">Add a frequently asked question about your business</label>
    <textarea class="form-control" id="faq" name="faq" placeholder="Which services does MyBusiness specialize in?" rows="4">@if($listing && $listing->business_data && isset($listing->business_data['tags']))@if(collect($listing->business_data['tags'])->filter(function($item){return isset($item['type']) && $item['type']== 'faq';} )->first()){{collect($listing->business_data['tags'])->filter(function($item){return isset($item['type']) && $item['type']== 'faq';} )->first()['ques']}}@endif
        @endif
    </textarea>

</div>
<div class="form-group col-6 pb-4">
    <label for="address">Add your answer for the above question</label>
    <textarea class="form-control" id="faqans" name="faqans" rows="4" placeholder="MyBusiness Technologies specializes in XYZ Services. We have over 1000 clients for XYZ which have over the years provided many testimonials for our service quality. Our founder Sh. ABC has been interviewed many times - you can see his video at ... ">@if($listing && $listing->business_data && isset($listing->business_data['tags']))@if(collect($listing->business_data['tags'])->filter(function($item){return isset($item['type']) && $item['type']== 'faq';} )->first()){{collect($listing->business_data['tags'])->filter(function($item){return isset($item['type']) && $item['type']== 'faq';} )->first()['ans']}}
            @endif
        @endif
    </textarea>
</div>
<div class="form-group col-12 border-top">
    <h6 class="text-info mt-3">Business Information</h6>
</div>
<div class="form-group col-4 pb-4">
    <label>Add a Logo (small)</label>
    <input id="logo" type="file" name="logo">
</div>
<div class="form-group col-4 pb-4">
    <label>Add a banner image (above listing)</label>
    <input id="banner" type="file" name="banner">
</div>
<div class="form-group col-4 pb-4">
    <label>Add another image (in content)</label>
    <input id="contentpic" type="file" name="contentpic">
</div>
<div class="form-group col-4 pb-4">
    <label>Add Brochure / Menu PDF:</label>
    <input id="contentpdf" type="file" name="contentpdf">
</div>
<div class="form-group col-4 pb-4">
    <label>Link of your Business Video on <span class="h5">Youtube</span>:
    <br> <span class="text-danger">Enter link of one video, not channel</span>  </label>

    <input class="form-control" type="text" name="youtubelink" @if(isset($listing->data['youtubelink'])) value="{{$listing->data['youtubelink']}}" placeholder="https://www.youtube.com/watch?v=abcdefg123h" @endif>
</div>


<div class="form-group col-12 border-top">
    <h6 class="text-info mt-3">Image Gallery</h6>
    <input type="checkbox" name="noimagegallery" ref="noimagegallery" @click="noimagegalleryclicked"/> Check this box IF YOU DO NOT WANT TO UPLOAD IMAGES in Image Gallery
</div>
<div class="form-group col-3 pb-4" v-if="imagegalleryallowed">
    <label>Upload <span class="h5">Image 1</span>:</label>
    <input type="file" name="galleryimg1">
</div>
<div class="form-group col-3 pb-4" v-if="imagegalleryallowed">
    <label>Upload <span class="h5">Image 2</span>:</label>
    <input type="file" name="galleryimg2">
</div>
<div class="form-group col-3 pb-4" v-if="imagegalleryallowed">
    <label>Upload <span class="h5">Image 3</span>:</label>
    <input type="file" name="galleryimg3">
</div>
<div class="form-group col-3 pb-4" v-if="imagegalleryallowed">
    <label>Upload <span class="h5">Image 4</span>:</label>
    <input type="file" name="galleryimg4">
</div>
<div class="form-group col-3 pb-4" v-if="imagegalleryallowed">
    <label>Upload <span class="h5">Image 5</span>:</label>
    <input type="file" name="galleryimg5">
</div>
<div class="form-group col-3 pb-4" v-if="imagegalleryallowed">
    <label>Upload <span class="h5">Image 6</span>:</label>
    <input type="file" name="galleryimg6">
</div>
<div class="form-group col-3 pb-4" v-if="imagegalleryallowed">
    <label>Upload <span class="h5">Image 7</span>:</label>
    <input type="file" name="galleryimg7">
</div>
<div class="form-group col-3 pb-4" v-if="imagegalleryallowed">
    <label>Upload <span class="h5">Image 8</span>:</label>
    <input type="file" name="galleryimg8">
</div>
<div class="form-group col-3 pb-4" v-if="imagegalleryallowed">
    <label>Upload <span class="h5">Image 9</span>:</label>
    <input type="file" name="galleryimg9">
</div>




<div class="form-group col-12 border-top">
    <h6 class="text-info mt-3">Custom Links</h6>
    <small class="text-danger">Providing these links will <strong>REALLY BOOST</strong> the SEO and priority of your listing, since we will submit them as 'same-as' attribute in SEO schema.<br> So <strong>WE STRONGLY RECOMMEND</strong> to add all your relevant links here, as this is very important.</small>
</div>
<div class="form-group col-3 pb-4">
    <label>Link of your <span class="h5">LinkedIn</span> Profile:</label>
    <input class="form-control" type="text" name="linkedinlink" @if(isset($listing->data['linkedinlink'])) value="{{$listing->data['linkedinlink']}}" @endif placeholder="https://www.linkedin.com/company/mytechnologies/">
</div>
<div class="form-group col-3 pb-4">
    <label>Link of your <span class="h5">Facebook</span> Profile:</label>
    <input class="form-control" type="text" name="facebooklink" @if(isset($listing->data['facebooklink'])) value="{{$listing->data['facebooklink']}}" @endif placeholder="https://www.facebook.com/MyTechnologies">
</div>
<div class="form-group col-3 pb-4">
    <label>Link of your <span class="h5">Twitter</span> Profile:</label>
    <input class="form-control" type="text" name="twitterlink" @if(isset($listing->data['twitterlink'])) value="{{$listing->data['twitterlink']}}" @endif placeholder="https://twitter.com/mytechnologies">
</div>
<div class="form-group col-3 pb-4">
    <label>Link of your <span class="h5">Instagram</span> Profile:</label>
    <input class="form-control" type="text" name="instagramlink" @if(isset($listing->data['instagramlink'])) value="{{$listing->data['instagramlink']}}" @endif placeholder="https://www.instagram.com/mytechnologies">
</div>


<div class="form-group col-3 pb-4">
    <label>Link of your <span class="h5">Indiamart</span> Profile:</label>
    <input class="form-control" type="text" name="indiamartlink" @if(isset($listing->data['indiamartlink'])) value="{{$listing->data['indiamartlink']}}" @endif placeholder="https://www.indiamart.com/mytechnologies/">
</div>
<div class="form-group col-3 pb-4">
    <label>Link of your <span class="h5">Justdial</span> Profile:</label>
    <input class="form-control" type="text" name="justdiallink" @if(isset($listing->data['justdiallink'])) value="{{$listing->data['justdiallink']}}" @endif placeholder="https://www.justdial.com/My-Technologies">
</div>
<div class="form-group col-3 pb-4">
    <label>Link of your <span class="h5">Sulekha</span> Profile:</label>
    <input class="form-control" type="text" name="sulekhalink" @if(isset($listing->data['sulekhalink'])) value="{{$listing->data['sulekhalink']}}" @endif placeholder="https://www.sulekha.com/mytechnologies">
</div>
<div class="form-group col-3 pb-4">
    <label>Link of your <span class="h5">MagicPin</span> Profile:</label>
    <input class="form-control" type="text" name="magicpinlink" @if(isset($listing->data['magicpinlink'])) value="{{$listing->data['magicpinlink']}}" @endif placeholder="https://magicpin.in/My-Technologies">
</div>

<div class="form-group col-3 pb-4">
    <label>Link on <span class="h5">Google Maps</span>:</label>
    <input class="form-control" type="text" name="custommap" @if(isset($listing->data['custommap'])) value="{{$listing->data['custommap']}}" @endif>
</div>
<div class="form-group col-3 pb-4">
    <label>Link on <span class="h5">Mouthshut</span>.com:</label>
    <input class="form-control" type="text" name="mouthshutlink" @if(isset($listing->data['mouthshutlink'])) value="{{$listing->data['mouthshutlink']}}" @endif placeholder="https://www.mouthshut.com/product-reviews/My-Technologies-123456">
</div>
<div class="form-group col-3 pb-4">
    <label>Link on <span class="h5">Nearbuy</span>.com:</label>
    <input class="form-control" type="text" name="nearbuylink" @if(isset($listing->data['nearbuylink'])) value="{{$listing->data['nearbuylink']}}" @endif placeholder="https://www.nearbuy.com/mycity/my-technologies">
</div>
<div class="form-group col-3 pb-4">
    <label>Link on <span class="h5">TripAdvisor</span>:</label>
    <input class="form-control" type="text" name="tripadvisorlink" @if(isset($listing->data['tripadvisorlink'])) value="{{$listing->data['tripadvisorlink']}}" @endif placeholder="https://tripadvisor.com/my-technologies">
</div>

<div class="form-group col-12 pb-0">
    <div v-if="!showClinicInputs">
        <input  type="checkbox" name="isrestaurant" ref="isrestaurant" @click="isrestaurantclicked"/> Check this box if your business is a <span class="h5">Restaurant</span>
    </div>
    <div v-if="!showRestaurantInputs">
        <input  type="checkbox" name="isclinic" ref="isclinic" @click="isclinicclicked"/> Check this box if your business is a <span class="h5">Clinic / Doctor</span>
    </div>
</div>
<div v-if="showRestaurantInputs" class="form-group col-3 pb-4">
    <label>Link on <span class="h5">Zomato</span>:</label>
    <input class="form-control" type="text" name="zomatolink" @if(isset($listing->data['zomatolink'])) value="{{$listing->data['zomatolink']}}" @endif placeholder="https://www.zomato.com/my-restaurant">
</div>
<div v-if="showRestaurantInputs" class="form-group col-3 pb-4">
    <label>Link on <span class="h5">Swiggy</span>:</label>
    <input class="form-control" type="text" name="swiggylink" @if(isset($listing->data['swiggylink'])) value="{{$listing->data['swiggylink']}}" @endif placeholder="https://swiggy.com/my-restaurant">
</div>
<div v-if="showRestaurantInputs" class="form-group col-3 pb-4">
    <label>Link on <span class="h5">EazyDiner</span>:</label>
    <input class="form-control" type="text" name="eazydinerlink" @if(isset($listing->data['eazydinerlink'])) value="{{$listing->data['eazydinerlink']}}" @endif placeholder="https://www.eazydiner.com/my-restaurant">
</div>

<div v-if="showRestaurantInputs" class="form-group col-3 pb-4">
    <label>Link on <span class="h5">Dineout</span>:</label>
    <input class="form-control" type="text" name="dineoutlink" @if(isset($listing->data['dineoutlink'])) value="{{$listing->data['dineoutlink']}}" @endif placeholder="https://www.dineout.com/my-restaurant">
</div>
<div v-if="showClinicInputs" class="form-group col-3 pb-4">
    <label>Link on <span class="h5">Practo</span>:</label>
    <input class="form-control" type="text" name="practolink" @if(isset($listing->data['practolink'])) value="{{$listing->data['practolink']}}" @endif placeholder="https://www.practo.com/my-name">
</div>

<div class="form-group col-12 border-top">
    <h6 class="text-info mt-3">Working Hours</h6>
    <input type="checkbox" name="noworkinghours" ref="noworkinghours" @click="noworkinghoursclicked"/> Check this box if this business has no working hours. This will remove this section.
</div>
@php
    $ok = true;
    if(isset($listing->data['knowledge_graph']['hours'])){
    $hours = $listing->data['knowledge_graph']['hours']; $c = collect($hours);
    $monday = $c->filter(function($item){return $item["name"]=="Monday";});
    $mondayvalue = $monday->toArray()[$monday->keys()[0]]["value"];
    if( $mondayvalue != "Open 24 Hours" && $mondayvalue != "Open 24 hours" && $mondayvalue != "Closed"){
        if(\Str::contains($mondayvalue,',')){$ok=false;}else{
        [$mondaystart,$mondayclose] = \App\Services\BusinessOpen::fn1($mondayvalue);
        }
    }
    $tuesday = $c->filter(function($item){return $item["name"]=="Tuesday";});
    $tuesdayvalue = $tuesday->toArray()[$tuesday->keys()[0]]["value"];
    if($tuesdayvalue != "Open 24 Hours" && $tuesdayvalue != "Open 24 hours" && $tuesdayvalue != "Closed"){
        if(\Str::contains($tuesdayvalue,',')){$ok=false;}else{
        [$tuesdaystart,$tuesdayclose] = \App\Services\BusinessOpen::fn1($tuesdayvalue);
        }
    }
    $wednesday = $c->filter(function($item){return $item["name"]=="Wednesday";});
    $wednesdayvalue = $wednesday->toArray()[$wednesday->keys()[0]]["value"];
    if($wednesdayvalue != "Open 24 Hours" && $wednesdayvalue!= "Open 24 hours" && $wednesdayvalue != "Closed"){
        if(\Str::contains($wednesdayvalue,',')){$ok=false;}else{
        [$wednesdaystart,$wednesdayclose] = \App\Services\BusinessOpen::fn1($wednesdayvalue);
        }
    }
    $thursday = $c->filter(function($item){return $item["name"]=="Thursday";});
    $thursdayvalue = $thursday->toArray()[$thursday->keys()[0]]["value"];
    if($thursdayvalue != "Open 24 Hours" && $thursdayvalue != "Open 24 hours" && $thursdayvalue != "Closed"){
        if(\Str::contains($thursdayvalue,',')){$ok=false;}else{
        [$thursdaystart,$thursdayclose] = \App\Services\BusinessOpen::fn1($thursdayvalue);
        }
    }
    $friday = $c->filter(function($item){return $item["name"]=="Friday";});
    $fridayvalue = $friday->toArray()[$friday->keys()[0]]["value"];
    if($fridayvalue != "Open 24 Hours" && $fridayvalue!= "Open 24 hours" && $fridayvalue != "Closed"){
        if(\Str::contains($fridayvalue,',')){$ok=false;}else{
        [$fridaystart,$fridayclose] = \App\Services\BusinessOpen::fn1($fridayvalue);
        }
    }
    $saturday = $c->filter(function($item){return $item["name"]=="Saturday";});
    $saturdayvalue = $saturday->toArray()[$saturday->keys()[0]]["value"];
    if($saturdayvalue != "Open 24 Hours" && $saturdayvalue != "Open 24 hours" && $saturdayvalue != "Closed"){
        if(\Str::contains($saturdayvalue,',')){$ok=false;}else{
        [$saturdaystart,$saturdayclose] = \App\Services\BusinessOpen::fn1($saturdayvalue);
        }
    }
    $sunday = $c->filter(function($item){return $item["name"]=="Sunday";});
    $sundayvalue = $sunday->toArray()[$sunday->keys()[0]]["value"];
    if($sundayvalue != "Open 24 Hours" && $sundayvalue != "Open 24 hours" && $sundayvalue != "Closed"){
        if(\Str::contains($sundayvalue,',')){$ok=false;}else{
        [$sundaystart,$sundayclose] = \App\Services\BusinessOpen::fn1($sundayvalue);
        }
    }
    }
@endphp

@if($ok)
<div v-if="workhoursallowed" class="form-group col-4 pb-4">
    <label>Monday:</label>
    <select class="form-control" type="text" name="monday" @change="mondayselected" ref="monday">
        <option value="closed" @if(isset($mondayvalue) && $mondayvalue == 'Closed') selected @endif>Closed</option>
        <option value="open24" @if(isset($mondayvalue) && ( ($mondayvalue == 'Open 24 Hours') || ($mondayvalue == 'Open 24 hours') ) ) selected @endif>Open 24 hours</option>
        <option value="custom" @if(isset($mondayvalue) && $mondayvalue != "Open 24 Hours" && $mondayvalue != "Open 24 hours" && $mondayvalue != "Closed") selected @endif>Specific hours</option>
    </select>
    <div v-show="showmondaycustomdiv">
        <br>
        Select Monday specific timings:

        <br />Open: <select ref="mondaystart" name="mondaystart">
            <option @if(isset($mondaystart) && $mondaystart->hour == 8 && $mondaystart->minute == 0) selected @endif value="8">08:00 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 8 && $mondaystart->minute == 30) selected @endif value="8h">08:30 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 9 && $mondaystart->minute == 0) selected @endif value="9">09:00 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 9 && $mondaystart->minute == 30) selected @endif value="9h">09:30 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 10 && $mondaystart->minute == 0) selected @endif value="10">10:00 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 10 && $mondaystart->minute == 30) selected @endif value="10h">10:30 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 11 && $mondaystart->minute == 0) selected @endif value="11">11:00 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 11 && $mondaystart->minute == 30) selected @endif value="11h">11:30 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 12 && $mondaystart->minute == 0) selected @endif value="12">12:00 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 12 && $mondaystart->minute == 30) selected @endif value="12h">12:30 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 13 && $mondaystart->minute == 0) selected @endif value="13">01:00 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 13 && $mondaystart->minute == 30) selected @endif value="13h">01:30 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 14 && $mondaystart->minute == 0) selected @endif value="14">02:00 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 14 && $mondaystart->minute == 30) selected @endif value="14h">02:30 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 15 && $mondaystart->minute == 0) selected @endif value="15">03:00 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 15 && $mondaystart->minute == 30) selected @endif value="15h">03:30 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 16 && $mondaystart->minute == 0) selected @endif value="16">04:00 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 16 && $mondaystart->minute == 30) selected @endif value="16h">04:30 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 17 && $mondaystart->minute == 0) selected @endif value="17">05:00 PM</option>
            <option @if(isset($mondaystart)&& $mondaystart->hour == 17 && $mondaystart->minute == 30) selected @endif value="17h">05:30 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 18 && $mondaystart->minute == 0) selected @endif value="18">06:00 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 18 && $mondaystart->minute == 30) selected @endif value="18h">06:30 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 19 && $mondaystart->minute == 0) selected @endif value="19">07:00 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 19 && $mondaystart->minute == 30) selected @endif value="19h">07:30 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 20 && $mondaystart->minute == 0) selected @endif value="20">08:00 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 20 && $mondaystart->minute == 30) selected @endif value="20h">08:30 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 21 && $mondaystart->minute == 0) selected @endif value="21">09:00 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 21 && $mondaystart->minute == 30) selected @endif value="21h">09:30 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 22 && $mondaystart->minute == 0) selected @endif value="22">10:00 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 22 && $mondaystart->minute == 30) selected @endif value="22h">10:30 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 23 && $mondaystart->minute == 0) selected @endif value="23">11:00 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 23 && $mondaystart->minute == 30) selected @endif value="23h">11:30 PM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 0 && $mondaystart->minute == 0) selected @endif value="0">00:00</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 0 && $mondaystart->minute == 30) selected @endif value="0h">00:30</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 1 && $mondaystart->minute == 0) selected @endif value="1">01:00 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 1 && $mondaystart->minute == 30) selected @endif value="1h">01:30 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 2 && $mondaystart->minute == 0) selected @endif value="2">02:00 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 2 && $mondaystart->minute == 30) selected @endif value="2h">02:30 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 3 && $mondaystart->minute == 0) selected @endif value="3">03:00 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 3 && $mondaystart->minute == 30) selected @endif value="3h">03:30 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 4 && $mondaystart->minute == 0) selected @endif value="4">04:00 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 4 && $mondaystart->minute == 30) selected @endif value="4h">04:30 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 5 && $mondaystart->minute == 0) selected @endif value="5">05:00 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 5 && $mondaystart->minute == 30) selected @endif value="5h">05:30 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 6 && $mondaystart->minute == 0) selected @endif value="6">06:00 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 6 && $mondaystart->minute == 30) selected @endif value="6h">06:30 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 7 && $mondaystart->minute == 0) selected @endif value="7">07:00 AM</option>
            <option @if(isset($mondaystart) && $mondaystart->hour == 7 && $mondaystart->minute == 30) selected @endif value="7h">07:30 AM</option>
        </select>
        <br />Close: <select ref="mondayclose" class="mb-2" name="mondayclose">
            <option @if(isset($mondayclose) && $mondayclose->hour == 8 && $mondayclose->minute == 0) selected @endif value="8">08:00 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 8 && $mondayclose->minute == 30) selected @endif value="8h">08:30 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 9 && $mondayclose->minute == 0) selected @endif value="9">09:00 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 9 && $mondayclose->minute == 30) selected @endif value="9h">09:30 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 10 && $mondayclose->minute == 0) selected @endif value="10">10:00 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 10 && $mondayclose->minute == 30) selected @endif value="10h">10:30 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 11 && $mondayclose->minute == 0) selected @endif value="11">11:00 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 11 && $mondayclose->minute == 30) selected @endif value="11h">11:30 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 12 && $mondayclose->minute == 0) selected @endif value="12">12:00 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 12 && $mondayclose->minute == 30) selected @endif value="12h">12:30 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 13 && $mondayclose->minute == 0) selected @endif value="13">01:00 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 13 && $mondayclose->minute == 30) selected @endif value="13h">01:30 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 14 && $mondayclose->minute == 0) selected @endif value="14">02:00 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 14 && $mondayclose->minute == 30) selected @endif value="14h">02:30 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 15 && $mondayclose->minute == 0) selected @endif value="15">03:00 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 15 && $mondayclose->minute == 30) selected @endif value="15h">03:30 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 16 && $mondayclose->minute == 0) selected @endif value="16">04:00 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 16 && $mondayclose->minute == 30) selected @endif value="16h">04:30 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 17 && $mondayclose->minute == 0) selected @endif value="17">05:00 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 17 && $mondayclose->minute == 30) selected @endif value="17h">05:30 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 18 && $mondayclose->minute == 0) selected @endif value="18">06:00 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 18 && $mondayclose->minute == 30) selected @endif value="18h">06:30 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 19 && $mondayclose->minute == 0) selected @endif value="19">07:00 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 19 && $mondayclose->minute == 30) selected @endif value="19h">07:30 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 20 && $mondayclose->minute == 0) selected @endif value="20">08:00 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 20 && $mondayclose->minute == 30) selected @endif value="20h">08:30 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 21 && $mondayclose->minute == 0) selected @endif value="21">09:00 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 21 && $mondayclose->minute == 30) selected @endif value="21h">09:30 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 22 && $mondayclose->minute == 0) selected @endif value="22">10:00 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 22 && $mondayclose->minute == 30) selected @endif value="22h">10:30 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 23 && $mondayclose->minute == 0) selected @endif value="23">11:00 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 23 && $mondayclose->minute == 30) selected @endif value="23h">11:30 PM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 0 && $mondayclose->minute == 0) selected @endif value="0">00:00</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 0 && $mondayclose->minute == 30) selected @endif value="0h">00:30</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 1 && $mondayclose->minute == 0) selected @endif value="1">01:00 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 1 && $mondayclose->minute == 30) selected @endif value="1h">01:30 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 2 && $mondayclose->minute == 0) selected @endif value="2">02:00 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 2 && $mondayclose->minute == 30) selected @endif value="2h">02:30 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 3 && $mondayclose->minute == 0) selected @endif value="3">03:00 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 3 && $mondayclose->minute == 30) selected @endif value="3h">03:30 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 4 && $mondayclose->minute == 0) selected @endif value="4">04:00 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 4 && $mondayclose->minute == 30) selected @endif value="4h">04:30 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 5 && $mondayclose->minute == 0) selected @endif value="5">05:00 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 5 && $mondayclose->minute == 30) selected @endif value="5h">05:30 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 6 && $mondayclose->minute == 0) selected @endif value="6">06:00 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 6 && $mondayclose->minute == 30) selected @endif value="6h">06:30 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 7 && $mondayclose->minute == 0) selected @endif value="7">07:00 AM</option>
            <option @if(isset($mondayclose) && $mondayclose->hour == 7 && $mondayclose->minute == 30) selected @endif value="7h">07:30 AM</option>
        </select>
        <br><input type="checkbox" name="copytoall" ref="copytoall" @click="copytoallclicked"/> <small class="text-danger">Copy these hours to all days</small>
    </div>
    <br>
    <label>Tuesday:</label>
    <select class="form-control" type="text" name="tuesday" @change="tuesdayselected" ref="tuesday">
        <option @if(isset($tuesdayvalue) && $tuesdayvalue == 'Closed') selected @endif value="closed">Closed</option>
        <option @if(isset($tuesdayvalue) && ((($tuesdayvalue == 'Open 24 Hours') || ($tuesdayvalue == 'Open 24 hours')))    ) selected @endif value="open24">Open 24 hours</option>
        <option @if(isset($tuesdayvalue) && $tuesdayvalue != "Closed" && $tuesdayvalue != "Open 24 Hours" && $tuesdayvalue != "Open 24 hours") selected @endif value="custom">Specific hours</option>
    </select>
    <div v-show="showtuesdaycustomdiv">
        <br>
        Select Tuesday specific timings:
        <br />Open: <select ref="tuesdaystart" name="tuesdaystart">
            <option @if(isset($tuesdaystart) && $tuesdaystart->hour == 8 && $tuesdaystart->minute == 0) selected @endif value="8">08:00 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 8 && $tuesdaystart->minute == 30) selected @endif value="8h">08:30 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 9 && $tuesdaystart->minute == 0) selected @endif value="9">09:00 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 9 && $tuesdaystart->minute == 30) selected @endif value="9h">09:30 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 10 && $tuesdaystart->minute == 0) selected @endif value="10">10:00 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 10 && $tuesdaystart->minute == 30) selected @endif value="10h">10:30 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 11 && $tuesdaystart->minute == 0) selected @endif value="11">11:00 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 11 && $tuesdaystart->minute == 30) selected @endif value="11h">11:30 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 12 && $tuesdaystart->minute == 0) selected @endif value="12">12:00 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 12 && $tuesdaystart->minute == 30) selected @endif value="12h">12:30 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 13 && $tuesdaystart->minute == 0) selected @endif value="13">01:00 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 13 && $tuesdaystart->minute == 30) selected @endif value="13h">01:30 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 14 && $tuesdaystart->minute == 0) selected @endif value="14">02:00 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 14 && $tuesdaystart->minute == 30) selected @endif value="14h">02:30 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 15 && $tuesdaystart->minute == 0) selected @endif value="15">03:00 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 15 && $tuesdaystart->minute == 30) selected @endif value="15h">03:30 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 16 && $tuesdaystart->minute == 0) selected @endif value="16">04:00 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 16 && $tuesdaystart->minute == 30) selected @endif value="16h">04:30 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 17 && $tuesdaystart->minute == 0) selected @endif value="17">05:00 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 17 && $tuesdaystart->minute == 30) selected @endif value="17h">05:30 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 18 && $tuesdaystart->minute == 0) selected @endif value="18">06:00 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 18 && $tuesdaystart->minute == 30) selected @endif value="18h">06:30 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 19 && $tuesdaystart->minute == 0) selected @endif value="19">07:00 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 19 && $tuesdaystart->minute == 30) selected @endif value="19h">07:30 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 20 && $tuesdaystart->minute == 0) selected @endif value="20">08:00 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 20 && $tuesdaystart->minute == 30) selected @endif value="20h">08:30 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 21 && $tuesdaystart->minute == 0) selected @endif value="21">09:00 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 21 && $tuesdaystart->minute == 30) selected @endif value="21h">09:30 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 22 && $tuesdaystart->minute == 0) selected @endif value="22">10:00 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 22 && $tuesdaystart->minute == 30) selected @endif value="22h">10:30 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 23 && $tuesdaystart->minute == 0) selected @endif value="23">11:00 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 23 && $tuesdaystart->minute == 30) selected @endif value="23h">11:30 PM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 0 && $tuesdaystart->minute == 0) selected @endif value="0">00:00</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 0 && $tuesdaystart->minute == 30) selected @endif value="0h">00:30</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 1 && $tuesdaystart->minute == 0) selected @endif value="1">01:00 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 1 && $tuesdaystart->minute == 30) selected @endif value="1h">01:30 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 2 && $tuesdaystart->minute == 0) selected @endif value="2">02:00 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 2 && $tuesdaystart->minute == 30) selected @endif value="2h">02:30 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 3 && $tuesdaystart->minute == 0) selected @endif value="3">03:00 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 3 && $tuesdaystart->minute == 30) selected @endif value="3h">03:30 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 4 && $tuesdaystart->minute == 0) selected @endif value="4">04:00 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 4 && $tuesdaystart->minute == 30) selected @endif value="4h">04:30 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 5 && $tuesdaystart->minute == 0) selected @endif value="5">05:00 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 5 && $tuesdaystart->minute == 30) selected @endif value="5h">05:30 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 6 && $tuesdaystart->minute == 0) selected @endif value="6">06:00 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 6 && $tuesdaystart->minute == 30) selected @endif value="6h">06:30 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 7 && $tuesdaystart->minute == 0) selected @endif value="7">07:00 AM</option>
            <option @if( isset($tuesdaystart) &&  $tuesdaystart->hour == 7 && $tuesdaystart->minute == 30) selected @endif value="7h">07:30 AM</option>
        </select>
        <br />Close: <select ref="tuesdayclose" name="tuesdayclose">
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 8 && $tuesdayclose->minute == 0) selected @endif value="8">08:00 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 8 && $tuesdayclose->minute == 30) selected @endif value="8h">08:30 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 9 && $tuesdayclose->minute == 0) selected @endif value="9">09:00 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 9 && $tuesdayclose->minute == 30) selected @endif value="9h">09:30 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 10 && $tuesdayclose->minute == 0) selected @endif value="10">10:00 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 10 && $tuesdayclose->minute == 30) selected @endif value="10h">10:30 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 11 && $tuesdayclose->minute == 0) selected @endif value="11">11:00 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 11 && $tuesdayclose->minute == 30) selected @endif value="11h">11:30 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 12 && $tuesdayclose->minute == 0) selected @endif value="12">12:00 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 12 && $tuesdayclose->minute == 30) selected @endif value="12h">12:30 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 13 && $tuesdayclose->minute == 0) selected @endif value="13">01:00 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 13 && $tuesdayclose->minute == 30) selected @endif value="13h">01:30 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 14 && $tuesdayclose->minute == 0) selected @endif value="14">02:00 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 14 && $tuesdayclose->minute == 30) selected @endif value="14h">02:30 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 15 && $tuesdayclose->minute == 0) selected @endif value="15">03:00 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 15 && $tuesdayclose->minute == 30) selected @endif value="15h">03:30 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 16 && $tuesdayclose->minute == 0) selected @endif value="16">04:00 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 16 && $tuesdayclose->minute == 30) selected @endif value="16h">04:30 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 17 && $tuesdayclose->minute == 0) selected @endif value="17">05:00 PM</option>
            <option @if( isset($tuesdayclose) && $tuesdayclose->hour == 17 && $tuesdayclose->minute == 30) selected @endif value="17h">05:30 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 18 && $tuesdayclose->minute == 0) selected @endif value="18">06:00 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 18 && $tuesdayclose->minute == 30) selected @endif value="18h">06:30 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 19 && $tuesdayclose->minute == 0) selected @endif value="19">07:00 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 19 && $tuesdayclose->minute == 30) selected @endif value="19h">07:30 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 20 && $tuesdayclose->minute == 0) selected @endif value="20">08:00 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 20 && $tuesdayclose->minute == 30) selected @endif value="20h">08:30 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 21 && $tuesdayclose->minute == 0) selected @endif value="21">09:00 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 21 && $tuesdayclose->minute == 30) selected @endif value="21h">09:30 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 22 && $tuesdayclose->minute == 0) selected @endif value="22">10:00 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 22 && $tuesdayclose->minute == 30) selected @endif value="22h">10:30 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 23 && $tuesdayclose->minute == 0) selected @endif value="23">11:00 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 23 && $tuesdayclose->minute == 30) selected @endif value="23h">11:30 PM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 0 && $tuesdayclose->minute == 0) selected @endif value="0">00:00</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 0 && $tuesdayclose->minute == 30) selected @endif value="0h">00:30</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 1 && $tuesdayclose->minute == 0) selected @endif value="1">01:00 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 1 && $tuesdayclose->minute == 30) selected @endif value="1h">01:30 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 2 && $tuesdayclose->minute == 0) selected @endif value="2">02:00 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 2 && $tuesdayclose->minute == 30) selected @endif value="2h">02:30 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 3 && $tuesdayclose->minute == 0) selected @endif value="3">03:00 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 3 && $tuesdayclose->minute == 30) selected @endif value="3h">03:30 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 4 && $tuesdayclose->minute == 0) selected @endif value="4">04:00 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 4 && $tuesdayclose->minute == 30) selected @endif value="4h">04:30 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 5 && $tuesdayclose->minute == 0) selected @endif value="5">05:00 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 5 && $tuesdayclose->minute == 30) selected @endif value="5h">05:30 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 6 && $tuesdayclose->minute == 0) selected @endif value="6">06:00 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 6 && $tuesdayclose->minute == 30) selected @endif value="6h">06:30 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 7 && $tuesdayclose->minute == 0) selected @endif value="7">07:00 AM</option>
            <option @if( isset($tuesdayclose) &&  $tuesdayclose->hour == 7 && $tuesdayclose->minute == 30) selected @endif value="7h">07:30 AM</option>
        </select>
    </div>
</div>
<div v-if="workhoursallowed" class="form-group col-4 pb-4">
    <label>Wednesday:</label>
    <select class="form-control" type="text" name="wednesday" @change="wednesdayselected" ref="wednesday">
        <option @if(isset($wednesdayvalue) && $wednesdayvalue == 'Closed') selected @endif value="closed">Closed</option>
        <option @if(isset($wednesdayvalue) && (( $wednesdayvalue == 'Open 24 Hours') || ( $wednesdayvalue == 'Open 24 hours') ) ) selected @endif value="open24">Open 24 hours</option>
        <option @if(isset($wednesdayvalue) && $wednesdayvalue != "Closed" && $wednesdayvalue != "Open 24 Hours" && $wednesdayvalue != "Open 24 hours") selected @endif value="custom">Specific hours</option>
    </select>
    <div v-show="showwednesdaycustomdiv">
    <br>
    Select Wednesday specific timings:
        <br />Open: <select ref="wednesdaystart" name="wednesdaystart">
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 8 && $wednesdaystart->minute == 0) selected @endif value="8">08:00 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 8 && $wednesdaystart->minute == 30) selected @endif value="8h">08:30 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 9 && $wednesdaystart->minute == 0) selected @endif value="9">09:00 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 9 && $wednesdaystart->minute == 30) selected @endif value="9h">09:30 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 10 && $wednesdaystart->minute == 0) selected @endif value="10">10:00 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 10 && $wednesdaystart->minute == 30) selected @endif value="10h">10:30 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 11 && $wednesdaystart->minute == 0) selected @endif value="11">11:00 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 11 && $wednesdaystart->minute == 30) selected @endif value="11h">11:30 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 12 && $wednesdaystart->minute == 0) selected @endif value="12">12:00 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 12 && $wednesdaystart->minute == 30) selected @endif value="12h">12:30 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 13 && $wednesdaystart->minute == 0) selected @endif value="13">01:00 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 13 && $wednesdaystart->minute == 30) selected @endif value="13h">01:30 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 14 && $wednesdaystart->minute == 0) selected @endif value="14">02:00 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 14 && $wednesdaystart->minute == 30) selected @endif value="14h">02:30 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 15 && $wednesdaystart->minute == 0) selected @endif value="15">03:00 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 15 && $wednesdaystart->minute == 30) selected @endif value="15h">03:30 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 16 && $wednesdaystart->minute == 0) selected @endif value="16">04:00 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 16 && $wednesdaystart->minute == 30) selected @endif value="16h">04:30 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 17 && $wednesdaystart->minute == 0) selected @endif value="17">05:00 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 17 && $wednesdaystart->minute == 30) selected @endif value="17h">05:30 PM</option>
            <option @if( isset($wednesdaystart) && $wednesdaystart->hour == 18 && $wednesdaystart->minute == 0) selected @endif value="18">06:00 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 18 && $wednesdaystart->minute == 30) selected @endif value="18h">06:30 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 19 && $wednesdaystart->minute == 0) selected @endif value="19">07:00 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 19 && $wednesdaystart->minute == 30) selected @endif value="19h">07:30 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 20 && $wednesdaystart->minute == 0) selected @endif value="20">08:00 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 20 && $wednesdaystart->minute == 30) selected @endif value="20h">08:30 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 21 && $wednesdaystart->minute == 0) selected @endif value="21">09:00 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 21 && $wednesdaystart->minute == 30) selected @endif value="21h">09:30 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 22 && $wednesdaystart->minute == 0) selected @endif value="22">10:00 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 22 && $wednesdaystart->minute == 30) selected @endif value="22h">10:30 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 23 && $wednesdaystart->minute == 0) selected @endif value="23">11:00 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 23 && $wednesdaystart->minute == 30) selected @endif value="23h">11:30 PM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 0 && $wednesdaystart->minute == 0) selected @endif value="0">00:00</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 0 && $wednesdaystart->minute == 30) selected @endif value="0h">00:30</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 1 && $wednesdaystart->minute == 0) selected @endif value="1">01:00 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 1 && $wednesdaystart->minute == 30) selected @endif value="1h">01:30 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 2 && $wednesdaystart->minute == 0) selected @endif value="2">02:00 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 2 && $wednesdaystart->minute == 30) selected @endif value="2h">02:30 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 3 && $wednesdaystart->minute == 0) selected @endif value="3">03:00 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 3 && $wednesdaystart->minute == 30) selected @endif value="3h">03:30 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 4 && $wednesdaystart->minute == 0) selected @endif value="4">04:00 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 4 && $wednesdaystart->minute == 30) selected @endif value="4h">04:30 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 5 && $wednesdaystart->minute == 0) selected @endif value="5">05:00 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 5 && $wednesdaystart->minute == 30) selected @endif value="5h">05:30 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 6 && $wednesdaystart->minute == 0) selected @endif value="6">06:00 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 6 && $wednesdaystart->minute == 30) selected @endif value="6h">06:30 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 7 && $wednesdaystart->minute == 0) selected @endif value="7">07:00 AM</option>
            <option @if( isset($wednesdaystart) &&  $wednesdaystart->hour == 7 && $wednesdaystart->minute == 30) selected @endif value="7h">07:30 AM</option>
        </select>
        <br />Close: <select ref="wednesdayclose" name="wednesdayclose">
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 8 && $wednesdayclose->minute == 0) selected @endif value="8">08:00 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 8 && $wednesdayclose->minute == 30) selected @endif value="8h">08:30 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 9 && $wednesdayclose->minute == 0) selected @endif value="9">09:00 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 9 && $wednesdayclose->minute == 30) selected @endif value="9h">09:30 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 10 && $wednesdayclose->minute == 0) selected @endif value="10">10:00 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 10 && $wednesdayclose->minute == 30) selected @endif value="10h">10:30 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 11 && $wednesdayclose->minute == 0) selected @endif value="11">11:00 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 11 && $wednesdayclose->minute == 30) selected @endif value="11h">11:30 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 12 && $wednesdayclose->minute == 0) selected @endif value="12">12:00 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 12 && $wednesdayclose->minute == 30) selected @endif value="12h">12:30 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 13 && $wednesdayclose->minute == 0) selected @endif value="13">01:00 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 13 && $wednesdayclose->minute == 30) selected @endif value="13h">01:30 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 14 && $wednesdayclose->minute == 0) selected @endif value="14">02:00 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 14 && $wednesdayclose->minute == 30) selected @endif value="14h">02:30 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 15 && $wednesdayclose->minute == 0) selected @endif value="15">03:00 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 15 && $wednesdayclose->minute == 30) selected @endif value="15h">03:30 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 16 && $wednesdayclose->minute == 0) selected @endif value="16">04:00 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 16 && $wednesdayclose->minute == 30) selected @endif value="16h">04:30 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 17 && $wednesdayclose->minute == 0) selected @endif value="17">05:00 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 17 && $wednesdayclose->minute == 30) selected @endif value="17h">05:30 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 18 && $wednesdayclose->minute == 0) selected @endif value="18">06:00 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 18 && $wednesdayclose->minute == 30) selected @endif value="18h">06:30 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 19 && $wednesdayclose->minute == 0) selected @endif value="19">07:00 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 19 && $wednesdayclose->minute == 30) selected @endif value="19h">07:30 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 20 && $wednesdayclose->minute == 0) selected @endif value="20">08:00 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 20 && $wednesdayclose->minute == 30) selected @endif value="20h">08:30 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 21 && $wednesdayclose->minute == 0) selected @endif value="21">09:00 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 21 && $wednesdayclose->minute == 30) selected @endif value="21h">09:30 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 22 && $wednesdayclose->minute == 0) selected @endif value="22">10:00 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 22 && $wednesdayclose->minute == 30) selected @endif value="22h">10:30 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 23 && $wednesdayclose->minute == 0) selected @endif value="23">11:00 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 23 && $wednesdayclose->minute == 30) selected @endif value="23h">11:30 PM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 0 && $wednesdayclose->minute == 0) selected @endif value="0">00:00</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 0 && $wednesdayclose->minute == 30) selected @endif value="0h">00:30</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 1 && $wednesdayclose->minute == 0) selected @endif value="1">01:00 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 1 && $wednesdayclose->minute == 30) selected @endif value="1h">01:30 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 2 && $wednesdayclose->minute == 0) selected @endif value="2">02:00 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 2 && $wednesdayclose->minute == 30) selected @endif value="2h">02:30 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 3 && $wednesdayclose->minute == 0) selected @endif value="3">03:00 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 3 && $wednesdayclose->minute == 30) selected @endif value="3h">03:30 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 4 && $wednesdayclose->minute == 0) selected @endif value="4">04:00 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 4 && $wednesdayclose->minute == 30) selected @endif value="4h">04:30 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 5 && $wednesdayclose->minute == 0) selected @endif value="5">05:00 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 5 && $wednesdayclose->minute == 30) selected @endif value="5h">05:30 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 6 && $wednesdayclose->minute == 0) selected @endif value="6">06:00 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 6 && $wednesdayclose->minute == 30) selected @endif value="6h">06:30 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 7 && $wednesdayclose->minute == 0) selected @endif value="7">07:00 AM</option>
            <option @if( isset($wednesdayclose) &&   $wednesdayclose->hour == 7 && $wednesdayclose->minute == 30) selected @endif value="7h">07:30 AM</option>
        </select>
    </div>
    <br>
    <label>Thursday:</label>
    <select class="form-control" type="text" name="thursday" @change="thursdayselected" ref="thursday">
        <option @if(isset($thursdayvalue) && $thursdayvalue == 'Closed') selected @endif value="closed">Closed</option>
        <option @if(isset($thursdayvalue) && (($thursdayvalue == 'Open 24 Hours') || ($thursdayvalue == 'Open 24 hours') )) selected @endif value="open24">Open 24 hours</option>
        <option @if(isset($thursdayvalue) && $thursdayvalue != "Closed" && $thursdayvalue != "Open 24 Hours" && $thursdayvalue != "Open 24 hours") selected @endif value="custom">Specific hours</option>
    </select>
    <div v-show="showthursdaycustomdiv">
        <br>
        Select Thursday specific timings:
        <br />Open: <select ref="thursdaystart" name="thursdaystart">
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 8 && $thursdaystart->minute == 0) selected @endif value="8">08:00 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 8 && $thursdaystart->minute == 30) selected @endif value="8h">08:30 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 9 && $thursdaystart->minute == 0) selected @endif value="9">09:00 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 9 && $thursdaystart->minute == 30) selected @endif value="9h">09:30 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 10 && $thursdaystart->minute == 0) selected @endif value="10">10:00 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 10 && $thursdaystart->minute == 30) selected @endif value="10h">10:30 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 11 && $thursdaystart->minute == 0) selected @endif value="11">11:00 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 11 && $thursdaystart->minute == 30) selected @endif value="11h">11:30 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 12 && $thursdaystart->minute == 0) selected @endif value="12">12:00 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 12 && $thursdaystart->minute == 30) selected @endif value="12h">12:30 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 13 && $thursdaystart->minute == 0) selected @endif value="13">01:00 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 13 && $thursdaystart->minute == 30) selected @endif value="13h">01:30 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 14 && $thursdaystart->minute == 0) selected @endif value="14">02:00 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 14 && $thursdaystart->minute == 30) selected @endif value="14h">02:30 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 15 && $thursdaystart->minute == 0) selected @endif value="15">03:00 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 15 && $thursdaystart->minute == 30) selected @endif value="15h">03:30 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 16 && $thursdaystart->minute == 0) selected @endif value="16">04:00 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 16 && $thursdaystart->minute == 30) selected @endif value="16h">04:30 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 17 && $thursdaystart->minute == 0) selected @endif value="17">05:00 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 17 && $thursdaystart->minute == 30) selected @endif value="17h">05:30 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 18 && $thursdaystart->minute == 0) selected @endif value="18">06:00 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 18 && $thursdaystart->minute == 30) selected @endif value="18h">06:30 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 19 && $thursdaystart->minute == 0) selected @endif value="19">07:00 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 19 && $thursdaystart->minute == 30) selected @endif value="19h">07:30 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 20 && $thursdaystart->minute == 0) selected @endif value="20">08:00 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 20 && $thursdaystart->minute == 30) selected @endif value="20h">08:30 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 21 && $thursdaystart->minute == 0) selected @endif value="21">09:00 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 21 && $thursdaystart->minute == 30) selected @endif value="21h">09:30 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 22 && $thursdaystart->minute == 0) selected @endif value="22">10:00 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 22 && $thursdaystart->minute == 30) selected @endif value="22h">10:30 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 23 && $thursdaystart->minute == 0) selected @endif value="23">11:00 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 23 && $thursdaystart->minute == 30) selected @endif value="23h">11:30 PM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 0 && $thursdaystart->minute == 0) selected @endif value="0">00:00</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 0 && $thursdaystart->minute == 30) selected @endif value="0h">00:30</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 1 && $thursdaystart->minute == 0) selected @endif value="1">01:00 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 1 && $thursdaystart->minute == 30) selected @endif value="1h">01:30 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 2 && $thursdaystart->minute == 0) selected @endif value="2">02:00 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 2 && $thursdaystart->minute == 30) selected @endif value="2h">02:30 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 3 && $thursdaystart->minute == 0) selected @endif value="3">03:00 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 3 && $thursdaystart->minute == 30) selected @endif value="3h">03:30 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 4 && $thursdaystart->minute == 0) selected @endif value="4">04:00 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 4 && $thursdaystart->minute == 30) selected @endif value="4h">04:30 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 5 && $thursdaystart->minute == 0) selected @endif value="5">05:00 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 5 && $thursdaystart->minute == 30) selected @endif value="5h">05:30 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 6 && $thursdaystart->minute == 0) selected @endif value="6">06:00 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 6 && $thursdaystart->minute == 30) selected @endif value="6h">06:30 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 7 && $thursdaystart->minute == 0) selected @endif value="7">07:00 AM</option>
            <option @if( isset($thursdaystart) &&  $thursdaystart->hour == 7 && $thursdaystart->minute == 30) selected @endif value="7h">07:30 AM</option>
        </select>
        <br />Close: <select ref="thursdayclose" name="thursdayclose">
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 8 && $thursdayclose->minute == 0) selected @endif value="8">08:00 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 8 && $thursdayclose->minute == 30) selected @endif value="8h">08:30 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 9 && $thursdayclose->minute == 0) selected @endif value="9">09:00 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 9 && $thursdayclose->minute == 30) selected @endif value="9h">09:30 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 10 && $thursdayclose->minute == 0) selected @endif value="10">10:00 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 10 && $thursdayclose->minute == 30) selected @endif value="10h">10:30 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 11 && $thursdayclose->minute == 0) selected @endif value="11">11:00 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 11 && $thursdayclose->minute == 30) selected @endif value="11h">11:30 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 12 && $thursdayclose->minute == 0) selected @endif value="12">12:00 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 12 && $thursdayclose->minute == 30) selected @endif value="12h">12:30 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 13 && $thursdayclose->minute == 0) selected @endif value="13">01:00 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 13 && $thursdayclose->minute == 30) selected @endif value="13h">01:30 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 14 && $thursdayclose->minute == 0) selected @endif value="14">02:00 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 14 && $thursdayclose->minute == 30) selected @endif value="14h">02:30 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 15 && $thursdayclose->minute == 0) selected @endif value="15">03:00 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 15 && $thursdayclose->minute == 30) selected @endif value="15h">03:30 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 16 && $thursdayclose->minute == 0) selected @endif value="16">04:00 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 16 && $thursdayclose->minute == 30) selected @endif value="16h">04:30 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 17 && $thursdayclose->minute == 0) selected @endif value="17">05:00 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 17 && $thursdayclose->minute == 30) selected @endif value="17h">05:30 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 18 && $thursdayclose->minute == 0) selected @endif value="18">06:00 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 18 && $thursdayclose->minute == 30) selected @endif value="18h">06:30 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 19 && $thursdayclose->minute == 0) selected @endif value="19">07:00 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 19 && $thursdayclose->minute == 30) selected @endif value="19h">07:30 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 20 && $thursdayclose->minute == 0) selected @endif value="20">08:00 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 20 && $thursdayclose->minute == 30) selected @endif value="20h">08:30 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 21 && $thursdayclose->minute == 0) selected @endif value="21">09:00 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 21 && $thursdayclose->minute == 30) selected @endif value="21h">09:30 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 22 && $thursdayclose->minute == 0) selected @endif value="22">10:00 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 22 && $thursdayclose->minute == 30) selected @endif value="22h">10:30 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 23 && $thursdayclose->minute == 0) selected @endif value="23">11:00 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 23 && $thursdayclose->minute == 30) selected @endif value="23h">11:30 PM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 0 && $thursdayclose->minute == 0) selected @endif value="0">00:00</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 0 && $thursdayclose->minute == 30) selected @endif value="0h">00:30</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 1 && $thursdayclose->minute == 0) selected @endif value="1">01:00 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 1 && $thursdayclose->minute == 30) selected @endif value="1h">01:30 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 2 && $thursdayclose->minute == 0) selected @endif value="2">02:00 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 2 && $thursdayclose->minute == 30) selected @endif value="2h">02:30 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 3 && $thursdayclose->minute == 0) selected @endif value="3">03:00 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 3 && $thursdayclose->minute == 30) selected @endif value="3h">03:30 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 4 && $thursdayclose->minute == 0) selected @endif value="4">04:00 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 4 && $thursdayclose->minute == 30) selected @endif value="4h">04:30 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 5 && $thursdayclose->minute == 0) selected @endif value="5">05:00 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 5 && $thursdayclose->minute == 30) selected @endif value="5h">05:30 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 6 && $thursdayclose->minute == 0) selected @endif value="6">06:00 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 6 && $thursdayclose->minute == 30) selected @endif value="6h">06:30 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 7 && $thursdayclose->minute == 0) selected @endif value="7">07:00 AM</option>
            <option @if( isset($thursdayclose) && $thursdayclose->hour == 7 && $thursdayclose->minute == 30) selected @endif value="7h">07:30 AM</option>
        </select>
    </div>
    <br>
    <label>Friday:</label>
    <select class="form-control" type="text" name="friday" @change="fridayselected" ref="friday">
        <option @if(isset($fridayvalue) && $fridayvalue == 'Closed') selected @endif value="closed">Closed</option>
        <option @if(isset($fridayvalue) && (($fridayvalue == 'Open 24 Hours') || ($fridayvalue == 'Open 24 hours'))) selected @endif value="open24">Open 24 hours</option>
        <option @if(isset($fridayvalue) && $fridayvalue != "Closed" && $fridayvalue != "Open 24 Hours" && $fridayvalue != "Open 24 hours") selected @endif value="custom">Specific hours</option>
    </select>
    <div v-show="showfridaycustomdiv">
        <br>
        Select Friday specific timings:
        <br />Open: <select ref="fridaystart" name="fridaystart">
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 8 && $fridaystart->minute == 0) selected @endif value="8">08:00 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 8 && $fridaystart->minute == 30) selected @endif value="8h">08:30 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 9 && $fridaystart->minute == 0) selected @endif value="9">09:00 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 9 && $fridaystart->minute == 30) selected @endif value="9h">09:30 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 10 && $fridaystart->minute == 0) selected @endif value="10">10:00 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 10 && $fridaystart->minute == 30) selected @endif value="10h">10:30 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 11 && $fridaystart->minute == 0) selected @endif value="11">11:00 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 11 && $fridaystart->minute == 30) selected @endif value="11h">11:30 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 12 && $fridaystart->minute == 0) selected @endif value="12">12:00 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 12 && $fridaystart->minute == 30) selected @endif value="12h">12:30 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 13 && $fridaystart->minute == 0) selected @endif value="13">01:00 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 13 && $fridaystart->minute == 30) selected @endif value="13h">01:30 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 14 && $fridaystart->minute == 0) selected @endif value="14">02:00 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 14 && $fridaystart->minute == 30) selected @endif value="14h">02:30 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 15 && $fridaystart->minute == 0) selected @endif value="15">03:00 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 15 && $fridaystart->minute == 30) selected @endif value="15h">03:30 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 16 && $fridaystart->minute == 0) selected @endif value="16">04:00 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 16 && $fridaystart->minute == 30) selected @endif value="16h">04:30 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 17 && $fridaystart->minute == 0) selected @endif value="17">05:00 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 17 && $fridaystart->minute == 30) selected @endif value="17h">05:30 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 18 && $fridaystart->minute == 0) selected @endif value="18">06:00 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 18 && $fridaystart->minute == 30) selected @endif value="18h">06:30 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 19 && $fridaystart->minute == 0) selected @endif value="19">07:00 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 19 && $fridaystart->minute == 30) selected @endif value="19h">07:30 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 20 && $fridaystart->minute == 0) selected @endif value="20">08:00 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 20 && $fridaystart->minute == 30) selected @endif value="20h">08:30 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 21 && $fridaystart->minute == 0) selected @endif value="21">09:00 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 21 && $fridaystart->minute == 30) selected @endif value="21h">09:30 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 22 && $fridaystart->minute == 0) selected @endif value="22">10:00 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 22 && $fridaystart->minute == 30) selected @endif value="22h">10:30 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 23 && $fridaystart->minute == 0) selected @endif value="23">11:00 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 23 && $fridaystart->minute == 30) selected @endif value="23h">11:30 PM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 0 && $fridaystart->minute == 0) selected @endif value="0">00:00</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 0 && $fridaystart->minute == 30) selected @endif value="0h">00:30</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 1 && $fridaystart->minute == 0) selected @endif value="1">01:00 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 1 && $fridaystart->minute == 30) selected @endif value="1h">01:30 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 2 && $fridaystart->minute == 0) selected @endif value="2">02:00 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 2 && $fridaystart->minute == 30) selected @endif value="2h">02:30 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 3 && $fridaystart->minute == 0) selected @endif value="3">03:00 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 3 && $fridaystart->minute == 30) selected @endif value="3h">03:30 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 4 && $fridaystart->minute == 0) selected @endif value="4">04:00 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 4 && $fridaystart->minute == 30) selected @endif value="4h">04:30 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 5 && $fridaystart->minute == 0) selected @endif value="5">05:00 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 5 && $fridaystart->minute == 30) selected @endif value="5h">05:30 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 6 && $fridaystart->minute == 0) selected @endif value="6">06:00 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 6 && $fridaystart->minute == 30) selected @endif value="6h">06:30 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 7 && $fridaystart->minute == 0) selected @endif value="7">07:00 AM</option>
            <option @if( isset($fridaystart) &&  $fridaystart->hour == 7 && $fridaystart->minute == 30) selected @endif value="7h">07:30 AM</option>
        </select>
        <br />Close: <select ref="fridayclose" name="fridayclose">
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 8 && $fridayclose->minute == 0) selected @endif value="8">08:00 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 8 && $fridayclose->minute == 30) selected @endif value="8h">08:30 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 9 && $fridayclose->minute == 0) selected @endif value="9">09:00 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 9 && $fridayclose->minute == 30) selected @endif value="9h">09:30 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 10 && $fridayclose->minute == 0) selected @endif value="10">10:00 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 10 && $fridayclose->minute == 30) selected @endif value="10h">10:30 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 11 && $fridayclose->minute == 0) selected @endif value="11">11:00 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 11 && $fridayclose->minute == 30) selected @endif value="11h">11:30 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 12 && $fridayclose->minute == 0) selected @endif value="12">12:00 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 12 && $fridayclose->minute == 30) selected @endif value="12h">12:30 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 13 && $fridayclose->minute == 0) selected @endif value="13">01:00 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 13 && $fridayclose->minute == 30) selected @endif value="13h">01:30 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 14 && $fridayclose->minute == 0) selected @endif value="14">02:00 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 14 && $fridayclose->minute == 30) selected @endif value="14h">02:30 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 15 && $fridayclose->minute == 0) selected @endif value="15">03:00 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 15 && $fridayclose->minute == 30) selected @endif value="15h">03:30 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 16 && $fridayclose->minute == 0) selected @endif value="16">04:00 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 16 && $fridayclose->minute == 30) selected @endif value="16h">04:30 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 17 && $fridayclose->minute == 0) selected @endif value="17">05:00 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 17 && $fridayclose->minute == 30) selected @endif value="17h">05:30 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 18 && $fridayclose->minute == 0) selected @endif value="18">06:00 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 18 && $fridayclose->minute == 30) selected @endif value="18h">06:30 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 19 && $fridayclose->minute == 0) selected @endif value="19">07:00 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 19 && $fridayclose->minute == 30) selected @endif value="19h">07:30 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 20 && $fridayclose->minute == 0) selected @endif value="20">08:00 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 20 && $fridayclose->minute == 30) selected @endif value="20h">08:30 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 21 && $fridayclose->minute == 0) selected @endif value="21">09:00 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 21 && $fridayclose->minute == 30) selected @endif value="21h">09:30 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 22 && $fridayclose->minute == 0) selected @endif value="22">10:00 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 22 && $fridayclose->minute == 30) selected @endif value="22h">10:30 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 23 && $fridayclose->minute == 0) selected @endif value="23">11:00 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 23 && $fridayclose->minute == 30) selected @endif value="23h">11:30 PM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 0 && $fridayclose->minute == 0) selected @endif value="0">00:00</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 0 && $fridayclose->minute == 30) selected @endif value="0h">00:30</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 1 && $fridayclose->minute == 0) selected @endif value="1">01:00 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 1 && $fridayclose->minute == 30) selected @endif value="1h">01:30 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 2 && $fridayclose->minute == 0) selected @endif value="2">02:00 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 2 && $fridayclose->minute == 30) selected @endif value="2h">02:30 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 3 && $fridayclose->minute == 0) selected @endif value="3">03:00 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 3 && $fridayclose->minute == 30) selected @endif value="3h">03:30 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 4 && $fridayclose->minute == 0) selected @endif value="4">04:00 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 4 && $fridayclose->minute == 30) selected @endif value="4h">04:30 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 5 && $fridayclose->minute == 0) selected @endif value="5">05:00 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 5 && $fridayclose->minute == 30) selected @endif value="5h">05:30 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 6 && $fridayclose->minute == 0) selected @endif value="6">06:00 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 6 && $fridayclose->minute == 30) selected @endif value="6h">06:30 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 7 && $fridayclose->minute == 0) selected @endif value="7">07:00 AM</option>
            <option @if( isset($fridayclose) &&   $fridayclose->hour == 7 && $fridayclose->minute == 30) selected @endif value="7h">07:30 AM</option>
        </select>
    </div>
</div>
<div v-if="workhoursallowed" class="form-group col-4 pb-4">
    <label>Saturday:</label>
    <select class="form-control" type="text" name="saturday" @change="saturdayselected" ref="saturday">
        <option @if(isset($saturdayvalue) && $saturdayvalue == 'Closed') selected @endif value="closed">Closed</option>
        <option @if(isset($saturdayvalue) && (($saturdayvalue == 'Open 24 Hours') || ($saturdayvalue == 'Open 24 hours') ))selected @endif value="open24">Open 24 hours</option>
        <option @if(isset($saturdayvalue) && $saturdayvalue != "Closed" && $saturdayvalue != "Open 24 Hours" && $saturdayvalue != "Open 24 hours") selected @endif value="custom">Specific hours</option>
    </select>
    <div v-show="showsaturdaycustomdiv">
    <br>
    Select Saturday specific timings:
        <br />Open: <select ref="saturdaystart" name="saturdaystart">
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 8 && $saturdaystart->minute == 0) selected @endif value="8">08:00 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 8 && $saturdaystart->minute == 30) selected @endif value="8h">08:30 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 9 && $saturdaystart->minute == 0) selected @endif value="9">09:00 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 9 && $saturdaystart->minute == 30) selected @endif value="9h">09:30 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 10 && $saturdaystart->minute == 0) selected @endif value="10">10:00 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 10 && $saturdaystart->minute == 30) selected @endif value="10h">10:30 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 11 && $saturdaystart->minute == 0) selected @endif value="11">11:00 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 11 && $saturdaystart->minute == 30) selected @endif value="11h">11:30 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 12 && $saturdaystart->minute == 0) selected @endif value="12">12:00 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 12 && $saturdaystart->minute == 30) selected @endif value="12h">12:30 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 13 && $saturdaystart->minute == 0) selected @endif value="13">01:00 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 13 && $saturdaystart->minute == 30) selected @endif value="13h">01:30 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 14 && $saturdaystart->minute == 0) selected @endif value="14">02:00 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 14 && $saturdaystart->minute == 30) selected @endif value="14h">02:30 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 15 && $saturdaystart->minute == 0) selected @endif value="15">03:00 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 15 && $saturdaystart->minute == 30) selected @endif value="15h">03:30 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 16 && $saturdaystart->minute == 0) selected @endif value="16">04:00 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 16 && $saturdaystart->minute == 30) selected @endif value="16h">04:30 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 17 && $saturdaystart->minute == 0) selected @endif value="17">05:00 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 17 && $saturdaystart->minute == 30) selected @endif value="17h">05:30 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 18 && $saturdaystart->minute == 0) selected @endif value="18">06:00 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 18 && $saturdaystart->minute == 30) selected @endif value="18h">06:30 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 19 && $saturdaystart->minute == 0) selected @endif value="19">07:00 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 19 && $saturdaystart->minute == 30) selected @endif value="19h">07:30 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 20 && $saturdaystart->minute == 0) selected @endif value="20">08:00 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 20 && $saturdaystart->minute == 30) selected @endif value="20h">08:30 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 21 && $saturdaystart->minute == 0) selected @endif value="21">09:00 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 21 && $saturdaystart->minute == 30) selected @endif value="21h">09:30 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 22 && $saturdaystart->minute == 0) selected @endif value="22">10:00 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 22 && $saturdaystart->minute == 30) selected @endif value="22h">10:30 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 23 && $saturdaystart->minute == 0) selected @endif value="23">11:00 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 23 && $saturdaystart->minute == 30) selected @endif value="23h">11:30 PM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 0 && $saturdaystart->minute == 0) selected @endif value="0">00:00</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 0 && $saturdaystart->minute == 30) selected @endif value="0h">00:30</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 1 && $saturdaystart->minute == 0) selected @endif value="1">01:00 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 1 && $saturdaystart->minute == 30) selected @endif value="1h">01:30 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 2 && $saturdaystart->minute == 0) selected @endif value="2">02:00 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 2 && $saturdaystart->minute == 30) selected @endif value="2h">02:30 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 3 && $saturdaystart->minute == 0) selected @endif value="3">03:00 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 3 && $saturdaystart->minute == 30) selected @endif value="3h">03:30 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 4 && $saturdaystart->minute == 0) selected @endif value="4">04:00 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 4 && $saturdaystart->minute == 30) selected @endif value="4h">04:30 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 5 && $saturdaystart->minute == 0) selected @endif value="5">05:00 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 5 && $saturdaystart->minute == 30) selected @endif value="5h">05:30 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 6 && $saturdaystart->minute == 0) selected @endif value="6">06:00 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 6 && $saturdaystart->minute == 30) selected @endif value="6h">06:30 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 7 && $saturdaystart->minute == 0) selected @endif value="7">07:00 AM</option>
            <option @if( isset($saturdaystart) &&  $saturdaystart->hour == 7 && $saturdaystart->minute == 30) selected @endif value="7h">07:30 AM</option>
        </select>
        <br />Close: <select ref="saturdayclose" name="saturdayclose">
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 8 && $saturdayclose->minute == 0) selected @endif value="8">08:00 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 8 && $saturdayclose->minute == 30) selected @endif value="8h">08:30 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 9 && $saturdayclose->minute == 0) selected @endif value="9">09:00 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 9 && $saturdayclose->minute == 30) selected @endif value="9h">09:30 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 10 && $saturdayclose->minute == 0) selected @endif value="10">10:00 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 10 && $saturdayclose->minute == 30) selected @endif value="10h">10:30 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 11 && $saturdayclose->minute == 0) selected @endif value="11">11:00 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 11 && $saturdayclose->minute == 30) selected @endif value="11h">11:30 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 12 && $saturdayclose->minute == 0) selected @endif value="12">12:00 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 12 && $saturdayclose->minute == 30) selected @endif value="12h">12:30 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 13 && $saturdayclose->minute == 0) selected @endif value="13">01:00 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 13 && $saturdayclose->minute == 30) selected @endif value="13h">01:30 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 14 && $saturdayclose->minute == 0) selected @endif value="14">02:00 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 14 && $saturdayclose->minute == 30) selected @endif value="14h">02:30 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 15 && $saturdayclose->minute == 0) selected @endif value="15">03:00 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 15 && $saturdayclose->minute == 30) selected @endif value="15h">03:30 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 16 && $saturdayclose->minute == 0) selected @endif value="16">04:00 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 16 && $saturdayclose->minute == 30) selected @endif value="16h">04:30 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 17 && $saturdayclose->minute == 0) selected @endif value="17">05:00 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 17 && $saturdayclose->minute == 30) selected @endif value="17h">05:30 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 18 && $saturdayclose->minute == 0) selected @endif value="18">06:00 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 18 && $saturdayclose->minute == 30) selected @endif value="18h">06:30 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 19 && $saturdayclose->minute == 0) selected @endif value="19">07:00 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 19 && $saturdayclose->minute == 30) selected @endif value="19h">07:30 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 20 && $saturdayclose->minute == 0) selected @endif value="20">08:00 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 20 && $saturdayclose->minute == 30) selected @endif value="20h">08:30 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 21 && $saturdayclose->minute == 0) selected @endif value="21">09:00 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 21 && $saturdayclose->minute == 30) selected @endif value="21h">09:30 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 22 && $saturdayclose->minute == 0) selected @endif value="22">10:00 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 22 && $saturdayclose->minute == 30) selected @endif value="22h">10:30 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 23 && $saturdayclose->minute == 0) selected @endif value="23">11:00 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 23 && $saturdayclose->minute == 30) selected @endif value="23h">11:30 PM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 0 && $saturdayclose->minute == 0) selected @endif value="0">00:00</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 0 && $saturdayclose->minute == 30) selected @endif value="0h">00:30</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 1 && $saturdayclose->minute == 0) selected @endif value="1">01:00 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 1 && $saturdayclose->minute == 30) selected @endif value="1h">01:30 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 2 && $saturdayclose->minute == 0) selected @endif value="2">02:00 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 2 && $saturdayclose->minute == 30) selected @endif value="2h">02:30 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 3 && $saturdayclose->minute == 0) selected @endif value="3">03:00 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 3 && $saturdayclose->minute == 30) selected @endif value="3h">03:30 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 4 && $saturdayclose->minute == 0) selected @endif value="4">04:00 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 4 && $saturdayclose->minute == 30) selected @endif value="4h">04:30 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 5 && $saturdayclose->minute == 0) selected @endif value="5">05:00 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 5 && $saturdayclose->minute == 30) selected @endif value="5h">05:30 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 6 && $saturdayclose->minute == 0) selected @endif value="6">06:00 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 6 && $saturdayclose->minute == 30) selected @endif value="6h">06:30 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 7 && $saturdayclose->minute == 0) selected @endif value="7">07:00 AM</option>
            <option @if( isset($saturdayclose) && $saturdayclose->hour == 7 && $saturdayclose->minute == 30) selected @endif value="7h">07:30 AM</option>
        </select>
    </div>
    <br>
    <label>Sunday:</label>
    <select class="form-control" type="text" name="sunday" @change="sundayselected" ref="sunday">
        <option @if(isset($sundayvalue) && $sundayvalue == 'Closed') selected @endif value="closed">Closed</option>
        <option @if(isset($sundayvalue) && (($sundayvalue == 'Open 24 Hours') || ($sundayvalue == 'Open 24 hours') )) selected @endif value="open24">Open 24 hours</option>
        <option @if(isset($sundayvalue) && $sundayvalue != "Closed" && $sundayvalue != "Open 24 Hours" && $sundayvalue != "Open 24 hours") selected @endif value="custom">Specific hours</option>
    </select>
    <div v-show="showsundaycustomdiv">
        <br>
        Select Sunday specific timings:
        <br />Open: <select ref="sundaystart" name="sundaystart">
            <option @if( isset($sundaystart) && $sundaystart->hour == 8 && $sundaystart->minute == 0) selected @endif value="8">08:00 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 8 && $sundaystart->minute == 30) selected @endif value="8h">08:30 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 9 && $sundaystart->minute == 0) selected @endif value="9">09:00 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 9 && $sundaystart->minute == 30) selected @endif value="9h">09:30 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 10 && $sundaystart->minute == 0) selected @endif value="10">10:00 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 10 && $sundaystart->minute == 30) selected @endif value="10h">10:30 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 11 && $sundaystart->minute == 0) selected @endif value="11">11:00 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 11 && $sundaystart->minute == 30) selected @endif value="11h">11:30 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 12 && $sundaystart->minute == 0) selected @endif value="12">12:00 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 12 && $sundaystart->minute == 30) selected @endif value="12h">12:30 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 13 && $sundaystart->minute == 0) selected @endif value="13">01:00 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 13 && $sundaystart->minute == 30) selected @endif value="13h">01:30 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 14 && $sundaystart->minute == 0) selected @endif value="14">02:00 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 14 && $sundaystart->minute == 30) selected @endif value="14h">02:30 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 15 && $sundaystart->minute == 0) selected @endif value="15">03:00 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 15 && $sundaystart->minute == 30) selected @endif value="15h">03:30 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 16 && $sundaystart->minute == 0) selected @endif value="16">04:00 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 16 && $sundaystart->minute == 30) selected @endif value="16h">04:30 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 17 && $sundaystart->minute == 0) selected @endif value="17">05:00 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 17 && $sundaystart->minute == 30) selected @endif value="17h">05:30 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 18 && $sundaystart->minute == 0) selected @endif value="18">06:00 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 18 && $sundaystart->minute == 30) selected @endif value="18h">06:30 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 19 && $sundaystart->minute == 0) selected @endif value="19">07:00 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 19 && $sundaystart->minute == 30) selected @endif value="19h">07:30 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 20 && $sundaystart->minute == 0) selected @endif value="20">08:00 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 20 && $sundaystart->minute == 30) selected @endif value="20h">08:30 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 21 && $sundaystart->minute == 0) selected @endif value="21">09:00 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 21 && $sundaystart->minute == 30) selected @endif value="21h">09:30 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 22 && $sundaystart->minute == 0) selected @endif value="22">10:00 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 22 && $sundaystart->minute == 30) selected @endif value="22h">10:30 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 23 && $sundaystart->minute == 0) selected @endif value="23">11:00 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 23 && $sundaystart->minute == 30) selected @endif value="23h">11:30 PM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 0 && $sundaystart->minute == 0) selected @endif value="0">00:00</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 0 && $sundaystart->minute == 30) selected @endif value="0h">00:30</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 1 && $sundaystart->minute == 0) selected @endif value="1">01:00 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 1 && $sundaystart->minute == 30) selected @endif value="1h">01:30 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 2 && $sundaystart->minute == 0) selected @endif value="2">02:00 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 2 && $sundaystart->minute == 30) selected @endif value="2h">02:30 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 3 && $sundaystart->minute == 0) selected @endif value="3">03:00 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 3 && $sundaystart->minute == 30) selected @endif value="3h">03:30 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 4 && $sundaystart->minute == 0) selected @endif value="4">04:00 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 4 && $sundaystart->minute == 30) selected @endif value="4h">04:30 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 5 && $sundaystart->minute == 0) selected @endif value="5">05:00 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 5 && $sundaystart->minute == 30) selected @endif value="5h">05:30 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 6 && $sundaystart->minute == 0) selected @endif value="6">06:00 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 6 && $sundaystart->minute == 30) selected @endif value="6h">06:30 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 7 && $sundaystart->minute == 0) selected @endif value="7">07:00 AM</option>
            <option @if( isset($sundaystart) && $sundaystart->hour == 7 && $sundaystart->minute == 30) selected @endif value="7h">07:30 AM</option>
        </select>
        <br />Close: <select ref="sundayclose" name="sundayclose">
            <option @if( isset($sundayclose) && $sundayclose->hour == 8 && $sundayclose->minute == 0) selected @endif value="8">08:00 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 8 && $sundayclose->minute == 30) selected @endif value="8h">08:30 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 9 && $sundayclose->minute == 0) selected @endif value="9">09:00 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 9 && $sundayclose->minute == 30) selected @endif value="9h">09:30 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 10 && $sundayclose->minute == 0) selected @endif value="10">10:00 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 10 && $sundayclose->minute == 30) selected @endif value="10h">10:30 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 11 && $sundayclose->minute == 0) selected @endif value="11">11:00 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 11 && $sundayclose->minute == 30) selected @endif value="11h">11:30 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 12 && $sundayclose->minute == 0) selected @endif value="12">12:00 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 12 && $sundayclose->minute == 30) selected @endif value="12h">12:30 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 13 && $sundayclose->minute == 0) selected @endif value="13">01:00 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 13 && $sundayclose->minute == 30) selected @endif value="13h">01:30 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 14 && $sundayclose->minute == 0) selected @endif value="14">02:00 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 14 && $sundayclose->minute == 30) selected @endif value="14h">02:30 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 15 && $sundayclose->minute == 0) selected @endif value="15">03:00 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 15 && $sundayclose->minute == 30) selected @endif value="15h">03:30 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 16 && $sundayclose->minute == 0) selected @endif value="16">04:00 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 16 && $sundayclose->minute == 30) selected @endif value="16h">04:30 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 17 && $sundayclose->minute == 0) selected @endif value="17">05:00 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 17 && $sundayclose->minute == 30) selected @endif value="17h">05:30 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 18 && $sundayclose->minute == 0) selected @endif value="18">06:00 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 18 && $sundayclose->minute == 30) selected @endif value="18h">06:30 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 19 && $sundayclose->minute == 0) selected @endif value="19">07:00 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 19 && $sundayclose->minute == 30) selected @endif value="19h">07:30 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 20 && $sundayclose->minute == 0) selected @endif value="20">08:00 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 20 && $sundayclose->minute == 30) selected @endif value="20h">08:30 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 21 && $sundayclose->minute == 0) selected @endif value="21">09:00 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 21 && $sundayclose->minute == 30) selected @endif value="21h">09:30 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 22 && $sundayclose->minute == 0) selected @endif value="22">10:00 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 22 && $sundayclose->minute == 30) selected @endif value="22h">10:30 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 23 && $sundayclose->minute == 0) selected @endif value="23">11:00 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 23 && $sundayclose->minute == 30) selected @endif value="23h">11:30 PM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 0 && $sundayclose->minute == 0) selected @endif value="0">00:00</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 0 && $sundayclose->minute == 30) selected @endif value="0h">00:30</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 1 && $sundayclose->minute == 0) selected @endif value="1">01:00 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 1 && $sundayclose->minute == 30) selected @endif value="1h">01:30 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 2 && $sundayclose->minute == 0) selected @endif value="2">02:00 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 2 && $sundayclose->minute == 30) selected @endif value="2h">02:30 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 3 && $sundayclose->minute == 0) selected @endif value="3">03:00 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 3 && $sundayclose->minute == 30) selected @endif value="3h">03:30 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 4 && $sundayclose->minute == 0) selected @endif value="4">04:00 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 4 && $sundayclose->minute == 30) selected @endif value="4h">04:30 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 5 && $sundayclose->minute == 0) selected @endif value="5">05:00 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 5 && $sundayclose->minute == 30) selected @endif value="5h">05:30 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 6 && $sundayclose->minute == 0) selected @endif value="6">06:00 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 6 && $sundayclose->minute == 30) selected @endif value="6h">06:30 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 7 && $sundayclose->minute == 0) selected @endif value="7">07:00 AM</option>
            <option @if( isset($sundayclose) && $sundayclose->hour == 7 && $sundayclose->minute == 30) selected @endif value="7h">07:30 AM</option>
        </select>
    </div>
    <br>

</div>
@else
    <div class="col-12 mb-4">
        Multiple Workhours found during same day. please contact info@wuchna.com to edit this section.
    </div>
@endif

{{--<div class="form-group col-12 border-top">--}}
{{--    <h6 class="text-info mt-3">References Section</h6>--}}
{{--    <input type="checkbox" name="noimagegallery" ref="noimagegallery" @click="noimagegalleryclicked"/> Check this box IF YOU DO NOT WANT TO ADD REFERENCES for your business--}}
{{--</div>--}}



<div class="form-group col-3 pb-4 text-center">
    <button type="submit" class="btn btn-danger btn-lg mt-3">Submit</button>
</div>

@if($listing && Auth::check() && auth()->id() == 1)
<div class="form-group col-3 pb-4 text-center">
    <a href="/admindeletebusiness/{{$listing->id}}" class="btn btn-danger btn-lg mt-3">Delete Listing</a>
</div>
    User Id: {{$listing->user_id}}
@endif




<div class="form-group col-12 mt-3 p-4 rounded" style="background-color: #f3cadd">
    Want a dofollow link (exchange), or want to upload your menu, services or products, or want to claim multiple listings? Do you have any other requests? Please email us at <a href="mailto:info@wuchna.com">info@wuchna.com</a>
</div>

@section('scripts')
    <script src="{{ asset('js/vue.js') }}"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                showingsearchinput: false, showlocalities:false, localities:[],vuecityselected:false,

                workhoursallowed : true, imagegalleryallowed: true,

                @if($listing && $listing->category && $listing->category->id == 1) showRestaurantInputs: true,
                @else showRestaurantInputs: false, @endif
                @if($listing && $listing->category && ($listing->category->id == 5 || $listing->category->id == 34 || $listing->category->id ==59) ) showClinicInputs: true,
                @else showClinicInputs: false, @endif

                @if(isset($listing->data['knowledge_graph']['hours']))

                    @if(isset($mondayvalue) && $mondayvalue != "Closed" && $mondayvalue != "Open 24 Hours" && $mondayvalue != "Open 24 hours") showmondaycustomdiv: true, @else showmondaycustomdiv: false, @endif
                    @if(isset($tuesdayvalue) && $tuesdayvalue != "Closed" && $tuesdayvalue != "Open 24 Hours" && $tuesdayvalue != "Open 24 hours") showtuesdaycustomdiv: true, @else showtuesdaycustomdiv: false, @endif
                    @if(isset($wednesdayvalue) && $wednesdayvalue != "Closed" && $wednesdayvalue != "Open 24 Hours" && $wednesdayvalue != "Open 24 hours") showwednesdaycustomdiv: true, @else showwednesdaycustomdiv: false, @endif
                    @if(isset($thursdayvalue) && $thursdayvalue != "Closed" && $thursdayvalue != "Open 24 Hours" && $thursdayvalue != "Open 24 hours") showthursdaycustomdiv: true, @else showthursdaycustomdiv: false, @endif
                    @if(isset($fridayvalue) && $fridayvalue != "Closed" && $fridayvalue != "Open 24 Hours" && $fridayvalue != "Open 24 hours") showfridaycustomdiv: true, @else showfridaycustomdiv: false, @endif
                    @if(isset($saturdayvalue) && $saturdayvalue != "Closed" && $saturdayvalue != "Open 24 Hours" && $saturdayvalue != "Open 24 hours") showsaturdaycustomdiv: true, @else showsaturdaycustomdiv: false, @endif
                    @if(isset($sundayvalue) && $sundayvalue != "Closed" && $sundayvalue != "Open 24 Hours" && $sundayvalue != "Open 24 hours") showsundaycustomdiv: true, @else showsundaycustomdiv: false, @endif

                @else

                showsundaycustomdiv: false,showmondaycustomdiv: false,showtuesdaycustomdiv: false,showwednesdaycustomdiv: false,showthursdaycustomdiv: false,showfridaycustomdiv: false,showsaturdaycustomdiv: false,

                @endif
            },
            methods: {
                showsearchinput(){
                    this.showingsearchinput = !this.showingsearchinput;
                },
                cityselected(){
                    this.vuecityselected=true;
                    axios.get(`/api/localities/${this.$refs.city.value}`).then(res=>{
                        this.showlocalities = true;
                        this.localities = res.data;
                    });
                },
                noimagegalleryclicked(){
                    this.imagegalleryallowed = !this.imagegalleryallowed;
                },
                noworkinghoursclicked(){
                    this.workhoursallowed = !this.workhoursallowed;
                },
                isrestaurantclicked(){
                    this.showRestaurantInputs = !this.showRestaurantInputs;
                },
                isclinicclicked(){
                    this.showClinicInputs = !this.showClinicInputs;
                },
                copytoallclicked(){
                    this.$refs.tuesday.value = 'custom'; this.tuesdayselected();
                    this.$refs.tuesdaystart.value = this.$refs.mondaystart.value;
                    this.$refs.tuesdayclose.value = this.$refs.mondayclose.value;

                    this.$refs.wednesday.value = 'custom'; this.wednesdayselected();
                    this.$refs.wednesdaystart.value = this.$refs.mondaystart.value;
                    this.$refs.wednesdayclose.value = this.$refs.mondayclose.value;

                    this.$refs.thursday.value = 'custom'; this.thursdayselected();
                    this.$refs.thursdaystart.value = this.$refs.mondaystart.value;
                    this.$refs.thursdayclose.value = this.$refs.mondayclose.value;

                    this.$refs.friday.value = 'custom'; this.fridayselected();
                    this.$refs.fridaystart.value = this.$refs.mondaystart.value;
                    this.$refs.fridayclose.value = this.$refs.mondayclose.value;

                    this.$refs.saturday.value = 'custom'; this.saturdayselected();
                    this.$refs.saturdaystart.value = this.$refs.mondaystart.value;
                    this.$refs.saturdayclose.value = this.$refs.mondayclose.value;

                    this.$refs.sunday.value = 'custom'; this.sundayselected();
                    this.$refs.sundaystart.value = this.$refs.mondaystart.value;
                    this.$refs.sundayclose.value = this.$refs.mondayclose.value;
                },
                sundayselected(){ if(this.$refs.sunday.value == 'custom'){ this.showsundaycustomdiv = true; }else{this.showsundaycustomdiv = false;}},
                mondayselected(){ if(this.$refs.monday.value == 'custom'){ this.showmondaycustomdiv = true; }else{this.showmondaycustomdiv = false;}},
                tuesdayselected(){ if(this.$refs.tuesday.value == 'custom'){ this.showtuesdaycustomdiv = true; }else{this.showtuesdaycustomdiv = false;}},
                wednesdayselected(){ if(this.$refs.wednesday.value == 'custom'){ this.showwednesdaycustomdiv = true; }else{this.showwednesdaycustomdiv = false;}},
                thursdayselected(){ if(this.$refs.thursday.value == 'custom'){ this.showthursdaycustomdiv = true; }else{this.showthursdaycustomdiv = false;}},
                fridayselected(){ if(this.$refs.friday.value == 'custom'){ this.showfridaycustomdiv = true; }else{this.showfridaycustomdiv = false;}},
                saturdayselected(){ if(this.$refs.saturday.value == 'custom'){ this.showsaturdaycustomdiv = true; }else{this.showsaturdaycustomdiv = false;}},
                formsubmitted(){
                    myEditor = document.querySelector('#editor');
                    var html = myEditor.children[0].innerHTML;
                    this.$refs.description.value = html;
                    // e.preventDefault();
                    // alert(html);
                    @if($listing)this.$refs.editbusinessform.submit(); @else this.$refs.addbusinessform.submit(); @endif
                    return true;
                }
            },
            mounted() {
                @if($listing && $listing->category && $listing->category->id == 1) this.$refs.isrestaurant.checked = true; @endif
            }
        });
    </script>
    <script defer src="{{ asset('js/app.js') }}"></script>

    <script src="https://m2.wuchna.com/quill.js"></script>

    <!-- Initialize Quill editor -->
    <script>
        var options = {
            placeholder: @if($listing)'{{$listing->description ? strip_tags($listing->description) : 'Enter business description here'}}' @else 'Enter business description here' @endif,
            modules: {
                syntax: false,
                toolbar: '#toolbar-container'
            },
            theme: 'snow'
        };
        var editor = new Quill('#editor', options);

    </script>
@endsection

