<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @if(isset($product->data['meta_description']))<meta name="description" content="{{$product->data['meta_description']}}">@endif
    <link rel="shortcut icon" href="/wuchna-16x16.png">
    <title>{{$product->title}}</title>
    <link rel="canonical" href="{{$product->full_link}}">
    @include('partials.postscss')
    <style>.img-thumb{max-width:120px; border: 1px solid #ccc; padding:2px} .img-thumbs::-webkit-scrollbar { display: none;}</style>
</head>

<body>
@if(session('message')) <div class="alert alert-danger">{!! session('message') !!}</div> @else
    @if(Auth::check() && (auth()->id() == $product->listing->user_id) ) <div class="alert alert-danger"><a href="/home">Home</a>&nbsp;OR &nbsp;<a href="/editproduct/{{$product->id}}">Edit Product</a></div> @endif
@endif

<div class="container" style="padding-top:15px">
    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills float-right">
                @if( isset($listing->data['facebooklink']) && $listing->data['facebooklink'] )
                    <li class="nav-item">
                        <div class="mt-2 card mx-xs-0 mx-md-2 bg-light mr-3" style="min-width:60px; border:none;">
                            <a class="mt-md-0" style="color:gray" title="Connect with {{$listing->title}} on Facebook" href="{{$listing->data['facebooklink']}}" rel="nofollow noreferrer" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="50px" height="50px" viewBox="0 0 266.893 266.895" enable-background="new 0 0 266.893 266.895" xml:space="preserve"><path id="Blue_1_" fill="#3C5A99" d="M248.082,262.307c7.854,0,14.223-6.369,14.223-14.225V18.812 c0-7.857-6.368-14.224-14.223-14.224H18.812c-7.857,0-14.224,6.367-14.224,14.224v229.27c0,7.855,6.366,14.225,14.224,14.225 H248.082z"></path> <path id="f" fill="#FFFFFF" d="M182.409,262.307v-99.803h33.499l5.016-38.895h-38.515V98.777c0-11.261,3.127-18.935,19.275-18.935 l20.596-0.009V45.045c-3.562-0.474-15.788-1.533-30.012-1.533c-29.695,0-50.025,18.126-50.025,51.413v28.684h-33.585v38.895h33.585 v99.803H182.409z"></path></svg>
                            </a>
                        </div>
                    </li>
                @endif
                @if( isset($listing->data['twitterlink']) && $listing->data['twitterlink'] )
                    <li class="nav-item">
                        <div class="mt-2 card mx-xs-0 mx-md-2 mr-2" style="min-width:50px; border:none;">
                            <a class=" mt-md-0" title="Follow {{$listing->title}} on Twitter" href="{{$listing->data['twitterlink']}}" rel="nofollow" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="padding-left:5px" height="50px" viewBox="0 0 210 300" xml:space="preserve"><g id="T_1_"><path fill="#157DC3" d="M165.5,268.2H94.3l-1.5-0.1c-48.4-4.4-80.8-40.8-80.5-90.3V41.8c0-17.7,14.3-32,32-32s32,14.3,32,32v47.2 l92.9,0.9c17.7,0.2,31.9,14.6,31.7,32.3c-0.2,17.6-14.5,31.7-32,31.7c-0.1,0-0.2,0-0.3,0L76.3,153v24.9 c-0.1,22.7,14.1,25.6,21,26.3h68.2c17.7,0,32,14.3,32,32S183.2,268.2,165.5,268.2z"></path></g></svg>
                            </a>
                        </div>
                    </li>
                @endif
                @if( isset($listing->data['instagramlink']) && $listing->data['instagramlink'])
                    <li class="nav-item">
                        <div class="mt-2 card mx-xs-0 mx-md-2 mr-2" style="min-width:60px; border:none;">
                            <a class=" mt-md-0" title="Follow {{$listing->title}} on Instagram" href="{{$listing->data['instagramlink']}}" rel="nofollow" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" style="background: #f3ad5f; border-radius: 10px;" width="50" height="50" viewBox="0 0 132 132" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><linearGradient id="b"><stop offset="0" stop-color="#3771c8"/><stop stop-color="#3771c8" offset=".128"/><stop offset="1" stop-color="#60f" stop-opacity="0"/></linearGradient><linearGradient id="a"><stop offset="0" stop-color="#fd5"/><stop offset=".1" stop-color="#fd5"/><stop offset=".5" stop-color="#ff543e"/><stop offset="1" stop-color="#c837ab"/></linearGradient><radialGradient id="c" cx="158.429" cy="578.088" r="65" xlink:href="#a" gradientUnits="userSpaceOnUse" gradientTransform="matrix(0 -1.98198 1.8439 0 -1031.402 454.004)" fx="158.429" fy="578.088"/><radialGradient id="d" cx="147.694" cy="473.455" r="65" xlink:href="#b" gradientUnits="userSpaceOnUse" gradientTransform="matrix(.17394 .86872 -3.5818 .71718 1648.348 -458.493)" fx="147.694" fy="473.455"/></defs><path fill="url(#c)" d="M65.03 0C37.888 0 29.95.028 28.407.156c-5.57.463-9.036 1.34-12.812 3.22-2.91 1.445-5.205 3.12-7.47 5.468C4 13.126 1.5 18.394.595 24.656c-.44 3.04-.568 3.66-.594 19.188-.01 5.176 0 11.988 0 21.125 0 27.12.03 35.05.16 36.59.45 5.42 1.3 8.83 3.1 12.56 3.44 7.14 10.01 12.5 17.75 14.5 2.68.69 5.64 1.07 9.44 1.25 1.61.07 18.02.12 34.44.12 16.42 0 32.84-.02 34.41-.1 4.4-.207 6.955-.55 9.78-1.28 7.79-2.01 14.24-7.29 17.75-14.53 1.765-3.64 2.66-7.18 3.065-12.317.088-1.12.125-18.977.125-36.81 0-17.836-.04-35.66-.128-36.78-.41-5.22-1.305-8.73-3.127-12.44-1.495-3.037-3.155-5.305-5.565-7.624C116.9 4 111.64 1.5 105.372.596 102.335.157 101.73.027 86.19 0H65.03z" transform="translate(1.004 1)"/><path fill="url(#d)" d="M65.03 0C37.888 0 29.95.028 28.407.156c-5.57.463-9.036 1.34-12.812 3.22-2.91 1.445-5.205 3.12-7.47 5.468C4 13.126 1.5 18.394.595 24.656c-.44 3.04-.568 3.66-.594 19.188-.01 5.176 0 11.988 0 21.125 0 27.12.03 35.05.16 36.59.45 5.42 1.3 8.83 3.1 12.56 3.44 7.14 10.01 12.5 17.75 14.5 2.68.69 5.64 1.07 9.44 1.25 1.61.07 18.02.12 34.44.12 16.42 0 32.84-.02 34.41-.1 4.4-.207 6.955-.55 9.78-1.28 7.79-2.01 14.24-7.29 17.75-14.53 1.765-3.64 2.66-7.18 3.065-12.317.088-1.12.125-18.977.125-36.81 0-17.836-.04-35.66-.128-36.78-.41-5.22-1.305-8.73-3.127-12.44-1.495-3.037-3.155-5.305-5.565-7.624C116.9 4 111.64 1.5 105.372.596 102.335.157 101.73.027 86.19 0H65.03z" transform="translate(1.004 1)"/><path fill="#fff" d="M66.004 18c-13.036 0-14.672.057-19.792.29-5.11.234-8.598 1.043-11.65 2.23-3.157 1.226-5.835 2.866-8.503 5.535-2.67 2.668-4.31 5.346-5.54 8.502-1.19 3.053-2 6.542-2.23 11.65C18.06 51.327 18 52.964 18 66s.058 14.667.29 19.787c.235 5.11 1.044 8.598 2.23 11.65 1.227 3.157 2.867 5.835 5.536 8.503 2.667 2.67 5.345 4.314 8.5 5.54 3.054 1.187 6.543 1.996 11.652 2.23 5.12.233 6.755.29 19.79.29 13.037 0 14.668-.057 19.788-.29 5.11-.234 8.602-1.043 11.656-2.23 3.156-1.226 5.83-2.87 8.497-5.54 2.67-2.668 4.31-5.346 5.54-8.502 1.18-3.053 1.99-6.542 2.23-11.65.23-5.12.29-6.752.29-19.788 0-13.036-.06-14.672-.29-19.792-.24-5.11-1.05-8.598-2.23-11.65-1.23-3.157-2.87-5.835-5.54-8.503-2.67-2.67-5.34-4.31-8.5-5.535-3.06-1.187-6.55-1.996-11.66-2.23-5.12-.233-6.75-.29-19.79-.29zm-4.306 8.65c1.278-.002 2.704 0 4.306 0 12.816 0 14.335.046 19.396.276 4.68.214 7.22.996 8.912 1.653 2.24.87 3.837 1.91 5.516 3.59 1.68 1.68 2.72 3.28 3.592 5.52.657 1.69 1.44 4.23 1.653 8.91.23 5.06.28 6.58.28 19.39s-.05 14.33-.28 19.39c-.214 4.68-.996 7.22-1.653 8.91-.87 2.24-1.912 3.835-3.592 5.514-1.68 1.68-3.275 2.72-5.516 3.59-1.69.66-4.232 1.44-8.912 1.654-5.06.23-6.58.28-19.396.28-12.817 0-14.336-.05-19.396-.28-4.68-.216-7.22-.998-8.913-1.655-2.24-.87-3.84-1.91-5.52-3.59-1.68-1.68-2.72-3.276-3.592-5.517-.657-1.69-1.44-4.23-1.653-8.91-.23-5.06-.276-6.58-.276-19.398s.046-14.33.276-19.39c.214-4.68.996-7.22 1.653-8.912.87-2.24 1.912-3.84 3.592-5.52 1.68-1.68 3.28-2.72 5.52-3.592 1.692-.66 4.233-1.44 8.913-1.655 4.428-.2 6.144-.26 15.09-.27zm29.928 7.97c-3.18 0-5.76 2.577-5.76 5.758 0 3.18 2.58 5.76 5.76 5.76 3.18 0 5.76-2.58 5.76-5.76 0-3.18-2.58-5.76-5.76-5.76zm-25.622 6.73c-13.613 0-24.65 11.037-24.65 24.65 0 13.613 11.037 24.645 24.65 24.645C79.617 90.645 90.65 79.613 90.65 66S79.616 41.35 66.003 41.35zm0 8.65c8.836 0 16 7.163 16 16 0 8.836-7.164 16-16 16-8.837 0-16-7.164-16-16 0-8.837 7.163-16 16-16z"/></svg>
                            </a>
                        </div>
                    </li>
                @endif
                @if( isset($listing->data['linkedinlink']) && $listing->data['linkedinlink'])
                    <li class="nav-item">
                        <div class="mt-2 card mx-xs-0 mx-md-2 mr-3" style="min-width:60px; border:none;">
                            <a class="mt-md-0" title="Follow {{$listing->title}} on LinkedIn" href="{{$listing->data['linkedinlink']}}" rel="nofollow" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" height="50" width="50" viewBox="0 0 200 200">
                                    <defs>
                                        <linearGradient id="linearGradient3003" y2="425.4" gradientUnits="userSpaceOnUse" x2="-395.85" gradientTransform="matrix(-0.50335197,0,0,0.50335205,-148.17928,-158.80197)" y1="274.71" x1="-344.15">
                                            <stop stop-color="#FFF" offset="0"/>
                                            <stop stop-color="#FFF" stop-opacity="0" offset="1"/>
                                        </linearGradient>
                                    </defs>
                                    <rect transform="scale(-1,1)" rx="30.201" ry="30.201" height="199.98" width="200" y="0.011226" x="-200" fill="#069"/>
                                    <path opacity="0.7811159" d="m147.16,8.5612-94.32,0c-24.967,0-45.066,20.263-45.066,45.433v92.02c0.80814,19.647,3.9167,7.2266,9.8337-14.531,6.8768-25.287,29.273-47.388,56.547-63.952,20.817-12.642,44.119-20.715,86.533-21.483,24.054-0.43553,21.931-31.218-13.527-37.487z" fill="url(#linearGradient3003)"/>
                                    <path d="m63.992,167.85,0-90.884-30.208,0,0,90.884,30.208,0zm-15.1-103.3c10.534,0,17.091-6.9789,17.091-15.7-0.19632-8.9179-6.5566-15.703-16.891-15.703-10.333,0-17.09,6.7852-17.09,15.703,0,8.7216,6.5553,15.7,16.693,15.7h0.19633z" fill="#FFF"/>
                                    <path d="m80.712,167.85,30.208,0,0-50.754c0-2.7163,0.19632-5.4298,0.99398-7.3715,2.1838-5.4271,7.1542-11.048,15.499-11.048,10.931,0,15.304,8.3343,15.304,20.552v48.621h30.206v-52.112c0-27.916-14.903-40.905-34.778-40.905-16.296,0-23.451,9.1089-27.426,15.313h0.2017v-13.181h-30.208c0.39641,8.528,0,90.884,0,90.884z" fill="#FFF"/>
                                </svg>
                            </a>
                        </div>
                    </li>
                @endif
            </ul>
        </nav>
        <h3 class="text-muted"><a href="{{$listing->full_link}}">{{$listing->title}}</a></h3>
    </div>

{{--    @if( isset($product->data['headline']) || isset($product->data['lead']) || isset($product->data['primarybutton'])   )--}}
{{--        <div class="jumbotron">--}}
{{--            @if(isset($product->data['headline']))<h1 class="display-3">{{$product->data['headline']}}</h1>@endif--}}
{{--            @if(isset($product->data['lead']))<p class="lead">{{$product->data['lead']}}</p>@endif--}}
{{--            @if(isset($product->data['primarybutton']))<p><a class="btn btn-lg btn-success" href="{{$product->data['primarybuttonlink']}}" rel="nofollow" role="button">{{$product->data['primarybuttontext']}}</a></p>@endif--}}
{{--        </div>--}}
{{--    @endif--}}

        <div class="row">
            <div class="col-md-6">
                <h1>{{$product->title}}</h1>
                {!! $product->body !!}
                @if(isset($product->data['videolink']))
                    <div class="mt-3" style="overflow: hidden;"><iframe width="224" height="126" src="https://www.youtube.com/embed/{{str_replace('https://www.youtube.com/watch?v=','',$product->data['videolink'])}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                @endif
            </div>
            <div class="col-md-6 mb-5">
                @if(isset($product->data['content_img']))
                <a href="{{$product->data['content_img']}}" target="_blank"><img src="{{$product->data['content_img']}}" class="img-fluid"></a>
                <br>
                @endif
                <div class="d-flex img-thumbs" style="max-height:100px; width: 100%; overflow: scroll">
                    @if(isset($product->data['content_img2']))<a target="_blank" href="{{$product->data['content_img2']}}"><img src="{{$product->data['content_img2']}}" class="img-thumb" /></a>@endif
                    @if(isset($product->data['content_img3']))<a target="_blank" href="{{$product->data['content_img3']}}"><img src="{{$product->data['content_img3']}}" class="img-thumb" /></a>@endif
                    @if(isset($product->data['content_img4']))<a target="_blank" href="{{$product->data['content_img4']}}"><img src="{{$product->data['content_img4']}}" class="img-thumb" /></a>@endif
                    @if(isset($product->data['content_img5']))<a target="_blank" href="{{$product->data['content_img5']}}"><img src="{{$product->data['content_img5']}}" class="img-thumb" /></a>@endif
                </div>
                <br>
                @if( isset($product->data['ownlink']) && $product->data['ownlink'] ) <a class="mb-2 btn btn-sm btn-primary" title="Buy from website of {{$listing->title}}" href="{{$product->data['ownlink']}}" rel="nofollow" target="_blank">Buy from website</a> @endif
                @if( isset($product->data['amazonlink']) && $product->data['amazonlink'] ) <a class="mb-2 btn btn-sm btn-warning" title="Buy from Amazon" href="{{$product->data['amazonlink']}}" rel="nofollow" target="_blank">Buy from Amazon</a> @endif
                @if( isset($product->data['flipkartlink']) && $product->data['flipkartlink'] ) <a class="mb-2 btn btn-sm btn-success" title="Buy from Flipkart" href="{{$product->data['flipkartlink']}}" rel="nofollow" target="_blank">Buy from Flipkart</a> @endif
                @if( isset($product->data['indiamartlink']) && $product->data['indiamartlink'] ) <a class="mb-2 btn btn-sm btn-info" title="Buy from Indiamart" href="{{$product->data['indiamartlink']}}" rel="nofollow" target="_blank">Buy from Indiamart</a> @endif

            </div>
        </div>



    <footer class="footer">
        <small>{{$product->listing->title}}&nbsp;
            @if(isset($listing->raw['address']))<span class="text-muted">{{$listing->raw['address']}}</span><br>@endif
        </small>
    </footer>

</div> <!-- /container -->


</body>
</html>
