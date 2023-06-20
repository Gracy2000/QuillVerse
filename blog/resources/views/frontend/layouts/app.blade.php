<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Pen-It')</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta charset="utf-8">
    <meta name="author" content="John Doe">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{asset('frontend/assets/img/favicon.png')}}">
    <link rel="apple-touch-icon" href="{{asset('frontend/assets/img/apple-touch-icon.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('frontend/assets/img/apple-touch-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('frontend/assets/img/apple-touch-icon-114x114.png')}}">

    <!-- Load Core CSS
    =====================================-->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/core/bootstrap-3.3.7.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/core/animate.min.css')}}">

    <!-- Load Main CSS
    =====================================-->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/main/main.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/main/setting.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/main/hover.css')}}">


    <link rel="stylesheet" href="{{asset('frontend/assets/css/color/pasific.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/icon/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/icon/et-line-font.css')}}">

    <style>

            .loader-items {
                position: absolute;
                top: 0;
                left: 50%;
                transform: translate(-50%,200%)
            }
            h1.loader {
            font-family: ‘Arial Narrow’, sans-serif;
            font-weight: 100;
            font-size: 1.1em;
            color: #a3e1f0;
            }

            .loader span {
            font-size: 40px;
            position: relative;
            top: 0.63em;
            display: inline-block;
            text-transform: uppercase;
            opacity: 0;
            transform: rotateX(-90deg);
            }

            .let1 {
            animation: drop 1.2s ease-in-out infinite;
            animation-delay: 0.1s;
            }

            .let2 {
            animation: drop 1.2s ease-in-out infinite;
            animation-delay: 0.2s;
            }

            .let3 {
            animation: drop 1.2s ease-in-out infinite;
            animation-delay: 0.3s;
            }

            .let4 {
            animation: drop 1.2s ease-in-out infinite;
            animation-delay: 0.4s;

            }

            .let5 {
            animation: drop 1.2s ease-in-out infinite;
            animation-delay: 0.5s;
            }

            .let6 {
            animation: drop 1.2s ease-in-out infinite;
            animation-delay: 0.6s;
            }

            .let7 {
            animation: drop 1.2s ease-in-out infinite;
            animation-delay: 0.8s;
            }

            @keyframes drop {
                10% {
                    opacity: 0.5;
                }
                20% {
                    opacity: 1;
                    top: 3.78em;
                    transform: rotateX(-360deg);
                }
                80% {
                    opacity: 1;
                    top: 3.78em;
                    transform: rotateX(-360deg);
                }
                90% {
                    opacity: 0.5;
                }
                100% {
                    opacity: 0;
                    top: 6.94em
                }
            }


    </style>
    @yield('styles')
    <!-- Load JS
    HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
    WARNING: Respond.js doesn't work if you view the page via file://
    =====================================-->

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body id="topPage" data-spy="scroll" data-target=".navbar" data-offset="100">



<!-- Page Loader
===================================== -->
@include('frontend.layouts._page-loader')

<a href="#page-top" class="go-to-top">
    <i class="fa fa-long-arrow-up"></i>
</a>


<!-- Navigation Area
===================================== -->
@include('frontend.layouts._navbar')


<!-- Main Header
===================================== -->
@include('frontend.layouts._main-header')

<!-- Blog Area
===================================== -->
@yield('main-content')


<!-- Newsletter Area
=====================================-->
@include('frontend.layouts._newsletter-section')


<!-- Footer Area
=====================================-->
@include('frontend.layouts._footer')


<!-- JQuery Core
=====================================-->
<script src="{{asset('frontend/assets/js/core/jquery.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/core/bootstrap-3.3.7.min.js')}}"></script>

<!-- Magnific Popup
=====================================-->
<script src="{{asset('frontend/assets/js/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/magnific-popup/magnific-popup-zoom-gallery.js')}}"></script>

<!-- JQuery Main
=====================================-->
<script src="{{asset('frontend/assets/js/main/jquery.appear.js')}}"></script>
<script src="{{asset('frontend/assets/js/main/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/main/parallax.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/main/jquery.sticky.js')}}"></script>
<script src="{{asset('frontend/assets/js/main/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/main/main.js')}}"></script>

@yield('scripts')

</body>
</html>
