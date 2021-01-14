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
                <form enctype="multipart/form-data" method="POST" action="/editproduct/{{$product->id}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="title">Title of the Product <span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title of the Product" value="{{$product->title}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="title">Any Image of the Product:</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="body">Body of the Product <span class="text-danger">*</span>:</label>
                            <textarea class="form-control" id="body" name="body" rows="5" placeholder="Enter the content of the Product">{!! $product->body !!}</textarea>
                        </div>
                        <div class="form-group  col-md-3">
                            <label for="title">Link of product on your website, <br><b>if you sell online</b></label>
                            <input type="text" class="form-control" id="ownlink" name="ownlink" placeholder="Link to buy online" @if(isset($product->data['ownlink']) && $product->data['ownlink'] ) value="{{$product->data['ownlink']}}"  @endif>
                        </div>
                        <div class="form-group  col-md-3">
                            <label for="title">Product Link, if you sell this on <br><b>Amazon</b></label>
                            <input type="text" class="form-control" id="amazonlink" name="amazonlink" placeholder="Link to buy online" @if(isset($product->data['amazonlink']) && $product->data['amazonlink'] ) value="{{$product->data['amazonlink']}}"  @endif>
                        </div>
                        <div class="form-group  col-md-3">
                            <label for="title">Product Link, if you sell this on <br><b>Flipkart</b></label>
                            <input type="text" class="form-control" id="flipkartlink" name="flipkartlink" placeholder="Link to buy online" @if(isset($product->data['flipkartlink']) && $product->data['flipkartlink'] ) value="{{$product->data['flipkartlink']}}"  @endif>
                        </div>
                        <div class="form-group  col-md-3">
                            <label for="title">Product Link, if you sell this on <br><b>Indiamart</b></label>
                            <input type="text" class="form-control" id="indiamartlink" name="indiamartlink" placeholder="Link to buy online" @if(isset($product->data['indiamartlink']) && $product->data['indiamartlink'] ) value="{{$product->data['indiamartlink']}}"  @endif>
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
                            <input type="text" class="form-control" id="videolink" name="videolink" placeholder="https://youtube.com/watch?v=abcd1234" @if(isset($product->data['videolink']) ) value="{{$product->data['videolink']}}"  @endif>
                        </div>

                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-danger float-right">Submit</button>
                        </div>
                    </div>
                </form>            </div>
        </div>
    </div>
@endsection
