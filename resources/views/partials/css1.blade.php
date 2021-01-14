<style>
    {{ Cache::remember('bootstrapcss',config('my.CACHE_HEAVY_DURATION'), function(){ return file_get_contents(base_path('public/css/app.css')); }) }} ol.breadcrumb li+li:before {padding: 2px;color: blue;content: "/\00a0";} .img-fluid{ max-width: 100%; height: auto;}.bg-soft-primary { background-color: rgba(55, 125, 255, 0.1); } @media (min-width: 768px){ .px-md-8 { padding-left: 6rem!important; } } .list-inline{padding-left:0;list-style:none !important;}.list-inline-item{display:inline-block !important;}.list-inline-item:not(:last-child){margin-right:.5rem} .dropdown-item-icon {display: inline-block; text-align: center; font-size: .75rem; min-width: 1rem; max-width: 1rem; margin-right: .5rem; margin-top: .5rem;}     .st0{fill:#FFC107;}	.st1{fill:#E7EAF3;} .greendot { height: 10px; width: 10px; background-color: lime; border-radius: 50%; display: inline-block;} .reddot { height: 10px; width: 10px; background-color: orangered; border-radius: 50%; display: inline-block;} .blog-header { position: -webkit-sticky; position: sticky; top: 0; background-color: #f8fafc !important; z-index:5; line-height: 1; border-bottom: 1px solid #e5e5e5; padding:5px 0 !important;} .breadcrumb{background-color:inherit !important; padding: 0.75rem 0.25rem;} .bd-placeholder-img { font-size: 1.125rem; text-anchor: middle; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; } @media (min-width: 768px) { .bd-placeholder-img-lg { font-size: 3.5rem; }}  .blog-header-logo { font-family: "Playfair Display", Georgia, "Times New Roman", serif; font-size: 2.25rem;}
    .blog-header-logo:hover {text-decoration: none;} h1, h2, h3, h4, h5, h6 { font-family: "Playfair Display", Georgia, "Times New Roman", serif;} .display-4 { font-size: 2.5rem;} @media (min-width: 768px) { .display-4 { font-size: 3rem;}} .nav-scroller { position: relative; z-index: 2; height: 2.75rem; overflow-y: hidden;} .nav-scroller .nav { display: -ms-flexbox; display: flex; -ms-flex-wrap: nowrap; flex-wrap: nowrap; padding-bottom: 1rem; margin-top: -1px; overflow-x: auto; text-align: center; white-space: nowrap; -webkit-overflow-scrolling: touch;} .nav-scroller .nav-link { padding-top: .75rem; padding-bottom: .75rem; font-size: .875rem;} .card-img-right { height: 100%; border-radius: 0 3px 3px 0;} .flex-auto { -ms-flex: 0 0 auto; flex: 0 0 auto; } .h-250 { height: 250px; } @media (min-width: 768px) { .h-md-250 { height: 250px; } } .avatar { position: relative; display: inline-block; width: 3.125rem; height: 3.125rem; border-radius: .3125rem; } .avatar-lg { width: 4.25rem; height: 4.25rem; } .avatar-img { max-width: 100%; height: auto; border-radius: .3125rem; }  .blog-title { margin-bottom: 0; font-size: 2rem; font-weight: 400; } .blog-description { font-size: 1.1rem; color: #999; }  @media (min-width: 40em) { .blog-title { font-size: 3.5rem; }}  .blog-pagination { margin-bottom: 4rem; }  .blog-pagination > .btn { border-radius: 2rem; } .blog-post { margin-bottom: 4rem; } .blog-post-title { margin-bottom: .25rem; font-size: 2.5rem;} .blog-post-meta { margin-bottom: 1.25rem; color: #999; } .blog-footer { padding: 2.5rem 0; color: #999; background-color: #f9f9f9; border-top: .05rem solid #e5e5e5; } .blog-footer p:last-child { margin-bottom: 0; }
    .wuchna-featured-snippet{border-radius:20px;padding:10px;padding-top:20px;background:rgba(55,125,255,.5);margin:10px; background-image:url(https://wuchna.com/w.png); background-repeat:no-repeat; padding-left:30px; display:block}
    #searchbox{border-radius: 5px; height:30px; border: 1px solid gray; width:100%} .algolia-autocomplete{width:100% !important;} .aa-dropdown-menu{background-color:#fff; font-size: 14px; border:2px solid rgba(228,228,228,.6);border-top-width:0;font-family:open sans,sans-serif;width:100%;margin-top:10px;box-shadow:4px 4px 0 rgba(241,241,241,.35);border-radius:4px;box-sizing:border-box} .aa-suggestion{color:#677788!important;padding:6px 12px;cursor:pointer;-webkit-transition:.2s;transition:.2s;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center} .aa-suggestion:hover,.aa-suggestion.aa-cursor{background-color:rgba(241,241,241,.35)} .aa-suggestion>div{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center;width:100%} .aa-suggestion span:first-child{color:#677788!important} .aa-suggestion span:last-child{text-transform:uppercase;color:#677788!important} .aa-suggestion img{max-width:80px;margin-right:10px} .aa-suggestions-category{text-transform:uppercase;border-bottom:2px solid rgba(228,228,228,.6);border-top:2px solid rgba(228,228,228,.6);padding:10px;color:#677788!important;padding:6px 12px;text-align:left} .aa-suggestion span:first-child em,.aa-suggestion span:last-child em{font-weight:700;font-style:normal;background-color:rgba(58,150,207,.1);padding:2px 0 2px 2px}.aa-dropdown-menu>div{display:inline-block;width:100%;vertical-align:top}.aa-empty{padding:6px 12px}
</style>
