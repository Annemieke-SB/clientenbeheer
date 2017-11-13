@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- Flashmessage -->
            @if (count(Session::get('message')) > 0)
            <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
            @endif
                        
            <div class="panel panel-default">
                <div class="panel-heading">Inschrijven</div>




                <div class="panel-body">



<h1>Welkom bij de Sinterklaasbank <br><small>De inschrijvingen zijn gesloten</small><br></h1><br>


<p>Helaas zijn de inschrijvingen momenteel gesloten. Het is dus niet (meer) mogelijk om op dit moment gezinnen en kinderen aan te melden. Houdt onze site in de gaten zodat u weet wanneer hij weer open gaat. 
</p>
<p>
  Met vriendelijke groeten,<br><br><br>
  Het Sinterklaasbank-team
</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
