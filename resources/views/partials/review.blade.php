<div class="row mt-3">
    <div class="col-md-1">
        <img style="width:50px" src="https://m1.wuchna.com/front/assets/img/100x100/img12.jpg" alt="Image of {{$review->user_name ? $review->user_name : $review->user->display_name }}">
    </div>
    <div class="col-md-3">
        <span class="text-muted mb-0">{{$review->created_at->format('d M Y')}}</span>
        <h6 class="mb-0">{{$review->user_name ? $review->user_name : $review->user->display_name }}</h6>
        @if(Auth::check() && auth()->id() == 1 && $review->user && $review->user->phone){{$review->user->phone}} @endif
    </div>
    <div class="col-md-8">
        <small class="float-right mt-n2">
            <i>
                @if(isset($review->data['helpfulcount'])){{$review->data['helpfulcount']}} people found this helpful. Did you?
                @else Found the review Helpful?
                @endif
                <button class="ml-1 btn btn-sm btn-outline-danger" @click="foundReviewHelpful({{$review->id}})">Yes</button>
            </i>
            @if(Auth::check() && auth()->id() == 1 && ! $review->user) <a href="/deletereview/{{$review->id}}" target="_blank" class="btn btn-danger btn-sm">Delete review</a>@endif
            @if(Auth::check() && auth()->id() == 1) <a href="/editreview/{{$review->id}}" target="_blank" class="btn btn-warning btn-sm">Edit review</a>@endif

        </small>
        <ul class="list-inline mt-n1 mb-2">
            @if($review->rating >= 1)<li class="list-inline-item mx-0">
                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/> </svg>
            </li>
            @else
                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
            @endif
            @if($review->rating >= 2)<li class="list-inline-item mx-0">
                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/> </svg>
            </li>
            @else
                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
            @endif
            @if($review->rating >= 3)<li class="list-inline-item mx-0">
                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/> </svg>
            </li>
            @else
                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
            @endif
            @if($review->rating >= 4)<li class="list-inline-item mx-0">
                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/> </svg>
            </li>
            @else
                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
            @endif
            @if($review->rating >= 5)<li class="list-inline-item mx-0">                                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"> <path class="st0" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/> </svg>
            </li>
            @else
                <svg width="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16.7 15.9" style="enable-background:new 0 0 16.7 15.9;" xml:space="preserve"><path class="st1" d="M8.7,0.2L11,4.9c0.1,0.1,0.2,0.2,0.3,0.2l5.1,0.7c0.3,0,0.4,0.4,0.2,0.6L12.9,10c-0.1,0.1-0.1,0.2-0.1,0.3 l0.9,5.1c0.1,0.3-0.3,0.5-0.5,0.4l-4.7-2.3c-0.1,0-0.2,0-0.3,0l-4.6,2.4C3.3,16,3,15.8,3.1,15.5L4,10.4c0-0.1,0-0.2-0.1-0.3L0.1,6.4 C-0.1,6.2,0,5.9,0.3,5.9l5.1-0.7c0.1,0,0.2-0.1,0.3-0.2L8,0.2C8.2-0.1,8.6-0.1,8.7,0.2z"/></svg>
            @endif
        </ul>

        <p class="mb-0" style="max-height:150px; overflow: auto;">{{$review->body}}</p>
    </div>
    <div class="col-md-12">
        <div class="px-3"></div>
        @if($review->vendor_reply)
            <div class="bg-light rounded border px-3">
                Owner Reply @if(isset($review->replied_at))(<span class="text-muted mb-0">{{$review->replied_at->format('d M Y')}}</span>)@endif: {{$review->vendor_reply}}
            </div>
        @endif
    </div>
</div>
