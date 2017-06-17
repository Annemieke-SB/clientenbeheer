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
                <div class="panel-heading">Inschrijving voltooid</div>

                <div class="panel-body">
                    <h1>Bedankt voor het aanmelden</h1>
                    <p>Uw inschrijving is bijna voltooid. De Sinterklaasbank moet uw aanmelding alleen nog goedkeuren. Hier gaat enige tijd overheen, zoals u ook in uw email heeft kunnen lezen. Vind u het te lang duren, neem dan contact op met de webmaster: webmaster@sinterklaasbank.nl.</p><p>Met vriendelijke groet, <br><br></p><p>Stichting de Sinterklaasbank</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection