<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>

    <!-- Latest compiled and minified JavaScript -- >
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js" defer></script-->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Latest compiled and minified CSS -- >
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css" rel="stylesheet"-->

    <style>
        body {
            padding-top: 50px;
        }

        .starter-template {
            padding: 40px 15px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div id="app">
        <!--nav class="navbar navbar-inverse navbar-fixed-top navbar-expand-md navbar-dark bg-dark shadow-sm"-->
        <nav class="navbar navbar-dark bg-dark fixed-top navbar-expand-md navbar-dark bg-dark shadow-sm">
            <!--div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -- >
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -- >
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -- >
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                                <a class="dropdown-item" href="{{ route('changePassword') }}">
                                    {{ __('Change password') }}
                                </a>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>-->

            <div class="navbar navbar-dark bg-dark fixed-top navbar-expand-md">
                <div class="container">
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target=".nav-collapse">&#x2630;</button>

                    <a class="navbar-brand" href="{{URL::route('index')}}">Gallery</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{URL::route('search')}}">All Images</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Albums
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @foreach($allAlbums as $album)
                                    <a class="dropdown-item" href="{{URL::route('show_album',array('id'=>$album->id))}}">{{$album->name}}</a>
                                    @endforeach
                                    <!--a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Something else here</a-->
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">Info</a>
                            </li>
                        </ul>
                        <form class="form-inline my-2 my-lg-0" action="{{URL::route('search')}}" method="GET">
                            <input name="sword" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" pattern="^[a-zA-Z0-9 ]{0,100}$" title="Use only letters from A to Z and numbers 0 to 9!" {!! $errors->has('sword') ? 'style="background-color: #faa"' : ''!!}>
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </form>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                            @endif
                            @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('home') }}">Dashboard</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    @can('isAdmin')
                                    <a class="dropdown-item" href="{{URL::route('create_album_form')}}" class="nav-link">Create New Album</a>
                                    <a class="dropdown-item" href="{{URL::route('add_image_free')}}" class="nav-link">Upload images</a>
                                    <div class="dropdown-divider"></div>
                                    @elsecan('isManager')
                                    <a class="dropdown-item" href="{{URL::route('add_image_free')}}" class="nav-link">Upload images</a>
                                    <div class="dropdown-divider"></div>
                                    @endcan
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                                    <a class="dropdown-item" href="{{ route('changePassword') }}">
                                        {{ __('Change password') }}
                                    </a>
                                </div>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!--div classs="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Awesome Albums</a>
                <div class="nav-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="{{URL::route('create_album_form')}}">Create New Album</a></li>
                    </ul>
                </div>
                <! --/.nav-collapse -- >
            </div>
        </div-->

        <!--
        @if($errors->isNotEmpty())
        <div class="span4" style="display:inline-block;margin-top:5px;text-align:center;">
            <div class="alert alert-warning" role="alert" id="error-block">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">×</button>
                <h4 class="alert-heading">Warning!</h4>
                <ul style="text-align: left;">
                    @foreach($errors->all() as $message)
                    <li>{{$message}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
        -->

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>