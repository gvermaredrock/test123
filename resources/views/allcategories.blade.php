@extends('bootstraplayout')
@section('seo',view('partials.seo',[
    'title'=>'Wuchna Sitemap: Links to all categories listed in Wuchna '.config('my.LOCAL_COUNTRY_NAME').'Directory',
    'description'=>'Wuchna Sitemap: Links to all categories listed in Wuchna '.config('my.LOCAL_COUNTRY_NAME').'Directory',
    'canonical'=>config('my.APP_URL').'/allcategories'
    ]))

@section('main')
    <div class="container space-2">
        <div class="w-md-80 w-lg-60 text-center mx-md-auto mb-5">
            <h1 class="h3 mb-3">All Categories in Wuchna {{config('my.LOCAL_COUNTRY_NAME')}} Network</h1>
        </div>

        <div class="row">
            @php
                $allcategories = \App\Category::all()->pluck('title','slug')->toArray();
                $allcharacters = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
            @endphp
            @foreach($allcharacters as $chara)
                <div class="col-6 col-md-2 mb-5">
                    <h2 class="mb-3"><u>{{strtoupper($chara)}}</u></h2>
                    @foreach(\Illuminate\Support\Arr::where($allcategories, function ($value) use($chara){return \Illuminate\Support\Str::startsWith(strtolower($value),$chara);}) as $slug => $name)
                        <a href="/{{$slug}}" class="text-body">{{$name}}</a><br><br>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/vue.js') }}"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                showingsearchinput: false,
            },
            methods: {
                showsearchinput(){
                    this.showingsearchinput = !this.showingsearchinput;
                },
            }
        });
    </script>
    <script defer src="{{ asset('js/app.js') }}"></script>
@endsection
