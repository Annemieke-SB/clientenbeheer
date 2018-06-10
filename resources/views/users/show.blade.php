@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">  
        <div class="col-md-8 col-md-offset-2">

                        
            <div class="panel panel-default">    

                @if (Auth::user()->usertype==1)
                    <ol class="breadcrumb">
                      <li><a href="{{ url('home') }}">Home</a></li>
                      <li><a href="{{ url('users/index') }}">Gebruikers</a></li>
                      <li class="active">{{ $user->naam }}</li>
                    </ol>
		@endif
                <div class="panel-body">



@include ('layouts.intermediairnav',['page'=>'home'])

    @if (App\Setting::get('inschrijven_gesloten') == 1) {{-- Inschrijvingen gesloten --}}
        <br><br>
        <div class="panel panel-danger">
              <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> | De inschrijvingen zijn gesloten! Er kan niets meer worden gewijzigd of toegevoegd.</div>
        </div>                        
    @endif
                                    <!-- Flashmessage -->
                        @if (count(Session::get('message')) > 0)
                        <br>
                        <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
                        @endif



    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    @if($user->geslacht == "v")
                        Mevr.&nbsp;
                    @else
                        Dhr.&nbsp;
                    @endif

                    {{ $user->naam }}&nbsp;

                            

		@if (Auth::user()->usertype == 1 && $user->blacklisted)
		&nbsp;<span class="label label-danger"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>&nbsp;Blacklist</span>

		@endif
				</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $user->functie }}&nbsp;bij&nbsp;{{ $user->organisatienaam }}&nbsp;</h6>
                <p class="card-text">
                <span class="glyphicon glyphicon glyphicon glyphicon-phone-alt" aria-hidden="true"></span> {{ $user->telefoon }}<br>
                <span class="glyphicon glyphicon glyphicon-globe" aria-hidden="true"></span> <a href="http://{{ preg_replace('#^https?://#', '', $user->website) }}" target="_BLANK" class="card-link">{{ $user->website }}</a> <br> 
                <span class="glyphicon glyphicon glyphicon glyphicon glyphicon-envelope" aria-hidden="true"></span> <a href="mailto:{{ $user->email }}" class="card-link">{{ $user->email }}</a>&nbsp;

                
                                    @if ($user->emailverified)
                                        
                                    @else
                					
                    					@if (Auth::user()->usertype==1)
                    					&nbsp;<a href="{{ url('/user') }}/manualemailverification/{{ $user->id }}">Handmatig geverifieerd door beheerder</a>
                				    	@endif
                				    @endif  
                                    <br><br>
                                    {{ $user->created_at->format('d-m-Y H:i:s') }}&nbsp;aangemaakt<br>
                                    {{ $user->updated_at->format('d-m-Y H:i:s') }}&nbsp;gewijzigd


	    </p></div>
         </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Reden aanmelden</h5>
            <p class="card-text">{{ $user->reden }}</p>
				    
            
          </div>
        </div>
    </div>

 </div>
     <div class="row">  
        <div class="col-md-10 col-md-offset-1">
<hr>
         <p>Op deze pagina staat alle voor u relevante informatie. In het overzicht hieronder staan alle door u aangemelde gezinnen. U kunt daarin ook de status terugvinden.</p><small>Tip: u kunt met de muis over de status heen voor meer info</small>

<h2>Gezinnen</h2>

                      <div class="table-responsive">
                            <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Naam&nbsp;</th>
                                        <th>Woonplaats&nbsp;</th>
                                        <th><span class="glyphicon glyphicon-user" aria-hidden="true" style="color:#1E90FF;" data-toggle="tooltip" title="Aantal kinderen in gezin."></span>&nbsp;</th>
                                        <th>Status&nbsp;</th> 
                                        <th>Actie&nbsp;</th> 
                                    </tr>                               
                                    </thead>
                                    <tbody>
@if (count($user->familys) == 0)
<tr>
	<td colspan=5><center>Nog geen gezinnen ingevoerd</center></td>
</tr>
@endif

@foreach ($user->familys as $family)
				      <tr>
                                        <td>{{$family->naam }} &nbsp;</td>
                                        
                                        <td>{{$family->woonplaats }}&nbsp;</td>
                                        <td>{{count($family->kids)}}&nbsp;</td>
					<td>
					
					
					@if (Auth::user()->usertype == 1 && $family->blacklisted)

		                         	&nbsp;<span class="label label-danger"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>&nbsp;Blacklist</span>

		                        @endif
						@if (!$family->aangemeld && !$family->redenafkeuren)
						<span class="label label-default" data-toggle="tooltip" title="Als alle gegevens zijn ingevoerd kan het gezin voor controle worden aangemeld.">Nog niet aangemeld</span>
						@elseif ($family->definitiefafkeuren)
						<span class="label label-danger" data-toggle="tooltip" title="Dit gezin is definitief aafgekeurd, u kunt het gezin verwijderen."><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>&nbsp;Definitief afgekeurd</span>     
						@elseif ($family->aangemeld && $family->goedgekeurd == 0 )
						<span class="label label-primary" data-toggle="tooltip" title="U heeft dit gezin al aangemeld, en het wacht momenteel op beoordeling van de Sinterklaasbank."><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span>&nbsp;Aangemeld</span>     
                        @elseif (isset($family->redenafkeuren))
                        <span class="label label-warning" data-toggle="tooltip" title="Dit gezin is afgekeurd, de reden hiervan kunt u lezen op de pagina van het gezin."><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>&nbsp;Afgekeurd</span>                
                        @elseif ($family->goedgekeurd == 1)
                        <span class="label label-success" data-toggle="tooltip" title="De aanmelding van dit gezin is goedgekeurd. Als de downloadpagina wordt geopend krijgt u de mogelijkheid om voor elk kind een PDF te downloaden."><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>&nbsp;Goedgekeurd</span>
                        @else
						Onbekend
						@endif
					&nbsp;
					</td>
                                        <td>

         
                                           
                                                
                                                <a href="{{ url('/family') }}/show/{{$family->id}}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Toon</button></a>

                                                @if (App\Setting::get('inschrijven_gesloten') == 0)      
                                                    @if (!$family->aangemeld)                        
                                                        @if (Auth::user()->id == Request::segment(3))       
                                                            <a href="{{ url('/family') }}/edit/{{ $family->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;Wijzig</button></a>
                                                            <a href="#" data-toggle="modal" data-target="#deleteModal{{ $family->id }}"><button class="btn btn-danger btn-xs" type="button"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>&nbsp;Wis</button></a>
                                                   

                                                            <!-- Modal om te deleten -->
                                                            <div class="modal fade" id="deleteModal{{ $family->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                              <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                  <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title" id="myModalLabel">Wissen van gezin {{ $family->naam }}?</h4>
                                                                  </div>
                                                                  <div class="modal-body">
                                                                    <p>Let op: als u het gezin wist, worden alle kinderen die eronder vallen ook <b>permanent</b> gewist.</p></blockquote>
                                                                  </div>
                                                                  <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuleren</button>
                                                                    <a id="deletehref" href="{{ url('/family') }}/destroy/{{ $family->id }}"><button type="button" class="btn btn-primary">Doorgaan</button></a>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endif

 
                                                
                                        </td>
				    </tr>
@endforeach
                                    </tbody>
                            </table>
<p>
</p>
                        </div>
                        </div>

<script type="text/javascript">


$(document).ready(function() {
// Hier om de tooltips te activeren
$('[data-toggle="tooltip"]').tooltip();

});



</script>
@endsection

