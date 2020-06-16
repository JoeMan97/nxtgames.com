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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                
                <!-- Boton para mostrar el Navbar -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Lado izquierdo del Navbar -->
                    <ul class="navbar-nav mr-auto">
                        
                        <!-- li Juegos -->
                        <!-- Esto no se muestra en pantallas medianas y mas grandes -->
                        <li class="nav-item d-md-none d-lg-none d-xl-none">
                            <a class="nav-link" data-toggle="collapse" href="#collapseGames" role="button" aria-expanded="false" aria-controls="collapseGames">
                                Juegos
                            </a>
                            <div class="collapse" id="collapseGames">
                            <a class="dropdown-item" href="{{ route('connect-4') }}">Conecta 4</a>
                                <a class="dropdown-item" href="{{ route('the-game-of-life') }}">El juego de la vida</a>
                                <a class="dropdown-item" href="{{ route('snake') }}">Snake</a>
                                <a class="dropdown-item" href="{{ route('tetris') }}">Tetris</a>
                            </div>
                        </li>
                        
                        <!-- Esto no se muestra en pantallas extra pequeñas y pequeñas -->
                        <li class="nav-item dropdown d-none d-md-block">
                            <a class="nav-link dropdown-toggle" href="#" id="navbar-dropdown-1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Juegos
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbar-dropdown-1">
                                <a class="dropdown-item" href="{{ route('connect-4') }}">Conecta 4</a>
                                <a class="dropdown-item" href="{{ route('the-game-of-life') }}">El juego de la vida</a>
                                <a class="dropdown-item" href="{{ route('snake') }}">Snake</a>
                                <a class="dropdown-item" href="{{ route('tetris') }}">Tetris</a>
                            </div>
                        </li>
                        
                        <!-- li Puntuaciones -->
                        <!-- Esto no se muestra en pantallas medianas y mas grandes -->
                        <li class="nav-item d-md-none d-lg-none d-xl-none">
                            <a class="nav-link" data-toggle="collapse" href="#collapseScores" role="button" aria-expanded="false" aria-controls="collapseScores">
                                Puntuaciones
                            </a>
                            <div class="collapse" id="collapseScores">
                                <a class="dropdown-item" href="{{ route('global-scores') }}">Tus Puntuaciones</a>
                                <a class="dropdown-item" href="{{ route('user-scores') }}">Puntuaciones Globales</a>
                            </div>
                        </li>

                        <!-- Esto no se muestra en pantallas extra pequeñas y pequeñas -->
                        <li class="nav-item dropdown d-none d-md-block">
                            <a class="nav-link dropdown-toggle" href="#" id="navbar-dropdown-2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Puntuaciones
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbar-dropdown-2">
                                <a class="dropdown-item" href="{{ route('global-scores') }}">Tus Puntuaciones</a>
                                <a class="dropdown-item" href="{{ route('user-scores') }}">Puntuaciones Globales</a>
                            </div>
                        </li>
                        
                        <!-- li Noticias -->
                        <li>
                            <a class="nav-link" href="{{ route('news') }}">Noticias</a>
                        </li>
                    </ul>

                    <!-- Lado derecho del Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Links de autenticacion -->
                        <!-- Si es un invitado... -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif

                        <!-- Si es un usuario... -->
                        @else
                            <!-- li divisor -->
                            <!-- Esto no se muestra en pantallas medianas y mas grandes -->
                            <li class="dropdown-divider d-md-none d-lg-none d-xl-none"></li>

                            <!-- li para cerrar sesion -->
                            <!-- Esto no se muestra en pantallas medianas y mas grandes -->    
                            <li class="nav-item d-md-none d-lg-none d-xl-none">
                                <a class="nav-link" data-toggle="collapse" href="#collapseLogout" role="button"  aria-expanded="false" aria-haspopup="true" v-pre>
                                    <img class="user-picture" src="{{ asset(Auth::user()->picture) }}" >
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <div class="collapse" id="collapseLogout">
                                    <a class="dropdown-item" href="#">
                                        Configuración
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Cerrar Sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>    

                            <!-- Esto no se muestra en pantallas extra pequeñas y pequeñas -->
                            <li class="nav-item dropdown d-none d-md-block">
                                <a id="navbar-dropdown-3" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img class="user-picture" src="{{ asset(Auth::user()->picture) }}">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-dropdown-3" id="dropDownMenuLogout">
                                    <a class="dropdown-item" href="#">
                                        Configuración
                                    </a>

                                    <div href="" class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Cerrar Sesión
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

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
