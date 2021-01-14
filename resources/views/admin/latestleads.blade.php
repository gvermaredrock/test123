@extends('bootstraplayout')
@section('footer') @endsection

@section('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .page-item{padding:5px 14px; border: 1px solid #ccc;}
    </style>
@endsection

@section('main')
    @if(session('message')) <div class="alert alert-danger">{{session('message')}}</div> @endif

    <div class="container mt-4">
{{--        <div class="row">--}}
{{--            <form method="GET" action="/latestleads" class="col-6 mb-5 row" >--}}
{{--                <div class="col-8">--}}
{{--                <select class="form-control" name="cat">--}}
{{--                    <option @if(! isset($_GET['cat']))selected disabled @endif>--</option>--}}
{{--                    @foreach(\App\Category::orderBy('title')->cursor() as $cat)--}}
{{--                    <option @if(isset($_GET['cat']) && ($cat->id == $_GET['cat']) ) selected @endif value="{{$cat->id}}">{{$cat->title}}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--                </div>--}}
{{--                <div class="col-3">--}}
{{--                    <button class="btn btn-sm btn-danger" type="submit">Submit</button>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--            <form method="GET" action="/latestleads" class="col-6 mb-5 row">--}}
{{--                <div class="col-8">--}}
{{--                <select class="form-control" name="city">--}}
{{--                    <option @if(! isset($_GET['city']))selected disabled @endif>--</option>--}}
{{--                @foreach(\App\City::orderBy('title')->cursor() as $city)--}}
{{--                    <option @if(isset($_GET['city']) && ($city->id == $_GET['city']) ) selected @endif value="{{$city->id}}">{{$city->title}}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--                </div>--}}
{{--                <div class="col-4">--}}
{{--                    <button class="btn btn-sm btn-danger" type="submit">Submit</button>--}}
{{--                </div>--}}
{{--                </form>--}}
{{--        </div>--}}

        <div class="row">
            <div class="col-12">
            <form action="/redirecttovendor" method="POST" class="d-flex" target="_blank">
                @csrf
                <input type="text" name="phone" class="form-control" placeholder="Vendor Phone Number">
                <button class="btn btn-sm btn-danger ml-3">Search</button>
            </form>
                <br>
            </div>
        </div>

        <div class="card mb-5">
            <div class="card-header">Latest Comments</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Review</th>
                        <th scope="col">Listing</th>
                        <th scope="col">Handle</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($latestreviews as $review)
                        @if($review->data['status']=="Under Review" && $review->listing)
                            <tr>
                                <th scope="row">{{$review->id}}</th>
                                <td>{{ \Str::words($review->body,40)  }}</td>
                                <td><a target="_blank" href="{{$review->listing->full_link}}">{{$review->listing->title}}</a></td>
                                <td style="width:150px">
                                    <a target="_blank" href="/approvereview/{{$review->id}}">Approve</a> &nbsp; <a href="/rejectreview/{{$review->id}}">Reject</a><br>
                                    <a href="/editreview/{{$review->id}}">Edit</a><br>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    {{ $latestreviews->links() }}
                    </tbody>
                </table>
            </div>
        </div>


        <div class="row justify-content-center my-3">
            <div class="col-md-12 ">
                <div class="card">
                    <div class="card-header">Latest Listings</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Listing</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($latestlistings as $listing)
                                <tr>
                                    <td>{{$listing->id}}</td>
                                    <td><a href="https://wa.me/91{{$listing->phone}}" target="_blank">{{$listing->user->name}}</a></td>
                                    <td><a href="{{$listing->full_link}}" target="_blank">{{$listing->title}}</a> @if($listing->blog)<a href="{{$listing->blog->full_link}}" target="_blank" class="small">({{$listing->blog->slug}})</a> @endif </td>
                                    <td>
                                        <a href="{{$listing->website}}">site</a>
                                        @if(isset($listing->data['facebooklink']) && $listing->data['facebooklink'])<a href="{{$listing->data['facebooklink']}}">FB</a>@endif
                                        @if(isset($listing->data['twitterlink']) && $listing->data['twitterlink'])<a href="{{$listing->data['twitterlink']}}">TWITTER</a>@endif
                                        @if(isset($listing->data['instagramlink']) && $listing->data['instagramlink'])<a href="{{$listing->data['instagramlink']}}">INSTA</a>@endif
                                        @if(isset($listing->data['zomatolink']) && $listing->data['zomatolink'])<a href="{{$listing->data['zomatolink']}}">ZOMATO</a>@endif
                                        @if(isset($listing->data['swiggylink']) && $listing->data['swiggylink'])<a href="{{$listing->data['swiggylink']}}">SWIGGY</a>@endif
                                        @if(isset($listing->data['tripadvisorlink']) && $listing->data['tripadvisorlink'])<a href="{{$listing->data['tripadvisorlink']}}">TA</a>@endif
                                        @if(isset($listing->data['indiamartlink']) && $listing->data['indiamartlink'])<a href="{{$listing->data['indiamartlink']}}">IM</a>@endif
                                    </td>
                                </tr>
                                @endforeach
                                {{ $latestlistings->links() }}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12 ">
                <div class="card">
                    <div class="card-header">Latest Leads Analysis</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Interaction</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($latestleads as $lead)
                                    @include('partials.latestleadsloop')
                                @endforeach
                                {{ $latestleads->links() }}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

