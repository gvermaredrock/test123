<link rel="dns-prefetch" href="https://m1.wuchna.com" /><link rel="dns-prefetch" href="https://m2.wuchna.com" /><link rel="dns-prefetch" href="https://m3.wuchna.com" />
<title>{{$title}}</title>
<meta name="description" content="{{$description}}" />
<meta property="og:title" content="{{$title}}">
<meta property="og:description" content="{{$description}}">
<meta property="og:image" content="{{config('my.APP_URL')}}/wuchna-logo.png">
<meta property="og:url" content="{{config('my.APP_URL')}}">
<meta name="twitter:title" content="{{$title}}">
<meta name="twitter:description" content="{{$description}}">
<meta name="twitter:image" content="{{config('my.APP_URL')}}/wuchna-logo.png">
<meta name="twitter:url" content="{{config('my.APP_URL')}}">
<link rel="canonical" href="{{$canonical ?? url()->current()}}" />
<script type='application/ld+json'> {
"@context": "https://schema.org/",
"@type": "Organization",
"name": "Wuchna, Inc.",
"url": "https://wuchna.com/",
"logo": "https://wuchna.com/wuchna-logo.png",
"email": "info@wuchna.com",
"sameAs": [
"https://www.facebook.com/wuchna",
"https://www.instagram.com/wuchnadotcom/"
]
}</script><script type='application/ld+json'> {
"@context": "https://www.schema.org",
"@type": "WebSite",
"name": "Wuchna {{config('my.LOCAL_COUNTRY_NAME')}}",
"url": "{{config('my.APP_URL')}}"
}</script>
