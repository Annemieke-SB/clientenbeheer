@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">



            <div class="panel panel-default">              
                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li class="active">Gebruikers</li>
                    </ol> 

                <div class="panel-body">
                                <!-- Flashmessage -->
            @if (Session::get('message'))
                <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
            @endif 
                    <p>


                        <a href="{{ url()->previous() }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                    </p>
                    
                    <p>
                        Hier is het overzicht van gebruikers. Dit overzicht is alleen beschikbaar voor administrators en raadplegers. Het is niet mogelijk gebruikers toe te voegen, zij moeten zichzelf registreren. Als ze dan in dit overzicht komen kan hun rol worden aangepast. 
                    </p>
                            
                </div>
            </div>

                      


            <div class="panel panel-default">   

                <div class="panel-body">            

                      
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <div class="navbar-brand"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        
        <li class="active"><a href="{{ url('/users/index') }}">Reset</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Kies <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ url('/users/index') }}/?filter=na">Toon alleen niet geactiveerd</a></li>   
            <li><a href="{{ url('/users/index') }}/?filter=izg">Toon intermediairs zonder gezinnen</a></li> 
            <li><a href="{{ url('/users/index') }}/?filter=izk">Toon intermediairs zonder kinderen</a></li> 
            <li><a href="{{ url('/users/index') }}/?filter=ipd">Toon intermediairs die nog pdf's moeten downloaden</a></li> 
            <li><a href="{{ url('/users/index') }}/?filter=iga">Toon intermediairs waarvan nog gezinnen moeten worden aangemeld</a></li> 
            <li><a href="{{ url('/users/index') }}/?filter=igg">Toon intermediairs waarvan nog gezinnen moeten worden goedgekeurd</a></li> 
            <li><a href="{{ url('/users/index') }}/?filter=iai">Toon intermediairs met andere initiatieven</a></li>      
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li>

            <p class="navbar-text">

                @if (Request::input('na'))
                    <b>niet aktief</b>  
                @elseif (Request::input('filter')=='izg')
                    <b>Intermediairs zonder gezinnen</b> 
                @elseif (Request::input('filter')=='izk')
                    <b>Intermediairs zonder kinderen</b>       
                @elseif (Request::input('filter')=='ipd')
                    <b>Intermediairs die PDF's moeten downloaden</b>       
                @elseif (Request::input('filter')=='iga')
                    <b>Intermediairs die nog gezinnen moeten aanmelden</b>  
                @elseif (Request::input('filter')=='igg')
                    <b>Intermediairs met te keuren/aangemelde gezinnen</b> 
                @elseif (Request::input('filter')=='iai')
                    <b>Intermediairs met andere initiatieven</b> 
                @else
                    Geen filter
                @endif

            </p>
        </li>
        <li><p class="navbar-text"><p class="navbar-text"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <b>{{$users->total()}}</b></p></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

                   

                    <div class="row">
                        <div class="col-sm-8 col-md-offset-2">
                            {{$users->render()}}
                        </div>

                    </div>
                    <div>
                        <small>
                            Totaal sortering aanpassen: achternaam (
                            <a href="{{ Request::url() }}?filter={{ Request::input('filter') }}&sort=aa&aant={{ Request::input('aant') }}">oplopend</a> / 
                            <a href="{{ Request::url() }}?filter={{ Request::input('filter') }}&sort=ad&aant={{ Request::input('aant') }}">aflopend</a>) 
                            |
                             aantal per pagina 
                            <a href="{{ Request::url() }}?filter={{ Request::input('filter') }}&sort={{ Request::input('sort') }}&aant=50">50</a> /
                            <a href="{{ Request::url() }}?filter={{ Request::input('filter') }}&sort={{ Request::input('sort') }}&aant=100">100</a> /
                            <a href="{{ Request::url() }}?filter={{ Request::input('filter') }}&sort={{ Request::input('sort') }}&aant=500">500</a> /
                            <a href="{{ Request::url() }}?filter={{ Request::input('filter') }}&sort={{ Request::input('sort') }}&aant=10000">10.000</a> 
                        </small>
                    </div>
                    <small><b>
                    @if (Request::input('sort')=='ad')
                    Gebruikers zijn nu alfabetisch gesorteerd oplopend op achternaam
                    @elseif(Request::input('sort')=='aga')
                    Gebruikers zijn nu gesorteerd oplopend op aantal kinderen
                    @elseif(Request::input('sort')=='agd')
                    Gebruikers zijn nu gesorteerd aflopend op aantal kinderen
                    @else
                    Gebruikers zijn nu alfabetisch gesorteerd oplopend op achternaam
                    @endif
                    </b></small>

                    <br>
                    <div class="table-responsive">
                        <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                                <thead>
                                <tr>
                    				<th style="max-width: 300px;">Gebruiker&nbsp;</th>
                    				<th>&nbsp;<span class="glyphicon glyphicon-envelope" aria-hidden="true" data-toggle="tooltip" title="Email geverifieerd"></span></th>
                                    <th>&nbsp;<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true" data-toggle="tooltip" title="Gebruiker geactiveerd"></span></th>
                                    <th>&nbsp;<span class="glyphicon glyphicon-home" aria-hidden="true" data-toggle="tooltip" title="Aantal gezinnen"></span></th>
                                    <th>Rol&nbsp;</th>
                                    <th style="width: 240px;">Actie&nbsp;</th> 
                                </tr>                 				
                    			</thead>
                                <tbody>
                    					@foreach ($users as $user)
                                                @if (!$user->emailverified || !$user->activated)
                                                    <tr class="danger" data-trigger="hover" data-placement="bottom" aria-hidden="true" data-toggle="popover" title="Reden van inschrijven" data-content="{{ $user->reden }}"></th>
                                                @else
                                                    <tr>
                                                @endif

						<td>
						    {{ $user->naam }}
							@if ($user->blacklisted)
								<span class="label label-danger"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>&nbsp;Blacklist</span>
							@endif
                            @if ($user->andereinitiatieven)
                                <span class="label label-danger"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>&nbsp;Andere Initiatieven</span>
                            @endif
                                                    <br><b><i>{{ $user->organisatienaam}} </i></b>
                                                </td>
                    							<td>
                                                    @if ($user->emailverified)
                                                        <span class="glyphicon glyphicon-ok-sign" aria-hidden="true" style="color:green;"></span>
                                                    @else
                                                        <span class="glyphicon glyphicon-remove-sign" aria-hidden="true" style="color:red;"></span>
                                                    @endif  
                                                    &nbsp;
                                                </td>
                                                <td>
                                                    @if ($user->activated)
                                                        <span class="glyphicon glyphicon-ok-sign" aria-hidden="true" style="color:green;"></span>&nbsp;
                                                    @else
                                                        <span class="glyphicon glyphicon-remove-sign" aria-hidden="true" style="color:red;"></span>&nbsp;
                                                    @endif                                               
						</td>
						<td>
							{{ count($user->familys) }}
						</td>
                                                <td>
                                                    @if ($user->usertype==1)
                                                        Admin&nbsp;
                                                    @elseif ($user->usertype==2)
                                                        Raadpleger&nbsp;
                                                    @elseif ($user->usertype==3)    
                                                        Intermediair&nbsp;
                                                    @endif                       
                                                </td>
                                                <td>                                                
                                                        <a href="{{ url('/user') }}/show/{{ $user->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Toon</button></a>

                                                        
                                                        @if ( Auth::user()->usertype == 1 ) 
                                                        <a href="#" data-toggle="modal" data-target="#deleteModal{{ $user->id }}"><button class="btn btn-danger btn-xs" type="button"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>&nbsp;Wis</button></a>
                                               

                                                        <!-- Modal om te deleten -->
                                                        <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                          <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                              <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title" id="myModalLabel">Wissen van gebruiker {{ $user->tussenvoegsel}} {{ $user->achternaam }}?</h4>
                                                              </div>
                                                              <div class="modal-body">
                                                                <p>Let op: als je de gebruiker wist, worden alle gezinnen en kinderen die eronder hangen ook <b>permanent</b> gewist.</p></blockquote>
                                                              </div>
                                                              <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuleren</button>
                                                                <a id="deletehref" href="{{ url('/user') }}/destroy/{{ $user->id }}"><button type="button" class="btn btn-primary">Doorgaan</button></a>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        @endif

                                                    @if ($user->activated)
                                                        <a href="{{ url('/user') }}/toggleactive/{{ $user->id }}"><button class="btn btn-warning btn-xs" type="button"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>&nbsp;Deactiveer</button></a>
                                                    @else
                                                        
                                                        @if ($user->emailverified)
                                                            <a href="{{ url('/user') }}/toggleactive/{{ $user->id }}"><button class="btn btn-success btn-xs" type="button"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>&nbsp;Activeer</button></a>
                                                        @endif
                                                    @endif                                                  
                                                </td>
                    						</tr>
                    					@endforeach
                                </tbody>
                    	</table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">

// Dit script zorgt voor sorteren in de lijst
$('th').click(function(){
    var table = $(this).parents('table').eq(0)
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
    this.asc = !this.asc
    if (!this.asc){rows = rows.reverse()}
    for (var i = 0; i < rows.length; i++){table.append(rows[i])}
})
function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index), valB = getCellValue(b, index)
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
    }
}
function getCellValue(row, index){ return $(row).children('td').eq(index).html() }

$(document).ready(function() {
// Hier om de tooltips te activeren
$('[data-toggle="tooltip"]').tooltip();
$('[data-toggle="popover"]').popover();

});



</script>
@endsection
