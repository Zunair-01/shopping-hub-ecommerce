<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('./images/favicon.png"') }}'">
    <!-- Page Title  -->
    <title>@yield('title', 'Dashboard')</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('./assets/css/dashlite.css?ver=2.9.0') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('./assets/css/theme.css?ver=2.9.0') }}">
    @yield('css')
</head>

<body class="nk-body bg-white npc-default has-aside ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap ">
                @include('admin.layouts.partials.header')
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container wide-xl">
                        <div class="nk-content-inner">
                            @include('admin.layouts.partials.sidebar')
                            <div class="nk-content-body">
                                @yield('content')

                                @include('admin.layouts.partials.footer')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
        @include('admin.layouts.partials.region')
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="{{ asset('./assets/js/bundle.js?ver=2.9.0') }}"></script>
    <script src="{{ asset('./assets/js/scripts.js?ver=2.9.0') }}"></script>
    <script src="{{ asset('./assets/js/charts/gd-default.js?ver=2.9.0') }}"></script>
    @yield('js')
</body>

</html>
