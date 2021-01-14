@extends('bootstraplayout')
@section('seo',view('partials.seo',[
    'title'=>$category->title. ' category Business Directory',
    'description'=>'Welcome to the Business Directory of '.$category->title.' category',
    'canonical'=>$category->full_link
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
        "name": "{{$category->title}}"
      }]
    }
    </script>
    <div class="container mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{config('my.APP_URL')}}">Wuchna {{config('my.LOCAL_COUNTRY_NAME')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ucwords($category->title)}}</li>
            </ol>
        </nav>
    </div>
@endsection

@section('main')
    @if($category->description) {!! $category->description !!} @endif
    <div class="row">
    @foreach($category->blogs()->whereNull('city_id')->cursor() as $blog)
        <div class="col-6 col-md-3 p-2">
            <a href="{{$blog->full_link}}" class="card">
                @if(isset($blog->data['avatar_img']))<img class="card-img-top" src="{{$blog->data['avatar_img']}}" alt="{{$blog->title}}">@endif
                <div class="card-body">
                    <h5 class="card-title">{{$blog->title}}</h5>
                </div>
            </a>
        </div>
    @endforeach
    @foreach($category->blogs()->whereNotNull('city_id')->inRandomOrder()->take(20)->cursor() as $blog)
        <div class="col-6 col-md-3 p-2">
            <a href="{{$blog->full_link}}" class="card">
                @if(isset($blog->data['avatar_img']))<img class="card-img-top" src="{{$blog->data['avatar_img']}}" alt="{{$blog->title}}">@endif
                <div class="card-body">
                    <h5 class="card-title">{{ucwords(str_replace('-',' ',$blog->slug))}}</h5>
                    <span class="text-dark">({{$blog->listing->count()}} Listings)</span>
                </div>
            </a>
        </div>
    @endforeach
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/vue.js') }}"></script>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                @include('partials.vue.data.search')
            },
            methods: {
                @include('partials.vue.methods.search')
            }
        });
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
