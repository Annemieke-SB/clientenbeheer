@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">


                        
            <div class="panel panel-default">
                <div class="panel-heading">Inschrijving bijna voltooid</div>

                <div class="panel-body">            <!-- Flashmessage -->
            @if (Session::get('message'))
            <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
            @endif
                    <h1>Een ogenblikje nog..</h1>
                    <p>Bedankt voor het aanmelden! Uw inschrijving is bijna voltooid. De Sinterklaasbank moet uw aanmelding nog goedkeuren. Hier kan wat tijd overheen gaan omdat we alle aanmeldingen handmatig controleren. We hopen op uw begrip hiervoor...</p><p>U krijgt van ons een email als uw account is goedgekeurd! </p><p>Vindt u het te lang duren, neem dan contact met ons op via <a href="mailto:info@sinterklaasbank.nl">info@sinterklaasbank.nl</a>.</p><p>Met vriendelijke groet, <br><br></p><p>Stichting de Sinterklaasbank</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection