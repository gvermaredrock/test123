    <div class="container">
{{--        @if(\App\ReportCase::where('data->status','Under Review')->cursor()->count())--}}
        <div class="card mb-5">
            <div class="card-header">Admin Section</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ReportCase</th>
                        <th scope="col">Listing</th>
                        <th scope="col">Handle</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(\App\ReportCase::latest()->take(10)->cursor() as $verifiedcase)
                        @if($verifiedcase->listing)
                        <tr>
                            <th scope="row">{{$verifiedcase->id}}</th>
                            <td>{{\Str::words($verifiedcase->body,40)}}</td>
                            <td><a href="{{$verifiedcase->listing->full_link}}">{{$verifiedcase->listing->title}}</a></td>
                            <td>
                                <a href="/deletelisting/{{$verifiedcase->listing->id}}">Delete Listing</a>
                                <a target="_blank" href="/approvereportcase/{{$verifiedcase->id}}">Approve Report</a>
                            </td>
                        </tr>
                        @endif
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
{{--        @endif--}}
    </div>
