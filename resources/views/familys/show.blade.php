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
                      <li><a href="{{ url('/intermediairs/show') }}/{{ $intermediair->id }}">{{ $eigenaar->voornaam }} {{ $eigenaar->achternaam }}</a></li>
                      <li class="active">Fam {{$family->achternaam}}</li>
                    </ol>
                @elseif (Auth::user()->usertype==3)
                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li class="active">Gezin {{$family->achternaam}}</li>
                    </ol>
                @endif

                <div class="panel-body">
                 <p>Op deze pagina staan alle gegevens die betrekking hebben de op het gezin en kinderen van het gezin.</p>

                    @if ($settings['inschrijven_gesloten'] == 1) {{-- Inschrijvingen gesloten --}}
                        <br><br>
                        <div class="panel panel-danger">
                              <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | De inschrijvingen zijn gesloten! Er kan niets meer worden gewijzigd of toegevoegd door de intermediairs.</b></div>
                        </div>                        
                    @else

                            @if($family->redenafkeuren && $family->aangemeld==0)
                            <br><br>
                                <div class="panel panel-danger">                      
                                  <div class="panel-body bg-danger">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>&nbsp;Uw aanmelding voor dit gezin is door de Sinterklaasbank afgekeurd om deze reden:<br><br>
                                    <blockquote>{{$family->redenafkeuren}}</blockquote>
                                    @if($family->definitiefafkeuren == 1)
                                       U kunt het probleem niet oplossen omdat het gezin definitief is afgekeurd. Gelieve het gezin te verwijderen. 
                                    @else
                                        U kunt het probleem oplossen en het gezin opnieuw aanmelden, of u kunt het gezin verwijderen.
                                        
                                    @endif
                                    
                                  </div>
                                </div>
                            @endif                    

                            @if($family->aangemeld==0 && $family->definitiefafkeuren != 1)
                            <br>
                                <div class="panel panel-danger">                      
                                  <div class="panel-body bg-danger">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>&nbsp;Dit gezin is nog niet aangemeld.  Na controle van de ingevoerde gegevens kunt u via de knop ‘Aanmelden’ (zie onderaan deze pagina) dit gezin aanmelden.
                                  </div>
                                </div>
                            @endif

                            @if($family->aangemeld==1 && $family->goedgekeurd==0)
                            <br><br>
                                <div class="panel panel-warning">                      
                                  <div class="panel-body bg-warning">
                                    <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>&nbsp;Dit gezin is al aangemeld maar wacht nog op goedkeuring van de Sinterklaasbank. Als u wijzigingen wilt aanbrengen moet u de aanmelding weer intrekken (onderaan deze pagina).
                                  </div>
                                </div>
                            @endif

                            @if($family->aangemeld==1 && $family->goedgekeurd==1)
                            <br><br>
                                <div class="panel panel-success">                      
                                  <div class="panel-body bg-success">
                                    <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>&nbsp;Dit gezin is al aangemeld en goedgekeurd door de Sinterklaasbank. Als u wijzigingen wilt aanbrengen moet u de aanmelding weer intrekken (onderaan deze pagina).
                                  </div>
                                </div>
                            @endif
                    @endif
                @if (Auth::user()->usertype==1)

                    @if($family->postcodehuisnummerdubbel)
                                
                                <div class="panel panel-danger">                      
                                  <div class="panel-body bg-danger">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>&nbsp;Bericht aan de beheerder: Dit gezin heeft een postcode en huisnummer dat ook bij een ander gezin voorkomt;<br><br>
                                    <table>
                                    @foreach($family->postcodehuisnummerdubbel as $dubbelfam)
                                        @if ($dubbelfam->id != $family->id)
                                        <tr>
                                        <td>Gezin {{$dubbelfam->achternaam}}&nbsp;&nbsp;</td><td><a href="{{ url('/family/show/'. $dubbelfam->id) }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Toon</button></a>&nbsp;&nbsp;</td>
                                        <td>Intermediair {{$dubbelfam->intermediair->user->achternaam}}&nbsp;&nbsp;</td><td><a href="{{ url('/intermediairs/show/'. $dubbelfam->intermediair->id) }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Toon</button></a>
                                        @if($dubbelfam->intermediair->id == $intermediair->id)
                                        &nbsp;&nbsp;(zelfde intermediair als dit gezin)
                                        @endif
                                        </td>

                                        </tr>
                                        @endif
                                    @endforeach
                                    </table>
                                  </div>
                                </div>
                    @endif


                    <a href="{{ url('/intermediairs/show/'. $intermediair->id) }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                @else

                    <a href="{{ url('/intermediairs/show/'. $intermediair->id) }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                @endif
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Gezinsgegevens</div>

                <div class="panel-body">

                    <table>

                        <tr>
                            <td>Gezin {{ $family->achternaam }}&nbsp;</td></tr><tr>                            
                            <td>{{ $family->adres }}&nbsp;{{ $family->huisnummer }}&nbsp;{{ $family->huisnummertoevoeging }}</td></tr><tr>                                                     
                            <td>{{ $family->postcode }}&nbsp;{{ $family->woonplaats }}</td></tr><tr>                            
                            <td>{{ $family->telefoon }}&nbsp;/&nbsp;{{ $family->email }}</td></tr><tr> 
                            <td>Motivering:&nbsp;</td></tr><tr>
                            <td><p>{{ $family->motivering }}</p></td></tr><tr>
                                               
                                <td>&nbsp;</td><td>&nbsp;&nbsp;</td>
                        </tr>

                    </table>
                    <table>                   
                        <tr>
                                <td>Intermediair&nbsp;</td><td>:&nbsp;{{ $eigenaar->voornaam }}&nbsp;{{ $eigenaar->achternaam }}&nbsp;({{ Custommade::typenIntermediairs($intermediair->type) }})&nbsp;</td>
                        </tr>
                        
                        <tr><td>Andere alternatieven&nbsp;</td>
                        <td>:
                            @if($family->andere_alternatieven==0)
                                Gezin is <b>niet</b> aangemeld bij andere Sinterklaasbank-alternatieven.
                            @else
                                Gezin is <b>wel</b> aangemeld bij andere Sinterklaasbank-alternatieven.
                            @endif


                        </td></tr>
                        
                    </table>
                    @if (Auth::user()->usertype==3)
                        @if(!$family->aangemeld && !$family->definitiefafkeuren)


                                         <a href="{{ url('/family/edit/'.$family->id) }}"><button type="button" class="btn btn-primary navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Wijzig</button></a>
                        @endif
                    @endif
                </div>
            </div>    
            <div class="panel panel-default">
                <div class="panel-heading">Kinderen&nbsp;</div>

                <div class="panel-body"><P>Hieronder staat het overzicht van de aangemelde kinderen. Minimaal één kind moet binnen de doelgroep vallen, als dat zo is, dan krijgen diegene in de broer/zus-groep ook een kado. De rode regels vallen buiten de boot.</P>
<table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                            <thead>
                            <tr>
                                <th>Naam&nbsp;</th>
                                <th>Achternaam&nbsp;</th>
                                <th>Geslacht&nbsp;</th>
                                <th>Geboren&nbsp;</th>
                                <th><span class="badge" data-toggle="tooltip" title="Dit is de leeftijd op aankomend sinterklaasfeest (5/12/{{Custommade::returnNextSinterklaasJaar()}}).">LT</span></th>
                                <th><span class="badge" data-toggle="tooltip" title="Bij een groen vinkje valt het kind in de doelgroep. Er is er minimaal één nodig binnen het gezin voor deelname.">D</span></th>
                                <th><span class="badge" data-toggle="tooltip" title="Kind valt in de 'broer/zus'-groep en doet mee als er een kind in het gezin binnen de doelgroep (kolom D) valt.">BZ</span></th>
                                <th><span class="badge" data-toggle="tooltip" title="Wanneer er een mogelijke dubbeling is geconstateerd, verschijnt er een uitroepteken. Klik dan op 'Toon' voor meer info.">DB</span></th>
                                <th>Actie&nbsp;</th> 
                            </tr>                               
                            </thead>
                            <tbody>

                    
                        @foreach ($kids as $kid)

                                    @if ($kid->disqualified==true)
                                    <tr class="danger">
                                    @else
                                    <tr>
                                    @endif
                            
                                <td>

                                    {{ $kid->voornaam }}&nbsp;</td>                               
                                
                                <td>
                                    @if (!$kid->achternaam)
                                    {{ $family->achternaam }}
                                    @else
                                    {{ $kid->achternaam }}
                                    @endif

                                    &nbsp;</td>
                           
                                <td>

                                    {{ $kid->geslacht }}&nbsp;</td>

                                <td>

                                    {{ Carbon\Carbon::parse($kid->geboortedatum)->format('d-m-Y') }}&nbsp;</td>
                                    
                                <td>

                                    {{ $kid->agenextsint }}&nbsp;</td>

                                <td>
                                    @if ($kid->targetkid)
                                    <span style="color:lime" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                    @else
                                    
                                    @endif
                                </td>
                                <td>
                                    @if ($kid->targetsibling)
                                    <span style="color:lime;" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                    @else
                                    
                                    @endif
                                </td>
                                <td>
                                    @if ($kid->Geboortedatumvoornaamdubbel)
                                    <span class="glyphicon glyphicon-exclamation-sign" style="color:#FF4000;" aria-hidden="true" data-toggle="tooltip" title="Mogelijke dubbelen. Klik op 'Toon' voor meer info."></span>
                                    @else
                                    
                                    @endif
                                </td>
                                <td>
                                     <a href="{{ url('/kids') }}/show/{{ $kid->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Toon</button></a>

                                        @if (Auth::user()->usertype==3)
                                            @if(!$family->aangemeld==1)
                                            <a href="#" data-toggle="modal" data-target="#deleteModal{{$kid->id}}"><button class="btn btn-danger btn-xs" type="button"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>&nbsp;Wis</button></a>
                                            @endif
                                            <!-- Modal om te deleten -->
                                            <div class="modal fade" id="deleteModal{{ $kid->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Wissen van kind {{ $kid->voornaam }}?</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                    <p>Klik op doorgaan om de kind-gegevens te wissen.</p>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
                                                    <a id="deletehref" href="{{ url('/kids') }}/destroy/{{ $kid->id }}"><button type="button" class="btn btn-primary">Doorgaan</button></a>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                        @endif
                                    </center>
                                </td>
                            </tr>



                        @endforeach
                        </tbody>
                        <p><small>Tip: Ga met je muis over <span class="badge">&nbsp;&nbsp;&nbsp;</span>-balonnen voor extra info.</small></p>
                    </table>
                    @if (Auth::user()->usertype==3)
                        @if(!$family->aangemeld && !$family->definitiefafkeuren)


                         <a href="{{ url('/kids/toevoegen/'.$family->id) }}"><button type="button" class="btn btn-primary navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-plus"></span>&nbsp;Toevoegen</button></a>

                        @endif
                    @endif
                </div>
            </div> 


            <div class="panel panel-default">
                <div class="panel-heading">Gezin aanmelden</div>

                <div class="panel-body">

                    @if ($settings['inschrijven_gesloten'] == 1) {{-- Inschrijvingen gesloten --}}
                        <br><br>
                        <div class="panel panel-danger">
                              <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | De inschrijvingen zijn gesloten! Er kan niets meer worden gewijzigd of toegevoegd door de intermediairs.</b></div>
                        </div>                        
                    @else


                                @if (!$family->targetkids)
                                <div class="panel panel-danger">
                                  <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | Dit gezin komt niet in aanmerking voor de sinterklaasbank!</b></div>
                                  <div class="panel-body bg-danger">
                                    Dit gezin heeft geen kind in de doelgroep, en komt niet in aanmerking voor de sinterklaasbank. Pas als er één kind tussen de {{$min_leeftijd_target->value}} en {{$max_leeftijd_target->value}} jaar is doet het gezin mee. Broertjes en zusjes tussen {{$min_leeftijd_target->value}} en {{$max_leeftijd_sibling->value}} doen dan ook mee. &nbsp;
                                  </div>
                                </div>
                                @endif

                                @if ($family->kidsdisqualified && $family->targetkids)
                                <div class="panel panel-danger">
                                  <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | 
                                    @if ($family->kidsdisqualified == 1)
                                        Er is 1 kind dat niet in aanmerking komt!
                                    @else
                                        Er zijn {{$family->kidsdisqualified}} kinderen die niet in aanmerking komen! 
                                    @endif  
                                    </b></div>
                                  <div class="panel-body bg-danger">
                                    Er valt in ieder geval één kind niet binnen een doelgroep. Deze zijn rood gekleurd. Aub deze kinderen verwijderen voordat u het gezin kunt aanmelden.
                                  </div>
                                </div>
                                @endif
                                @if (Auth::user()->usertype==3)
                                    @if (($family->kidsdisqualified && $family->targetkids) || !$family->targetkids || $family->definitiefafkeuren == 1)
                                        
                                            
                                            <div class="form-group">

                                                {!! Form::submit('Aanmelden', ['class' => 'btn btn-primary form-control disabled']) !!}                            

                                            </div>       
                                                        

                                    @elseif($family->aangemeld)
                                    U heeft het gezin al aangemeld. Als u de gegevens van dit gezin wilt wijzigen, of de kinderen van dat gezin, moet u de aanmelding intrekken.<br><br>
                                        <a class="btn btn-warning" href="{{ url('/family/intrekken') }}/{{$family->id}}" role="button" style="width:100%">Aanmelding intrekken</a>                
                                    @else
                                    U kunt het gezin nu aanmelden. De Sinterklaasbank zal vervolgens de aanmelding controleren en deze beoordelen. Wilt u daarna weer een aanpassing aan het gezien doet, dan moet u het gezin weer opnieuw aanmelden, wees er dus zeker van dat de gegevens compleet zijn.<br><br>
                                        <a class="btn btn-success" href="{{ url('/family/aanmelden') }}/{{$family->id}}" role="button" style="width:100%">Aanmelden</a>
                                    @endif  
                                @else
                                    <p>Je bent niet aangemeld als intermediair, dus het is niet mogelijk om het gezin aan te melden of deze in te trekken.
                                @endif
                    @endif            
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

