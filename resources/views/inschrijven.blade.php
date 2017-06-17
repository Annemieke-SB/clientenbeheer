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



<h1>Welkom bij de Sinterklaasbank <br><small>Klik hieronder op wat bij u van toepassing is:</small><br></h1><br>


<div class="row">
  <div class="col-sm-6 col-md-6">
    <div class="thumbnail"><br>
      <span style="font-size:4em;text-align: center;width: 100%;" class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>
      <div class="caption">
        <h3>Intermediairs</h3>
        <p>
            <ul class="list-group">
                <li class="list-group-item">Ik begeleid kinderen met een probleemsituatie..</li>
                <li class="list-group-item">Ik zie gezinnen om mij heen die problemen hebben met rondkomen..</li>
                <li class="list-group-item">Ik werk voor een school, in de gezondheidszorg of als een hulpverlener..</li>
            </ul>
        </p>
        <p><a href="{{ url('/voorwaarden') }}" class="btn btn-primary" role="button">Ik ben een intermediair</a></p>
      </div>
    </div>
  </div>


  <div class="col-sm-6 col-md-6">
    <div class="thumbnail"><br>
      <span style="font-size:4em;text-align: center;width: 100%;" class="glyphicon glyphicon-user" aria-hidden="true"></span>
      <div class="caption">
        <h3>Particulieren</h3>
        <p>
            <ul class="list-group">
                <li class="list-group-item">Ik ken iemand ken die in aanmerking zou moeten komen voor de Sinterklaasbank..</li>
                <li class="list-group-item">Ik vind dat mijn gezin in aanmerking zou moeten komen voor de Sinterklaasbank..</li>
                <li class="list-group-item">Ik werk niet bij een hulpverlenings-instelling..</li>
            </ul>
        </p>
        <p><a href="{{ url('/particulier') }}" class="btn btn-primary" role="button">Ik ben een particulier</a></p>
      </div>
    </div>
  </div>
</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
