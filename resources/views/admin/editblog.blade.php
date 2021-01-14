@extends('bootstraplayout')
@section('footer') @endsection

@section('styles')
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="https://m2.wuchna.com/quill.snow.css" rel="stylesheet">
    <style>
        label{ font-size: 80%; font-weight: 400;}

        #standalone-container, #toolbar-container,#editor {border-radius:5px}
    </style>
@endsection

@section('main')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10 ">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (Session::has('message'))
                    <div class="alert alert-danger">{{Session::get('message')}}</div>
                @endif

                <div class="card">
                    <div class="card-header">Edit Blog</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="">
                            <form class="row" id="admineditbusiness" method="POST" action="/admineditblog/{{$blog->id}}">
                                @csrf
                                <div class="form-group col-12 pb-4">
                                    <label for="title" class="text-danger">Title of the Blog *</label>
                                    <input type="text" class="form-control" id="title" name="title" required value="{{$blog->title}}">
                                </div>
                                <div class="form-group col-12 pb-4">
                                    <label for="title" class="text-danger">Meta Title</label>
                                    <input type="text" class="form-control" id="meta_title" name="meta_title" required value="{{$blog->meta_title}}">
                                </div>
                                <div class="form-group col-12 pb-4">
                                    <label for="title" class="text-danger">Meta Description</label>
                                    <input type="text" class="form-control" id="meta_description" name="meta_description" required value="{{$blog->meta_description}}">
                                </div>
                                <div class="form-group col-12 pb-4">
                                    <label for="title" class="text-danger">Description</label>
                                    <textarea class="form-control" id="description" name="description" ref="description" rows="3">{!! $blog->description  !!}</textarea>
                                </div>
                                <div class="form-group col-12 pb-4">
                                    <button type="submit" class="btn btn-danger float-right">Submit</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

