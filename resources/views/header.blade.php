<header class="blog-header mb-3">
    <div class="container">
        <div class="row flex-nowrap justify-content-between align-items-center" >
            <div class="col-1 col-md-6 pt-1" v-show="!showingsearchinput">
                <a class="blog-header-logo d-none d-md-block" href="{{config('my.APP_URL')}}" aria-label="Wuchna"><img src="https://m1.wuchna.com/images/wuchna-logo.png" alt="Wuchna {{config('my.LOCAL_COUNTRY_NAME')}} Logo" style="height:40px"></a>
                <a class="blog-header-logo d-block d-md-none" href="{{config('my.APP_URL')}}" aria-label="Wuchna"><img src="/w.png" alt="Wuchna {{config('my.LOCAL_COUNTRY_NAME')}} Logo" style="height:40px"></a>
            </div>
            <div class="d-flex justify-content-end align-items-center" ref="searchcontainer" v-bind:class="{ 'col-12': showingsearchinput, 'col-11': !showingsearchinput, 'col-md-12': showingsearchinput, 'col-md-6': !showingsearchinput}">
                <input ref="searchbox" type="text" v-show="showingsearchinput" id="searchbox"/>
                <div id="hits"></div>
                <a class="text-dark" href="#" @click.prevent="showsearchinput" name="searchboxbutton" title="searchboxbutton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="red" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="mx-3" role="img" viewBox="0 0 24 24"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"/><path d="M21 21l-5.2-5.2"/></svg>
                </a>
                @auth
                <a href="/home" class="text-dark" style="flex:none" v-show="!showingsearchinput">{{auth()->user()->name}}</a>
                @endauth
                @guest
                    <a href="/login" class="ml-4 text-dark" style="flex: 0 0 auto;">Login</a>
                    <a href="/register" class="text-dark ml-4" style="flex: 0 0 auto;">Register</a>
                @endguest
{{--                <a class="d-none d-md-block btn btn-sm btn-outline-secondary" href="#">List your Business</a>--}}
            </div>
        </div>
    </div>
</header>
