@extends('bootstraplayout')

@section('header') @include('partials.headerwithnosearch') @endsection
@section('footer') @endsection


@section('main')

    <div class="container mt-4">
        @if(session('message')) <div class="alert alert-danger">{{session('message')}}</div> @endif
        <div class="row">
            <div class="col-12">
                <a href="/home" class="mr-2 float-left"><- Back to Home</a>
                <a href="/addpost" class="btn btn-success mr-2 float-right">Click to Add a Post</a>
            </div>
        </div>
            @if(auth()->user()->listing->posts->count())
                <div class="row my-4 bg-light">
                    Total Posts: {{auth()->user()->listing->posts->count()}}
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">When</th>
                                <th scope="col">Title</th>
                                <th scope="col">Body</th>
                                <th scope="col">Image</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(auth()->user()->listing->posts()->latest()->take(20)->cursor() as $post)
                                <tr>
                                    <th scope="row">{{$post->created_at->diffForHumans()}}</th>
                                    <td><a href="{{$post->full_link}}">{{$post->title}}</a></td>
                                    <td>{!! \Str::words($post->body,40) !!}</td>
                                    <td>@if(isset($post->data['content_img']))<img src="{{$post->data['content_img']}}" class="img-fluid" style="max-width:300px;max-height:300px"/>@endif</td>
                                    <td><a class="btn btn-sm btn-danger" href="/editpost/{{$post->id}}">Edit Post</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr class="my-3">
                </div>
            @else
                You have no posts yet. <br><br>
            @endif
    </div>

    <br>
    <br>
    <br>
    <br>

@endsection
