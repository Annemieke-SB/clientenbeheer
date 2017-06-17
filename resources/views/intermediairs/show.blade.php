

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

                @if(Auth::user()->usertype != 3 )  
                        <ol class="breadcrumb">
                          <li><a href="{{ url('/home') }}">Home</a></li>
                          <li><a href="{{ url('/intermediairs') }}">Intermediairs</a></li>
                          <li class="active">{{ $eigenaar->voornaam }}&nbsp;{{ $eigenaar->achternaam }}</li>
                        </ol>                
                @endif

                @if (Auth::user()->usertype==3)
                        <ol class="breadcrumb">
                          <li class="active">Home</li>
                        </ol>
                @endif
                <div class="panel-body">

                    @if ($settings['inschrijven_gesloten'] == 1) {{-- Inschrijvingen gesloten --}}
                        
                        <div class="panel panel-danger">
                              <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | De inschrijvingen zijn gesloten! Er kunnen geen gezinnen en kinderen meer worden toegevoegd of gewijzigd.</b></div>
                        </div>                        
                    @else

                              @if($intermediair->nietaangemeldefams || count($familys)==0)
                            
       
                                      @if (count($afgekeurde_families)>0)
                                      <div class="panel panel-danger">
                                        <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | Afgekeurde gezinnen!</b></div>
                                        <div class="panel-body bg-danger">
                                          Er is in ieder geval één gezin afgekeurd dat u heeft aangemeld. Het gezin staat in het rood vermeld in de lijst van niet afgeronde gezinnen. 

                                        </div>
                                      </div>
                                      @endif                           

                                      @if ($intermediair->nietaangemeldefams)
                                      <div class="panel panel-danger">
                                        <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | Niet aangemelde gezinnen!</b></div>
                                        <div class="panel-body bg-danger">
                                          U heeft één of meer gezinnen die niet zijn aangemeld. 

                                        </div>
                                      </div>
                                      @endif

                                      @if (count($familys)==0)
                                      <div class="panel panel-danger">
                                        <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | 

                                              Er zijn (nog) geen gezinnen door u ingevoerd! 
                                                     
                                      </b></div>
                                        <div class="panel-body bg-danger">
                                          Mogelijk bent u net begonnen als intermediair. Gebruik de button ‘Gezin toevoegen’ om gezinnen in te voeren.&nbsp;
                                        </div>
                                      </div>
                                      @endif   

                                  
                              
                              @endif
                    @endif 

                  Op deze pagina treft u al uw gegevens aan. Klik op de sectiekoppen om de onderliggende gegevens te tonen. 

             @if(Auth::user()->usertype == 3 )  
                          @if ($settings['inschrijven_gesloten'] == 0) {{-- Inschrijvingen open --}}

                              <a href="#" data-toggle="modal" data-target="#toevoegModal{{$intermediair->id}}"><button type="button" class="btn btn-primary navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-plus"></span>&nbsp;Gezin toevoegen</button></a>
                          

                                

                                                                        <!-- Modal om te toe te voegen -->
                                                    <div class="modal fade" id="toevoegModal{{ $intermediair->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                      <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                          <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Toevoegen van een gezin</h4>
                                                          </div>
                                                          <div class="modal-body">
                                                            {!! showVoorwaarden() !!}
                                                          </div>
                                                          <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-thumbs-down"></span>&nbsp;Annuleer</button>
                                                            <a id="deletehref" href="{{ url('/familie') }}/toevoegen/{{ $intermediair->id }}"><button type="button" class="btn btn-success"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;Ik ben akkoord met de voorwaarden!</button></a>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>

                            @else

                            <br><br>De inschrijvingen zijn gesloten. U kunt nu naar de downloads-pagina gaan om de PDF's met de kadokaart-barcode te downloaden. <br><br>

                            {{ Html::link('/intermediair/downloads', '<button type="button" class="btn btn-success navbar-btn btn-sm text-right pdfdownload"><span class="glyphicon glyphicon-download"></span>&nbsp;&nbsp;Downloads</button>', 'Terug', array(), false)}}&nbsp;

                            @endif
            @else

                    {{ Html::link(URL::previous(), '<button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button>', 'Terug', array(), false)}}

            @endif



                </div>
            </div>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
          Uw gebruikersgegevens&nbsp;<small>(klik op uit te klappen)</small>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
      <table>
                        <tr>
                            <td>
                                @if ($eigenaar->geslacht == 'm') 
                                Dhr.&nbsp;
                                @else 
                                Mevr.&nbsp;                                
                                @endif

                                {{ $eigenaar->voornaam }}&nbsp;{{ $eigenaar->achternaam }}&nbsp;
                                @if (Auth::user()->usertype != 3)
                                    <a href="{{ url('/user/show') }}/{{ $eigenaar->id }}"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a>
                                @endif
                            </td></tr>
                            <tr>   
                            <tr>                            
                            <td>{{ $eigenaar->organisatienaam }}&nbsp;

                            </td></tr>                           
                            <td>{{ $eigenaar->functie }}&nbsp;

                            </td></tr>  
                            <tr>                            
                            <td>{{ $eigenaar->email }}&nbsp;|&nbsp;{{ $eigenaar->telefoon }}&nbsp;|&nbsp;{{ $eigenaar->website }}

                            </td></tr>                                                                             
                        </tr>
                    </table>
                    @if (Auth::user()->usertype==3)

                        {{ Html::link('/user/edit/'.$eigenaar->id, '<button type="button" class="btn btn-primary navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Wijzig gegevens & wachtwoord</button>', 'Wijzig', array(), false)}}
                    @endif

      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          De gegevens van uw organisatie&nbsp;<small>(klik op uit te klappen)</small>
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
      <table>
                        <tr>
                            <td><b>{{ Custommade::typenIntermediairs($intermediair->type) }}</b>&nbsp;</td></tr><tr>                                                    
                            <td>{{ $intermediair->adres }}&nbsp;{{ $intermediair->huisnummer }}&nbsp;{{ $intermediair->huisnummertoevoeging }}</td></tr><tr>                                                     
                            <td>{{ $intermediair->postcode }}&nbsp;{{ $intermediair->woonplaats }}</td></tr><tr>                           
                        </tr>
                    </table>

                    @if (Auth::user()->usertype==3)

                          {{ Html::link('/intermediair/edit/'.$intermediair->id, '<button type="button" class="btn btn-primary navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Wijzig</button>', 'Wijzig', array(), false)}}
                    @endif
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
          Gezinsoverzicht
        </a>
      </h4>
    </div>
    <div class="panel-body">










     <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-success">
          <div class="panel-heading" role="tab" id="headingFour">
            <h4 class="panel-title"><span class="caret"></span>



              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                Aantal aanmeldingen die zijn goedgekeurd door de Sinterklaasbank
              </a>



              <span class="badge">{{count($goedgekeurde_families)}}</span>&nbsp;<small>(klik op uit te klappen)</small>
            </h4>
          </div>
          <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
            <div class="panel-body">
                      <p>In dit overzicht vind u de aangemelde gezinnen die zijn goedgekeurd door de Sinterklaasbank. Dat betekent dat deze gezinnen verzekerd zijn van deelname aankomend sinterklaasfeest. Als u dit gezin wilt wijzigen of verwijderen moet u eerst de aanmelding intrekken, klik daarvoor op 'toon'.</p>
                  @if(count($goedgekeurde_families)>0)

                      <div class="table-responsive">
                            <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Naam&nbsp;</th>
                                        <th>Woonplaats&nbsp;</th>
                                        <th><span class="glyphicon glyphicon-user" aria-hidden="true" style="color:#1E90FF;" data-toggle="tooltip" title="Aantal kinderen in gezin."></span>&nbsp;</th>
                                        <th>Actie&nbsp;</th> 
                                    </tr>                               
                                    </thead>
                                    <tbody>
                                @foreach ($goedgekeurde_families as $goedgekeurde_familie)
                                      <tr>
                                        <td>{{ $goedgekeurde_familie->achternaam }}&nbsp;</td>
                                        
                                        <td>{{ $goedgekeurde_familie->woonplaats }}&nbsp;</td>
                                        <td>{{ $goedgekeurde_familie->kidscount }}&nbsp;</td>
                                        <td>

         
                                          
                                                
                                                <a href="{{ url('/family') }}/show/{{ $goedgekeurde_familie->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Toon</button></a>

                                                
                                        </td>
                                    </tr>
                                @endforeach
                                    </tbody>
                            </table>
                        </div>

                @else
                  <p>U heeft geen gezinnen die al zijn goedgekeurd.</p>
                @endif
                      
              </div>
          </div>
        </div>
        <div class="panel panel-warning">
          <div class="panel-heading" role="tab" id="headingFive">
            <h4 class="panel-title"><span class="caret"></span>
              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                Aantal aangemelde gezinnen in afwachting van goedkeuring Sinterklaasbank
              </a><span class="badge">{{count($aangemelde_families)}}</span>&nbsp;<small>(klik op uit te klappen)</small>
            </h4>
          </div>
          <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
            <div class="panel-body">

                <p>In dit overzicht vind u de aangemelde gezinnen die in afwachting zijn voor goedkeuring door de Sinterklaasbank. Als u het gezin wilt wijzigen of verwijderen moet u eerst de aanmelding intrekken. Klik daarvoor op 'toon'.</p>
                @if(count($aangemelde_families)>0)

                      <div class="table-responsive">
                            <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Naam&nbsp;</th>
                                        <th>Woonplaats&nbsp;</th>
                                        <th><span class="glyphicon glyphicon-user" aria-hidden="true" style="color:#1E90FF;" data-toggle="tooltip" title="Aantal kinderen in gezin."></span>&nbsp;</th>
                                        <th>Actie&nbsp;</th> 
                                    </tr>                               
                                    </thead>
                                    <tbody>
                                @foreach ($aangemelde_families as $aangemelde_familie)
                                     
                                      <tr>

                                        <td>{{ $aangemelde_familie->achternaam }}&nbsp;</td>
                                        
                                        <td>{{ $aangemelde_familie->woonplaats }}&nbsp;</td>
                                        <td>{{ $aangemelde_familie->kidscount }}&nbsp;</td>
                                        <td> 
         
                                          
                                                
                                                <a href="{{ url('/family') }}/show/{{ $aangemelde_familie->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Toon</button></a>
                                               
                                            
                                        </td>
                                    </tr>
                                @endforeach
                                    </tbody>
                            </table>
                        </div>    
                @else
                  <p>U heeft geen gezinnen die zijn aangemeld.</p>
                @endif


            </div>
          </div>
        </div>
        <div class="panel panel-danger">
          <div class="panel-heading" role="tab" id="headingSix">
            <h4 class="panel-title"><span class="caret"></span>
              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                Aantal gezinnen die u nog niet heeft afgerond en aangemeld
              </a><span class="badge">{{count($nietaangemelde_families)}}</span> &nbsp;<small>(klik op uit te klappen)</small>
            </h4> 
          </div>
          <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
            <div class="panel-body">

 <p>In dit overzicht vind u de gezinnen die nog moeten worden aangemeld bij de Sinterklaasbank. Na aanmelding zal het gezin kan het gezin in aanmerking komen voor deelname, als de Sinterklaasbank de aanmelding heeft goedgekeurd. Hier kan enige tijd overheen gaan.</p>

                @if(count($nietaangemelde_families)>0)
                      <div class="table-responsive">
                            <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                                    <thead>


                                    
                                        <th>Naam&nbsp;</th>
                                        <th>Woonplaats&nbsp;</th>
                                        <th><span class="glyphicon glyphicon-user" aria-hidden="true" style="color:#1E90FF;" data-toggle="tooltip" title="Aantal kinderen in gezin."></span>&nbsp;</th>
                                        <th><span class="badge" data-toggle="tooltip" title="Als in deze kolom een envelopje staat, dan is de aanmelding voor dat gezin door de sinterklaasbank afgekeurd. Als u met uw muis over het envelopje gaat ziet u de reden van afmelding. Als u het kan aanpassen kunt u het gezin opnieuw aanmelden. Als u het niet kunt oplossen, kunt u het gezin verwijderen door op 'wis' te klikken.">RA</span></th> 
                                        <th>Actie&nbsp;</th> 
                                                                  
                                    </thead>
                                    <tbody>
                                @foreach ($nietaangemelde_families as $nietaangemelde_familie)
                                    @if($nietaangemelde_familie->redenafkeuren)
                                      <tr class="danger">
                                    @else
                                      <tr>
                                    @endif
                                        <td>{{ $nietaangemelde_familie->achternaam }}&nbsp;</td>
                                        
                                        <td>{{ $nietaangemelde_familie->woonplaats }}&nbsp;</td>
                                        <td>{{ $nietaangemelde_familie->kidscount }}&nbsp;</td>
                                        <td>                                       
                                        @if ($nietaangemelde_familie->redenafkeuren)
                                            <span class="glyphicon glyphicon-envelope" data-toggle="tooltip" title="{{$nietaangemelde_familie->redenafkeuren}}"></span>
                                        @endif</td>
                                        <td> 
         
                                          
                                                
                                                <a href="{{ url('/family') }}/show/{{ $nietaangemelde_familie->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Toon</button></a>
                                                
                                                @if (Auth::user()->usertype==3)
                                                    @if ($settings['inschrijven_gesloten'] == 0) {{-- Inschrijvingen open --}}

                                                          <a href="#" data-toggle="modal" data-target="#deleteModal{{$nietaangemelde_familie->id}}"><button class="btn btn-danger btn-xs" type="button"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>&nbsp;Wis</button></a>
                                                          
                                                          <!-- Modal om te deleten -->
                                                          <div class="modal fade" id="deleteModal{{ $nietaangemelde_familie->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog" role="document">
                                                              <div class="modal-content">
                                                                <div class="modal-header">
                                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                  <h4 class="modal-title" id="myModalLabel">Wissen van gezin {{ $nietaangemelde_familie->name }}?</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                  <blockquote><p>Let op: als je het gezin wist, worden alle kinderen die eronder hangen ook <b>permanent</b> gewist.</p></blockquote>
                                                                </div>
                                                                <div class="modal-footer">
                                                                  <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
                                                                  <a id="deletehref" href="{{ url('/family') }}/destroy/{{ $nietaangemelde_familie->id }}"><button type="button" class="btn btn-primary">Doorgaan</button></a>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                    @endif
                                                @endif
                                            
                                        </td>
                                    </tr>
                                @endforeach
                                    </tbody>
                            </table>
                        </div>   
                @else
                  <p>U heeft geen gezinnen die u nog moet aanmelden.</p>
                @endif



            </div>
          </div>
        </div>
      </div>

    </div>






<!-- Hieronder de modal met help over het toevoegen van gezin-->
@if (Session::get('message') == 'Familie toegevoegd')

    <div class="modal fade" id="family_created" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Gezin toegevoegd</h4>
          </div>
          <div class="modal-body">
           <h4>Wat nu?</h4>
           <p>Het gezin is toegevoegd. Nu is het van belang dat er kinderen bij het gezin worden ingevoerd. Zorg dat alle rode waarschuwingen en rode regels en velden verdwijnen om zeker te zijn dat alles goed komt.</p>
           <p>U krijgt een week voor de sluitingsdatum een email met uw overzicht en heeft dan nog tijd om eea op te lossen.<p>
                        <p> Is het nog niet helemaal duidelijk? Geen probleem, kijk dit korte filmpje of klik op de 'help'-knop rechts bovenin.<br><br>
                <!-- 16:9 aspect ratio -->
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/j1nWI1n8pzo" allowfullscreen></iframe>
                </div>
                </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;Sluit</button>
            
          </div>
        </div>
      </div>
    </div>
</div>
@endif
  
<!-- einde modal-->










 </div> 
<!-- einde modal-->

<script type="text/javascript">


$(document).ready(function() {
// Hier om de tooltips te activeren
$('[data-toggle="tooltip"]').tooltip();
$('#family_created').modal('show');
});



</script>



@endsection

