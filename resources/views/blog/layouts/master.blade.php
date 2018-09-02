<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $meta_description }}">
    <meta name="author" content="{{ config('blog.author') }}">

    <title>{{ $title or config('blog.title') }}</title>
    <link rel="alternate" type="application/rss+xml" href="{{url('rss')}}" title="RSS Feed {{config('blog.title')}}">

    {{-- Styles --}}
    <link href="{{asset('/css/clean-blog.css')}}" rel="stylesheet">
    <link href="{{asset('/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('/bootstrap/js/bootstrap.js')}}" rel="stylesheet">
    <link href="{{asset('/font-awesome/css/font-awesome.min.css')}}">
    <script src="{{asset('/js/jquery.js')}}"></script>
    <script src="{{asset('/js/clean-blog.js')}}"></script>
    @yield('styles')

  {{-- HTML5 Shim and Respond.js for IE8 support --}}
  <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
@include('blog.partials.page-nav')

@yield('page-header')
@yield('content')

@include('blog.partials.page-footer')

{{-- Scripts --}}
{{--<script src="{{ asset ('/js/blog.js')}}"></script>--}}
@yield('scripts')

</body>
</html>