@extends('bootstraplayout')
@section('seo',view('partials.seo',[
    'title'=>$city->title. ' Business Directory',
    'description'=>'The Business Directory of '.$city->title.' city: provided by Wuchna',
    'canonical'=>$city->full_link
    ]))


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
      },{
        "@type": "ListItem",
        "position": 2,
        "name": "{{$city->title}}"
      }]
    }
    </script>
    <div class="container mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{config('my.APP_URL')}}">Wuchna {{config('my.LOCAL_COUNTRY_NAME')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ucwords($city->title)}}</li>
            </ol>
        </nav>
    </div>
@endsection

@section('main')
    <div class="row mb-5">
        <h1>{{$city->title}} City Business Directory </h1>
    </div>

    <div class="row" >
        @php
            $all_lps = Cache::remember('random_lps_of_city_'.$city->id, config('my.CACHE_HEAVY_DURATION'),function()use($city){
    return $city->blogs()->with('locality')->inRandomOrder()->take(70)->cursor()->pluck('locality.title','slug')->toArray();
});
            $allcharacters = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
        @endphp
        @if($city->locality && $city->locality->count() ==  1)
            <div class="col-12 mb-5">
                <h2 class="mb-3">Some Pages in {{$city->title}}</h2>
            </div>
            @foreach($city->blog as $blog)
                <div class="col-12 col-md-3">
                    <a href="{{$blog->full_link}}" class="text-body">{{ucwords(str_replace('-',' ',$blog->slug))}}</a>
                </div>
            @endforeach
        @elseif($city->locality && $city->locality->count() >  1)
            @foreach($allcharacters as $chara)
                <div class="col-6 col-md-3 mb-5">
                    <h2 class="mb-3"><u>{{strtoupper($chara)}}</u></h2>
                    @foreach(\Illuminate\Support\Arr::where($all_lps, function ($value) use($chara){return \Illuminate\Support\Str::startsWith(strtolower($value),$chara);}) as $slug => $locality)
                        <a href="{{$city->full_link}}/{{$slug}}" class="text-body">{{ucwords(str_replace('-',' ',$slug))}}</a><br>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>

    <div class="row small mt-4">
        <p>{{$city->title}} is a city in {{config('my.LOCAL_COUNTRY_NAME')}}, and on this page we provide you links of all the various businesses listed here. @if($city->locality && $city->locality->count()>1) Following are some of the localities in {{$city->title}}: @foreach(\Cache::remember('localities_of_city_'.$city->title, config('my.CACHE_HEAVY_DURATION'), function()use($city){ return $city->localities()->orderBy('title')->select('title','id')->get();})->take(8) as $l) {{$l->title}}@unless($loop->last), @endunless @endforeach @endif
        </p>
    </div>
@endsection

@section('scripts')
    {{--<script defer src="{{ asset('js/manifest.js') }}"></script>--}}
    {{--<script defer src="{{ asset('js/vendor.js') }}"></script>--}}

    {{--<script defer src="{{ asset('js/welcome2.js') }}"></script>--}}
    {{--<script src="https://cdn.jsdelivr.net/npm/algoliasearch@4.5.1/dist/algoliasearch-lite.umd.js" integrity="sha256-EXPXz4W6pQgfYY3yTpnDa3OH8/EPn16ciVsPQ/ypsjk=" crossorigin="anonymous" defer></script>--}}
    {{--<script src="https://cdn.jsdelivr.net/npm/vue-instantsearch@3.4.2/dist/vue-instantsearch.js" integrity="sha256-n2IafdANKRLjFjtPQVSQZ6QlxBrYqPDZfi3IkZjDT84=" crossorigin="anonymous" defer></script>--}}
    {{--<script src="/js/autocomplete.min.js"></script>--}}
{{--    <script src="{{ asset('js/app.js') }}"></script>--}}

    <script src="{{ asset('js/vue.js') }}"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                showingsearchinput: false,
                {{--@foreach($listings as $listing) display{{$listing->id}}: false, @endforeach--}}
            },
            methods: {
                focusInput() { this.$refs.searchbox.focus(); },
                showsearchinput(){ this.showingsearchinput = !this.showingsearchinput;
                    Vue.nextTick(() => { this.focusInput(); });
                },
            }
        });
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
