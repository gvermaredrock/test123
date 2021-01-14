@extends('bootstraplayout')

@section('header') @include('partials.headerwithnosearch') @endsection
@section('footer') @endsection

@section('pagelinks')
    <div class="container mt-5">
        <div class="nav-scroller py-1 mb-2">
            <nav class="nav d-flex justify-content-start">
                @if(!auth()->user()->listing)
                    <a href="/addbusiness" class="btn btn-danger mr-2">Add your Business</a>
                    <a href="/claimbusiness" class="btn btn-success mr-2">Claim an existing Listing</a>
                    <a href="#" class="btn btn-secondary mr-2">Link to your Business</a>
                    <a href="#" class="btn btn-secondary mr-2">Edit your Business</a>
                    <a href="#" class="btn btn-secondary mr-2">View and Reply to reviews</a>
                    <a href="#" class="btn btn-secondary mr-2">Set Workhours</a>
                    <a href="#" class="btn btn-secondary mr-2">Add Image Gallery</a>
                    <a href="#" class="btn btn-secondary mr-2">Add POSTS</a>
                @else
                    <a href="{{auth()->user()->listing->full_link}}" class="btn btn-danger mr-2">Link to your Business</a>
                    <a href="/editbusiness/{{auth()->user()->listing->id}}" class="btn btn-success mr-2">Edit your Business</a>
                    <a href="/managecomments" class="btn btn-warning mr-2">Manage Reviews</a>
                    <a href="/manageposts" class="btn mr-2" style="color: #fff; background-color: #5e72e4; border-color: #5e72e4;">Manage Posts</a>
                    <a href="/manageproducts" class="btn mr-2" style="color: #fff; background-color: #fb6340; border-color: #fb6340;">Manage Products</a>
                @endif
            </nav>
        </div>
    </div>
@endsection

@section('main')
    <div class="container mt-4">
    @if(session('message')) <div class="alert alert-danger">{{session('message')}}</div> @endif
{{--    @directive_name()--}}
{{--    @hello()--}}
    @if(Auth::check() && auth()->id() == 1) @include('admin.homeissues') @endif
    @if(auth()->user()->listing)
        <h2 class="text-danger mb-3">Thanks for adding your business in Wuchna Directory! Benefits:</h2>
        <h4>1. Get FREE Verified Business Badge shown below. Add below code on the left to your website footer to show this verified badge</h4>
        <div class="row my-4 ">
            <div class="col-12 col-md-6">
                <textarea class="mr-3 form-control" rows="5" style="border:none; max-height:315px"><a href="{{auth()->user()->listing->full_link}}" target="_blank"><iframe width="280" src="{{config('my.APP_URL').'/badge/'.auth()->user()->listing->id}}"></iframe></a></textarea>
            </div>
            <div class="col-12 col-md-6" style="background-color:#f8fafc !important;">
                <a href="{{auth()->user()->listing->full_link}}" target="_blank"><iframe width="100%" style="border:none; " src="{{config('my.APP_URL').'/badge/'.auth()->user()->listing->id}}"></iframe></a>
            </div>
            <div class="col-md-3"></div>
            <div class="col-12 text-danger mt-n2">To get custom badge, contact info@wuchna.com</div>
        </div>
        <h4>2. Get to see the data of leads generated for you. These are the people who enquired for you:</h4>
        @if(auth()->user()->listing->leads->count())
            <div class="row my-4 bg-light">
                    Total Leads: {{auth()->user()->listing->leads->count()}}
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">When</th>
                                <th scope="col">User Name</th>
                                <th scope="col">User Phone Number</th>
                                <th scope="col">User Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(auth()->user()->listing->leads()->latest()->take(20)->cursor() as $lead)
                                <tr>
                                    <th scope="row">{{$lead->created_at->diffForHumans()}}</th>
                                    <td>{{$lead->user->name}}</td>
                                    <td>{{$lead->user->phone}}</td>
                                    <td>{{$lead->user->email}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr class="my-3">
            </div>
        @else
                You have no leads generated for you. <br><br>
        @endif
        <h4 class="my-3">3. Get to reply back to comments / reviews. Whenever anyone adds a review, we will inform you via email, and the email will also have a link using which you can reply back on the review.&nbsp;&nbsp; <a href="/managecomments" class="btn btn-warning mr-2">Click to View and Reply to Reviews</a></h4>
<br>
        <h4 class="my-3">4. Get to upload posts. Posting regular updates with high-quality content will help reach your brand reachout to a larger audience, helping you in SEO. &nbsp;&nbsp;  <a href="/manageposts" class="btn mr-2" style="color: #fff; background-color: #5e72e4; border-color: #5e72e4;">Manage Posts</a></h4>
<br>
        <h4 class="my-3">5. Get to upload your products. Each product gets a separate link, so better online marketing! Uploading products here will promote them to a larger audience, helping you in getting free enquiries. &nbsp;&nbsp; <a href="/manageproducts" class="btn mr-2" style="color: #fff; background-color: #fb6340; border-color: #fb6340;">Manage Products</a></h4>


    @endif
      @if(auth()->user()->reportcases->count())
        <div class="row justify-content-center mt-3">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Listings / Comments you reported: </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title of Listing</th>
                                <th scope="col">Your Reason</th>
                                <th scope="col">Action Taken</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(auth()->user()->reportcases()->with('listing')->get() as $case)
                            <tr>
                                <th scope="row">{{$loop->index + 1}}</th>
                                <td>
                                    @if($case->listing)
                                        <a href="{{$case->listing->full_link}}">{{$case->listing->title}}</a>
                                @endif
                                </td>
                                <td>{{$case->body}}</td>
                                <td>
                                    @if(isset($case->data['status']))
                                        {{$case->data['status']}}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      @endif
</div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
@endsection
