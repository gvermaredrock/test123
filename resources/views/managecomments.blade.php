@extends('bootstraplayout')

@section('header') @include('partials.headerwithnosearch') @endsection
@section('footer') @endsection


@section('main')
    <div class="container mt-4">
        @if(session('message')) <div class="alert alert-danger">{{session('message')}}</div> @endif
        @if($reviews->count())
            <div class="row justify-content-center mt-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Comments on <a href="{{$listing->full_link}}">{{$listing->title}}</a>: </div>

                        <div class="card-body table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Body of Comment</th>
                                    <th scope="col"><span class="text-danger">Add your reply here and press Save</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reviews as $review)
                                    <tr>
                                        <th scope="row">{{$review->created_at->format('d M Y')}}</th>
                                        <td>{{$review->user ? $review->user->display_name : $review->user_name}}</td>
                                        <td style="min-width:140px"><p style="max-height:300px;overflow: auto">{{$review->body}}</p></td>
                                        <td style="min-width:330px">
                                            <form class="d-flex" method="POST" action="/vendorreply/{{$review->id}}" >@csrf<textarea name="reply" required rows="2" class="form-control">{{$review->vendor_reply}}</textarea><button class="ml-2 btn btn-sm btn-info" type="submit">Save</button> </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
                No Customer reviews for {{$listing->title}}. <a href="/home">Click here to go back</a>
        @endif
    </div>
@endsection
