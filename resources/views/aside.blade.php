
{{--@if($aside['type']=='greyblock')--}}
{{--    @if(isset($aside['title']) && isset($aside['content']))--}}
{{--        <div class="p-4 mb-3 bg-light rounded">--}}
{{--            <h4 class="font-italic">{{$aside['title']}}</h4>--}}
{{--            <p class="mb-0">{{$aside['content']}}</p>--}}
{{--        </div>--}}
{{--    @else--}}
{{--        @if(isset($category->data['greyblock_title']) && isset($category->data['greyblock_content']))--}}
{{--            <div class="p-4 mb-3 bg-light rounded">--}}
{{--                <h4 class="font-italic">{{$category->data['greyblock_title']}}</h4>--}}
{{--                <p class="mb-0">{{$category->data['greyblock_content']}}</p>--}}
{{--            </div>--}}
{{--        @endif--}}
{{--    @endif--}}
{{--@endif--}}

{{--@if($aside['type']=='listoflinks')--}}
{{--<div class="p-4">--}}
{{--    <h4 class="font-italic">{{$aside['title']}}</h4>--}}
{{--    <ol class="list-unstyled mb-0">--}}
{{--        @foreach($aside['links'] as $obj)--}}
{{--            @dump($obj)--}}
{{--            <li><a--}}
{{--                    href="{{$obj['url']}}"--}}
{{--                @if(isset($obj['rel'])) rel="{{$obj['rel']}}" @endif--}}
{{--                @if(isset($obj['target'])) target="{{$obj['target']}}" @endif--}}
{{--                >{{$obj['title']}}</a></li>--}}
{{--        @endforeach--}}
{{--    </ol>--}}
{{--</div>--}}
{{--@endif--}}


<div class="row">
    <h4 class="ml-5">From our Blog:</h4>
    @foreach(\App\Blog::whereNull('city_id')->inRandomOrder()->take(5)->get() as $b)
        <div class="col-12 px-5 py-2">
            <a href="{{$b->full_link}}" class="card text-dark">
                @if(isset($b->data['avatar_img']))<img class="card-img-top" src="{{$b->data['avatar_img']}}" alt="{{$b->title}}">@endif
                <div class="card-body" style="padding:0.9rem"><h6 class="card-title">{{$b->title}}</h6></div>
            </a>
        </div>
    @endforeach
</div>
