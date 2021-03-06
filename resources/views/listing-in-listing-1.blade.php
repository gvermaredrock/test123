<div class="row mx-n4">
        <div class="col-3"><img class="img-fluid" style="min-height:65px"
        src="{{ isset($listing->data['logo_img']) ?  $listing->data['logo_img'] : ( isset($blog->data['logo_img']) ? $blog->data['logo_img'] : 'https://m'.rand(1,3).'.wuchna.com/images/320x320/img33.jpg' ) }}"
            alt="{{$listing->title}} Logo"></div>
{{--        @if(url()->current() != $listing->full_link)<a href="{{$listing->full_link}}" style="text-decoration: none">@endif--}}
        <div class="col-9">
            <h1 class="mb-0" style="min-width:120px">{{$listing->title}}</h1>
{{--                <span class="badge badge-dark">--}}
{{--                <span class="greendot mt-2 mx-2"></span> <span class="mr-2" style="color:lime;">Online</span>--}}
{{--                <span class="reddot mt-2 mx-2"></span><span class="mr-2" style="color: orangered;">Offline</span>--}}
{{--                </span>--}}
            @if(Auth::check() && auth()->id() == 1)
                <small>@if($listing->phone)<a target="_blank" rel="nofollow noreferrer" href="https://wa.me/91{{$listing->phone}}">Whatsapp {{$listing->phone}}</a> @endif @if(isset($listing->raw['phone'])) {{$listing->raw['phone']}} @endif</small>
            @endif
        </div>
    @if(Auth::check() && auth()->id() == 1)
        <div class="col-12" style="background: #e9caca">
            <a href="/admineditbusiness/{{$listing->id}}" class="ml-4 btn btn-danger btn-sm">Edit</a>
            @if($listing->keywords->isNotEmpty()) Keywords: {{implode(', ',$listing->keywords->pluck('title')->toArray())}}
            @endif

            <br>
            @if($listing->owner) Owned by User ID: {{$listing->owner->id}}   @if($listing->owner->phone && !isset($listing->data['nowhatsapp']) )  <a href="https://wa.me/91{{$listing->owner->phone}}">Whatsapp {{$listing->owner->phone}}</a> @if(! \Str::contains($listing->owner->email,'@wuchna.com')) Email <a href="mailto:{{$listing->owner->email}}">{{$listing->owner->email}}</a> @endif @endif @endif
            <br>
            <form method="POST" action="/adminaddlistingmeta">
                @csrf
                <input type="hidden" name="listing_id" value="{{$listing->id}}" />
                <input type="text" name="title" /><button class="btn btn-sm btn-danger">Add Meta</button>
            </form>
{{--            <a href="/adminleadsanalysis/{{$listing->id}}" class="ml-2 btn btn-danger btn-sm">Leads Analysis</a>--}}
            <br>
            @if($listing->leads->count())
                Total Leads: {{$listing->leads->count()}}
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">When</th>
                            <th scope="col">User Name</th>
                            <th scope="col">User Phone Number</th>
                            <th scope="col">User Email</th>
                            <th scope="col">Vendor Phone</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($listing->leads()->latest()->take(20)->cursor() as $lead)
                            <tr>
                                <th scope="row">{{$lead->created_at->diffForHumans()}}</th>
                                <td>{{$lead->user->name}}</td>
                                <td>{{$lead->user->phone}}</td>
                                <td>{{$lead->user->email}}</td>
                                <td>@if($listing->phone)<a target="_blank" rel="nofollow noreferrer" href="https://wa.me/91{{$listing->phone}}">Whatsapp {{$listing->phone}}</a> @endif @if($listing->raw['phone']) {{$listing->raw['phone']}} @endif</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <hr class="my-3">
            @endif
            <br>

            <h3>Total Interactions: {{$listing->interactions->count()}}</h3>
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <form method="POST" action="/addleadinteraction/{{$listing->id}}">
                        @csrf
                        <textarea class="form-control" name="body">@if($listing->interactions->count()){{$listing->interactions()->latest()->first()->body}}@endif</textarea>
                        <select name="relationshipstage">
                            <option selected disabled>--</option>
                            <option value="1" @if(isset($listing->data['relationshipstage']) && $listing->data['relationshipstage'] == 1) selected @endif  >Stage 1: We whatsapped</option>
                            <option value="2"  @if(isset($listing->data['relationshipstage']) && $listing->data['relationshipstage'] == 2) selected @endif>Stage 2: They replied</option>
                            <option value="3"  @if(isset($listing->data['relationshipstage']) && $listing->data['relationshipstage'] == 3) selected @endif >Stage 3: Priority requested</option>
                            <option value="4"  @if(isset($listing->data['relationshipstage']) && $listing->data['relationshipstage'] == 4) selected @endif >Stage 4: Conversion</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-danger">Save</button>
                    </form>
                </div>
                <div class="col-md-12 col-lg-4">
                    @if($listing->phone)
                        @if( isset($listing->data['nowhatsapp']))
                            <button class="btn btn-sm btn-secondary">Whatsapp not available at this number</button>
                        @else
                            <a href="/nowhatsapp/{{$listing->id}}" class="btn btn-sm  btn-danger">No Whatsapp</a>
                        @endif
                        <a href="/deletephone/{{$listing->id}}" class="btn btn-sm btn-info">Delete Phone number</a>
                    @else
                        <button class="btn btn-sm btn-secondary">No Phone number for this listing</button>
                    @endif
                </div>
            </div>
            @if($listing->interactions->count())


            @foreach($listing->interactions as $int)
                    <br />
{{$int->created_at->diffForHumans()}}: {!! $int->body !!}
                @endforeach
            @endif
            @if($listing->owner && $listing->owner->interactions->count())
                Total Owner Interactions: {{$listing->owner->interactions->count()}}
                @foreach($listing->owner->interactions as $int2)
                    <br />
{{$int2->created_at->diffForHumans()}}: {!! $int2->body !!}
                @endforeach
            @endif
        </div>
    @endif

{{--    @if(url()->current() != $listing->full_link) </a> @endif--}}
    </div>
    <div class="nav-scroller my-3">
        <nav class="nav d-flex justify-content-start mt-0">
{{--            @if(Auth::check() &&  $listing->email)--}}
{{--            <a class="btn btn-danger rounded-pill mr-3" >Send message</a>--}}
{{--                <textarea placeholder="Type your message here ... "></textarea>--}}
            @if($listing->phone || isset($listing->raw['phone']) )
            <a class="btn btn-danger rounded-pill mr-3" href="#" {{-- @click.prevent="showClickToCallForm({{$listing->id}})" --}} v-show="! toShowCallData{{$listing->id}}">Click to Call</a>
            @if($listing->phone && !isset($listing->data['nowhatsapp']))
            <a v-show="toShowCallData{{$listing->id}}" title="Connect on Whatsapp" href="https://wa.me/91{{ltrim( str_replace(' ','',$listing->phone) , 0)}}" rel="nofollow noreferrer" target="_blank" style="cursor: pointer;margin-right: 5px">

                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="30" width="30" style="margin-top:6px" viewBox="50 50 500 500"><defs><linearGradient x1=".5" y1="0" x2=".5" y2="1" id="a"><stop stop-color="#20B038" offset="0%"/><stop stop-color="#60D66A" offset="100%"/></linearGradient><linearGradient x1=".5" y1="0" x2=".5" y2="1" id="b"><stop stop-color="#F9F9F9" offset="0%"/><stop stop-color="#FFF" offset="100%"/></linearGradient><linearGradient xlink:href="#a" id="f" x1="270.265" y1="1.184" x2="270.265" y2="541.56" gradientTransform="scale(.99775 1.00225)" gradientUnits="userSpaceOnUse"/><linearGradient xlink:href="#b" id="g" x1="279.952" y1=".811" x2="279.952" y2="560.571" gradientTransform="scale(.99777 1.00224)" gradientUnits="userSpaceOnUse"/><filter x="-.056" y="-.062" width="1.112" height="1.11" filterUnits="objectBoundingBox" id="c"><feGaussianBlur stdDeviation="2" in="SourceGraphic"/></filter><filter x="-.082" y="-.088" width="1.164" height="1.162" filterUnits="objectBoundingBox" id="d"><feOffset dy="-4" in="SourceAlpha" result="shadowOffsetOuter1"/><feGaussianBlur stdDeviation="12.5" in="shadowOffsetOuter1" result="shadowBlurOuter1"/><feComposite in="shadowBlurOuter1" in2="SourceAlpha" operator="out" result="shadowBlurOuter1"/><feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.21 0" in="shadowBlurOuter1"/></filter><path d="M576.337 707.516c-.018-49.17 12.795-97.167 37.15-139.475L574 423.48l147.548 38.792c40.652-22.23 86.423-33.944 133.002-33.962h.12c153.395 0 278.265 125.166 278.33 278.98.025 74.548-28.9 144.642-81.446 197.373C999 957.393 929.12 986.447 854.67 986.48c-153.42 0-278.272-125.146-278.333-278.964z" id="e"/></defs><g fill="none" fill-rule="evenodd"><g transform="matrix(1 0 0 -1 -542.696 1013.504)" fill="#000" fill-rule="nonzero" filter="url(#c)"><use filter="url(#d)" xlink:href="#e" width="100%" height="100%"/><use fill-opacity=".2" xlink:href="#e" width="100%" height="100%"/></g><path transform="matrix(1 0 0 -1 41.304 577.504)" fill-rule="nonzero" fill="url(#f)" d="M2.325 274.421c-.014-47.29 12.342-93.466 35.839-134.166L.077 1.187l142.314 37.316C181.6 17.133 225.745 5.856 270.673 5.84h.12c147.95 0 268.386 120.396 268.447 268.372.03 71.707-27.87 139.132-78.559 189.858-50.68 50.726-118.084 78.676-189.898 78.708-147.968 0-268.398-120.386-268.458-268.358"/><path transform="matrix(1 0 0 -1 31.637 586.837)" fill-rule="nonzero" fill="url(#g)" d="M2.407 283.847c-.018-48.996 12.784-96.824 37.117-138.983L.072.814l147.419 38.654c40.616-22.15 86.346-33.824 132.885-33.841h.12c153.26 0 278.02 124.724 278.085 277.994.026 74.286-28.874 144.132-81.374 196.678-52.507 52.544-122.326 81.494-196.711 81.528-153.285 0-278.028-124.704-278.09-277.98zm87.789-131.724l-5.503 8.74C61.555 197.653 49.34 240.17 49.36 283.828c.049 127.399 103.73 231.044 231.224 231.044 61.74-.025 119.765-24.09 163.409-67.763 43.639-43.67 67.653-101.726 67.635-163.469-.054-127.403-103.739-231.063-231.131-231.063h-.09c-41.482.022-82.162 11.159-117.642 32.214l-8.444 5.004L66.84 66.86z"/><path d="M242.63 186.78c-5.205-11.57-10.684-11.803-15.636-12.006-4.05-.173-8.687-.162-13.316-.162-4.632 0-12.161 1.74-18.527 8.693-6.37 6.953-24.322 23.761-24.322 57.947 0 34.19 24.901 67.222 28.372 71.862 3.474 4.634 48.07 77.028 118.694 104.88 58.696 23.146 70.64 18.542 83.38 17.384 12.74-1.158 41.11-16.805 46.9-33.03 5.791-16.223 5.791-30.128 4.054-33.035-1.738-2.896-6.37-4.633-13.319-8.108-6.95-3.475-41.11-20.287-47.48-22.603-6.37-2.316-11.003-3.474-15.635 3.482-4.633 6.95-17.94 22.596-21.996 27.23-4.053 4.643-8.106 5.222-15.056 1.747-6.949-3.485-29.328-10.815-55.876-34.485-20.656-18.416-34.6-41.16-38.656-48.116-4.053-6.95-.433-10.714 3.052-14.178 3.12-3.113 6.95-8.11 10.424-12.168 3.467-4.057 4.626-6.953 6.942-11.586 2.316-4.64 1.158-8.698-.579-12.172-1.737-3.475-15.241-37.838-21.42-51.576" fill="#FFF"/></g></svg>
                </a>
            @endif
            <a v-show="toShowCallData{{$listing->id}}" title="Call phone number" href="tel:+91{{ltrim( str_replace([' ','+'],['','0'],($listing->phone ?? $listing->raw['phone'])  ) , 0)}}" class="mr-0 btn">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve" width="30">
<g><path fill="red" d="M188.2,10C90.2,10,10,90.2,10,188.2v623.6c0,98,80.2,178.2,178.2,178.2h623.6c98,0,178.2-80.2,178.2-178.2V188.2C990,90.2,909.8,10,811.8,10H188.2L188.2,10z M749.6,795c-45.2,45.2-213.8,2.3-380.4-164.2C202.7,464.2,159.8,295.6,205,250.4c39.2-39.2,86.9-107.6,158.6-18.5c71.7,89.1,36.4,114.1-4,154.5c-28.2,28.3,30.8,99.8,92.5,161.5c61.7,61.7,133.2,120.7,161.4,92.4c40.5-40.4,65.4-75.6,154.6-4C857.3,708,788.8,755.8,749.6,795L749.6,795z"/></g>
</svg>
                    </a>
            <a v-show="toShowCallData{{$listing->id}}" class="row btn-outline mt-n1 mx-0" @click.prevent="copyToClipboard({{$listing->id}})">
                <span class="col-12"> <span href="#" class="small float-left" >Copy Phone Number:</span> </span>
                <span class="col-12"> <input type="text" style="float:left; width:140px !important;border:0; font-size:80%" id="hiddeninput-{{$listing->id}}" value="{{ltrim( str_replace([' ','+'],'',($listing->phone ?? $listing->raw['phone'])  ) , 0)}}"/> </span>
            </a>

            @endif

            @if(isset($listing->raw['link']))
                    @if(\Illuminate\Support\Str::contains($listing->raw['link'],config('my.rejectdomains')))
                    @else
                    <a class="mr-3 btn btn-success rounded-pill" @if(isset($listing->raw['dofollow'])) @if( $listing->raw['dofollow']) @else rel="nofollow noreferrer" @endif @else rel="nofollow noreferrer" @endif target="_blank"
            href=
            @if(isset(parse_url($listing->raw['link'])['scheme']) && isset(parse_url($listing->raw['link'])['host']))
                "{{parse_url($listing->raw['link'])['scheme']}}://{{parse_url($listing->raw['link'])['host']}}"
            @else
                "{{ isset(($listing->raw['link'])['path']) ? "http://{{parse_url($listing->raw['link'])['path']" : 'http://www.'.$listing->raw['link'] }}"
            @endif
            >Visit Website</a>
                    @endif
            @endif

            @if(isset($listing->raw['address']))<a class="mr-3 btn btn-dark rounded-pill" rel="nofollow noreferrer" target="_blank"
   href="https://www.google.com/maps/search/{{str_replace([' ','/'],['+','%2F'],$listing->raw['address'])}}"
            >See on Map</a>@endif

        </nav>
    </div>

@guest
<form @submit.prevent="clickToCallFormSubmitted" class="bg-light border p-4 rounded" v-show="showingClickToCallForm">
    <label for="clicktocallemail" class="small">Your Email Address:</label>
    <input ref="clicktocallemail" type="email" id="clicktocallemail" name="clicktocallemail" placeholder="Enter your email address" required class="form-control"/>
    <small class="text-muted">We will send OTP to confirm email</small><br>
    <button class="btn btn-danger btn-sm float-right mt-2" type="submit">Submit</button>
</form>
<form @submit.prevent="clickToCallOtpSubmitted" class="bg-light border p-4 rounded" v-show="showingClickToCallOtp">
    <label for="clicktocallotp" class="small">Enter OTP received at email:</label>
    <input ref="clicktocallotp" type="text" id="clicktocallotp" name="clicktocallotp" placeholder="Enter OTP received at email" required class="form-control"/>
    <button class="btn btn-secondary btn-sm float-right mt-2" type="submit">Submit</button>
</form>
@endguest

    <div class="d-flex mt-0">
        @if(isset($listing->business_data['tags']))
            @foreach($listing->business_data['tags'] as $tag)
                @if($tag['type'] == 'award')
                    <div class="mt-2 card mx-xs-0 mx-md-2 p-2 bg-light mr-3" style="min-width:65px; border:none;">
                        <a class="mt-md-0" style="color:gray" title="{{$tag['description']}}">
                            <svg width="40" xmlns="http://www.w3.org/2000/svg" fill="#f1c688" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 612 612" xml:space="preserve"><g>
                <path d="M607.47,58.142c-3.466-3.95-8.466-6.215-13.722-6.215h-84.891c0.388-10.101,0.335-16.498,0.315-17.851 c-0.141-9.979-8.269-17.994-18.25-17.994H121.078c-9.98,0-18.11,8.017-18.25,17.994c-0.02,1.355-0.073,7.752,0.315,17.851H18.252 c-5.255,0-10.254,2.265-13.72,6.215c-3.466,3.951-5.06,9.203-4.376,14.414c0.668,5.101,17.27,125.821,92.686,203.749 c3.439,3.553,8.17,5.559,13.115,5.559h62.337c9.81,14.175,21.063,27.33,34.029,38.828l14.864,73.314 c-11.909,11.611-19.327,27.809-19.327,45.716v2.021c0,15.11,5.285,29.003,14.09,39.952c-4.038,2.24-8.253,4.847-12.507,7.891 c-20.102,14.379-44.592,41.158-47.109,87.081c-0.275,5.007,1.522,9.904,4.97,13.545c3.448,3.64,8.24,5.703,13.253,5.703h270.88 c5.013,0,9.807-2.064,13.253-5.703c3.448-3.643,5.244-8.539,4.97-13.545c-2.516-45.923-27.006-72.702-47.108-87.081 c-4.254-3.043-8.469-5.65-12.507-7.891c8.803-10.948,14.088-24.841,14.088-39.952v-2.021c0-17.906-7.416-34.107-19.327-45.716 l14.864-73.314c12.967-11.5,24.219-24.653,34.029-38.828h62.337c4.946,0,9.678-2.006,13.115-5.559 c75.417-77.928,92.018-198.648,92.687-203.749C612.528,67.345,610.934,62.094,607.47,58.142z M234.366,439.722 c0-15.097,12.282-27.377,27.377-27.377h88.515c15.095,0,27.377,12.28,27.377,27.377v2.021c0,15.095-12.282,27.377-27.377,27.377 h-88.515c-15.095,0-27.377-12.282-27.377-27.377V439.722z M381.404,296.852c-3.218,2.662-5.427,6.348-6.257,10.44l-13.9,68.55 H250.751l-13.898-68.55c-0.83-4.091-3.039-7.778-6.257-10.44c-75.394-62.332-88.535-195.845-90.804-244.267h332.417 C469.941,101.011,456.8,234.519,381.404,296.852z M113.885,245.362C67.98,194.379,47.765,123.135,40.202,88.43h65.534 c4.33,42.496,15.022,103.083,41.303,156.932H113.885z M420.026,559.412H191.974c11.386-39.299,48.439-51.516,56.748-53.789 h114.543C371.749,507.951,408.665,520.202,420.026,559.412z M498.117,245.362h-33.158 c26.283-53.847,36.974-114.434,41.306-156.932h65.56C564.308,123.095,544.161,194.243,498.117,245.362z"/>
            </g></svg>
                        </a>
                    </div>
                @endif
            @endforeach
        @endif

        @if(isset($listing->data['zomatolink']) && $listing->data['zomatolink'])
            <div class="mt-2 card mx-xs-0 mx-md-2 bg-light mr-3" style="min-width:60px; border:none;">
                <a class=" mt-md-0" style="color:gray" title="Order Online from {{$listing->title}} via Zomato" href="{{$listing->data['zomatolink']}}" rel="nofollow noreferrer" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 652 652" width="70" xml:space="preserve">
                        <g>
                            <path id="Rectangle-Copy-10" fill="#E23744" class="zomato" d="M82.3,71h475.3c6.8,0,12.3,5.5,12.3,12.3v475.3c0,6.8-5.5,12.3-12.3,12.3H82.3
c-6.8,0-12.3-5.5-12.3-12.3V83.3C70,76.5,75.5,71,82.3,71z"/>
                            <g id="Group" fill="#FFFFFF" transform="translate(31.000000, 221.000000)">
                                <path id="zomato-copy-10" d="M136.6,75.4l-0.4,12.7l-33.1,36c13.8,0,22.6-0.1,27.6-0.4c-1.5,6.8-2.7,12.4-3.9,20.8
    c-6.6-0.6-17-0.7-27.4-0.7c-11.6,0-21.7,0.1-29.8,0.7l0.3-12.8l33.1-35.8c-14.5,0-19.8,0.1-25.8,0.3c1.3-6.4,2.3-13.5,3.2-20.6
    C91,75.8,95.2,76,108.8,76C121.5,76,128.6,75.8,136.6,75.4z M160.1,115.2c0,8.5,2.8,12.8,7.6,12.8c6.4,0,11.4-10.3,11.4-22.9
    c0-8.6-2.8-12.8-7.4-12.8C165.3,92.3,160.1,102.5,160.1,115.2z M203.6,104.1c0,23.1-16.3,42.4-38,42.4
    c-19.4,0-29.4-13.2-29.4-30.5c0-23,16.5-42.2,38-42.2C193.9,73.8,203.6,87,203.6,104.1z M463.9,115.2c0,8.5,2.8,12.8,7.6,12.8
    c6.4,0,11.4-10.3,11.4-22.9c0-8.6-2.8-12.8-7.4-12.8C469.1,92.3,463.9,102.5,463.9,115.2z M508.2,103.7
    c0,23.4-16.6,42.9-38.5,42.9c-19.7,0-29.7-13.4-29.7-30.9c0-23.3,16.7-42.8,38.5-42.8C498.4,72.9,508.2,86.3,508.2,103.7z
     M315.3,96.2c1.7-11.9,0.8-22.6-12.4-22.6c-9.6,0-19.9,8.1-27.2,21.6c1.6-11.2,0.7-21.6-12.4-21.6c-9.8,0-20.5,8.5-27.8,22.6
    c1.9-9.2,1.5-19.7,0.9-21.9c-7.6,1.3-14.2,2-23.5,2.2c0.3,6.4-0.1,14.8-1.3,22.7l-3.1,20.9c-1.2,8.2-2.5,17.7-3.9,23.7h24.7
    c0.1-3.6,1.1-9.3,1.7-14.4l2.1-14.4c1.7-9.3,9.2-20.4,14.9-20.4c3.3,0,3.2,3.2,2.3,9.2l-2.4,16.2c-1.2,8.2-2.5,17.7-3.9,23.7h25
    c0.1-3.6,0.9-9.3,1.6-14.4l2.1-14.4c1.7-9.3,9.2-20.4,14.9-20.4c3.3,0,3.2,3.1,2.7,7.2l-6,41.8h22.8L315.3,96.2z M434.6,124.2
    l-2.7,16.5c-4.1,2.2-11.8,5.4-20.7,5.4c-15.1,0-18.2-8.1-15.8-25.2l3.9-27.6h-7.5l2.1-17.9l8.1-0.4l3.1-13l23-8.6L425.2,75H441
    c-0.5,2.2-2.4,14.5-2.9,18.3h-15.4l-3.5,25.5c-0.9,6.6-0.4,8.9,4.1,8.9C426.7,127.7,431.6,125.7,434.6,124.2z"/>
                                <path id="a-copy-7" fill="#FFFFFF" d="M347.5,132c8.4-1,14.1-9.1,15.5-17.1l0.2-2.2c-3.6-0.8-8.8-1.4-13.8-0.8
    c-4.8,0.6-8.8,2.6-10.9,5.5c-1.6,2.1-2.4,4.6-2.1,7.5C336.9,129.3,341.8,132.7,347.5,132z M340.3,144.8
    c-11.8,1.5-19.6-3.2-21.9-13.9c-1.5-6.7,0.6-14.3,4.1-18.9c4.8-6,12.5-9.8,22-11c7.6-0.9,14-0.5,20,0.7l0.3-1
    c0.2-1.6,0.3-3.3,0.1-5.3c-0.6-5-4.6-8.1-14.4-6.9c-6.6,0.8-13,3.2-17.9,5.9l-4.8-14.4c6.6-3.8,15-6.7,24.6-7.9
    c18.3-2.3,31.2,3.6,32.8,17c0.4,3.6,0.5,7.4,0,10.8c-2.4,16.6-3.9,29.1-4.5,37.5c-0.1,1.3-0.1,3.5,0,6.7l-22.7,0
    c0.5-1.3,0.9-3.1,1.3-5.3c0.3-1.5,0.4-3.3,0.6-5.6C355.2,139.8,348.6,143.8,340.3,144.8z"/>
                            </g>
                        </g>
</svg>
                </a>
            </div>
        @endif
        @if(isset($listing->data['swiggylink']) && $listing->data['swiggylink'])
                <div class="mt-2 card mx-xs-0 mx-md-2 bg-light mr-3 " style="min-width:60px; border:none;">
                <a class="mt-md-0" style="color:gray" title="Order Online from {{$listing->title}} via Swiggy" href="{{$listing->data['swiggylink']}}" rel="nofollow noreferrer" target="_blank">
                    <svg class="mt-1" viewBox="0 0 16 25" height="60" width="40" fill="#fc8019"><path d="M15.5397581,11.1409928 C15.6509608,10.509712 15.5235868,10.0243137 15.1951696,9.77089093 C14.7011461,9.38969453 13.9591625,9.18240372 12.1918981,9.18240372 C10.8843181,9.18240372 9.48050894,9.18382005 8.88067307,9.18351656 C8.824972,9.17259055 8.62352934,9.10693329 8.6159428,8.86342483 L8.60775734,4.99753828 C8.60755774,4.75352397 8.80231214,4.55503473 9.04308494,4.55452889 C9.28425707,4.55412423 9.47990987,4.75190531 9.4801096,4.99571727 C9.4801096,4.99571727 9.48609894,7.09432117 9.48669787,7.84012275 C9.48669787,7.91215351 9.52822427,8.08029271 9.69013694,8.12409793 C10.745764,8.40908477 16.0819961,8.20068119 15.9990433,7.22017265 C15.5462467,3.15296419 12.1495732,0 8.02559027,0 C6.72689454,0 5.497376,0.313010053 4.40860776,0.868112227 C1.80303074,2.22496121 -0.0474859557,4.9636474 0.000928137643,8.12703176 C0.0352672176,10.3690901 1.49467783,14.3542524 2.38809268,14.9457747 C2.7998621,15.2186215 3.34210002,15.1176569 5.7669976,15.1176569 C6.86664654,15.1176569 7.89062974,15.1212989 8.39383694,15.1236259 C8.44614414,15.1335401 8.72045734,15.1971741 8.72045734,15.4525191 L8.726846,18.391212 C8.72744507,18.6353275 8.53249094,18.8337155 8.2913188,18.8338167 C8.050546,18.8342213 7.85499294,18.6366427 7.85459374,18.3927295 C7.85459374,18.3927295 7.8760556,17.2135293 7.8760556,16.7737573 C7.8760556,16.6719836 7.88334267,16.4971673 7.59006307,16.3649424 C6.6241768,15.929824 3.48764179,16.1924529 3.31165404,16.6725905 C3.24427359,16.8573211 3.5949514,17.5713563 4.13479358,18.4869157 C5.93330254,21.3601537 7.6990696,23.6004924 7.98456307,23.9589263 C8.00223174,23.9744048 8.0192016,23.9886693 8.03437467,24 C8.26985694,23.7099548 14.5488164,16.7550415 15.5397581,11.1409928 Z" id="Swiggy_Filled"></path></svg>
                </a>
            </div>
        @endif
        @if(isset($listing->data['tripadvisorlink']) && $listing->data['tripadvisorlink'] )
                <div class="mt-2 card mx-xs-0 mx-md-2 p-md-1 bg-light mr-3" style="min-width:70px; border:none;">
                <a class="mt-md-0" style="color:gray" title="See Reviews of {{$listing->title}} On TripAdvisor" href="{{$listing->data['tripadvisorlink']}}" rel="nofollow noreferrer" target="_blank">

                    <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 812.82 729.6"><title>See Reviews of {{$listing->title}} On TripAdvisor</title><path d="M346.87,517.5a71.94,71.94,0,1,0-71.93-71.93A71.94,71.94,0,0,0,346.87,517.5Z" transform="translate(-143.89 -143.89)"/><circle cx="608.53" cy="301.68" r="71.94"/><path d="M144.1,445.57c0,112,90.78,202.77,202.77,202.77a202,202,0,0,0,137.81-54.05l65,70.73,65-70.69a202,202,0,0,0,137.77,54c112,0,202.86-90.79,202.86-202.77A202.29,202.29,0,0,0,889.13,295.7l66.35-72.19H808.39a459.49,459.49,0,0,0-517,0H143.89l66.35,72.19A202.28,202.28,0,0,0,144.1,445.57Zm745.55,0A137.23,137.23,0,1,1,752.42,308.34,137.23,137.23,0,0,1,889.65,445.57Zm-340-235.33A393.78,393.78,0,0,1,702,240.7c-86.61,33.14-152.28,110.62-152.28,200.91,0-90.3-65.69-167.79-152.31-200.92A393.7,393.7,0,0,1,549.65,210.24Zm-202.78,98.1A137.23,137.23,0,1,1,209.64,445.57,137.23,137.23,0,0,1,346.87,308.34Z" transform="translate(-143.89 -143.89)"/><path d="M948.42,833.27a8.29,8.29,0,1,0,8.29,8.29A8.3,8.3,0,0,0,948.42,833.27Zm0,15.28a7,7,0,1,1,7-7A7,7,0,0,1,948.42,848.55Z" transform="translate(-143.89 -143.89)"/><path d="M951.11,840.15a2.36,2.36,0,0,0-2.64-2.4h-2.65v7.54h1.3v-2.74h1.41l1.37,2.74h1.41l-1.51-3A2.18,2.18,0,0,0,951.11,840.15Zm-2.7,1.25h-1.29v-2.5h1.29c.87,0,1.4.44,1.4,1.25S949.28,841.4,948.41,841.4Z" transform="translate(-143.89 -143.89)"/><path d="M238.87,777.87V763.59H217v85h21.9V797.61c0-9.23,5.92-13.76,15.15-13.76h12V763.59H255.76C247.75,763.59,240.78,767.77,238.87,777.87Z" transform="translate(-143.89 -143.89)"/><path d="M286.51,730a13.32,13.32,0,1,0,13.23,13.41A13.15,13.15,0,0,0,286.51,730Z" transform="translate(-143.89 -143.89)"/><rect x="131.7" y="619.7" width="21.84" height="84.95"/><path d="M357.57,762.16a42.22,42.22,0,0,0-25.78,8.62v-7.19H310V873.48h21.84V841.36A42.28,42.28,0,0,0,357.57,850a43.91,43.91,0,0,0,0-87.82Zm-1.93,67.76a23.86,23.86,0,1,1,23.86-23.85A23.85,23.85,0,0,1,355.64,829.92Z" transform="translate(-143.89 -143.89)"/><path d="M781.14,798.62l-12.74-3.5c-8.38-2.18-11.65-4.76-11.65-9.19s4.59-7.33,11.16-7.33c6.26,0,11.16,4.1,11.16,9.33v.49H799.2v-.49c0-15.42-12.57-25.77-31.29-25.77-18.54,0-32,10.35-32,24.61,0,11.09,7.36,19.45,20.18,22.92L768.3,813c9.27,2.57,12.71,5.42,12.71,10.52,0,5.38-5,9-12.39,9-7.74,0-12.93-4.89-12.93-12.16v-.49H734.32v.49c0,17.43,14,29.6,34.12,29.6,19.36,0,33.41-11.89,33.41-28.27C801.85,813.69,798.26,803.18,781.14,798.62Z" transform="translate(-143.89 -143.89)"/><path d="M479,770.78a42.22,42.22,0,0,0-25.78-8.62,43.91,43.91,0,0,0,0,87.82A42.28,42.28,0,0,0,479,841.36v7.19h21.84v-85H479Zm0,35.29a23.86,23.86,0,1,1-23.85-23.86A23.85,23.85,0,0,1,479,806.07Z" transform="translate(-143.89 -143.89)"/><path d="M579.68,770.78a42.21,42.21,0,0,0-25.77-8.62,43.91,43.91,0,1,0,0,87.82,42.28,42.28,0,0,0,25.77-8.62v7.19h21.84V733.35H579.68Zm-23.85,59.14a23.86,23.86,0,1,1,23.85-23.85A23.85,23.85,0,0,1,555.83,829.92Z" transform="translate(-143.89 -143.89)"/><rect x="559.06" y="619.7" width="21.84" height="84.95"/><path d="M713.87,730a13.32,13.32,0,1,0,13.23,13.41A13.15,13.15,0,0,0,713.87,730Z" transform="translate(-143.89 -143.89)"/><path d="M852.36,762.16a43.91,43.91,0,1,0,43.91,43.91A43.91,43.91,0,0,0,852.36,762.16Zm0,67.76a23.86,23.86,0,1,1,23.85-23.85A23.85,23.85,0,0,1,852.36,829.92Z" transform="translate(-143.89 -143.89)"/><polygon points="83.79 589.46 0 589.46 0 608.95 31.02 608.95 31.02 704.66 52.78 704.66 52.78 608.95 83.79 608.95 83.79 589.46"/><polygon points="507.55 681.39 488.13 619.7 465.18 619.7 494.32 704.66 520.61 704.66 549.92 619.7 526.98 619.7 507.55 681.39"/><path d="M955.4,783.85V763.59H945.17c-8,0-15,4.18-16.89,14.28V763.59H906.39v85h21.89V797.61c0-9.23,5.92-13.76,15.15-13.76Z" transform="translate(-143.89 -143.89)"/></svg>
{{--                            <div class="card-body p-0 mt-n1"><small>TripAdvisor</small></div>--}}
                </a>
            </div>
        @endif
        @if( isset($listing->data['facebooklink']) && $listing->data['facebooklink'] )
                <div class="mt-2 card mx-xs-0 mx-md-2 bg-light mr-3" style="min-width:60px; border:none;">
                <a class="mt-md-0" style="color:gray" title="Connect with {{$listing->title}} on Facebook" href="{{$listing->data['facebooklink']}}" rel="nofollow noreferrer" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="50px" height="50px" viewBox="0 0 266.893 266.895" enable-background="new 0 0 266.893 266.895" xml:space="preserve"><path id="Blue_1_" fill="#3C5A99" d="M248.082,262.307c7.854,0,14.223-6.369,14.223-14.225V18.812 c0-7.857-6.368-14.224-14.223-14.224H18.812c-7.857,0-14.224,6.367-14.224,14.224v229.27c0,7.855,6.366,14.225,14.224,14.225 H248.082z"></path> <path id="f" fill="#FFFFFF" d="M182.409,262.307v-99.803h33.499l5.016-38.895h-38.515V98.777c0-11.261,3.127-18.935,19.275-18.935 l20.596-0.009V45.045c-3.562-0.474-15.788-1.533-30.012-1.533c-29.695,0-50.025,18.126-50.025,51.413v28.684h-33.585v38.895h33.585 v99.803H182.409z"></path></svg>
                </a>
            </div>
        @endif
        @if( isset($listing->data['twitterlink']) && $listing->data['twitterlink'] )
        <div class="mt-2 card mx-xs-0 mx-md-2 mr-2 bg-light" style="min-width:50px; border:none;">
            <a class=" mt-md-0" style="color:gray" title="Follow {{$listing->title}} on Twitter" href="{{$listing->data['twitterlink']}}" rel="nofollow noreferrer" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="padding-left:5px" height="50px" viewBox="0 0 210 300" xml:space="preserve"><g id="T_1_"><path fill="#157DC3" d="M165.5,268.2H94.3l-1.5-0.1c-48.4-4.4-80.8-40.8-80.5-90.3V41.8c0-17.7,14.3-32,32-32s32,14.3,32,32v47.2 l92.9,0.9c17.7,0.2,31.9,14.6,31.7,32.3c-0.2,17.6-14.5,31.7-32,31.7c-0.1,0-0.2,0-0.3,0L76.3,153v24.9 c-0.1,22.7,14.1,25.6,21,26.3h68.2c17.7,0,32,14.3,32,32S183.2,268.2,165.5,268.2z"></path></g></svg>
            </a>
        </div>
        @endif
        @if( isset($listing->data['instagramlink']) && $listing->data['instagramlink'])
                <div class="mt-2 card mx-xs-0 mx-md-2 mr-2 bg-light" style="min-width:60px; border:none;">
                    <a class=" mt-md-0" style="color:gray" title="Follow {{$listing->title}} on Instagram" href="{{$listing->data['instagramlink']}}" rel="nofollow noreferrer" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" style="background: #f3ad5f; border-radius: 10px;" width="50" height="50" viewBox="0 0 132 132" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><linearGradient id="b"><stop offset="0" stop-color="#3771c8"/><stop stop-color="#3771c8" offset=".128"/><stop offset="1" stop-color="#60f" stop-opacity="0"/></linearGradient><linearGradient id="a"><stop offset="0" stop-color="#fd5"/><stop offset=".1" stop-color="#fd5"/><stop offset=".5" stop-color="#ff543e"/><stop offset="1" stop-color="#c837ab"/></linearGradient><radialGradient id="c" cx="158.429" cy="578.088" r="65" xlink:href="#a" gradientUnits="userSpaceOnUse" gradientTransform="matrix(0 -1.98198 1.8439 0 -1031.402 454.004)" fx="158.429" fy="578.088"/><radialGradient id="d" cx="147.694" cy="473.455" r="65" xlink:href="#b" gradientUnits="userSpaceOnUse" gradientTransform="matrix(.17394 .86872 -3.5818 .71718 1648.348 -458.493)" fx="147.694" fy="473.455"/></defs><path fill="url(#c)" d="M65.03 0C37.888 0 29.95.028 28.407.156c-5.57.463-9.036 1.34-12.812 3.22-2.91 1.445-5.205 3.12-7.47 5.468C4 13.126 1.5 18.394.595 24.656c-.44 3.04-.568 3.66-.594 19.188-.01 5.176 0 11.988 0 21.125 0 27.12.03 35.05.16 36.59.45 5.42 1.3 8.83 3.1 12.56 3.44 7.14 10.01 12.5 17.75 14.5 2.68.69 5.64 1.07 9.44 1.25 1.61.07 18.02.12 34.44.12 16.42 0 32.84-.02 34.41-.1 4.4-.207 6.955-.55 9.78-1.28 7.79-2.01 14.24-7.29 17.75-14.53 1.765-3.64 2.66-7.18 3.065-12.317.088-1.12.125-18.977.125-36.81 0-17.836-.04-35.66-.128-36.78-.41-5.22-1.305-8.73-3.127-12.44-1.495-3.037-3.155-5.305-5.565-7.624C116.9 4 111.64 1.5 105.372.596 102.335.157 101.73.027 86.19 0H65.03z" transform="translate(1.004 1)"/><path fill="url(#d)" d="M65.03 0C37.888 0 29.95.028 28.407.156c-5.57.463-9.036 1.34-12.812 3.22-2.91 1.445-5.205 3.12-7.47 5.468C4 13.126 1.5 18.394.595 24.656c-.44 3.04-.568 3.66-.594 19.188-.01 5.176 0 11.988 0 21.125 0 27.12.03 35.05.16 36.59.45 5.42 1.3 8.83 3.1 12.56 3.44 7.14 10.01 12.5 17.75 14.5 2.68.69 5.64 1.07 9.44 1.25 1.61.07 18.02.12 34.44.12 16.42 0 32.84-.02 34.41-.1 4.4-.207 6.955-.55 9.78-1.28 7.79-2.01 14.24-7.29 17.75-14.53 1.765-3.64 2.66-7.18 3.065-12.317.088-1.12.125-18.977.125-36.81 0-17.836-.04-35.66-.128-36.78-.41-5.22-1.305-8.73-3.127-12.44-1.495-3.037-3.155-5.305-5.565-7.624C116.9 4 111.64 1.5 105.372.596 102.335.157 101.73.027 86.19 0H65.03z" transform="translate(1.004 1)"/><path fill="#fff" d="M66.004 18c-13.036 0-14.672.057-19.792.29-5.11.234-8.598 1.043-11.65 2.23-3.157 1.226-5.835 2.866-8.503 5.535-2.67 2.668-4.31 5.346-5.54 8.502-1.19 3.053-2 6.542-2.23 11.65C18.06 51.327 18 52.964 18 66s.058 14.667.29 19.787c.235 5.11 1.044 8.598 2.23 11.65 1.227 3.157 2.867 5.835 5.536 8.503 2.667 2.67 5.345 4.314 8.5 5.54 3.054 1.187 6.543 1.996 11.652 2.23 5.12.233 6.755.29 19.79.29 13.037 0 14.668-.057 19.788-.29 5.11-.234 8.602-1.043 11.656-2.23 3.156-1.226 5.83-2.87 8.497-5.54 2.67-2.668 4.31-5.346 5.54-8.502 1.18-3.053 1.99-6.542 2.23-11.65.23-5.12.29-6.752.29-19.788 0-13.036-.06-14.672-.29-19.792-.24-5.11-1.05-8.598-2.23-11.65-1.23-3.157-2.87-5.835-5.54-8.503-2.67-2.67-5.34-4.31-8.5-5.535-3.06-1.187-6.55-1.996-11.66-2.23-5.12-.233-6.75-.29-19.79-.29zm-4.306 8.65c1.278-.002 2.704 0 4.306 0 12.816 0 14.335.046 19.396.276 4.68.214 7.22.996 8.912 1.653 2.24.87 3.837 1.91 5.516 3.59 1.68 1.68 2.72 3.28 3.592 5.52.657 1.69 1.44 4.23 1.653 8.91.23 5.06.28 6.58.28 19.39s-.05 14.33-.28 19.39c-.214 4.68-.996 7.22-1.653 8.91-.87 2.24-1.912 3.835-3.592 5.514-1.68 1.68-3.275 2.72-5.516 3.59-1.69.66-4.232 1.44-8.912 1.654-5.06.23-6.58.28-19.396.28-12.817 0-14.336-.05-19.396-.28-4.68-.216-7.22-.998-8.913-1.655-2.24-.87-3.84-1.91-5.52-3.59-1.68-1.68-2.72-3.276-3.592-5.517-.657-1.69-1.44-4.23-1.653-8.91-.23-5.06-.276-6.58-.276-19.398s.046-14.33.276-19.39c.214-4.68.996-7.22 1.653-8.912.87-2.24 1.912-3.84 3.592-5.52 1.68-1.68 3.28-2.72 5.52-3.592 1.692-.66 4.233-1.44 8.913-1.655 4.428-.2 6.144-.26 15.09-.27zm29.928 7.97c-3.18 0-5.76 2.577-5.76 5.758 0 3.18 2.58 5.76 5.76 5.76 3.18 0 5.76-2.58 5.76-5.76 0-3.18-2.58-5.76-5.76-5.76zm-25.622 6.73c-13.613 0-24.65 11.037-24.65 24.65 0 13.613 11.037 24.645 24.65 24.645C79.617 90.645 90.65 79.613 90.65 66S79.616 41.35 66.003 41.35zm0 8.65c8.836 0 16 7.163 16 16 0 8.836-7.164 16-16 16-8.837 0-16-7.164-16-16 0-8.837 7.163-16 16-16z"/></svg>
                    </a>
                </div>
        @endif
        @if( isset($listing->data['linkedinlink']) && $listing->data['linkedinlink'])
        <div class="mt-2 card mx-xs-0 mx-md-2 mr-3 bg-light" style="min-width:60px; border:none;">
            <a class="mt-md-0" style="color:gray" title="Follow {{$listing->title}} on LinkedIn" href="{{$listing->data['linkedinlink']}}" rel="nofollow noreferrer" target="_blank">
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
        @endif
        @if( isset($listing->data['practolink']) && $listing->data['practolink'])
                <div class="mt-2 card mx-xs-0 mx-md-2 mr-3 bg-light" style="min-width:60px; border:none;">
                    <a class=" mt-md-0" style="color:gray" title="See {{$listing->title}} at Practo" href="{{$listing->data['practolink']}}" rel="nofollow noreferrer" target="_blank">
                    <svg width="100" height="23" style="margin-top: 13px" viewBox="0 0 516 118" xmlns="http://www.w3.org/2000/svg"><desc>Logo of Practo</desc><g fill="none" fill-rule="evenodd"><path d="M39.818 57.187c0-10.969-8.892-19.863-19.864-19.863-10.974 0-19.87 8.894-19.87 19.863 0 10.972 8.896 19.865 19.87 19.865 10.972 0 19.864-8.893 19.864-19.865M515.805 57.187c0-10.969-8.895-19.863-19.866-19.863-10.97 0-19.865 8.894-19.865 19.863 0 10.972 8.895 19.865 19.865 19.865 10.971 0 19.866-8.893 19.866-19.865" fill="#2CB7DF"/><path d="M304.963 75.017c-9.653 0-17.479-7.115-17.479-17.83 0-10.715 7.826-17.826 17.479-17.826 6.215 0 11.59 2.909 14.82 8.007l16.158-11.607c-6.793-9.824-18.132-16.263-30.978-16.263-20.793 0-37.65 16.858-37.65 37.657 0 20.795 16.857 37.655 37.65 37.655 12.341 0 23.371-5.494 31.789-17.059l-16.324-11.303c-3.432 5.077-8.707 8.569-15.465 8.569M220.438 75.017c-9.656 0-17.484-7.115-17.484-17.83 0-10.715 7.828-17.826 17.484-17.826 9.654 0 17.481 7.164 17.481 17.826 0 10.664-7.827 17.83-17.481 17.83zm17.869-47.207c-5.015-4.757-11.705-8.312-21.091-8.312-17.872 0-34.435 15.062-34.435 37.657 0 22.592 16.406 37.655 34.435 37.655 8.693 0 15.325-3.383 20.341-8.317v6.192h20.173V21.659h-19.423v6.151zM153.617 29.934v-8.275h-19.443v71.026h20.159V58.999c0-14.15 7.857-17.992 16.578-17.992 2.141 0 4.428.142 6.859.711V21.659c-1.431-.43-3.575-.715-5.719-.715-5.716 0-13.939 1.876-18.434 8.99M363.979.938h-20.172v69.273c0 14.146 8.634 23.03 25.728 23.03 6.852 0 13.262-1.003 17.52-2.136V73.052c-3.951 1.135-8.354 1.992-13.815 1.992-5.631 0-9.261-1.574-9.261-7.43V39.361h23.417V21.554h-23.417V.938M430.061 75.017c-9.657 0-17.485-7.115-17.485-17.83 0-10.715 7.828-17.826 17.485-17.826 9.652 0 17.48 7.164 17.48 17.826 0 10.664-7.828 17.83-17.48 17.83zm0-55.519c-20.797 0-37.653 16.858-37.653 37.657 0 20.795 16.856 37.655 37.653 37.655 20.794 0 37.654-16.86 37.654-37.655 0-20.799-16.86-37.657-37.654-37.657zM86.934 75.017c-9.657 0-17.484-7.166-17.484-17.83 0-10.662 7.827-17.826 17.484-17.826 9.653 0 17.481 7.111 17.481 17.826s-7.828 17.83-17.481 17.83zm3.222-55.519c-9.389 0-16.078 3.555-21.094 8.312v-6.151h-19.42v96.28h20.173l-.002-31.446c5.018 4.934 11.649 8.317 20.343 8.317 18.027 0 34.435-15.063 34.435-37.655 0-22.595-16.566-37.657-34.435-37.657z" fill="#263077"/></g></svg>
                    </a>
                </div>
            @endif

    </div>


