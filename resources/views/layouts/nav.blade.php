<nav class="navbar navbar-default">
  <div class="container-fluid" style="background-color: #cada5c;">
    <!-- Brand and toggle get grouped for better mobile display -->
        

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
 
  @if (App::environment('dev'))
           <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ url('/img/sintbankpics/logo-Sinterklaasbank_test.png') }}" style="margin-top:-11px;">
           </a>
        @else
           <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ url('/img/sintbankpics/logo-Sinterklaasbank.png') }}" style="margin-top:-11px;">
           </a>                
        @endif
 
   </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


<!--
  Hier komt de navigatie voor de admin
-->

@unless (!Auth::check())
@if (Auth::user()->usertype==1)




      <ul class="nav navbar-nav">
  <p class="navbar-text">&nbsp;</p>
        <!--<li class="active"><a href="{{ url('home')  }}">Administrator <span class="sr-only">(current)</span></a></li>-->
  <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>&nbsp;Sitebeheer <span class="caret"></span></a>
          <ul class="dropdown-menu">
    <li><a href="{{ url('/settings/') }}">Instellingen</a></li>
    <li><a href="{{ url('/faq/') }}">Faq aanpassen</a></li>
    <li><a href="{{ url('/blacklist/') }}">Blacklist</a></li>
  </ul>
  <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;Overzichten <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ url('/users/index') }}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;Gebruikersbeheer</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ url('/tellingen/') }}">Tellingen</a></li>
            <li><a href="{{ url('/kinderlijst/') }}">Kinderlijst</a></li>
            <li><a href="{{ url('/gezinnenlijst/') }}">Gezinnenlijst</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ url('/barcodes/') }}">Barcodes</a></li>
          </ul>
  </li>
  <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>&nbsp;Functies <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ url('/sendmailform') }}"><span class="glyphicon glyphicon-enveloppe" aria-hidden="true"></span>&nbsp;Verstuur berichten</a></li>
            <li><a href="{{ url('/template') }}"><span class="glyphicon glyphicon-enveloppe" aria-hidden="true"></span>&nbsp;Bekijk template</a></li>
          </ul>
        </li>

      </ul>
 
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Geef een naam..">
        </div>
        <button type="submit" class="btn btn-default">Zoek</button>
      </form>

@endif
@endunless
<!--
  Einde navigatie voor de admin
-->

      <ul class="nav navbar-nav navbar-right">



                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Inloggen</a></li>
                            <li><a href="{{ url('/inschrijven') }}">Inschrijven</a></li>
                            <li><a href="https://www.sinterklaasbank.nl">Sinterklaasbank.nl</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->getNaam() }} <span class="caret"></span>
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
      <a href="{{url('faq')}}"><button type="button" class="btn btn-primary navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-question-sign"></span>&nbsp;Klik hier voor help</button></a>
      @endif
 






      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
