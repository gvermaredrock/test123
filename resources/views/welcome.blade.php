@extends('bootstraplayout')
@section('seo',view('partials.seo',[
    'title'=>'Wuchna Business Transaction Network '.config('my.LOCAL_COUNTRY_NAME'),
    'description'=>'An end-to-end Business Transaction Network and technology enabler for small and medium enterprises. Grow your business with Wuchna.',
    'canonical'=>config('my.APP_URL')
    ]))

@section('styles')
{{--    @foreach(Cache::remember('homeblogs',config('my.CACHE_LIGHT_DURATION'),function(){--}}
{{--    return \App\Blog::where('category_id',143)->whereNull('city_id')->inRandomOrder()->take(4)->get();--}}
{{--}) as $b)--}}
{{--        @if(isset($b->data['avatar_img']))<link rel="preload" as="image" href="{{$b->data['avatar_img']}}"> @endif--}}
{{--    @endforeach--}}
    <style> #searchbox{border-radius: inherit !important; height:inherit; border: none; width:100%} .zoom { transition: transform .2s;}   .zoom:hover { -ms-transform: scale(1.05); -webkit-transform: scale(1.05); transform: scale(1.05); } </style>
@endsection

@section('header')
   @include('partials.headerwithnosearch')
@endsection


@section('pagelinks')
    <div class="container mt-3">
        <div class="nav-scroller py-1 mb-2">
            <nav class="nav d-flex justify-content-between">
                @foreach(\App\City::whereIn('slug',['delhi','mumbai','chennai','kolkata','bengaluru'])->get() as $city)
                    <a class="p-2 text-dark" href="/{{$city->slug}}">{{$city->title}}</a>
                @endforeach
            </nav>
        </div>
    </div>
@endsection


@section('main')
    <div class="jumbotron mt-3">
        <h1 class="display-5">Join our Business Transaction Network !!!</h1>
        <p>We enable small and medium businesses around the world with the tools they need to stay competitive. We make it easy for businesses to manage their online presence and outreach, and provide softwares to easily transact with OUR users. </p>
{{--        <p>--}}
{{--            Problems we help solve:--}}
{{--                1. Having affordable SAAS easy-to-manage website, you can base your business softwares on. December. --}}
{{--                2. Having appointment booking softwares. --}}
{{--                3. Outsourcing and paying hourly? Bring others on workalong. Hire others internationally easily.--}}
{{--        </p>--}}
        <hr class="my-4">
        <div class="lead">
            <div class="mb-4">
                <input autofocus type="text" id="searchbox" class="form-control" placeholder="Search our {{config('my.LOCAL_COUNTRY_NAME')}} Directory ... "/>
                <div id="hits"></div>
            </div>
        </div>
                @include('admin.welcomestats')
    </div>

    @if(!$ismobile)
    <div class="row">
        <div class="col-12 mb-3"><h3>Latest Posts:</h3><hr></div>
        @foreach(Cache::remember('homeposts',config('my.CACHE_LIGHT_DURATION'),function(){
return \App\Post::with('listing')->whereNotNull('data->content_img')->latest()->take(4)->get();
}) as $post)
            <div class="col-6 col-md-3 mb-2">
                <a class="card" style="max-height:440px;overflow: auto; text-decoration: none !important; color: #212529" href="{{$post->full_link}}">

                    @if( isset($post->data['content_img']))<img src="{{str_replace('https://my.wuchna.com/storage/external','https://my-externalstorage'.rand(1,3).'.wuchna.com',$post->data['content_img'])}}" alt="Post by {{$post->listing->title}}" class="zoom img-fluid" style="max-height:240px">@endif

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

    <div class="row my-4">
        <div class="col-12 mb-3"><h2>Businesses Added Today:</h2><hr></div>
        @foreach($todaylistings as $l)
        <div class="col-12 col-md-4 my-2">
            <a href="{{$l->full_link}}"><h4>{{\Str::words($l->title,10)}}</h4></a>
            <p class="small text-muted">@if($l->blog)<a class="text-muted" href="{{$l->blog->full_link}}">{{ucwords(str_replace('-',' ',$l->blog->slug))}}</a> | @endif{{$l->created_at->diffForHumans()}}</p>
            <div class="border rounded small p-3" style="max-height: 180px; overflow-y: hidden">{!! \Str::words( strip_tags($l->description),30) !!}</div>
        </div>
        @endforeach
    </div>

    <div class="row my-4">
        <div class="col-12 mb-3"><h2>Reviews Added Today:</h2><hr></div>
        @foreach($todayreviews as $review)
            @if($review->listing)
        <div class="col-12 col-md-6 p-2">
            <div class="border rounded small p-2" style="max-height: 200px; overflow-y: auto">
                <div class="row mt-3">
                    <div class="col-md-1">
                        <img style="width:50px" src="https://m1.wuchna.com/front/assets/img/100x100/img12.jpg" alt="Image of {{$review->user_name ? $review->user_name : $review->user->display_name }}">
                    </div>
                    <div class="col-md-3">
                        <span class="text-muted mb-0">{{$review->created_at->format('d M Y')}}</span>
                        <h6 class="mb-0">{{$review->user_name ? $review->user_name : $review->user->display_name }}</h6>
                        @if(Auth::check() && auth()->id() == 1 && $review->user && $review->user->phone){{$review->user->phone}} @endif
                    </div>
                    <div class="col-md-8">
                        <small class="float-right mt-n2">
                            <i>
                                @if(isset($review->data['helpfulcount'])){{$review->data['helpfulcount']}} people found this helpful. Did you?
                                @else Found the review Helpful?
                                @endif
                                <button class="ml-1 btn btn-sm btn-outline-danger" @click="foundReviewHelpful({{$review->id}})">Yes</button>
                            </i>
                            @if(Auth::check() && auth()->id() == 1 && ! $review->user) <a href="/deletereview/{{$review->id}}" target="_blank" class="btn btn-danger btn-sm">Delete review</a>@endif
                            @if(Auth::check() && auth()->id() == 1) <a href="/editreview/{{$review->id}}" target="_blank" class="btn btn-warning btn-sm">Edit review</a>@endif

                        </small>
                        <ul class="list-inline mt-n1 mb-2">
                            @if($review->rating >= 1)<li class="list-inline-item mx-0">
                                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/> </svg>
                            </li>
                            @else
                                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                            @endif
                            @if($review->rating >= 2)<li class="list-inline-item mx-0">
                                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/> </svg>
                            </li>
                            @else
                                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                            @endif
                            @if($review->rating >= 3)<li class="list-inline-item mx-0">
                                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/> </svg>
                            </li>
                            @else
                                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                            @endif
                            @if($review->rating >= 4)<li class="list-inline-item mx-0">
                                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/> </svg>
                            </li>
                            @else
                                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                            @endif
                            @if($review->rating >= 5)<li class="list-inline-item mx-0">                                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/> </svg>
                            </li>
                            @else
                                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                            @endif
                        </ul>

                        <p class="mb-0" style="max-height:150px; overflow: auto;">{{\Str::words($review->body,20)}}</p>
                    </div>
                    <div class="col-md-12">
                        <div class="px-3"></div>
                        @if($review->vendor_reply)
                            <div class="bg-light rounded border px-3">
                                Owner Reply @if(isset($review->replied_at))(<span class="text-muted mb-0">{{$review->replied_at->format('d M Y')}}</span>)@endif: {{$review->vendor_reply}}
                            </div>
                        @endif
                    </div>
                </div>

                <p class="small text-muted mt-2 mb-0">Posted for: <a href="{{$review->listing->full_link}}">{{$review->listing->title}}</a> | @if($review->blog)<a class="text-muted" href="{{$review->blog->full_link}}">{{ucwords(str_replace('-',' ',$review->blog->slug))}}</a>@endif | {{$review->created_at->diffForHumans()}}</p>
            </div>
        </div>
            @endif
        @endforeach
    </div>



    @if($allprioritylistings->count() || $allpriorityblogs->count() )
    <div class="row my-4">
        <div class="col-12 mb-3"><h3>Some Random Links:</h3><hr></div>
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
    @endif


{{--    <div class="row">--}}
{{--        <div class="col-12 mb-3"><h3>From our Blog:</h3><hr></div>--}}
{{--        @foreach(Cache::remember('homeblogs',config('my.CACHE_LIGHT_DURATION'),function(){--}}
{{--return \App\Blog::where('category_id',143)->whereNull('city_id')->inRandomOrder()->take(4)->get();--}}
{{--}) as $b)--}}
{{--            <div class="col-6 col-md-3 mb-2">--}}
{{--                <a href="{{$b->full_link}}" class="card text-dark">--}}
{{--                    @if(isset($b->data['avatar_img']))<img class="card-img-top" src="{{$b->data['avatar_img']}}" alt="{{$b->title}}">@endif--}}
{{--                    <div class="card-body" style="padding:0.9rem"><h6 class="card-title">{{$b->title}}</h6></div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    </div>--}}

@endsection

@section('scripts')
    <script src="{{ asset('js/vue.js') }}"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {},
            methods :{
                foundReviewHelpful(id){
                    axios.post(`/foundreviewhelpful/${id}`).then(res=>alert('Thanks!'));
                },
            }
        });
    </script>
    <script defer src="{{ asset('js/app.js') }}"></script>
@endsection

