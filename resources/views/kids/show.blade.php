@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">  
        <div class="col-md-8 col-md-offset-2">
                                    <!-- Flashmessage -->
                        @if (Session::get('message'))
                        <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
                        @endif
                        
            <div class="panel panel-default">    


                @if (Auth::user()->usertype==1)
                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li><a href="{{ url('/users/index') }}">Gebruikers</a></li>
                      <li><a href="{{ url('/user') }}/show/{{ $kid->user->id }}">{{ $kid->user->naam }}</a></li>
                      <li><a href="{{ url('/family') }}/show/{{ $kid->family->id }}">Gezin {{ $kid->family->naam }}</a></li>
                      <li class="active">{{ $kid->naam }}</li>
                    </ol>
                @elseif (Auth::user()->usertype==3)
                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li><a href="{{ url('/family') }}/show/{{ $kid->family->id }}">Gezin {{ $kid->family->naam }}</a></li>
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
                                <br>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;<b>Betreft een kind met achternaam {{$ander->tussenvoegsel}} {{$ander->achternaam}}</b> <br>&nbsp;&nbsp;&nbsp;<a href="{{ url('user/show'). "/$ander->user_id"}}">klik hier om die intermediair te zien</a><br>
                                @endif
                            @endforeach
                      </div>
                    </div>
                    @endif

                    <table>

                        <tr>
                            <td>Gezin&nbsp;</td><td> : </td><td>&nbsp;
                            @if ( $kid->family->tussenvoegsel != "" )
                                 {{$kid->family->tussenvoegsel}}&nbsp;
                            @endif
                            {{$kid->family->achternaam}}&nbsp;</td>
                        </tr>
                        <tr>                            
                            <td>Naam&nbsp;</td><td> : </td><td>&nbsp;{{ $kid->naam }}&nbsp;
                            </td>
                        </tr>
                        <tr>                                                     
                            <td>geboortedatum&nbsp;</td><td> : </td><td>&nbsp;{{ $kid->geboortedatum }}</td></tr><tr>  
                            <td>Leeftijd op Sinterklaasavond&nbsp;</td><td> : </td><td>&nbsp;{{ $kid->agenextsint }}</td></tr><tr>  
                            <td>Geslacht&nbsp;</td><td> : </td><td>&nbsp;{{ $kid->geslacht }}</td></tr>
                            @if (Auth::user()->usertype==1) 
                              <tr><td>Verzilverd bedrag&nbsp;</td><td> : </td><td>&nbsp;{{ $kid->bedragverzilverd }}

                              </td></tr>
                            @endif       

                    </table>

                    @if ( !$kid->bedragverzilverd && Auth::user()->usertype==1 )
                                {!! Form::open(['url' => 'barcodes/doorgeven_reden_nietgebruik']) !!}
                                {!! Form::token() !!}

                                <div class="form-group">

                                    {!! Form::text('reden_nietgebruikt', $kid->barcode->reden_nietgebruikt) !!}
                                    {!! Form::hidden('id', $kid->barcode->id) !!}
                                    {!! Form::submit('verwerk') !!}

                                </div>    
                                {!! Form::close() !!}
                    @endif

                    @if ($gesloten == 1) {{-- Inschrijvingen gesloten --}}
                        <br><br>
                        <div class="panel panel-danger">
                              <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | De inschrijvingen zijn gesloten! Er kan niets meer worden gewijzigd of toegevoegd door de intermediairs.</b></div>
                        </div>                        
                    @else
                        @if (Auth::user()->usertype==3)
                            @if(!$kid->family->aangemeld)
                              
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

