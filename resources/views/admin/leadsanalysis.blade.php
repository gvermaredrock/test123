@extends('bootstraplayout')
@section('footer') @endsection

@section('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection

@section('main')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12 ">
                <div class="card">
                    <div class="card-header">Leads Analysis of <a target="_blank" href="{{$listing->full_link}}">{{$listing->title}}</a>. Total Leads: {{$listing->leads->count()}}</div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">When</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">User Phone Number</th>
                                    <th scope="col">User Email</th>
                                    <th scope="col">Vendor Phone</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listing->leads()->latest()->take(20)->cursor() as $lead)
                                    <tr>
                                        <th scope="row">{{$lead->created_at->diffForHumans()}}</th>
                                        <td>{{$lead->user->name}}</td>
                                        <td>{{$lead->user->phone}}</td>
                                        <td>{{$lead->user->email}}</td>
                                        <td><a target="_blank" rel="nofollow noreferrer" href="https://wa.me/91{{$listing->phone}}">Whatsapp {{$listing->phone}}</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

