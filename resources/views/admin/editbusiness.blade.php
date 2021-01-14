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
                    <div class="card-header">Edit your Business in Wuchna Business Wikipedia</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="">
                            <form class="row" id="admineditbusiness" method="POST" action="/admineditbusiness" ref="editbusinessform" @submit.prevent="formsubmitted" enctype="multipart/form-data">
                                @csrf
                                @include('addbusinessform',compact(['listing']))


                            </form>

                            <form method="POST" action="/admindeleteandredirectlisting/{{$listing->id}}" class="border p-3">
                                @csrf
                                <input type="text" name="to" required="required"/>
                                <button type="submit"  class="btn btn-warning btn-lg">Delete and redirect</button>
                            </form>
                                <br><br>
                                <br><br>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

