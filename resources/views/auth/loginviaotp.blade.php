@extends('bootstraplayout')

@section('header')
    @include('partials.headerwithnosearch')
@endsection


@section('main')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Enter OTP</div>

                    <div class="card-body">
                        <form method="POST" action="/enterotp">
                            @csrf

                            <div class="form-group row">
                                <label for="otp" class="col-md-4 col-form-label text-md-right">Enter OTP</label>
                                <div class="col-md-6">
                                    <input id="email" type="hidden" class="form-control" name="email" value="{{ $user->email }}">
                                    <input id="otp" type="text" class="form-control @error('otp') is-invalid @enderror" name="otp" value="{{ old('otp') }}" required autocomplete="otp" autofocus>

                                    @error('otp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer') @endsection
