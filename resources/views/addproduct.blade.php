@extends('bootstraplayout')

@section('header') @include('partials.headerwithnosearch') @endsection
@section('footer') @endsection

@section('main')
    <div class="container mt-4">
        @if(session('message')) <div class="alert alert-danger">{{session('message')}}</div>@endif
            <div class="row my-4">
                <div class="col-12">
                    <a href="/home" class="mr-2 float-left"><- Back to Home</a>
                    <a href="/manageproducts" class="mr-2 float-right"><- Back to Manage Products</a>
                </div>
                <br><br>
            </div>

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
                <form enctype="multipart/form-data" method="POST" action="/addproduct/{{$listing->id}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="title">Title of the Product <span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title of the Product">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="title">Any Image of the Product:</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="body">Body of the Product <span class="text-danger">*</span>:</label>
                            <textarea class="form-control" id="body" name="body" rows="5" placeholder="Enter the content of the Product"></textarea>
                        </div>
                        <div class="form-group  col-md-3">
                            <label for="title">Link of product on your website, <br><b>if you sell online</b></label>
                            <input type="text" class="form-control" id="ownlink" name="ownlink" placeholder="Link to buy online">
                        </div>
                        <div class="form-group  col-md-3">
                            <label for="title">Product Link, if you sell this on <br><b>Amazon</b></label>
                            <input type="text" class="form-control" id="amazonlink" name="amazonlink" placeholder="Link to buy online">
                        </div>
                        <div class="form-group  col-md-3">
                            <label for="title">Product Link, if you sell this on <br><b>Flipkart</b></label>
                            <input type="text" class="form-control" id="flipkartlink" name="flipkartlink" placeholder="Link to buy online">
                        </div>
                        <div class="form-group  col-md-3">
                            <label for="title">Product Link, if you sell this on <br><b>Indiamart</b></label>
                            <input type="text" class="form-control" id="indiamartlink" name="indiamartlink" placeholder="Link to buy online">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="title">Additional Images, if any:</label>
                            <input type="file" class="form-control" id="image2" name="image2">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="title">Additional Images, if any:</label>
                            <input type="file" class="form-control" id="image3" name="image3">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="title">Additional Images, if any:</label>
                            <input type="file" class="form-control" id="image4" name="image4">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="title">Additional Images, if any:</label>
                            <input type="file" class="form-control" id="image5" name="image5">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="title">Youtube Video Link, if any</label>
                            <input type="text" class="form-control" id="videolinklink" name="videolinklink" placeholder="https://youtube.com/watch?v=abcd1234" >
                        </div>

                        {{--// video, reviews--}}
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-danger float-right">Submit</button>
                        </div>
                    </div>
                </form>            </div>
        </div>
    </div>
@endsection
