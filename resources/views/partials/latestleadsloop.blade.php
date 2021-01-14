@if($lead->listing)
    <tr @if($lead->listing->phone == $lead->user->phone) style="background:#efb0b0" @endif>
        <th scope="row">
            <strong>#{{$lead->id}}</strong> &nbsp;&nbsp;&nbsp; {{$lead->created_at->diffForHumans()}} <br><br>
            <a target="_blank" href="{{$lead->listing->full_link}}">{{$lead->listing->title}}</a> <br>
            @if($lead->listing->phone)<a href="https://wa.me/91{{$lead->listing->phone}}" target="_blank">Whatsapp {{$lead->listing->phone}}</a>@endif
        </th>
        <td>{{$lead->user->name}}, {{$lead->user->email}},<br>
            <a target="_blank" rel="nofollow" href="https://wa.me/91/{{$lead->user->phone}}">Whatsapp {{$lead->user->phone}}</a>
        </td>
        <td style="min-width:300px">
            <form method="POST" action="/addleadinteraction/{{$lead->listing->id}}">
                @csrf
                <textarea class="form-control" name="body">@if($lead->listing->interactions->count()){{$lead->listing->interactions()->latest()->first()->body}}@endif</textarea>
                <select name="relationshipstage">
                    <option selected disabled>--</option>
                    <option value="1" @if(isset($lead->listing->data['relationshipstage']) && $lead->listing->data['relationshipstage'] == 1) selected @endif  >Stage 1: We whatsapped</option>
                    <option value="2"  @if(isset($lead->listing->data['relationshipstage']) && $lead->listing->data['relationshipstage'] == 2) selected @endif>Stage 2: They replied</option>
                    <option value="3"  @if(isset($lead->listing->data['relationshipstage']) && $lead->listing->data['relationshipstage'] == 3) selected @endif >Stage 3: Priority requested</option>
                    <option value="4"  @if(isset($lead->listing->data['relationshipstage']) && $lead->listing->data['relationshipstage'] == 4) selected @endif >Stage 4: Conversion</option>
                </select>
                <button type="submit" class="btn btn-sm btn-danger">Save</button>
            </form>
        </td>
        <td>
            @include('partials.latestleadsactions')
        </td>
    </tr>
@endif
