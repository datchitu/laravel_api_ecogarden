<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A project management Bootstrap theme by Medium Rare">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Gothic+A1" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet" type="text/css" media="all" />
</head>

<body>

<div class="layout layout-nav-side">
    <div class="navbar navbar-expand-lg bg-dark navbar-dark sticky-top">
        <div class="d-flex align-items-center">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="d-block d-lg-none ml-2">
                <div class="dropdown">
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="nav-side-user.html" class="dropdown-item">Profile</a>
                        <a href="utility-account-settings.html" class="dropdown-item">Account Settings</a>
                        <a href="#" class="dropdown-item">Log Out</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse flex-column" id="navbar-collapse">
            <ul class="navbar-nav d-lg-block">
                @foreach(config('menu') as $item)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route($item['route']) }}" title="{{ $item['name'] }}">{{ $item['name'] }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
    <div class="main-container">

        <div class="container-fluid">
            <div class="row justify-content-center">
                @yield('content')
            </div>
        </div>

    </div>
</div>

<!-- Required vendor scripts (Do not remove) -->
<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>

<!-- Optional Vendor Scripts (Remove the plugin script here and comment initializer script out of index.js if site does not use that feature) -->

<!-- List.js - filter list elements -->
{{--<script type="text/javascript" src="{{ asset('js/list.min.js') }}"></script>--}}

<!-- Required theme scripts (Do not remove) -->
{{--<script type="text/javascript" src="{{ asset('js/theme.js') }}"></script>--}}

<!-- This appears in the demo only - demonstrates different layouts -->
<style type="text/css">
    .layout-switcher{ position: fixed; bottom: 0; left: 50%; transform: translateX(-50%) translateY(73px); color: #fff; transition: all .35s ease; background: #343a40; border-radius: .25rem .25rem 0 0; padding: .75rem; z-index: 999; }
    .layout-switcher:not(:hover){ opacity: .95; }
    .layout-switcher:not(:focus){ cursor: pointer; }
    .layout-switcher-head{ font-size: .75rem; font-weight: 600; text-transform: uppercase; }
    .layout-switcher-head i{ font-size: 1.25rem; transition: all .35s ease; }
    .layout-switcher-body{ transition: all .55s ease; opacity: 0; padding-top: .75rem; transform: translateY(24px); text-align: center; }
    .layout-switcher:focus{ opacity: 1; outline: none; transform: translateX(-50%) translateY(0); }
    .layout-switcher:focus .layout-switcher-head i{ transform: rotateZ(180deg); opacity: 0; }
    .layout-switcher:focus .layout-switcher-body{ opacity: 1; transform: translateY(0); }
    .layout-switcher-option{ width: 72px; padding: .25rem; border: 2px solid rgba(255,255,255,0); display: inline-block; border-radius: 4px; transition: all .35s ease; }
    .layout-switcher-option.active{ border-color: #007bff; }
    .layout-switcher-icon{ width: 100%; border-radius: 4px; }
    .layout-switcher-body:hover .layout-switcher-option:not(:hover){ opacity: .5; transform: scale(0.9); }
    @media all and (max-width: 990px){ .layout-switcher{ min-width: 250px; } }
    @media all and (max-width: 767px){ .layout-switcher{ display: none; } }
</style>
<div class="layout-switcher" tabindex="1">
    <div class="layout-switcher-head d-flex justify-content-between">
        <span>Select Layout</span>
        <i class="material-icons">arrow_drop_up</i>
    </div>
    <div class="layout-switcher-body">

    </div>
</div>

</body>

</html>
