<!doctype html>
<html amp lang="en">
<head>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="/wuchna-16x16.png">
    <title>{{$blog->title}}</title>
    <link rel="canonical" href="{{$blog->full_link}}">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style>

    <noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>

    <style amp-custom>
        html { height: 100%; margin: auto; max-width: 500px; background:#fff}
        body {padding:10px; background: #fff}
        h1, h2, h3, h4, h5, h6, p { margin: 0;}
        h1{font-size: 2.25rem;font-weight: 500;line-height: 1.0;margin-bottom: 15px;}
        a { text-decoration: none; color: blue;}
        amp-img, .inline-block { display: inline-block;}
        .mr-3 {margin-right: 1rem}
        .ml-3 {margin-left: 1rem}
        .text-muted {color: #6c757d}
        ol.breadcrumb {padding: 10px 16px;list-style: none;background-color: #eee;}
        ol.breadcrumb li {display: inline;}
        ol.breadcrumb li+li:before {padding: 8px;color: black;content: "/\00a0";}
        ol.breadcrumb li a {color: #0275d8;text-decoration: none;}
        ol.breadcrumb li a:hover {color: #01447e;text-decoration: underline;}
        .text-dark{color: #000;}
        .border {border: 1px solid #dee2e6;}
        .p-3{padding: 0.7rem;}
        .st0 {fill: #FFC107;}.st1{fill:#E7EAF3;}
        .jumbotron {padding: 2rem 1rem;margin-bottom: 2rem;background-color: #e9ecef;border-radius: .3rem;}
        .wuchna-featured-snippet {border-radius: 20px;padding: 10px;padding-top: 20px;background: rgba(55,125,255,.5);margin: 10px;background-image: url(https://wuchna.com/w.png);background-repeat: no-repeat;padding-left: 30px;display: block;}
    </style>

</head>
<body>
<div><a href="/"><amp-img src="/w.png" alt="Wuchna India Logo" height="40" width="42"></amp-img></a></div>
<div>
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
      ,{
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
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{$city->full_link}}">{{ucwords($city->title)}}</a></li>
        @if($city->locality_count != 1) <li class="breadcrumb-item"><a href="{{config('my.APP_URL').'/'.$city->slug.'/'.$category->slug}}">{{ucwords($category->title)}} in {{$city->title}}</a></li> @endif
        <li class="breadcrumb-item active" aria-current="page">{{ucwords(str_replace('-',' ',$blog->slug))}}</li>
    </ol>
</div>

<div class="jumbotron">
    @if(!isset($blog->data['nobannercontent']))
        <div class="p-3">
            @if($blog->title)<h4 style="margin-bottom: 10px">{{$blog->title}}</h4>@endif
            @if($blog->description){!! $blog->description !!}@endif
        </div>
    @endif
</div>

<div>
    @if($listings->count())
        <h2 style="margin-top: 10px;">{{$listings->count()}} Results <small>for "{{ucwords(str_replace( '-',' ',$blog->slug))}}"</small></h2>
        <div>
        @foreach($listings as $listing)
            <a href="{{$listing->amp_link}}">
            @if($listing->pre_description)
                <div style="cursor: pointer; margin-top: 10px; margin-bottom: 10px;">
                    <span class="text-dark">{!! $listing->pre_description !!}</span>
                </div>
            @endif
            <div class="border p-3" id="listing_{{$listing->id}}"  style="cursor: pointer; margin-top:20px">
                <div style="display:flex; padding-top:5px; padding-bottom:5px;">
                    <amp-img height="40" width="60" alt="{{$listing->title}} Logo"
                             src="{{ isset($listing->data['logo_img']) ?  $listing->data['logo_img'] : ( isset($blog->data['logo_img']) ? $blog->data['logo_img'] : 'https://m'.rand(1,3).'.wuchna.com/images/320x320/img33.jpg' ) }}"
                    ></amp-img>
                     <h3 class="text-dark" style="margin-left: 10px; margin-top:5px">{{$listing->title}}</h3>
                </div>
                @if(isset($listing->raw['address'])) <span class="text-muted" style="text-decoration: none;">{{$listing->raw['address']}}</span> @endif
                <br>

                @if($listing->reviews->count())
                    <div style="margin-top: 10px;">
                        <div style="text-decoration: none;">
                            @php $avgrating = round(array_sum($listing->reviews->pluck('rating')->toArray()) /  count($listing->reviews->pluck('rating')) ,1 );  @endphp
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

                            <span class="ml-3" style="margin-bottom: 15px">{{$avgrating}}/5 ({{$listing->reviews->count()}} reviews)
                                                                    </span>
                            @foreach($listing->reviews->sortByDesc('created_at')->take(2) as $review)
                                <br>
                                <div style="display: flex; border-top: 1px solid #dee2e6; padding:8px">
                                    <div style="width:34%;margin-right:5px">
                                        <amp-img width="50" height="50" src="https://m1.wuchna.com/front/assets/img/100x100/img12.jpg" @if($review->user) alt="Image of {{$review->user->display_name}}" @endif></amp-img>
                                        <br>
                                        <span class="text-muted">{{$review->created_at->format('d M Y')}}</span>
                                        <h4 class="text-dark">{{$review->user_name ? $review->user_name : $review->user->display_name }}</h4>
                                    </div>
                                    <div style="width:60%">
                                        <ul style="display:flex;margin:0px;padding:0px;margin-bottom:10px">
                                            @if($review->rating >= 1)<li style="list-style: none">
                                                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/> </svg>
                                            </li>
                                            @else
                                                <li style="list-style: none">
                                                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                                                </li>
                                            @endif
                                            @if($review->rating >= 2)<li style="list-style: none">
                                                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/> </svg>
                                            </li>
                                            @else
                                                <li style="list-style: none">
                                                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                                                </li>
                                            @endif
                                            @if($review->rating >= 3)<li style="list-style: none">
                                                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/> </svg>
                                            </li>
                                            @else
                                                <li style="list-style: none">
                                                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                                                </li>
                                            @endif
                                            @if($review->rating >= 4)<li style="list-style: none">
                                                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/> </svg>
                                            </li>
                                            @else
                                                <li style="list-style: none">
                                                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                                                </li>
                                            @endif
                                            @if($review->rating >= 5)<li style="list-style: none">                                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/> </svg>
                                            </li>
                                            @else
                                                <li style="list-style: none">
                                                    <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
                                                </li>
                                            @endif
                                        </ul>
                                        <p class="text-dark" style="max-height:150px; overflow: auto;">{{$review->body}}</p>
                                    </div>
                                </div>
                        @endforeach
                        </div>
                    </div>
                @endif
            </div>
            @if($listing->post_description)
                <div style="margin-top: 10px;">
                    <span class="text-dark">{!! $listing->post_description !!}</span>
                </div>
            @endif
            </a>
            @endforeach
        </div>
    @endif
</div>

@if($blog->references->count())
    <div style="margin-top: 15px;">
        <h5>Sources and References:</h5>
        <p><ol>
            @foreach($blog->references as $ref)
                <li style="margin-bottom: 7px;" class="text-muted">
                    <b>{{$ref->title}}</b>: <small>{{\Illuminate\Support\Str::words($ref->snippet,30)}} <a href="{{$ref->link}}" rel="nofollow noreferrer" target="_blank">
                            <svg viewBox="0 -256 1850 1850" width="16" height="16"><g fill="blue" transform="matrix(1,0,0,-1,30.372881,1426.9492)"> <path stroke="blue" stroke-width="6" d="M 1408,608 V 288 Q 1408,169 1323.5,84.5 1239,0 1120,0 H 288 Q 169,0 84.5,84.5 0,169 0,288 v 832 Q 0,1239 84.5,1323.5 169,1408 288,1408 h 704 q 14,0 23,-9 9,-9 9,-23 v -64 q 0,-14 -9,-23 -9,-9 -23,-9 H 288 q -66,0 -113,-47 -47,-47 -47,-113 V 288 q 0,-66 47,-113 47,-47 113,-47 h 832 q 66,0 113,47 47,47 47,113 v 320 q 0,14 9,23 9,9 23,9 h 64 q 14,0 23,-9 9,-9 9,-23 z m 384,864 V 960 q 0,-26 -19,-45 -19,-19 -45,-19 -26,0 -45,19 L 1507,1091 855,439 q -10,-10 -23,-10 -13,0 -23,10 L 695,553 q -10,10 -10,23 0,13 10,23 l 652,652 -176,176 q -19,19 -19,45 0,26 19,45 19,19 45,19 h 512 q 26,0 45,-19 19,-19 19,-45 z" /></g>
                            </svg></a></small>
                </li>
            @endforeach
        </ol></p>
    </div>
@endif

<br><br>&nbsp;
<br><br>&nbsp;
</body>
</html>
