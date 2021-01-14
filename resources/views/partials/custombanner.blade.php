@if($category)

@if(in_array($category->slug, ['seo-company','software-development','website-development','digital-marketing','social-media-marketing']))
<div class="bg-soft-primary my-4"><div class="container py-5">
        <form action="/{{$category->slug}}-lead" method="POST">
        <div class="row">
        @csrf
        <div class="col-12 col-md-6">
            @php switch ($category->slug) {
                case "seo-company": echo "<h2>Looking for SEO which brings results? </h2>"; break;
                case "software-development": echo "<h2>Looking for reliable Software Developers?</h2>"; break;
                case "website-development": echo "<h2>Looking for a proper business Website?</h2>"; break;
                case "digital-marketing": echo "<h2>Looking for a reliable digital marketing partner?</h2>"; break;
                case "social-media-marketing": echo "<h2>Looking for an efficient social media marketing firm?</h2>"; break;
                } @endphp
        </div>
        <div class="col-12 col-md-6">
            <h6>Just enter your mobile, and we will get back to you </h6>
            <span class="input-group" >
                <input type="text" class="mt-2 form-control @if($errors->any()) is-invalid @endif" id="leadinput" name="mobile" placeholder="9871002345" required autofocus>
                @if($errors->any())<span class="invalid-feedback">@foreach($errors->all() as $error){{$error}}@endforeach </span>@endif
            </span>
            <button id="leadsubmitbutton" type="submit" class="btn btn-danger btn-sm mt-3">Submit</button>
        </div>
    </div>
</form></div></div>
    <script>
        var input = document.getElementById("leadinput");
        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) { event.preventDefault(); document.getElementById("leadsubmitbutton").click(); }
        });
    </script>
@else
@endif




@endif
