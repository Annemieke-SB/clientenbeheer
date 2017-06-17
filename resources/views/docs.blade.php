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
                <div class="panel-heading">Documentatie</div>




                <div class="panel-body">
                    <p>{{ Html::link('/home/', '<button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button>', 'Terug', array(), false)}}
                    </p>
                <h1>Handleiding Clientenbeheer</h1>

                <h2>Algemene Werking Clientenbeheer</h2>
                <p>Deze site is de administratie van de kinderen, gezinnen en intermediairs van de Sinterklaasbank.</p>
                <p>Het principe is dat de intermediairs zichzelf inschrijven, de families aanmaken en daaronder de kinderen. Het is van belang dat de intermediairs ook zorg dragen voor de correctie invoer. De Sinterklaasbank-beheerders zien erop toe dat dit wordt nageleegd. Intermediairs zien in hun overzichten dat er (mogelijk) gegevens niet kloppen. Wanneer van toepassing krijgt een intermediair de contactgegevens van een andere intermediair om met elkaar contact op te nemen wanneer er sprake is van een (mogelijke) dubbele invoer. </p>

                <blockquote>Deze handleiding is nog niet af!</blockquote>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
