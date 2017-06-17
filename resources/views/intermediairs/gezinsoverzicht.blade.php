
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
                          <li><a href="{{ url('/intermediairs/show') }}/{{$intermediair->id}}">{{ $eigenaar->voornaam }}&nbsp;{{ $eigenaar->achternaam }}</a></li>
                          <li class="active">Gezinsoverzicht</li>
                        </ol>            
                @endif
                @if (Auth::user()->usertype==3)        
                        <ol class="breadcrumb">
                          <li><a href="{{ url('/home') }}">Home</a></li>
                          <li class="active">Gezinsoverzicht</li>
                        </ol>
                @endif

              <div class="panel-body">

                    @if ($settings['inschrijven_gesloten'] == 1) {{-- Inschrijvingen gesloten --}}
                        
                        <div class="panel panel-danger">
                              <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | De inschrijvingen zijn gesloten! Er kunnen geen gezinnen en kinderen meer worden toegevoegd of gewijzigd.</b></div>
                        </div>                        
                    @else

                              @if($intermediair->nietaangemeldefams || count($familys)==0)
                            


                                      @if ($intermediair->nietaangemeldefams)
                                      <div class="panel panel-danger">
                                        <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | Niet aangemelde gezinnen!</b></div>
                                        <div class="panel-body bg-danger">
                                          U heeft één of meer gezinnen die niet zijn aangemeld. Ga naar het gezinsoverzicht om deze gezinnen aan te melden.&nbsp;             
                                        </div>
                                      </div>
                                      @endif

                                      @if (count($familys)==0)
                                      <div class="panel panel-danger">
                                        <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | 

                                              Er vallen (nog) geen gezinnen onder deze intermediair! 
                                                     
                                      </b></div>
                                        <div class="panel-body bg-danger">
                                          Mogelijk bent u net begonnen als intermediair. Ga naar het gezinsoverzicht om gezinnen in te voeren.&nbsp;
                                        </div>
                                      </div>
                                      @endif   

                                  
                              
                              @endif
                    @endif

            <p>{{ Html::link('/intermediairs/show/' . $intermediair->id, '<button type="button" class="btn btn-default navbar-btn btn-sm text-right pdfdownload"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button>', 'Terug', array(), false)}}&nbsp;

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
                @endif
                </p>
              </div>
            </div>

                       



      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-success">
          <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title"><span class="caret"></span>
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Aantal aanmeldingen die zijn goedgekeurd door de Sinterklaasbank
              </a><span class="badge">{{count($goedgekeurde_families)}}</span>&nbsp;<small>(klik op uit te klappen)</small>
            </h4>
          </div>
          <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                      <p>In dit overzicht vind u de aangemelde gezinnen die zijn goedgekeurd door de Sinterklaasbank. Dat betekent dat deze gezinnen verzekerd zijn van deelname aankomend sinterklaasfeest.</p>
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


                                                @if ($settings['inschrijven_gesloten'] == 0) {{-- Inschrijvingen open --}}
                                               
                                                    <a href="#" data-toggle="modal" data-target="#deleteModal{{$goedgekeurde_familie->id}}"><button class="btn btn-danger btn-xs" type="button"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>&nbsp;Wis</button></a>
                                                    
                                                        <!-- Modal om te deleten -->
                                                        <div class="modal fade" id="deleteModal{{ $goedgekeurde_familie->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                          <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                              <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title" id="myModalLabel">Wissen van het gezin {{ $goedgekeurde_familie->name }}?</h4>
                                                              </div>
                                                              <div class="modal-body">
                                                                <blockquote><p>Let op: als je het gezin wist, worden alle kinderen die eronder hangen ook <b>permanent</b> gewist.</p></blockquote>
                                                              </div>
                                                              <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
                                                                <a id="deletehref" href="{{ url('/family') }}/destroy/{{ $goedgekeurde_familie->id }}"><button type="button" class="btn btn-primary">Doorgaan</button></a>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                @endif
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
          <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title"><span class="caret"></span>
              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Aantal aangemelde gezinnen in afwachting van goedkeuring Sinterklaasbank
              </a><span class="badge">{{count($aangemelde_families)}}</span>&nbsp;<small>(klik op uit te klappen)</small>
            </h4>
          </div>
          <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">

                <p>In dit overzicht vind u de aangemelde gezinnen die in afwachting zijn voor goedkeuring door de Sinterklaasbank.</p>
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
                                               

                                                @if ($settings['inschrijven_gesloten'] == 0) {{-- Inschrijvingen open --}}
                                                    <a href="#" data-toggle="modal" data-target="#deleteModal{{$aangemelde_familie->id}}"><button class="btn btn-danger btn-xs" type="button"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>&nbsp;Wis</button></a>
                                                    
                                                    <!-- Modal om te deleten -->
                                                    <div class="modal fade" id="deleteModal{{ $aangemelde_familie->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                      <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                          <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Wissen van gezin {{ $aangemelde_familie->name }}?</h4>
                                                          </div>
                                                          <div class="modal-body">
                                                            <blockquote><p>Let op: als je het gezin wist, worden alle kinderen die eronder hangen ook <b>permanent</b> gewist.</p></blockquote>
                                                          </div>
                                                          <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
                                                            <a id="deletehref" href="{{ url('/family') }}/destroy/{{ $aangemelde_familie->id }}"><button type="button" class="btn btn-primary">Doorgaan</button></a>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                @endif
                                            
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
          <div class="panel-heading" role="tab" id="headingThree">
            <h4 class="panel-title"><span class="caret"></span>
              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Aantal gezinnen die u nog niet heeft afgerond en aangemeld
              </a><span class="badge">{{count($nietaangemelde_families)}}</span> &nbsp;<small>(klik op uit te klappen)</small>
            </h4> 
          </div>
          <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <div class="panel-body">

 <p>In dit overzicht vind u de gezinnen die nog moeten worden aangemeld bij de Sinterklaasbank. Na aanmelding zal het gezin kan het gezin in aanmerking komen voor deelname, als de Sinterklaasbank de aanmelding heeft goedgekeurd. Hier kan enige tijd overheen gaan.</p>

                @if(count($nietaangemelde_families)>0)
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
                                @foreach ($nietaangemelde_families as $nietaangemelde_familie)
                                      <tr>
                                        <td>{{ $nietaangemelde_familie->achternaam }}&nbsp;</td>
                                        
                                        <td>{{ $nietaangemelde_familie->woonplaats }}&nbsp;</td>
                                        <td>{{ $nietaangemelde_familie->kidscount }}&nbsp;</td>
                                        <td> 
         
                                          
                                                
                                                <a href="{{ url('/family') }}/show/{{ $nietaangemelde_familie->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Toon</button></a>
                                                

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

<script type="text/javascript">


$(document).ready(function() {
// Hier om de tooltips te activeren
$('[data-toggle="tooltip"]').tooltip();
$('#family_created').modal('show');
});



</script>
@endsection
