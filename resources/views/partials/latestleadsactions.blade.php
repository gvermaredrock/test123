@php
$rulesmatched = \App\LeadDistributionRules::whereNotNull('city_id')->whereNull('locality_id')->where('city_id',$lead->listing->city_id)->where('category_id',$lead->listing->category_id)->get()
->merge(
    \App\LeadDistributionRules::whereNull('city_id')->whereNotNull('locality_id')->where('locality_id',$lead->listing->locality_id)->where('category_id',$lead->listing->category_id)->get()
)->merge(
    \App\LeadDistributionRules::whereNull('city_id')->whereNull('locality_id')->where('category_id',$lead->listing->category_id)->get()
);


if($rulesmatched->count()){
    foreach ($rulesmatched as $match){
        echo "Lead to be distributed. ";
        if($match->listing->phone){echo 'Send to: <a style="color:blue; font-size:18px; font-weight:bold" href="https://wa.me/91'.$match->listing->phone.'">'.$match->listing->phone.'</a>'; }
        echo "<br><br>";

    }
}
@endphp

@if($lead->listing->phone)
    @if( isset($lead->listing->data['nowhatsapp']))
        <button class="btn btn-sm btn-secondary">Whatsapp not available at this number</button>
    @else
        <a href="/nowhatsapp/{{$lead->listing->id}}" class="btn btn-sm  btn-danger">No Whatsapp</a>
    @endif
    <a href="/deletephone/{{$lead->listing->id}}" class="btn btn-sm btn-info">Delete Phone number</a>
@else
    <button class="btn btn-sm btn-secondary">No Phone number for this listing</button>
@endif
