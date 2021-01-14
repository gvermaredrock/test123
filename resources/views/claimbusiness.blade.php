@extends('bootstraplayout')

@section('footer','')

@section('styles')
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="https://m2.wuchna.com/quill.snow.css" rel="stylesheet">
    <style>
        #standalone-container, #toolbar-container,#editor {border-radius:5px}
    </style>
@endsection


@section('main')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Claim an existing Business already listed in Wuchna Business Wikipedia</div>
                    @if(auth()->user()->listing)
                        <div class="card-body">
                            <div class="alert alert-danger">You have already claimed a business. If you want to claim more, please contact us: <a href="mailto:info@wuchna.com">info@wuchna.com</a></div>
                        </div>
                    @else
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="">
                            @if($id)
                                @php $listing = \App\Listing::find($id) @endphp
                                <div class="mt-4 d-flex justify-content-center">
                                    <span class="mb-4">Do you want to claim the business:
                                        <h2 class="my-4">{{$listing->title}}</h2>
                                        <h4>{{ucwords(str_replace('-',' ',$listing->blog->slug))}}</h4>
                                    </span>
                                </div>
                                <form method="POST" action="/claimbusiness/{{$id}}" class="d-flex justify-content-around mb-5">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-lg">YES, I want to claim it</button> <a class="btn btn-danger btn-lg" href="/claimbusiness">NO. GO BACK</a>
                                </form>

                            @else
                                To claim a listing, please search via the searchbox above, and click on the red "Edit / Claim this business" link on the listing you want to claim. <br><br>
                                If you encounter a problem, please contact us: <a href="mailto:info@wuchna.com">info@wuchna.com</a>
                            @endif
                        </div>

                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/vue.js') }}"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                showingsearchinput: false,
            },
            methods: {
                showsearchinput(){
                    this.showingsearchinput = !this.showingsearchinput;
                },
            }
        });
    </script>
    <script defer src="{{ asset('js/app.js') }}"></script>
@endsection
