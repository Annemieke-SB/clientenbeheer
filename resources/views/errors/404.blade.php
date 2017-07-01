<!DOCTYPE html>
<html>
    <head>
        <title>Sorry!</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato', sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content"><img src="{{ url('/img/mijter.gif') }}">


                <div class="jumbotron">
                <div class="title">Oeps!</div>
                @if (request()->is('/register/verify/{token}'))
                  <h1>De verificatielink is al gebruikt!</h1>
                  <p>Klopt dit niet? Kopieer dan het adres en mail het de <a href="mailto:webmaster@sinterklaasbank.nl">webmaster</a></p>
                  <a href="{{ url('login') }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Log in</button></a>

                @else
                  <h1>De pagina bestaat helemaal niet!</h1>


                  <p>Klopt dit niet? Kopieer dan het adres en mail het de <a href="mailto:webmaster@sinterklaasbank.nl">webmaster</a></p>
                  <a href="{{ url(URL::previous()) }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                @endif
                  
                </div>
            </div>
        </div>
    </body>
</html>
