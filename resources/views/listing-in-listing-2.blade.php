

@if(isset($listing->raw['address']))<br><div class="card-text mb-auto text-muted">Address: {{$listing->raw['address']}}</div><br>@endif
@if(isset($listing->data['youtubelink']) && $listing->data['youtubelink'])
    <iframe style="margin-bottom: 15px" width="560" height="315" src="https://www.youtube.com/embed/{{str_replace('https://www.youtube.com/watch?v=','',$listing->data['youtubelink'])}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
@endif
@if($listing->description){!! str_replace('<img ','<img class="image-fluid"',$listing->description) !!}@endif
@if(isset($listing->data['content_img']))
    <img class="img-fluid mb-3" src="{{$listing->data['content_img']}}" alt="{{$listing->title}} Image">
@endif

@if(isset($listing->data['galleryimg1']) || isset($listing->data['galleryimg2']) || isset($listing->data['galleryimg3']) || isset($listing->data['galleryimg4']) || isset($listing->data['galleryimg5']) || isset($listing->data['galleryimg6']) || isset($listing->data['galleryimg7']) || isset($listing->data['galleryimg8']) || isset($listing->data['galleryimg9']))
    <div class="col-12 row border">
        @if(isset($listing->data['galleryimg1']))<div class="col-12 col-md-4"><a target="_blank" href="{{$listing->data['galleryimg1']}}"><img class="img-fluid" src="{{$listing->data['galleryimg1']}}" alt="Gallery Image 1"></a></div>@endif
        @if(isset($listing->data['galleryimg2']))<div class="col-12 col-md-4"><a target="_blank" href="{{$listing->data['galleryimg2']}}"><img class="img-fluid" src="{{$listing->data['galleryimg2']}}" alt="Gallery Image 2"></a></div>@endif
            @if(isset($listing->data['galleryimg3']))<div class="col-12 col-md-4"><a target="_blank" href="{{$listing->data['galleryimg3']}}"><img class="img-fluid" src="{{$listing->data['galleryimg3']}}" alt="Gallery Image 3"></a></div>@endif
            @if(isset($listing->data['galleryimg4']))<div class="col-12 col-md-4"><a target="_blank" href="{{$listing->data['galleryimg4']}}"><img class="img-fluid" src="{{$listing->data['galleryimg4']}}" alt="Gallery Image 4"></a></div>@endif
            @if(isset($listing->data['galleryimg5']))<div class="col-12 col-md-4"><a target="_blank" href="{{$listing->data['galleryimg5']}}"><img class="img-fluid" src="{{$listing->data['galleryimg5']}}" alt="Gallery Image 5"></a></div>@endif
            @if(isset($listing->data['galleryimg6']))<div class="col-12 col-md-4"><a target="_blank" href="{{$listing->data['galleryimg6']}}"><img class="img-fluid" src="{{$listing->data['galleryimg6']}}" alt="Gallery Image 6"></a></div>@endif
            @if(isset($listing->data['galleryimg7']))<div class="col-12 col-md-4"><a target="_blank" href="{{$listing->data['galleryimg7']}}"><img class="img-fluid" src="{{$listing->data['galleryimg7']}}" alt="Gallery Image 7"></a></div>@endif
            @if(isset($listing->data['galleryimg8']))<div class="col-12 col-md-4"><a target="_blank" href="{{$listing->data['galleryimg8']}}"><img class="img-fluid" src="{{$listing->data['galleryimg8']}}" alt="Gallery Image 8"></a></div>@endif
            @if(isset($listing->data['galleryimg9']))<div class="col-12 col-md-4"><a target="_blank" href="{{$listing->data['galleryimg9']}}"><img class="img-fluid" src="{{$listing->data['galleryimg9']}}" alt="Gallery Image 9"></a></div>@endif
</div>

@endif

@php $faqs = collect([]); if(isset($listing->business_data['tags'])){
                            $faqs = collect($listing->business_data['tags'])->filter(function($item){
                                return $item['type']=='faq';
                            }); }
@endphp
@if($faqs->isNotEmpty() || isset($listing->data['knowledge_graph']['hours']))
<script type="application/ld+json">{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
    @if(isset($listing->data['knowledge_graph']['hours']))
{"@type":"Question","name":"What are the operating hours of {{stripslashes($listing->title)}}?","acceptedAnswer":{"@type":"Answer","text":" @foreach($listing->data['knowledge_graph']['hours'] as $item) {{$item['name']}} : {{$item['value']}} @endforeach"}} @if($faqs->isNotEmpty()),@endif
    @endif
    @foreach($faqs as $faq)
{"@type":"Question","name":"{{stripslashes($faq['ques'])}}","acceptedAnswer":{"@type":"Answer","text":"{{stripslashes($faq['ans'])}}"}}@unless($loop->last),@endunless
    @endforeach
    ]}</script>
<div class="row no-gutters">
    <div class="col-12">
        <div class="tab-content">
            @foreach($faqs as $tag)
                <div class="card my-3">
                    <h6 class="card-header">{{$tag['ques']}}</h6>
                    <small class="card-body">{{$tag['ans']}}</small>
                </div>
            @endforeach
            @if(isset($listing->data['knowledge_graph']['hours']))
                <div class="card mt-4">
                    <div class="card-header">
                        Operating Hours of {{$listing->title}}
                        @php
                            foreach($listing->data['knowledge_graph']['hours'] as $s){
                                if($s['name']==date('l')){
                                    if($s['value'] =='Closed') {
                                        echo ('<button class="ml-3 btn btn-md btn-danger">CURRENTLY CLOSED</button>');
                                    }
                                    elseif($s['value'] =='Open 24 Hours' || $s['value'] =='Open 24 hours') {
                                        echo ('<button class="ml-3 btn btn-md btn-success">CURRENTLY OPEN</button>');
                                    }
                                    else{
                                        if(\Illuminate\Support\Str::contains($s['value'],', ')){
                                            $open = false;
                                            foreach(explode(', ',$s['value']) as $ss){
                                                [$time1,$time2] = \App\Services\BusinessOpen::fn1($ss);
                                                $time3 = \Carbon\Carbon::now();
                                                if( ($time1 <  $time3) && ($time3 < $time2) ){
                                                    $open = true;
                                                }
                                            }
                                            if($open){
                                                echo ('<button class="ml-3 btn btn-md btn-danger">CURRENTLY OPEN</button>');
                                            }
                                            else{
                                                echo ('<button class="ml-3 btn btn-md btn-danger">CURRENTLY CLOSED</button>');
                                            }
                                        }
                                        else{
                                            [$time1,$time2] = \App\Services\BusinessOpen::fn1($s['value']);
                                            $time3 = \Carbon\Carbon::now();
                                            if( ($time1 <  $time3) && ($time3 < $time2) ){
                                                echo ('<button class="ml-3 btn btn-md btn-success">CURRENTLY OPEN</button>');
                                            }else{
                                                echo ('<button class="ml-3 btn btn-md btn-danger">CURRENTLY CLOSED</button>');
                                            }
                                        }
                                    }
                                }
                            }
                        @endphp
                    </div>
                    <div class="card-body">
                        @foreach($listing->data['knowledge_graph']['hours'] as $item)
                            @if($item['value'] == "Closed")<span class="text-danger">@endif
                                {{$item['name']}} : {{$item['value']}}<br>
                                @if($item['value'] == "Closed")</span>@endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endif



<script type="application/ld+json">
{
"@context": "https://schema.org",
"@type": "LocalBusiness",
@if($blog && isset($listing->raw['address']) && $city && $blog->locality) "address": {
"@type": "PostalAddress",
"addressLocality": "{{$blog->locality->title}}",
"addressRegion": "{{$city->title}}",
"streetAddress": "{{stripslashes($listing->raw['address'])}}"
},@endif
    "name": "{{$listing->title}}",
"image": ["{{isset($listing->raw['logo_img']) ? $listing->raw['logo_img'] : 'https://wuchna.com/wuchna-logo.png'}}"],
    "url": "{{$listing->full_link}}"
@if(isset($listing->raw['gps_coordinates']))
    ,"geo": { "@type": "GeoCoordinates", "longitude": "{{$listing->raw['gps_coordinates']['longitude']}}", "latitude": "{{$listing->raw['gps_coordinates']['latitude']}}" }
@endif


@if( $listing->website || isset($listing->data['linkedinlink']) || isset($listing->data['facebooklink']) || isset($listing->data['twitterlink']) || isset($listing->data['magicpinlink']) || isset($listing->data['custommap']) || isset($listing->data['justdiallink']) || isset($listing->data['zomatolink']) || isset($listing->data['nearbuylink'])|| isset($listing->data['practolink'])|| isset($listing->data['lbblink'])|| isset($listing->data['tripadvisorlink'])  ) ,"sameAs": [
@php
    $toprint = "";
if(isset($listing->data['linkedinlink'])&& $listing->data['linkedinlink']) { $toprint = $toprint.'"'. $listing->data['linkedinlink'].'", ';}
if(isset($listing->data['facebooklink']) && $listing->data['facebooklink']) { $toprint = $toprint.'"'. $listing->data['facebooklink'].'", ';}
if(isset($listing->data['twitterlink']) && $listing->data['twitterlink'] ) { $toprint = $toprint.'"'. $listing->data['twitterlink'].'", ';}
if(isset($listing->data['instagramlink']) && $listing->data['instagramlink'] ) { $toprint = $toprint.'"'. $listing->data['instagramlink'].'", ';}
if(isset($listing->data['indiamartlink']) && $listing->data['indiamartlink']  ) { $toprint = $toprint.'"'. $listing->data['indiamartlink'].'", ';}
if(isset($listing->data['justdiallink']) && $listing->data['justdiallink'] ) { $toprint = $toprint.'"'. $listing->data['justdiallink'].'", ';}
if(isset($listing->data['sulekhalink']) && $listing->data['sulekhalink']) { $toprint = $toprint.'"'. $listing->data['sulekhalink'].'", ';}
if(isset($listing->data['magicpinlink']) && $listing->data['magicpinlink']  ) { $toprint = $toprint.'"'. $listing->data['magicpinlink'].'", ';}
if(isset($listing->data['custommap']) && $listing->data['custommap']  ) { $toprint = $toprint.'"'. $listing->data['custommap'].'", ';}
if(isset($listing->data['mouthshutlink']) && $listing->data['mouthshutlink'] ) { $toprint = $toprint.'"'. $listing->data['mouthshutlink'].'", ';}
if(isset($listing->data['nearbuylink']) && $listing->data['nearbuylink']) { $toprint = $toprint.'"'. $listing->data['nearbuylink'].'", ';}
if(isset($listing->data['mydalalink']) && $listing->data['mydalalink']) { $toprint = $toprint.'"'. $listing->data['mydalalink'].'", ';}
if(isset($listing->data['lbblink']) && $listing->data['lbblink'] ) { $toprint = $toprint.'"'. $listing->data['lbblink'].'", ';}
if(isset($listing->data['wikipedialink']) && $listing->data['wikipedialink']) { $toprint = $toprint.'"'. $listing->data['wikipedialink'].'", ';}
if(isset($listing->data['housinglink']) && $listing->data['housinglink'] ) { $toprint = $toprint.'"'. $listing->data['housinglink'].'", ';}
if(isset($listing->data['tripadvisorlink']) && $listing->data['tripadvisorlink'] ) { $toprint = $toprint.'"'. $listing->data['tripadvisorlink'].'", ';}
if(isset($listing->data['zomatolink']) && $listing->data['zomatolink']  ) { $toprint = $toprint.'"'. $listing->data['zomatolink'].'", ';}
if(isset($listing->data['swiggylink']) && $listing->data['swiggylink']) { $toprint = $toprint.'"'. $listing->data['swiggylink'].'", ';}
if(isset($listing->data['eazydinerlink']) && $listing->data['eazydinerlink']) { $toprint = $toprint.'"'. $listing->data['eazydinerlink'].'", ';}
if(isset($listing->data['dineoutlink']) && $listing->data['dineoutlink']) { $toprint = $toprint.'"'. $listing->data['dineoutlink'].'", ';}
if(isset($listing->data['practolink']) && $listing->data['practolink']) { $toprint = $toprint.'"'. $listing->data['practolink'].'", ';}
if($listing->website) { $toprint = $toprint.'"'. $listing->website.'", ';}
@endphp
   {!! rtrim($toprint,', ')  !!}     ]
@endif
@if(isset($listing->data['knowledge_graph']['hours']))
,"openingHours":[@php
    $final = [];
    foreach ($listing->data['knowledge_graph']['hours'] as $item) {
        $final[$item['value']][] = $item['name'];
    }
    $todump='"';
    foreach($final as $time => $daysarray){
        if($time=="Open 24 Hours" || $time=="Open 24 hours"){
            foreach ($daysarray as $day) {
//            dump($day);
                switch (ucwords($day)) {
                    case "Sunday":
                        $todump .= 'Su,';
                        break;
                    case "Monday":
                        $todump .= 'Mo,';
                        break;
                    case "Tuesday":
                        $todump .= 'Tu,';
                        break;
                    case "Wednesday":
                        $todump .= 'We,';
                        break;
                    case "Thursday":
                        $todump .= 'Th,';
                        break;
                    case "Friday":
                        $todump .= 'Fr,';
                        break;
                    case "Saturday":
                        $todump .= 'Sa,';
                        break;
                }
            }
            $todump = substr($todump, 0, -1).' all day';
        }
        elseif($time=="Closed"){continue;}
        else{
            foreach ($daysarray as $day) {
    //            dump($day);
                switch (ucwords($day)) {
                    case "Sunday":
                        $todump .= 'Su,';
                        break;
                    case "Monday":
                        $todump .= 'Mo,';
                        break;
                    case "Tuesday":
                        $todump .= 'Tu,';
                        break;
                    case "Wednesday":
                        $todump .= 'We,';
                        break;
                    case "Thursday":
                        $todump .= 'Th,';
                        break;
                    case "Friday":
                        $todump .= 'Fr,';
                        break;
                    case "Saturday":
                        $todump .= 'Sa,';
                        break;
                }
            }
            $todump = substr($todump, 0, -1);
            foreach(explode(', ',$time) as $timesection) {
                [$start, $end] = \App\Services\BusinessOpen::fn1(str_replace(' ', '–', $timesection));
                $todump = $todump . ' ' . $start->format('H:i') . '-' . $end->format('H:i');
            }
        }
        $todump = $todump.'","';
    }
    echo(substr($todump,0,-2));
@endphp]
@endif

@if($listing->reviews->count()),
@php $avgrating = round(array_sum($listing->reviews->pluck('rating')->toArray()) /  count($listing->reviews->pluck('rating')) ,1 );
        $fives = $listing->reviews->where('rating',5)->count();
        $fours = $listing->reviews->where('rating',4)->count();
        $threes = $listing->reviews->where('rating',3)->count();
        $twos = $listing->reviews->where('rating',2)->count();
        $ones = $listing->reviews->where('rating',1)->count(); @endphp
    "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{$avgrating}}",
"ratingCount": "{{$listing->reviews->count()}}",
"bestRating":"5","worstRating":"0"
},

"review": [
@foreach($listing->reviews as $review)
        {
        "@type": "Review",
        "datePublished": "{{$review->created_at->format('jS F, Y')}}",
"reviewBody": "{{stripslashes($review->body)}}",
"author": {"@type": "Person","name": "{{$review->user_name?? $review->user->display_name}}"}
}@unless($loop->last),@endunless
@endforeach
    ]
@endif
    }
</script>

@if($listing->reviews->count())
<div class="mb-7 mt-4">
<h4 class="mb-4" id="reviews">Overall feedback</h4>
<div class="row align-items-center">
    <div class="col-lg-4 mb-4 mb-lg-0">
        <div class="card bg-primary text-white text-center py-4 px-3">

            <span class=display-4>{{$avgrating}}</span>
            <span class="my-2">
        @if($avgrating >= 1)
                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve">
                <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3
                    l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4
                    C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/>
            </svg>
                @elseif($avgrating > 0)
                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st1" d="M16.6,6.3c0.2-0.2,0.1-0.6-0.2-0.6L11.3,5C11.2,5,11.1,5,11,4.8L8.7,0.1C8.6,0,8.5,0,8.4,0v13.4 c0,0,0.1,0,0.2,0l4.7,2.3c0.2,0.1,0.6-0.1,0.5-0.4l-0.9-5.1c0-0.1,0-0.2,0.1-0.3L16.6,6.3z"/><path class="st0" d="M8.4,0C8.2,0,8.1,0.1,8,0.1L5.7,5C5.6,5,5.5,5.1,5.4,5.1L0.3,5.8C0,5.8-0.1,6.3,0.1,6.5L3.9,10 C4,10.1,4,10.3,4,10.3l-0.9,5.1C3,15.8,3.3,16,3.6,15.8l4.6-2.4c0,0,0.1,0,0.1,0V0z"/></svg>
                @else
                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                @endif

                @if($avgrating >= 2)
                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve">
                <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3
                    l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4
                    C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/>
            </svg>
                @elseif($avgrating > 1)
                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st1" d="M16.6,6.3c0.2-0.2,0.1-0.6-0.2-0.6L11.3,5C11.2,5,11.1,5,11,4.8L8.7,0.1C8.6,0,8.5,0,8.4,0v13.4 c0,0,0.1,0,0.2,0l4.7,2.3c0.2,0.1,0.6-0.1,0.5-0.4l-0.9-5.1c0-0.1,0-0.2,0.1-0.3L16.6,6.3z"/><path class="st0" d="M8.4,0C8.2,0,8.1,0.1,8,0.1L5.7,5C5.6,5,5.5,5.1,5.4,5.1L0.3,5.8C0,5.8-0.1,6.3,0.1,6.5L3.9,10 C4,10.1,4,10.3,4,10.3l-0.9,5.1C3,15.8,3.3,16,3.6,15.8l4.6-2.4c0,0,0.1,0,0.1,0V0z"/></svg>
                @else
                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                @endif

                @if($avgrating >= 3)
                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve">
                <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3
                    l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4
                    C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/>
            </svg>
                @elseif($avgrating > 2)
                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st1" d="M16.6,6.3c0.2-0.2,0.1-0.6-0.2-0.6L11.3,5C11.2,5,11.1,5,11,4.8L8.7,0.1C8.6,0,8.5,0,8.4,0v13.4 c0,0,0.1,0,0.2,0l4.7,2.3c0.2,0.1,0.6-0.1,0.5-0.4l-0.9-5.1c0-0.1,0-0.2,0.1-0.3L16.6,6.3z"/><path class="st0" d="M8.4,0C8.2,0,8.1,0.1,8,0.1L5.7,5C5.6,5,5.5,5.1,5.4,5.1L0.3,5.8C0,5.8-0.1,6.3,0.1,6.5L3.9,10 C4,10.1,4,10.3,4,10.3l-0.9,5.1C3,15.8,3.3,16,3.6,15.8l4.6-2.4c0,0,0.1,0,0.1,0V0z"/></svg>
                @else
                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                @endif

                @if($avgrating >= 4)
                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"  viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve">
                <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3
                    l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4
                    C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/>
            </svg>
                @elseif($avgrating > 3)
                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st1" d="M16.6,6.3c0.2-0.2,0.1-0.6-0.2-0.6L11.3,5C11.2,5,11.1,5,11,4.8L8.7,0.1C8.6,0,8.5,0,8.4,0v13.4 c0,0,0.1,0,0.2,0l4.7,2.3c0.2,0.1,0.6-0.1,0.5-0.4l-0.9-5.1c0-0.1,0-0.2,0.1-0.3L16.6,6.3z"/><path class="st0" d="M8.4,0C8.2,0,8.1,0.1,8,0.1L5.7,5C5.6,5,5.5,5.1,5.4,5.1L0.3,5.8C0,5.8-0.1,6.3,0.1,6.5L3.9,10 C4,10.1,4,10.3,4,10.3l-0.9,5.1C3,15.8,3.3,16,3.6,15.8l4.6-2.4c0,0,0.1,0,0.1,0V0z"/></svg>
                @else
                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                @endif

                @if($avgrating == 5)
                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve">
                <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3
                    l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4
                    C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/>
            </svg>
                @elseif($avgrating > 4)
                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st1" d="M16.6,6.3c0.2-0.2,0.1-0.6-0.2-0.6L11.3,5C11.2,5,11.1,5,11,4.8L8.7,0.1C8.6,0,8.5,0,8.4,0v13.4 c0,0,0.1,0,0.2,0l4.7,2.3c0.2,0.1,0.6-0.1,0.5-0.4l-0.9-5.1c0-0.1,0-0.2,0.1-0.3L16.6,6.3z"/><path class="st0" d="M8.4,0C8.2,0,8.1,0.1,8,0.1L5.7,5C5.6,5,5.5,5.1,5.4,5.1L0.3,5.8C0,5.8-0.1,6.3,0.1,6.5L3.9,10 C4,10.1,4,10.3,4,10.3l-0.9,5.1C3,15.8,3.3,16,3.6,15.8l4.6-2.4c0,0,0.1,0,0.1,0V0z"/></svg>
                @else
                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                @endif
            </span>
            <span>Average rating</span>
        </div>
    </div>
    <div class=col-lg-8>
        <ul class="list-unstyled list-sm-article mb-0">
            <li>
                <a class="d-flex align-items-center font-size-1">
                    <div class="progress w-100" style="height: 8px;">
                        <div class=progress-bar role=progressbar style="width: {{$ones/$listing->reviews->count() * 100}}%;" aria-valuenow=0 aria-valuemin=0 aria-valuemax=100></div>
                    </div>
                    <div class="d-flex align-items-center min-w-21rem ml-3">
                        <ul class="d-flex list-inline mr-1 mb-2">
                            @for($i=0;$i<1;$i++)
                                <li class="list-inline-item mr-1">
                                    <svg width="16" version="1.1" name="fullstar" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/>
                                </svg>
                                </li>
                            @endfor
                            @for($i=0;$i<4;$i++)
                                <li class="list-inline-item mr-1">
                                    <svg width="16" version="1.1" name="emptystar" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                                </li>
                            @endfor

                        </ul>
                        <span>{{$ones}}</span>
                    </div>
                </a>
            </li>
            <li>
                <a class="d-flex align-items-center font-size-1">
                    <div class="progress w-100" style="height: 8px;">
                        <div class=progress-bar role=progressbar style="width: {{$twos/$listing->reviews->count() * 100}}%;" aria-valuenow=0 aria-valuemin=0 aria-valuemax=100></div>
                    </div>
                    <div class="d-flex align-items-center min-w-21rem ml-3">
                        <ul class="d-flex list-inline mr-1 mb-2">
                            @for($i=0;$i<2;$i++)
                                <li class="list-inline-item mr-1">
                                    <svg width="16" version="1.1" name="fullstar" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/>
                                </svg>
                                </li>
                            @endfor
                            @for($i=0;$i<3;$i++)
                                <li class="list-inline-item mr-1">
                                    <svg width="16" version="1.1" name="emptystar" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                                </li>
                            @endfor

                        </ul>
                        <span>{{$twos}}</span>
                    </div>
                </a>
            </li>
            <li>
                <a class="d-flex align-items-center font-size-1" >
                    <div class="progress w-100" style="height: 8px;">
                        <div class=progress-bar role=progressbar style="width: {{$threes/$listing->reviews->count() * 100}}%;" aria-valuenow=0 aria-valuemin=0 aria-valuemax=100></div>
                    </div>
                    <div class="d-flex align-items-center min-w-21rem ml-3">
                        <ul class="d-flex list-inline mr-1 mb-2">
                            @for($i=0;$i<3;$i++)
                                <li class="list-inline-item mr-1">
                                    <svg width="16" version="1.1" name="fullstar" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/>
                                </svg>
                                </li>
                            @endfor
                            @for($i=0;$i<2;$i++)
                                <li class="list-inline-item mr-1">
                                    <svg width="16" version="1.1" name="emptystar" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                                </li>
                            @endfor

                        </ul>
                        <span>{{$threes}}</span>
                    </div>
                </a>
            </li>
            <li>
                <a class="d-flex align-items-center font-size-1">
                    <div class="progress w-100" style="height: 8px;">
                        <div class=progress-bar role=progressbar style="width: {{$fours/$listing->reviews->count() * 100}}%;" aria-valuenow=80 aria-valuemin=0 aria-valuemax=100></div>
                    </div>
                    <div class="d-flex align-items-center min-w-21rem ml-3">
                        <ul class="d-flex list-inline mr-1 mb-2">
                            @for($i=0;$i<4;$i++)
                                <li class="list-inline-item mr-1">
                                    <svg width="16" version="1.1" name="fullstar" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/>
                                </svg>
                                </li>
                            @endfor
                            @for($i=0;$i<1;$i++)
                                <li class="list-inline-item mr-1">
                                    <svg width="16" version="1.1" name="emptystar" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                                </li>
                            @endfor

                        </ul>
                        <span>{{$fours}}</span>
                    </div>
                </a>
            </li>
            <li>
                <a class="d-flex align-items-center font-size-1">
                    <div class="progress w-100" style="height: 8px;">
                        <div class=progress-bar role=progressbar style="width: {{$fives/$listing->reviews->count() * 100}}%;" aria-valuenow=80 aria-valuemin=0 aria-valuemax=100></div>
                    </div>
                    <div class="d-flex align-items-center min-w-21rem ml-3">
                        <ul class="d-flex list-inline mr-1 mb-2">
                            @for($i=0;$i<5;$i++)
                                <li class="list-inline-item mr-1">
                                    <svg width="16" version="1.1" name="fullstar" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/>
                                </svg>
                                </li>
                            @endfor
                        </ul>
                        <span>{{$fives}}</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>

</div>
@else
<h6 class="my-4">No reviews found for {{$listing->title}}</h6>
@endif

<div class="text-body border-top my-2 mt-3">
    @foreach($listing->reviews->sortByDesc('created_at') as $review)
        @include('partials.review')
        <hr>
    @endforeach
</div>






