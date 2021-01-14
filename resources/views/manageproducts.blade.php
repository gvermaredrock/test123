@extends('bootstraplayout')

@section('header') @include('partials.headerwithnosearch') @endsection
@section('footer') @endsection


@section('main')

    <div class="container mt-4">
        @if(session('message')) <div class="alert alert-danger">{{session('message')}}</div> @endif
        <div class="row">
            <div class="col-12">
                <a href="/home" class="mr-2 float-left"><- Back to Home</a>
                <a href="/addproduct" class="btn btn-success mr-2 float-right">Click to Add a Product</a>
            </div>
        </div>
        @if(auth()->user()->listing->products->count())
            <div class="row my-4 bg-light">
                Total Posts: {{auth()->user()->listing->products->count()}}
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
                        @foreach(auth()->user()->listing->products()->latest()->take(20)->cursor() as $product)
                            <tr>
                                <th scope="row">{{$product->created_at->diffForHumans()}}</th>
                                <td><a href="{{$product->full_link}}">{{$product->title}}</a></td>
                                <td>{!! \Str::words($product->body,40) !!}</td>
                                <td>@if(isset($product->data['content_img']))<img src="{{$product->data['content_img']}}" class="img-fluid" style="max-width:300px;max-height:300px"/>@endif</td>
                                <td><a class="btn btn-sm btn-danger" href="/editproduct/{{$product->id}}">Edit Product</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <hr class="my-3">
            </div>
        @else
            You have no products yet. <br><br>
        @endif
    </div>

    <br>
    <br>
    <br>
    <br>

@endsection
