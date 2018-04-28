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

                    <ol class="breadcrumb">
                      <li><a href="{{ url('home') }}">Home</a></li>
                      <li><a href="{{ url('users/index') }}">Gebruikers</a></li>
                      <li class="active">{{$user->voornaam}} {{$user->tussenvoegsel}} {{$user->achternaam}}</li>
                    </ol>

                <div class="panel-body">
<div>
<ul class="nav nav-tabs nav-justified">
  <li role="presentation" class="active"><a href="#">Home</a></li>
  <li role="presentation"><a href="{{url('/user/edit/')."/$user->id" }}">Wijzig uw gegevens</a></li>
  <li role="presentation"><a href="#">Gezinnen toevoegen</a></li>
  <li role="presentation" class="disabled" data-trigger="hover" data-placement="left" aria-hidden="true" data-toggle="popover" title="Downloads gesloten" data-content="Downloads worden later geopend, u krijgt daarover een bericht van ons."><a href="#">Downloads</a></li>
</ul>

</div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    @if($user->geslacht == "v")
                        Mevr.&nbsp;
                    @else
                        Dhr.&nbsp;
                    @endif

                    {{ $user->voornaam }}&nbsp;{{ $user->tussenvoegsel }}&nbsp;{{ $user->achternaam }}&nbsp;

                            <span class="badge badge-info">

                            @if ($user->usertype==1)
                                Admin
                            @elseif ($user->usertype==2)
                                Raadpleger
                            @elseif ($user->usertype==3)    
                                Intermediair
                            @endif     
                            </span></h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $user->functie }}&nbsp;bij&nbsp;{{ $user->organisatienaam }}&nbsp;</h6>
                <p class="card-text">
                <span class="glyphicon glyphicon glyphicon glyphicon-phone-alt" aria-hidden="true"></span> {{ $user->telefoon }}<br>
                <span class="glyphicon glyphicon glyphicon-globe" aria-hidden="true"></span> <a href="http://{{ preg_replace('#^https?://#', '', $user->website) }}" target="_BLANK" class="card-link">{{ $user->website }}</a> <br> 
                <span class="glyphicon glyphicon glyphicon glyphicon glyphicon-envelope" aria-hidden="true"></span> <a href="mailto:{{ $user->email }}" class="card-link">{{ $user->email }}</a>&nbsp;

                
                                    @if ($user->emailverified)
                                        <span class="badge badge-success">geverifieerd</span>
                                    @else
					<span class="glyphicon glyphicon-remove-sign" aria-hidden="true" style="color:red;"></span>
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
							bla: {{ Auth::user()->usertype }}
            <p class="card-text">{{ $user->reden }}</p>
                                    Gebruiker geactiveerd: @if ($user->activated)
                                        <span class="glyphicon glyphicon-ok-sign" aria-hidden="true" style="color:green;"></span>&nbsp;<a href="{{ url('/user') }}/toggleactive/{{ $user->id }}">Wijzig</a>
                                    @else
                                        <span class="glyphicon glyphicon-remove-sign" aria-hidden="true" style="color:red;" data-toggle="tooltip" title="{{$user->reden}}"></span>&nbsp;
                                        @if ($user->emailverified)
						@if (Auth::user()->usertype==1)
                                            		<a href="{{ url('/user') }}/toggleactive/{{ $user->id }}" class="btn btn-primary">Wijzig</a>
                                        	@endif
                                        @endif
                                    @endif 
            
          </div>
        </div>
    </div>

 </div>
     <div class="row">  
        <div class="col-md-10 col-md-offset-1">
<hr>
         <p>Op deze pagina staat alle informatie die voor u nodig is. In het overzicht hieronder staan alle door u aangemelde gezinnen. U kunt daarin ook de status terugvinden. De Sinterklaasbank controleert namelijk alle aanmeldingen of ze aan onze eisen voldoen. </p>

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
                                        <td>{{$family->achternaam }} &nbsp;</td>
                                        
                                        <td>{{$family->woonplaats }}&nbsp;</td>
                                        <td>{{count($family->kids)}}&nbsp;</td>
                                        <td>Goedgekeurd&nbsp;</td>
                                        <td>

         
                                          
                                                
                                                <a href="{{ url('/family') }}/show/{{$family->id}}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Toon</button></a>

                                                
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
$('[data-toggle="popover"]').popover();

});



</script>
@endsection

