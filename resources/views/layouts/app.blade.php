<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>HoubaBook</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ __('HoubaBook') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mx-auto-auto">
                        <div class="mx-auto">
                            <form action="{{ route('search') }}" method="POST" role="search">
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <input id="search" type="search" class="form-control{{ $errors->has('search') ? ' is-invalid' : '' }}" name="search" placeholder="Rechercher" required>
                                    <button type="submit" class="btn btn-light">
                                        <span class="fa fa-search bg-light"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </ul>
        
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            @if (Route::has('register'))
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Inscription') }}</a>
                            @endif
                        </li>
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @inject('helper', 'App\User')
                                <i class="fa fa-user"><span class="badge badge-danger">{{ count(Auth::User()->invitations()) }}</span></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if(count(Auth::User()->invitations()) == 0)
                                    <div class="container">
                                        <div class="row">
                                            <div class="mx-auto">
                                                <p class="lead">Aucune requête d'invitation</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    @foreach($helper->all()->except(Auth::id()) as $user)
                                        @if($user->invitationsRecus())
                                            <div class="container">
                                                <div class="row">
                                                    <div class="mx-auto">
                                                        <p class="lead"><a href="{{ route('detailUser', $user->id) }}"> {{ $user->prenom }} {{ $user->nom }}  </a><br> {{ $user->race }} {{ $user->getAge() }} ans.</p>
                                                        <div class="ml-auto">
                                                            <a href="{{ route('acceptFriend', $user->id) }}">
                                                                <button type="button" class="btn btn-info btn-sm" style="float:left;"><i class="fa fa-user-plus" style="color:white;"></i> Accepter</button>
                                                            </a>
                                                            <a href="{{ route('deleteFriend', $user->id) }}">
                                                                <button type="button" class="btn btn-danger btn-sm" style="float:left;"><i class="fa fa-trash" style="color:white;"></i> Décliner</button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><hr>
                                        @endif     
                                    @endforeach
                                @endif
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Houba, Houba! {{ Auth::user()->nom }} {{Auth::user()->prenom }}<span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('account') }}">
                                {{ __('Mon compte') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Déconnexion') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @include('flash-message')
    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
