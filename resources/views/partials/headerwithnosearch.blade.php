<header class="blog-header">
    <div class="container">
        <div class="row flex-nowrap justify-content-between align-items-center" >
            <div class="col-4 pt-1">
                <a class="blog-header-logo" @guest href="{{config('my.APP_URL')}}" @else href="/home" @endguest aria-label="Wuchna"><img src="https://m1.wuchna.com/images/wuchna-logo.png" alt="Wuchna {{config('my.LOCAL_COUNTRY_NAME')}} Logo" style="height:40px"></a>
            </div>
            <div class="col-8 d-flex justify-content-end align-items-center">
                {{--                        <input type="text" v-show="showingsearchinput" id="searchbox"/>--}}
                {{--                        <div id="hits"></div>--}}
                {{--                        <a class="text-muted" href="#" @click.prevent="showsearchinput">--}}
                {{--                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24" focusable="false"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"/><path d="M21 21l-5.2-5.2"/></svg>--}}
                {{--                        </a>--}}
                {{--                    <a class="d-none d-md-block btn btn-sm btn-outline-secondary" href="#">List your Business</a>--}}
                @auth
                    <a href="/home" class="text-dark" style="flex:none">{{auth()->user()->name}}</a>
                    <a href="/logout" class="text-dark ml-4" style="flex:none">Logout</a>
                @endauth
                @guest
                    <a href="/login" class="text-dark" style="flex:none">Login</a>
                    <a href="/register" class="text-dark ml-4" style="flex:none">Register</a>
                @endguest

            </div>
        </div>
    </div>
</header>
