<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ url('/') }}/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ url('/') }}/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ url('/') }}/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ url('/') }}/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="{{ url('/') }}/apple-touch-icon-60x60.png" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{ url('/') }}/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="{{ url('/') }}/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ url('/') }}/apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="{{ url('/') }}/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="{{ url('/') }}/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="{{ url('/') }}/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ url('/') }}/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="{{ url('/') }}/favicon-128.png" sizes="128x128" />
    <meta name="application-name" content="Clientenbeheer Sinterklaasbank"/>
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="{{ url('/') }}/mstile-144x144.png" />
    <meta name="msapplication-square70x70logo" content="{{ url('/') }}/mstile-70x70.png" />
    <meta name="msapplication-square150x150logo" content="{{ url('/') }}/mstile-150x150.png" />
    <meta name="msapplication-wide310x150logo" content="{{ url('/') }}/mstile-310x150.png" />
    <meta name="msapplication-square310x310logo" content="{{ url('/') }}/mstile-310x310.png" />






    @yield('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Clientenbeheer') }}</title>

    <!-- Styles -->
    <link href="{{ url('/css/app.css') }}" rel="stylesheet">
    <style type="text/css">
        body {
            background-image: url({{ url('/img/sintbankpics/bg.jpg') }} );
            background-repeat: no-repeat;

        }

        nav.navbar-static-top {
            height: 94px;
            background-color: #cada5c;
            color: #707070;
            font-family: Raleway, arial, sans-serif;
            text-decoration: none;
            vertical-align: center;

        }
    </style>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <style>
    @yield('css')
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header" style="background-color: #cada5c;">

                    <!-- Branding Image -->

                    @if(App::environment('dev'))
                    <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ url('/img/sintbankpics/logo-Sinterklaasbank_test.png') }}">
                    </a>
                    @else
                    <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ url('/img/sintbankpics/logo-Sinterklaasbank.png') }}">
                    </a>                
                    @endif

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" style="background-color: #cada5c;">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse" style="background-color: #cada5c;">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Inloggen</a></li>
                            <li><a href="{{ url('/inschrijven') }}">Inschrijven</a></li>
                            <li><a href="https://www.sinterklaasbank.nl">Sinterklaasbank.nl</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->voornaam }}&nbsp;{{ Auth::user()->achternaam }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/user/edit') }}/{{ Auth::user()->id }}">Wijzig gegevens</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Uitloggen
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                    <li><a href="https://www.sinterklaasbank.nl">Sinterklaasbank.nl</a></li>

                                </ul>
                            </li>
                        @endif
                        @if (!Auth::guest())
                        <a href="#" data-toggle="modal" data-target="#helpbox"><button type="button" class="btn btn-primary navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-question-sign"></span>&nbsp;Klik hier voor help</button></a>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

<!-- Hieronder de modal met help over het toevoegen van gezin-->

    <div class="modal fade" id="helpbox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Help</h4>
          </div>
          <div class="modal-body">
            @include('modalbodies.help')
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;Sluit</button>
            
          </div>
        </div>
      </div>
    </div>

  
<!-- einde modal-->



    </div>

    <!-- Scripts -->
    <script src="{{ url('/js') }}/app.js"></script>
</body>
</html>
