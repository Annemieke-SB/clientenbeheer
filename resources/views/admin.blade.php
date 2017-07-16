@extends('layouts.app')


@section('css')

.pulse {

  
  cursor: pointer;
  box-shadow: 0 0 0 rgba(204,169,44, 0.4);
  animation: pulse 2s infinite;
}
.pulse:hover {
  animation: none;
}

@-webkit-keyframes pulse {
  0% {
    -webkit-box-shadow: 0 0 0 0 rgba(204,169,44, 0.4);
  }
  70% {
      -webkit-box-shadow: 0 0 0 10px rgba(204,169,44, 0);
  }
  100% {
      -webkit-box-shadow: 0 0 0 0 rgba(204,169,44, 0);
  }
}
@keyframes pulse {
  0% {
    -moz-box-shadow: 0 0 0 0 rgba(204,169,44, 0.4);
    box-shadow: 0 0 0 0 rgba(204,169,44, 0.4);
  }
  70% {
      -moz-box-shadow: 0 0 0 10px rgba(204,169,44, 0);
      box-shadow: 0 0 0 10px rgba(204,169,44, 0);
  }
  100% {
      -moz-box-shadow: 0 0 0 0 rgba(204,169,44, 0);
      box-shadow: 0 0 0 0 rgba(204,169,44, 0);
  }
}

@stop



@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">              
      
                    <ol class="breadcrumb">
                      <li class="active">Home</li>

                    </ol>                

                <div class="panel-body">
                 Welkom op de administrator-pagina. Klik op de knoppen hieronder voor de gewenste overzichten of pagina's. 



                    @if ($settings['inschrijven_gesloten'] == 1 && $settings['downloads_ingeschakeld'] == 1) {{-- Inschrijvingen gesloten downloads aktief --}}
                        <br><br>
                        <div class="panel panel-danger">
                              <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | De inschrijvingen zijn gesloten! Er kan niets meer worden gewijzigd of toegevoegd door de intermediairs. De downloadpagina is ook aktief, dus intermediairs kunnen downloaden</b></div>
                        </div>                        
                    @elseif ($settings['inschrijven_gesloten'] == 1 && $settings['downloads_ingeschakeld'] == 0) {{-- Downloads aktief --}}
                        <br><br>
                        <div class="panel panel-danger">
                              <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | De downloadpagina is niet actief!!! De inschrijvingen zijn wel gesloten! Er kan niets meer worden gewijzigd of toegevoegd door de intermediairs maar ze kunnen nog niets downloaden!.</b>
                              </div> 
                        </div>                                           
                    @endif


                </div>
            </div>

            <!-- Flashmessage -->
            @if (count(Session::get('message')) > 0)
            <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
            @endif
                        


                        
            <div class="panel panel-default">    
                <div class="panel-heading">Sitebeheer</div>

                <div class="panel-body">
                    <a class="btn btn-warning" href="{{ url('/settings/') }}" role="button"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>&nbsp;Instellingen</a>
                    <a class="btn btn-warning" href="{{ url('/users/index') }}" role="button"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;Gebruikersbeheer</a>        
                    <a class="btn btn-info" href="/docs/" role="button"><span class="glyphicon glyphicon-book" aria-hidden="true"></span>&nbsp;Documentatie</a>  
                </div>
            </div>

            <div class="panel panel-default">    
            <div class="panel-heading">Overzichten</div>
                <div class="panel-body">
                    <a class="btn btn-info" href="{{ url('/tellingen/') }}" role="button"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;Tellingen</a>      
                    <a class="btn btn-info" href="{{ url('/kinderlijst/') }}" role="button"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;Kinderlijst</a>     


                    @if ($aangemelde_families>0) 

                        <a class="btn btn-info pulse" href="{{ url('/gezinnenlijst/') }}" role="button"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;Gezinnenlijst&nbsp;<span class="badge" data-toggle="tooltip" title="Er zijn aangemeldde gezinnen!">{{$aangemelde_families}}</span></a>

                    @else

                        <a class="btn btn-info" href="{{ url('/gezinnenlijst/') }}" role="button"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;Gezinnenlijst&nbsp;</a>

                    @endif
                    
                    <a class="btn btn-info" href="{{ url('/intermediairs/') }}" role="button"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;Intermediairs</a>
                    <a class="btn btn-info" href="{{ url('/barcodes/') }}" role="button"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;Barcodes</a>
                    </div>
            </div>

            <div class="panel panel-default">    
            <div class="panel-heading">Email naar alle gebruikers (intermediairs en beheerders)</div>
                <div class="panel-body">
                    <p>Met deze knop kan je een email aan alle gebruikers sturen. Klik op template om een voorbeeld te bekijken. Je hoeft zelf alleen de tekst in te voeren voor het tekstveld in te voeren, daar verschijnt de tekst. Alles eromheen staat er al.</p>

                    <blockquote>Dit is alleen bedoeld voor eenvoudige tekst, zonder 'enters' en opmaak.</blockquote>
                    <a class="btn btn-info" href="{{ url('/template/') }}" role="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Template</a>
                    <a class="btn btn-default" href="{{ url('/sendmailform/') }}" role="button"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>&nbsp;Maak email</a>
                    </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Waarschuwingen</div>
                <div class="panel-body">            
                @if($kids_disqualified)
                    <div class="alert alert-danger" role="alert"><b>O nee!</b> Er zijn kinderen die niet in aanmerking komen! Kijk hier <a href="{{ url('/kinderlijst') }}"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a> welke kinderen dat zijn.</div>
                @endif 

                @if($families_disqualified)
                    <div class="alert alert-danger" role="alert">Er zijn hele gezinnen die niet in aanmerking komen! Kijk hier <a href="{{ url('/intermediairs') }}"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a> in kolom 'DF' welke gezinnen dat zijn.</div>
                @endif  

                @if($kids_dubbel)
                    <div class="alert alert-danger" role="alert">Er zijn mogelijk dubbele kinderen! Kijk hier <a href="{{ url('/intermediairs') }}"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a> in kolom 'DB' welke kinderen dat zijn.</div>
                @endif                    

                @if($intermediairzonderfamilies)
                    <div class="alert alert-danger" role="alert">Er zijn intermediairs die nog geen gezinnen hebben ingevoerd! Kijk hier <a href="{{ url('/intermediairs') }}"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a> in kolom 'AF' welke intermediairs dat zijn.</div>
                @endif    

                @if($familieszonderkinderen)
                    <div class="alert alert-danger" role="alert">Er zijn gezinnen waarbij nog geen kinderen zijn ingevoerd! Kijk hier <a href="{{ url('/intermediairs') }}"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a> in kolom 'GK' welke gezinnen dat zijn.</div></div>
                @endif                      

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
