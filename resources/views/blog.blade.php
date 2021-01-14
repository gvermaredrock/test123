@extends('bootstraplayout')
@section('seo')
    @include('partials.seo',[
    'title'=>$blog->meta_title ? $blog->meta_title : 'Wuchna',
    'description'=>$blog->meta_description ? $blog->meta_description : 'Wuchna',
    'canonical'=>$blog->full_link
    ])
    <link rel="amphtml" href="{{$blog->amp_link}}">
@endsection

@section('styles')
@if(isset($blog->data['externalcontent']) && $blog->data['externalcontent'])
    <style>
        img{max-width: 100%; height: auto;}
        video{max-width: 100%; height: auto;}
        figcaption{margin-top: -40px; color: white; margin-left: 10px; z-index: 5; font-weight: bold; padding: 5px}
    </style>
@endif

@if($blog->keywords->isNotEmpty() ||  ($blog->search_result && isset($blog->search_result->data['related_searches'])) )
    <meta name="keywords" content=" {{strtolower(str_replace('-',' ',$blog->slug))}},
        @if($blog->keywords->isNotEmpty())
    {{implode(', ',$blog->keywords->pluck('title')->toArray())}}
    @if(isset($blog->search_result->data['related_searches'])) ,
            @foreach($blog->search_result->data['related_searches'] as $rr) {{$rr['query']}}@unless($loop->last), @endunless @endforeach
    @endif
    @else
    @foreach($blog->search_result->data['related_searches'] as $rr) {{$rr['query']}}@unless($loop->last), @endunless @endforeach
    @endif">
@endif

@endsection

@section('pagelinks')
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "Wuchna {{config('my.LOCAL_COUNTRY_NAME')}}",
        "item": "{{config('my.APP_URL')}}"
      }
      @if($city),{
        "@type": "ListItem",
        "position": 2,
        "name": "{{$city->title}}",
        "item": "{{$city->full_link}}"
      }@if($city->locality_count != 1),{
        "@type": "ListItem",
        "position": 3,
        "name": "{{ucwords($category->title)}} in {{$city->title}}",
        "item": "{{config('my.APP_URL').'/'.$city->slug.'/'.$category->slug}}"
      }@endif,{
        "@type": "ListItem",
        "position": @if($city->locality_count != 1) 4 @else 3 @endif,
        "name": "{{ucwords(str_replace('-',' ',$blog->slug))}}"
      }]
      @else,{
        "@type": "ListItem",
        "position": 2,
        "name": "{{$category->title}}",
        "item": "{{$category->full_link}}"
      },{
        "@type": "ListItem",
        "position": 3,
        "name": "{{ucwords(str_replace('-',' ',$blog->slug))}}"
      }]
      @endif

    }
    </script>
@if($listings->count() && ($listings->count() > 1) )
    <script type="application/ld+json">{
"@context": "https://schema.org/",
"@type": "ItemList",
"itemListElement": [
@foreach($listings as $listing)
    {"@type":"ListItem","position":{{$loop->index+1}},"url":"{{$listing->full_link}}"}@unless($loop->last),@endunless
@endforeach
    ]
}</script>
    @endif
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                @if(!$ismobile)<li class="breadcrumb-item"><a class="text-dark" href="{{config('my.APP_URL')}}">Wuchna {{config('my.LOCAL_COUNTRY_NAME')}}</a></li>@endif
@if($city)
                        <li class="breadcrumb-item"><a class="text-dark" href="{{$city->full_link}}">{{ucwords($city->title)}}</a></li>
@if($city->locality_count != 1) <li class="breadcrumb-item"><a class="text-dark" href="{{config('my.APP_URL').'/'.$city->slug.'/'.$category->slug}}">{{ucwords($category->title)}} in {{$city->title}}</a></li> @endif
                        <li class="breadcrumb-item active" aria-current="page" class="text-dark">{{ucwords(str_replace('-',' ',$blog->slug))}}</li>

@else
                        <li class="breadcrumb-item"><a class="text-dark" href="{{$category->full_link}}">{{ucwords($category->title)}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page" class="text-dark">{{ucwords(str_replace('-',' ',$blog->slug))}}</li>

@endif
            </ol>
        </nav>
    </div>
@endsection

{{--@section('preheader')--}}
{{--    <template v-if="showingBlog">--}}
{{--@endsection--}}

@section('jumbotron')

        @if(!isset($blog->data['externalcontent']))
            <div class="jumbotron text-dark rounded p-md-4" style="position: relative;
            @if(!$ismobile)
                background: url('{{ isset($blog->data['banner_img']) ?  $blog->data['banner_img'] : ( isset($category->data['banner_img']) ? $category->data['banner_img'] : 'https://m1.wuchna.com/images/1920x800/'.$category->slug.'.jpg' ) }}') ;
                @if(isset($blog->data['bannerheight']))height: {{$blog->data['bannerheight']}}px; @endif
                background-size: cover;
            @endif ">
                @if(!$ismobile) @if(! isset($blog->data['nobanneroverlay'])) <div class="overlay" style="position: absolute; top: 0; right: 0; bottom: 0; left: 0; background-color: rgba(255, 255, 255, 0.7); z-index: 1;"></div> @endif @endif
                @if(!isset($blog->data['nobannercontent']))
                <div class="inner col-md-12 px-md-8" style="position: relative; z-index: 2;">
                    @if($blog->title)<h4>{{$blog->title}}</h4>@endif
                        @if(Auth::check() && auth()->id() == 1)
                            <a href="/admineditblog/{{$blog->id}}" class="btn btn-warning">Edit Blog</a>
                            <a href="/admindeleteblog/{{$blog->id}}" class="btn btn-danger ml-4" target="_blank">Delete</a>

                            @if($blog->keywords->isNotEmpty()) Keywords: {{implode(', ',$blog->keywords->pluck('title')->toArray())}} @endif

                            <form method="POST" action="/adminaddblogmeta">
                                @csrf
                                <input type="hidden" name="blog_id" value="{{$blog->id}}" />
                                <input type="text" name="title" /><button class="btn btn-sm btn-danger">Add Meta</button>
                            </form>

                        @endif
                    @if($blog->description){!! $blog->description !!}@endif
                </div>
                @endif
            </div>
        @else
            <div class="jumbotron text-dark rounded p-md-4">
                <div class="inner col-md-12 px-md-8">
                    @if(isset($blog->data['externallink']))<a rel="nofollow" target="_blank" class="text-dark" href="{{$blog->data['externallink']}}"> @endif
                    @if($blog->title)<h1>{{$blog->title}}</h1>@endif
                    @if(isset($blog->data['externallink']))</a>@endif
                    <small>
                        @if(isset($blog->data['externallink']))<a rel="nofollow" target="_blank" class="text-dark" href="{{$blog->data['externallink']}}"> @endif

                            @if(isset($blog->data['externalauthor']))<span class="text-dark">by</span> <span class="h5 text-dark">{{$blog->data['externalauthor']}}</span> @endif
                            @if(isset($blog->data['externallink']))</a>@endif

                        | {{$blog->created_at->format('M d Y')}}
                    </small>
                </div>
            </div>
        @endif

        @if(session('message')) <div class="alert alert-danger">{{session('message')}}</div> @endif
        @include('partials.custombanner',compact(['blog','category']))
@endsection

@section('main')
    <div class="row" >
        <div class="col-md-9 blog-main">
            @if(isset($htmlsections['content-top']))
                {!! $htmlsections['content-top'] !!}
            @endif

            @if($listings->count())
                <h2 class="h5 mb-3">{{$listings->count()}} Results <small class="text-body">for "{{ucwords(str_replace( '-',' ',$blog->slug))}}"</small></h2>
                <div class="row no-gutters overflow-auto flex-md-row mb-4 position-relative">
                    @foreach($listings as $listing)
                        @include('listing-in-blog')
                    @endforeach
                </div>
            @endif

            @if(isset($htmlsections['content-bottom']))
                {!! $htmlsections['content-bottom'] !!}
            @endif

        </div><!-- /.blog-main -->

        <aside class="col-md-3 blog-sidebar p-4">
            @if($locality)
                @if($relatedblogs->where('id','!=',$blog->id)->count())
                <h4>More in {{$locality->title}}</h4>
                <p class="mb-4">
                    @foreach($relatedblogs->where('id','!=',$blog->id)->take(5) as $relatedblog)
                        <a href="{{$relatedblog->full_link}}">{{$relatedblog->title}}</a><br>
                    @endforeach
                </p>
                @endif
            @endif

            @if($nearbyplaces->count())
            <h4>Near {{$locality->title}}</h4>
            <p class="mb-4">
                @foreach($nearbyplaces as $nearbyblog)
                <a href="{{$nearbyblog->full_link}}">{{ucwords(str_replace('-',' ',$nearbyblog->slug))}}</a><br>
                @endforeach
            </p>
            @endif

            @if((!$ismobile) && isset($categoryposts) && $categoryposts->isNotEmpty())
            <div class="row">
                <div class="col-12 mb-3"><h3>Latest Posts:</h3><hr></div>
                @foreach($categoryposts as $post)
                    <div class="col-12 mb-2">
                        <a class="card" style="max-height:440px;overflow: auto; text-decoration: none !important; color: #212529" href="{{$post->full_link}}">
                            <img src="{{str_replace('https://my.wuchna.com/storage/external','https://my-externalstorage'.rand(1,3).'.wuchna.com',$post->data['content_img'])}}" class="zoom img-fluid" alt="Post by {{$post->listing->title}}" style="max-height:240px">

                            <div style="padding: .75rem 1.25rem;" ><h4 class="mb-2">{{$post->title}}</h4>
                                <p class="small text-muted">@if($post->listing){{$post->listing->title}} | @endif {{$post->created_at->diffForHumans()}}</p>

                                {!! \Str::words($post->body,20) !!}</div>
                        </a>
                    </div>

                    {{--            <div class="col-6 col-md-3 mb-2">--}}
                    {{--                <a href="{{$b->full_link}}" class="card text-dark">--}}
                    {{--                    @if(isset($b->data['avatar_img']))<img class="card-img-top" src="{{$b->data['avatar_img']}}" alt="{{$b->title}}">@endif--}}
                    {{--                    <div class="card-body" style="padding:0.9rem"><h6 class="card-title">{{$b->title}}</h6></div>--}}
                    {{--                </a>--}}
                    {{--            </div>--}}
                @endforeach
            </div>
            @endif
{{--                @include('aside')--}}

{{--            @if(isset($blog->data['aside']))--}}
{{--                @foreach($blog->data['aside'] as $aside)--}}
{{--                    @yield('aside',view('aside',['aside'=>$aside,'blog'=>$blog,'category'=>$category]))--}}
{{--                @endforeach--}}
{{--            @else--}}

{{--            @endif--}}
{{--            @if(isset($htmlsections['aside-2']))--}}
{{--                {!! $htmlsections['aside-2'] !!}--}}
{{--            @endif--}}
{{--            @if(isset($htmlsections['aside-3']))--}}
{{--                {!! $htmlsections['aside-3'] !!}--}}
{{--            @endif--}}


        </aside>



    </div>
            @if(isset($blog->data['externalcontent']))
            <div class="row"><div class="col-12 p-3 text-muted"><p class="small">DISCLAIMER: Information on this page was syndicated through a content partner, and Wuchna is not liable for the views expressed, or the accuracy of this information, or for the copyright of the media links (images, videos etc.) - they are the property of the content partner, and are embedded as links from the content partner. </p></div></div>
            @endif

    @if($blog->references->count())
        <div class="row">
            <div class="col-lg-12 mt-4 border-bottom p-2">
                <h6 class="h5">Sources and References:</h6>
                <p><ol class="references">
                    @foreach($blog->references as $ref)
                        <li><b>{{$ref->title}}</b>: <small>{{\Illuminate\Support\Str::words($ref->snippet,30)}} <a href="{{$ref->link}}" rel="nofollow noreferrer" target="_blank">
                                        <svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 -256 1850 1850" width="16" height="16"><g fill="blue" transform="matrix(1,0,0,-1,30.372881,1426.9492)"> <path stroke="blue" stroke-width="6" d="M 1408,608 V 288 Q 1408,169 1323.5,84.5 1239,0 1120,0 H 288 Q 169,0 84.5,84.5 0,169 0,288 v 832 Q 0,1239 84.5,1323.5 169,1408 288,1408 h 704 q 14,0 23,-9 9,-9 9,-23 v -64 q 0,-14 -9,-23 -9,-9 -23,-9 H 288 q -66,0 -113,-47 -47,-47 -47,-113 V 288 q 0,-66 47,-113 47,-47 113,-47 h 832 q 66,0 113,47 47,47 47,113 v 320 q 0,14 9,23 9,9 23,9 h 64 q 14,0 23,-9 9,-9 9,-23 z m 384,864 V 960 q 0,-26 -19,-45 -19,-19 -45,-19 -26,0 -45,19 L 1507,1091 855,439 q -10,-10 -23,-10 -13,0 -23,10 L 695,553 q -10,10 -10,23 0,13 10,23 l 652,652 -176,176 q -19,19 -19,45 0,26 19,45 19,19 45,19 h 512 q 26,0 45,-19 19,-19 19,-45 z" /></g>
                                        </svg></a></small></li>
                        @if(Auth::check() && auth()->id() == 1)
                            <span class="text-body" style="font-size:16px; font-weight: bold">{{$ref->link}}</span>
                            <a target="_blank" href="/admindeletereference/{{$ref->id}}" class="btn btn-sm btn-danger">Delete Reference</a>
                        @endif
                    @endforeach
                </ol></p>
            </div>
        </div>
    @endif


    @if($blog->search_result && isset($blog->search_result->data['related_searches']))
        <div class="row">
            <div class="col-lg-12 border-bottom py-3">
                <h6 class="h5">People also search for: </h6>
                <p class="small text-muted">@foreach($blog->search_result->data['related_searches'] as $rr)
                        <em>{{$rr['query']}}</em> @unless($loop->last), @endunless
                    @endforeach</p>
            </div>
        </div>
    @endif
@endsection

{{--@section('postfooter')--}}
{{--    </template>--}}

{{--    <template v-if="showingListing">--}}
{{--        <header class="blog-header">--}}
{{--            <div class="container">--}}
{{--                <div class="row" >--}}
{{--                    <div class="col-12 justify-content-around">--}}
{{--                        <a class="text-muted" href="#" @click.prevent="back">--}}
{{--                            <svg  xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" width="20" height="20">--}}
{{--                                <g stroke-width="2" stroke="#6c757d">--}}
{{--                                    <path style="font-size:11px;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;text-align:start;line-height:125%;letter-spacing:0px;word-spacing:0px;writing-mode:lr-tb;text-anchor:start;fill:#1a1a1a;fill-opacity:1;stroke:none;" d="m 1.731867,9.9956035 c 2e-5,0.7560365 0.09966,1.4842425 0.298902,2.1846165 0.199287,0.700357 0.477675,1.358232 0.835165,1.973627 0.357528,0.615372 0.786831,1.175079 1.287912,1.67912 0.501116,0.504017 1.057891,0.936251 1.67033,1.296703 0.612469,0.360426 1.270344,0.640279 1.973627,0.839561 0.703309,0.199253 1.432978,0.298886 2.18901,0.298901 0.756055,-1.5e-5 1.484259,-0.09965 2.184616,-0.298901 0.700375,-0.199282 1.355319,-0.479135 1.964834,-0.839561 0.609531,-0.360452 1.167773,-0.792686 1.674726,-1.296703 0.506965,-0.504041 0.940664,-1.063748 1.301099,-1.67912 0.360444,-0.615395 0.641762,-1.27327 0.843956,-1.973627 0.202201,-0.700374 0.3033,-1.42858 0.303296,-2.1846165 4e-6,-0.756049 -0.09963,-1.484254 -0.298901,-2.184615 -0.199263,-0.70037 -0.479116,-1.356779 -0.83956,-1.969231 -0.360435,-0.612454 -0.792669,-1.169231 -1.296704,-1.67033 -0.504022,-0.501098 -1.063729,-0.931867 -1.67912,-1.292307 -0.615377,-0.360439 -1.273251,-0.640292 -1.973626,-0.839561 -0.700357,-0.199264 -1.428561,-0.298899 -2.184616,-0.2989 -0.756032,10e-7 -1.485701,0.09964 -2.18901,0.2989 -0.703283,0.199269 -1.361158,0.477658 -1.973627,0.835165 -0.612439,0.357511 -1.169214,0.786814 -1.67033,1.287912 -0.501081,0.501099 -0.930384,1.05934 -1.287912,1.674726 -0.35749,0.615382 -0.635878,1.273256 -0.835165,1.973626 -0.199247,0.700361 -0.298882,1.428566 -0.298902,2.184615 z m 2.769231,0.035172 0,-0.035172 4.026374,-4.210988 2.918682,0 -3.068132,3.138462 6.672527,0 0,2.1802195 -6.672527,0 3.068132,3.138461 -2.918682,0 z M 0,9.9868115 c 2.0999981e-5,-0.90843 0.120171,-1.784619 0.360439,-2.628572 0.240315,-0.843958 0.58024,-1.636632 1.01978,-2.378021 0.43958,-0.741393 0.964123,-1.416851 1.573627,-2.026375 C 3.563387,2.3443225 4.238845,1.8197795 4.980218,1.3802185 5.721627,0.94065953 6.515765,0.60073453 7.362637,0.36043753 8.209538,0.12014953 9.087192,2.5255985e-6 9.995604,-4.7440151e-7 10.90404,2.5255985e-6 11.781694,0.12015453 12.628571,0.36043853 c 0.846895,0.240297 1.641033,0.577292 2.382418,1.01098997 0.741398,0.433701 1.41832,0.955312 2.030769,1.564835 0.612458,0.609524 1.138465,1.284982 1.578022,2.026374 0.439563,0.74139 0.77949,1.535528 1.01978,2.382416 0.240295,0.846883 0.360442,1.727468 0.36044,2.641759 2e-6,0.9084175 -0.120145,1.7860735 -0.36044,2.6329675 -0.24029,0.846877 -0.580217,1.641015 -1.01978,2.382417 -0.439557,0.74138 -0.965564,1.418303 -1.578022,2.03077 -0.612449,0.61244 -1.289371,1.138447 -2.030769,1.578022 -0.741385,0.439545 -1.535523,0.780937 -2.382418,1.024176 C 11.781694,19.878372 10.90404,19.999984 9.995604,20 9.087192,19.999984 8.209538,19.879837 7.362637,19.63956 6.515765,19.399252 5.721627,19.06079 4.980218,18.624176 4.238845,18.187531 3.563387,17.66299 2.953846,17.050549 2.344342,16.438082 1.819799,15.761159 1.380219,15.019779 0.940679,14.278377 0.600754,13.482774 0.360439,12.632967 0.120168,11.783143 2.0999981e-5,10.901091 0,9.9868125 z" />--}}
{{--                                </g>--}}
{{--                            </svg>--}}
{{--                            Back--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </header>--}}

{{--    @foreach($listings as $listing)--}}
{{--        <template v-if="showingListing && showingListingId === {{$listing->id}}">--}}
{{--            <main role="main" class="container">--}}
{{--                <div class="row" >--}}
{{--                    <div class="col-md-12 mt-4">--}}
{{--                        @include('listing-in-listing-1')--}}
{{--                        @include('listing-in-listing-2')--}}
{{--                    </div><!-- /.blog-main -->--}}
{{--                </div><!-- /.row -->--}}
{{--            </main>--}}

{{--        </template>--}}
{{--    @endforeach--}}

{{--    </template>--}}

{{--@endsection--}}



@section('scripts')
{{--    <script src="{{config('my.VUE_LINK')}}"></script>--}}
<script src="{{ asset('js/vue.js') }}"></script>
{{--<script src="//cdnjs.cloudflare.com/ajax/libs/mousetrap/1.4.6/mousetrap.min.js"></script>--}}

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                @include('partials.vue.data.search'),
                @include('partials.vue.data.listing-in-listing-1'),

                showingBlog: true,  showingListingId:null,
                showingListing: false,
                @foreach($listings as $listing)
                showingListing{{$listing->id}}: false,
                toShowCallData{{$listing->id}}: false,
                displayReviewsOf{{$listing->id}}: false,
                @endforeach
            },
            mounted() {
                this.focusInput();
                // Mousetrap.bind('f', function(e) {
                //     window.app.showsearchinput();
                // });
        },
            methods: {
                @include('partials.vue.methods.search'),
                @include('partials.vue.methods.listing-in-listing-1'),
                // showListing(id){ this.showingBlog = false; this.showingListing = true; this.showingListingId = id; window.scrollTo(0, 0);},
                // back(){
                //     this.showingListing = false; this.showingBlog = true;
                //     var that = this;
                //     setTimeout((that) => {
                //         var e = document.getElementById("listing_"+this.showingListingId); e.scrollIntoView();
                //         window.scrollBy(0,-100);
                //         window.app.showingListingId = null;
                //         }, 100);
                // },
            }

        });
    </script>
    <script src="{{ asset('js/app.js') }}"></script>

@endsection
