@extends('bootstraplayout')
@section('main')
    @if (Session::has('message'))
        <div class="alert alert-danger">{{Session::get('message')}}</div>
    @endif
    <br>
    <form class="my-5" method="POST" action="/editreview/{{$review->id}}">
    @csrf
    <textarea name="body" rows="8" class="form-control">{{$review->body}}</textarea>
        <br>
        <br>
    <button type="submit" class="btn btn-danger float-right">Submit</button>
</form>
<br><br><br>
@endsection
