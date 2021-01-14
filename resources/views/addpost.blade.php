@extends('bootstraplayout')

@section('header') @include('partials.headerwithnosearch') @endsection
@section('footer') @endsection

@section('main')
    <div class="container mt-4">
        @if(session('message')) <div class="alert alert-danger">{{session('message')}}</div> @endif
        <br>
        <div class="row justify-content-center mt-2">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="col-md-12">
                <form enctype="multipart/form-data" method="POST" action="/addpost/{{$listing->id}}">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title of the Post:</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title of the Post">
                    </div>
                    <div class="form-group">
                        <label for="body">Body of the Post:</label>
                        <textarea class="form-control" id="body" name="body" rows="5" placeholder="Enter the content of the Post"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="title">Any Image of the Post:</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger float-right">Submit</button>
                    </div>
                </form>            </div>
        </div>
    </div>
@endsection
