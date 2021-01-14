<html><head><link rel="shortcut icon" href="/wuchna-16x16.png"><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" /><style>.st0{fill:#FFC107;}.st1{fill:#E7EAF3;}</style>
</head><body><a href="{{$listing->full_link}}" target="_blank" class="row p-2 border rounded shadow-sm" style="max-height: 240px; max-width:400px; text-decoration:none !important;background: url('{{ isset($listing->data['badge_img']) ?  $listing->data['badge_img'] : ( isset($listing->blog->data['banner_img']) ?  $listing->blog->data['banner_img'] : ( isset($listing->blog->category->data['banner_img']) ? $listing->blog->category->data['banner_img'] : 'https://m1.wuchna.com/images/1920x800/'.$listing->blog->category->slug.'.jpg' ) ) }}') ; " >
        <div class="col-12 mb-5" ><span class="px-0 py-1 font-weight-bold align-content-between bg-white rounded-sm text-dark" style="padding-bottom: .55rem!important;"><img src="https://my.wuchna.com/wuchna-logo.png" height="28px" style="margin-top:-2px"/> Verified Business </span> </div>
        <div class="col-12 px-2"><h4 style="@if(isset($listing->data['badge_color'])) color:{{$listing->data['badge_color']}} @else color: #FFC107 @endif" class="pl-2">{{$listing->title}}</h4></div>
        @if($listing->reviews->count())
            <div class="col-12" style="text-decoration: none !important;">
                @php $avgrating = round(array_sum($listing->reviews->pluck('rating')->toArray()) /  count($listing->reviews->pluck('rating')) ,1 );  @endphp
                <div>
                    @if($avgrating >= 1)
                        <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve">
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

                    <span class="ml-3" style="@if(isset($listing->data['badge_color'])) color:{{$listing->data['badge_color']}} @else color: #FFC107 @endif">{{$avgrating}}/5 ({{$listing->reviews->count()}} reviews)
                                    </span>
                </div>
                {{--        <div class="text-body border-top my-2 mt-3" v-show="displayReviewsOf{{$listing->id}}">--}}
                {{--            @foreach($listing->reviews->sortByDesc('created_at')->take(2) as $review)--}}
                {{--                @include('partials.review',compact(['review']))--}}
                {{--            @endforeach--}}
                {{--            <a href="#" @click.prevent="showListing({{$listing->id}})">See all reviews</a>--}}
                {{--        </div>--}}
            </div>
        @endif
    </a></body></html>
