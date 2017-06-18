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


                @if (Auth::user()->usertype==1)
                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li><a href="{{ url('/intermediairs') }}">Intermediairs</a></li>
                      <li><a href="{{ url('/intermediairs') }}/show/{{ $intermediair->id }}">{{ $eigenaar->voornaam }} {{ $eigenaar->achternaam }}</a></li>
                      <li><a href="{{ url('/family') }}/show/{{ $family->id }}">Fam {{$family->achternaam}}</a></li>
                      <li class="active">{{$kid->voornaam}}</li>
                    </ol>
                @elseif (Auth::user()->usertype==3)
                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li><a href="{{ url('/family') }}/show/{{ $family->id }}">Fam {{$family->achternaam}}</a></li>
                      <li class="active">{{$kid->voornaam}}</li>
                    </ol>
                @endif


                <div class="panel-body">
                 Op deze pagina staan alle gegevens die betrekking hebben dit kind.


                @if($kid->family->aangemeld==1 && $kid->family->goedgekeurd==0)
                <br><br>
                    <div class="panel panel-warning">                      
                      <div class="panel-body bg-warning">
                        <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>&nbsp;Dit gezin is al aangemeld maar wacht nog op goedkeuring van de Sinterklaasbank. Als u wijzigingen wilt aanbrengen moet u de aanmelding weer intrekken (onderaan de gezinspagina).
                      </div>
                    </div>
                @endif

                @if($kid->family->aangemeld==1 && $kid->family->goedgekeurd==1)
                <br><br>
                    <div class="panel panel-success">                      
                      <div class="panel-body bg-success">
                        <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>&nbsp;Dit gezin is al aangemeld en goedgekeurd door de Sinterklaasbank. Als u wijzigingen wilt aanbrengen moet u de aanmelding weer intrekken (onderaan de gezinspagina).
                      </div>
                    </div>
                @endif
                         
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Kindgegevens</div>

                <div class="panel-body">
                    @if (!$kid->targetkid && !$kid->targetsibling)
                    <div class="panel panel-danger">
                      <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | Dit kind valt niet in de doelgroep!</b></div>
                      <div class="panel-body bg-danger">
                        Dit kind valt niet in beide doelgroepen (kind en broer/zus), en komt niet in aanmerking voor de sinterklaasbank.&nbsp;
                      </div>
                    </div>
                    @endif

                    @if ($kid->heeftkindmogelijkdubbel)
                    <div class="panel panel-danger">
                      <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | Kind mogelijk {{$family->heeftkindmogelijkdubbel}} keer dubbel ingevoerd!</b></div>
                      <div class="panel-body bg-danger">
                        Op basis van geboortedatum/voornaam blijkt dat het kind mogelijk dubbel is ingevoerd. Zie in het onderstaande overzicht van kinderen. 
                        Klik op het kind en neem contact op met de intermediair om dit op te lossen. De sinterklaasbank rekent erop dat intermediairs dubbelen onderling oplossen.
                      </div>
                    </div>
                    @endif

                    @if ($kid->disqualified && $kid->targetsibling)
                    <div class="panel panel-danger">
                      <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | 
                        @if ($kid->disqualified)
                            Dit kind valt buiten de boot!
                        @endif  
                        </b></div>
                      <div class="panel-body bg-danger">
                        Dit kind valt wel in de (broer/zus) doelgroep maar heeft geen broertjes of zusjes die in de eerste doelgroep vallen. Als dat wel zo is, moet u deze (nog) toe te voegen.
                      </div>
                    </div>
                    @endif

                    @if ($kid->geboortedatumvoornaamdubbel)
                    <div class="panel panel-danger">
                      <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | Dit kind is mogelijk dubbel ingevoerd!</b></div>
                      <div class="panel-body bg-danger">
                        Er is al een kind met deze voornaam en geboortedatum ingevoerd. Neem contact op met de andere intermediair(s) om dit op te lossen;<br>
                            @foreach($kid->geboortedatumvoornaamdubbel as $ander)
                                @if ($kid->id != $ander->id)
                                <br>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;<b>Betreft een kind met achternaam {{$ander->achternaam}}</b> <br>&nbsp;&nbsp;&nbsp;{{$ander->intermediairgegevens}}<br>
                                @endif
                            @endforeach
                      </div>
                    </div>
                    @endif

                    <table>

                        <tr>
                            <td>Familienaam&nbsp;</td><td> : </td><td>&nbsp;Familie {{ $family->achternaam }}&nbsp;</td>
                        </tr>
                        <tr>                            
                            <td>Voor- en achternaam&nbsp;</td><td> : </td><td>&nbsp;{{ $kid->voornaam }}&nbsp;
                                    @if (!$kid->achternaam)
                                    {{ $family->achternaam }}
                                    @else
                                    {{ $kid->achternaam }}
                                    @endif
                            &nbsp;</td>
                        </tr>
                        <tr>                                                     
                            <td>geboortedatum&nbsp;</td><td> : </td><td>&nbsp;{{ $kid->geboortedatum }}</td></tr><tr>  
                            <td>Uniek nummer&nbsp;</td><td> : </td><td>&nbsp;{{ $kid->unieknummer }}</td></tr><tr>  
                            <td>Leeftijd volgend sinterklaas&nbsp;</td><td> : </td><td>&nbsp;{{ $kid->agenextsint }}</td></tr><tr>  
                            <td>Geslacht&nbsp;</td><td> : </td><td>&nbsp;{{ $kid->geslacht }}

                        </td>
                        </tr>

                    </table>

                    @if ($settings['inschrijven_gesloten'] == 1) {{-- Inschrijvingen gesloten --}}
                        <br><br>
                        <div class="panel panel-danger">
                              <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | De inschrijvingen zijn gesloten! Er kan niets meer worden gewijzigd of toegevoegd door de intermediairs.</b></div>
                        </div>                        
                    @else
                        @if (Auth::user()->usertype==3)
                            @if(!$kid->family->aangemeld)
                              {{ Html::link('/kids/edit/'.$kid->id, '<button type="button" class="btn btn-primary navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Wijzig</button>', 'Wijzig', array(), false)}}

                              <a href="{{ url('/kids/edit/'.$kid->id) }}"><button type="button" class="btn btn-primary navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Wijzig</button></a>
                            @endif
                        @endif    
                    @endif              

                    <a href="{{ url('/family/show/'.$kid->family_id) }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                </div>
            </div>    
            
        </div>
    </div>
</div>


<script type="text/javascript">


$(document).ready(function() {
// Hier om de tooltips te activeren
$('[data-toggle="tooltip"]').tooltip();
});



</script>
@endsection

