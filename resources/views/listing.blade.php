@extends('bootstraplayout')
@section('seo')
    @if( (!(Auth::check() && auth()->user()->reviews->where('listing_id',$listing->id)->count())) && (!(Auth::check() && auth()->id() == $listing->user_id)))
    <link rel="preload" href="/quill-emoji.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    @endif
    @include('partials.seo',[
    'title'=>$listing->meta_title ? $listing->meta_title : 'Wuchna',
    'description'=>$listing->meta_description ? $listing->meta_description : 'Wuchna',
    'canonical'=>$listing->full_link
    ])
    @if( (!(Auth::check() && auth()->user()->reviews->where('listing_id',$listing->id)->count())) && (!(Auth::check() && auth()->id() == $listing->user_id)) )
        <link rel="preload" href="https://m3.wuchna.com/quill.snow.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <link rel="preload" href="https://m3.wuchna.com/quill.js" as="script">
    @endif
    <link rel="amphtml" href="{{$listing->amp_link}}">
@endsection

@section('styles')
    @if($listing->keywords->isNotEmpty() || isset($listing->data['related_searches']) )
        <meta name="keywords" content=" {{$listing->title}}, @if($listing->keywords->isNotEmpty()){{implode(', ',$listing->keywords->pluck('title')->toArray())}} @if(isset($listing->data['related_searches'])) , @foreach($listing->data['related_searches'] as $rr){{$rr['query']}}@unless($loop->last), @endunless @endforeach @endif @else @foreach($listing->data['related_searches'] as $rr){{$rr['query']}}@unless($loop->last), @endunless @endforeach @endif">
    @endif

    <style>
    #standalone-container, #toolbar-container,#editor {border-radius:5px}  .zoom { transition: transform .2s;}   .zoom:hover { -ms-transform: scale(1.05); -webkit-transform: scale(1.05); transform: scale(1.05); }
</style>

@endsection

@section('pagelinks')
    @if($blog)
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "Wuchna {{config('my.LOCAL_COUNTRY_NAME')}}",
        "item": "{{config('my.APP_URL')}}"
      },{
        "@type": "ListItem",
        "position": 2,
        "name": "{{$city->title}}",
        "item": "{{$city->full_link}}"
      },{
        "@type": "ListItem",
        "position": 3,
        "name": "{{ucwords(str_replace('-',' ',$blog->slug))}}",
        "item": "{{$blog->full_link}}"
      },{
        "@type": "ListItem",
        "position": 4,
        "name": "{{ucwords(str_replace('-',' ',$listing->title))}}"
      }]
    }
    </script>



    <div class="container">
        @if(!$ismobile)
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-dark" href="{{config('my.APP_URL')}}">Wuchna {{config('my.LOCAL_COUNTRY_NAME')}}</a></li>
                <li class="breadcrumb-item"><a class="text-dark" href="{{$city->full_link}}">{{ucwords($city->title)}}</a></li>
                <li class="breadcrumb-item"><a class="text-dark" href="{{$blog->full_link}}">{{ucwords(str_replace('-',' ',$blog->slug))}}</a></li>
                <li class="breadcrumb-item active text-dark" aria-current="page">{{ucwords($listing->title)}}</li>
            </ol>
        </nav>
            @endif
    </div>
    @endif

    @if($errors->any())
        <div class="col-md-12 my-3 alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)<li>{{$error}}</li>@endforeach
            </ul>
        </div>
    @endif
    @if(Session::has('message'))
        <div class="col-md-12 my-3 alert alert-danger">{{Session::get('message')}}</div>
    @endif

    @include('partials.custombanner',compact(['blog','category']))
    @if($ismobile && isset($listing->data['banner_img']))
        <div class="container mb-5">
            <img src="{{$listing->data['banner_img']}}" class="img-fluid" alt="{{$listing->title}} Banner" style="max-height:400px;"/>
        </div>
    @endif
@endsection

@section('main')
    <div class="row">


            <div class="col-md-9 blog-main">
                @if(isset($htmlsections['content-top']))
                    {!! $htmlsections['content-top'] !!}
                @endif

                <div class="col p-1 d-flex flex-column position-static">
                    @include('listing-in-listing-1')
                    @if(isset($htmlsections['content-between'])) {!! $htmlsections['content-between'] !!} @endif
                    @if($listing->products->count())
                        <br>
                        <h2>Products:</h2>
                        <div class="d-flex my-2" style="width:100%; overflow:scroll">
                            @foreach($listing->products()->latest()->take(6)->get() as $product)
                                <div class="col-md-3 my-3">
                                    <a class="card" style="max-height:310px;overflow: auto; text-decoration: none !important; color: #212529" href="{{$product->full_link}}">

                                        @if( isset($product->data['content_img']))<img src="{{$product->data['content_img']}}" class="zoom img-fluid" style="max-height:240px">@endif

                                        <div style="padding: .5rem 1rem;" ><h4 class="mb-2">{{$product->title}}</h4>
                                            {!! \Str::words($product->body,30) !!}</div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @include('listing-in-listing-2')
                    @include('addreviewform-in-listing')
                </div>

                @if(isset($htmlsections['content-bottom']))
                    {!! $htmlsections['content-bottom'] !!}
                @endif
                @if($listing->posts->count())
                    <br>
                    <div class="row my-2">
                        <div class="col-12"><h3>Latest posts:</h3></div>
                        @foreach($listing->posts()->latest()->take(4)->get() as $post)
                            <div class="col-md-6 my-3">
                                <a class="card" style="max-height:310px;overflow: auto; text-decoration: none !important; color: #212529" href="{{$post->full_link}}">

                                    @if( isset($post->data['content_img']))<img src="{{$post->data['content_img']}}" class="zoom img-fluid" style="max-height:240px">@endif

                                    <div style="padding: .75rem 1.25rem;" ><h3 class="mb-2">{{$post->title}}</h3>
                                        <h6 class="small text-muted">{{$post->created_at->diffForHumans()}}</h6>
                                        {!! \Str::words($post->body,30) !!}</div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <br>
                @endif





                    {{--                <nav class="blog-pagination">--}}
{{--                    <a class="btn btn-outline-primary" href="#">Older</a>--}}
{{--                    <a class="btn btn-outline-secondary disabled" href="#" tabindex="-1" aria-disabled="true">Newer</a>--}}
{{--                </nav>--}}

            </div><!-- /.blog-main -->

            <aside class="col-md-3 blog-sidebar p-4">
                @if(!$listing->user_id)
                    <a href="/claimbusiness/{{$listing->id}}" class="badge badge-danger p-2 my-3">Edit / Claim this listing</a>
                @endif
                @auth @if(auth()->id() == $listing->user_id)
                        <a href="/editbusiness/{{$listing->id}}" class="badge badge-danger" style="line-height: 11px;height:18px">Edit your listing</a>
                @endif @endauth


                    <div class="row my-3"><div class="col-12">
                            @if(isset($listing->raw['category']))<span class="d-inline-block mr-1 mb-2"><button class="btn btn-sm btn-outline-secondary">{{str_replace('₹','',$listing->raw['category'])}}</button></span>@endif
                            @if(isset($listing->business_data['services'])) @foreach($listing->business_data['services'] as $service) <span class="d-inline-block mr-1 mb-2"><button type="button" class="btn btn-sm btn-outline-secondary">{{ucwords($service)}}</button></span> @endforeach
                            @endif
                        </div></div>


{{--            @if(isset($htmlsections['aside-1']))--}}
{{--                    {!! $htmlsections['aside-1'] !!}--}}
{{--                @endif--}}
{{--                @if(isset($htmlsections['aside-2']))--}}
{{--                    {!! $htmlsections['aside-2'] !!}--}}
{{--                @endif--}}
{{--                @if(isset($htmlsections['aside-3']))--}}
{{--                    {!! $htmlsections['aside-3'] !!}--}}
{{--                @endif--}}

                @if(isset($listing->raw['knowledge_graph']['type']))
                    <div class="btn btn-outline-danger">{{$listing->raw['knowledge_graph']['type']}}</div>
                @endif

                    <div style="cursor: pointer;" class="mb-4" @click="showreportform"><a href="#">
                            <svg class="mr-2" id="flag-icon" width="15" height="15" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" >
                                <line x1="10" y1="10" x2="10" y2="90" style="stroke:rgb(255,0,0);stroke-width:6" />
                                <line x1="13" y1="13" x2="13" y2="90" style="stroke:rgb(255,0,0);stroke-width:6" />
                                <line x1="10" y1="10" x2="50" y2="10" style="stroke:rgb(255,0,0);stroke-width:6" />
                                <line x1="50" y1="10" x2="50" y2="15" style="stroke:rgb(255,0,0);stroke-width:6" />
                                <line x1="50" y1="15" x2="90" y2="15" style="stroke:rgb(255,0,0);stroke-width:6" />
                                <line x1="90" y1="15" x2="90" y2="50" style="stroke:rgb(255,0,0);stroke-width:6" />
                                <line x1="90" y1="50" x2="50" y2="50" style="stroke:rgb(255,0,0);stroke-width:6" />
                                <line x1="50" y1="50" x2="50" y2="45" style="stroke:rgb(255,0,0);stroke-width:6" />
                                <line x1="50" y1="45" x2="10" y2="45" style="stroke:rgb(255,0,0);stroke-width:6" />
                            </svg>
                            Report listing / comment</a></div>
                    <div class="alert alert-danger" v-show="reportingFinished">Thanks for reporting!</div>
                    @auth @if(auth()->user()->reportcases()->where('listing_id',$listing->id)->first())
                            <div class="alert alert-danger">You earlier reported this listing! <a href="/home">See its status here. </a></div>
                    @endif @endauth
                    @if(Auth::check() && auth()->id() == $listing->user_id)
                        <div class="alert alert-danger">You cannot report your own listing!</div>
                    @else
                        <form @submit.prevent="formsubmit" v-show="showingreportform"><br>
                            <label for="reason" class="small">Reason:</label>
                            <textarea ref="reason" id="reason" rows="2" name="comment" placeholder="Your reason for reporting this page / any comment" required class="form-control mb-1"></textarea>
                            <label for="email" class="small">Your Email Address:</label>
                            <input ref="email" type="text" id="email" name="email" placeholder="Enter your email address" required class="form-control" @if(Auth::check() && auth()->user()->email) disabled value="{{auth()->user()->email}}" @endif/>
                            <small class="text-muted">We will send OTP to confirm email</small><br>
                            <button class="btn btn-secondary btn-sm float-right mt-2" type="submit">Submit</button>
                        </form>
                <form @submit.prevent="otpsubmit" v-show="showingotpform">
                    <label for="otp" class="small">Enter OTP received at Email:</label>
                    <input ref="otp" type="text" id="otp" name="otp" placeholder="Enter OTP received at Email" required class="form-control"/>


                    <button class="btn btn-secondary btn-sm float-right mt-2" type="submit">Submit</button>
                </form>
                    @endif



{{--@include('aside')--}}

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



            </aside>



        </div><!-- /.row -->

    <div class="row">
        <div class="col-12 p-3 text-muted">
{{--            @if($listing->user_id)<p class="small">DISCLAIMER: Information on this page was added by a User at {{$listing->created_at->format('d-m-Y H:m:s')}}. @if($listing->user->phone) User verified an OTP via SMS to Mobile number or via email @endif Apart from verifying this OTP, Wuchna has not verified any information related to this listing, and is not associated with them in any way, and is not liable for the accuracy of this information, or does it take any responsibility of any injury, material damages and monetary losses due to profiles listed on this website. User caution is advised. Wuchna is a Business Directory, where information can be added by anybody, and we cannot confirm the authenticity / accuracy of the claims / information uploaded by users.</p>--}}
{{--            @else--}}
                <p class="small">DISCLAIMER: Information on this page was added by a contributor at {{$listing->created_at->format('d-m-Y H:m:s')}}. Wuchna has not verified any information related to this listing, and is not associated with them in any way, and is not liable for the accuracy of this information, or does it take any responsibility of any injury, material damages and monetary losses due to profiles listed on this website. User caution is advised. Wuchna is a Business Directory, where information can be added by anybody, and we cannot confirm the authenticity / accuracy of the claims / information uploaded by users.</p>
{{--            @endif--}}
        </div>
    </div>

    @if($listing->references->count())
        <!-- Sources Items Section -->
        <div class="container space-1">
            <!-- Title -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Sources and References:</h3>
            </div>
            <!-- End Title -->

            <div class="row">
                <div class="col-12">
                    <ol class="small text-muted">
                        @foreach($listing->references as $ref)
                            <li>{!!  str_replace($listing->title,'<mark>'.$listing->title.'</mark>',$ref->title) !!}: {!! str_replace($listing->title,'<mark>'.$listing->title.'</mark>',$ref->snippet) !!} <a href="{{$ref->link}}" rel="nofollow noreferrer" target="_blank">Link</a></li>
                            @if(Auth::check() && auth()->id() == 1)
                                <span class="text-body" style="font-size:16px; font-weight: bold">{{$ref->link}}</span>
                                <a target="_blank" href="/admindeletereference/{{$ref->id}}" class="btn btn-sm btn-danger">Delete Reference</a>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
        <!-- End Related Items Section -->
    @else
        @if($listing->blog)
            @php
            $blog = $listing->blog;
            $samebloglistings = Cache::remember('listings_of_blog_'.$blog->id,config('my.CACHE_HEAVY_DURATION'),function()use($blog){
            $alllistings = $blog->listings()->with('reviews')->withCount('reviews')->get();
            return $alllistings
            //                ->reject(function($listing){return ! $listing->reviews_count;})
            ->sortByDesc('reviews_count')
            ->take(12);
            });
            @endphp

        @each('listing-in-blog',$samebloglistings->where('id','!=',$listing->id)->take(2),'listing')
        @endif

    @endif




    @if(isset($listing->data['related_searches']))
        <!-- Sources Items Section -->
        <div class="container mb-5">
            <!-- Title -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">People also search for:</h3>
            </div>
            <!-- End Title -->

            <div class="row mx-1">
                <div class="col-12 small text-muted">
                    @foreach($listing->data['related_searches'] as $rr)
                        {{$rr['query']}}@unless($loop->last),&nbsp;@endunless
                    @endforeach
                </div>
            </div>
        </div>
        <!-- End Related Items Section -->
    @endif

    @php
        $allprioritylistings = Cache::remember('allprioritylistings',config('my.CACHE_HEAVY_DURATION'),function(){return \App\Listing::where('priority',true)->get();});
        $allpriorityblogs = Cache::remember('allpriorityblogs',config('my.CACHE_HEAVY_DURATION'),function(){return \App\Blog::where('priority',true)->get();});
    @endphp

    @if($allprioritylistings->count() || $allpriorityblogs->count() )
        <div class="container">
            <div class="row my-4">
                <div class="col-12 mb-3"><h2>Some Random Links:</h2><hr></div>
                @if($allprioritylistings->count() > 4)
                    @foreach($allprioritylistings->random(4) as $pl)
                        <div class="col-12 col-md-3"><a href="{{$pl->full_link}}">{{count($pl->keywords) ? $pl->keywords->first()->title : $pl->title}}</a></div>
                    @endforeach
                @endif
                @if($allpriorityblogs->count() > 4)
                    @foreach($allpriorityblogs->random(4) as $pb)
                        <div class="col-12 col-md-3"><a href="{{$pb->full_link}}">{{ucwords(str_replace('-',' ',$pb->slug))}}</a></div>
                    @endforeach
                @endif
            </div>
        </div>
    @endif


@endsection

@section('scripts')
{{--<script defer src="{{ asset('js/manifest.js') }}"></script>--}}
{{--<script defer src="{{ asset('js/vendor.js') }}"></script>--}}

{{--<script defer src="{{ asset('js/welcome2.js') }}"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/algoliasearch@4.5.1/dist/algoliasearch-lite.umd.js" integrity="sha256-EXPXz4W6pQgfYY3yTpnDa3OH8/EPn16ciVsPQ/ypsjk=" crossorigin="anonymous" defer></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/vue-instantsearch@3.4.2/dist/vue-instantsearch.js" integrity="sha256-n2IafdANKRLjFjtPQVSQZ6QlxBrYqPDZfi3IkZjDT84=" crossorigin="anonymous" defer></script>--}}
{{--<script src="/js/autocomplete.min.js"></script>--}}
{{--<script src="{{config('my.VUE_LINK')}}"></script>--}}
<script src="{{ asset('js/vue.js') }}"></script>
{{--<script src="{{ asset('js/app-with-vue.js') }}"></script>--}}
<script>
    var app = new Vue({
        el: '#app',
        data: {
            @include('partials.vue.data.search'),
            @include('partials.vue.data.listing-in-listing-1'),
            rating:4,

            showingreportform:false,showingotpform:false, reportid: null, reportingFinished: false,
            reviewprovided: false,showingreviewotpform:false,showingreviewform:true,reviewid:null,
            showingListingId:{{$listing->id}}, toShowCallData{{$listing->id}}: false,
        },
        methods: {
            @include('partials.vue.methods.search'),
            @include('partials.vue.methods.listing-in-listing-1'),
            showreportform(){this.showingreportform = true;},
            formsubmit(){
                axios.post('/reportlisting/{{$listing->id}}',{'reason':this.$refs.reason.value, 'email':this.$refs.email.value})
                .then(res => {
                    this.showingreportform = false;
                    if(res.data!='finished') {
                        this.reportid = res.data;
                        this.showingotpform = true;
                    }else{
                        this.reportingFinished=true;
                    }
                });
            },
            otpsubmit(){
                axios.post(`/otpsubmit/${this.reportid}`,{'otp':this.$refs.otp.value,'email':this.$refs.email.value})
                .then(res2=>{
                    if(res2.data == 'finished') {
                        this.showingotpform = false;
                        this.reportingFinished = true;
                    }else{
                        alert('OTP Not Correct. Please retry');
                    }
                });
            },
            createreview(){
                var myEditor = document.querySelector('#editor');
                var html = myEditor.children[0].innerHTML;

                @auth
                axios.post('/reviews',{'rating':this.$refs.rating.value,'review':html,'listing_id':{{$listing->id}} })
                .then(res=>{  if(res.data == 'thanks'){this.reviewprovided = true; this.showingreviewform = false;}   })
                .catch(res=>alert('Something went wrong'));
                @endauth

                @guest
                axios.post('/reviews',{'user_name':this.$refs.user_name.value,'user_email':this.$refs.user_email.value,'rating':this.$refs.rating.value,'review':html,'listing_id':{{$listing->id}} })
                .then(res=>{  this.showingreviewform = false; this.showingreviewotpform = true; this.reviewid=res.data;  })
                .catch(res=>alert('Something went wrong'));
                @endguest
            },
            reviewotpsubmit(){
                axios.post(`/reviewotpsubmit/${this.reviewid}`,{'otp':this.$refs.reviewotp.value,'user_email':this.$refs.user_email.value})
                    .then(res=>{
                        if(res.data == 'finished') {
                            this.showingreviewotpform = false;
                            this.reviewprovided = true;
                            alert('Thanks. You are now verified and logged in. You can now access Wuchna without asking OTP again, until you logoff');
                        }else if(res.data == 'review-ok-but-no-login') {
                            this.showingreviewotpform = false;
                            this.reviewprovided = true;
                            alert('Thanks for your review');
                        }
                        else{
                            alert('OTP Not Correct. Please retry');
                        }
                    });
            },
            ratingStar (star) {
                this.rating = star;
                if (this.rating == 1) {
                    this.$refs.star1.classList = "st0";
                    this.$refs.star2.classList = "st1";
                    this.$refs.star3.classList = "st1";
                    this.$refs.star4.classList = "st1";
                    this.$refs.star5.classList = "st1";
                    this.$refs.rating.value = 1;
                }
                else if (this.rating == 2) {
                    this.$refs.star1.classList = "st0";
                    this.$refs.star2.classList = "st0";
                    this.$refs.star3.classList = "st1";
                    this.$refs.star4.classList = "st1";
                    this.$refs.star5.classList = "st1";
                    this.$refs.rating.value = 2;
                }
                else if (this.rating == 3) {
                    this.$refs.star1.classList = "st0";
                    this.$refs.star2.classList = "st0";
                    this.$refs.star3.classList = "st0";
                    this.$refs.star4.classList = "st1";
                    this.$refs.star5.classList = "st1";
                    this.$refs.rating.value = 3;
                }
                else if (this.rating == 4) {
                    this.$refs.star1.classList = "st0";
                    this.$refs.star2.classList = "st0";
                    this.$refs.star3.classList = "st0";
                    this.$refs.star4.classList = "st0";
                    this.$refs.star5.classList = "st1";
                    this.$refs.rating.value = 4;
                }
                else if (this.rating == 5) {
                    this.$refs.star1.classList = "st0";
                    this.$refs.star2.classList = "st0";
                    this.$refs.star3.classList = "st0";
                    this.$refs.star4.classList = "st0";
                    this.$refs.star5.classList = "st0";
                    this.$refs.rating.value = 5;
                }
                else {
                    this.$refs.star1.classList = "st0";
                    this.$refs.star2.classList = "st0";
                    this.$refs.star3.classList = "st0";
                    this.$refs.star4.classList = "st0";
                    this.$refs.star5.classList = "st1";
                    this.$refs.rating.value = 4;
                }
            }

            }
    });
</script>
<script src="{{ asset('js/app.js') }}"></script>
@if( (! (Auth::check() && auth()->user()->reviews->where('listing_id',$listing->id)->count())) && (! (Auth::check() && auth()->id() == $listing->user_id)) )
<noscript><link rel="stylesheet" href="https://m3.wuchna.com/quill.snow.css"></noscript>
<noscript><link rel="stylesheet" href="/quill-emoji.css"></noscript>
<script async src="https://m3.wuchna.com/quill.js"></script>
<script async src="{{ asset('js/quill-script.js') }}"></script>

@endif
@endsection
