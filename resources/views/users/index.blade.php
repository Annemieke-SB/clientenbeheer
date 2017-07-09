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
                    <p>


                        <a href="{{ url('/home/') }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                    </p>
                    <p>
                        Hier is het overzicht van gebruikers. Dit overzicht is alleen beschikbaar voor administrators en raadplegers. Het is niet mogelijk gebruikers toe te voegen, zij moeten zichzelf registreren. Als ze dan in dit overzicht komen kan hun rol worden aangepast. 
                    </p>
                  <small>Tip: Klik op de kolomkoppen om te sorteren. </small>             
                </div>
            </div>

            <!-- Flashmessage -->
            @if (count(Session::get('message')) > 0)
                <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
            @endif                       


            <div class="panel panel-default">   

                <div class="panel-body">            
                                <div class="panel panel-warning">                      
                                  <div class="panel-body bg-warning">
                                    <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>&nbsp;Bericht van Henrique: ik ben op dit moment bezig op deze pagina om het wat overzichtelijker te krijgen. Een ogenblik geduld :).
                                  </div>
                                </div>
                      
                    <br><br>
                    <div class="row">
                        <div class="col-sm-8 col-md-offset-2">
                            {{$users->render()}}
                        </div>

                    </div>
                    Filter: 
                        <a href="{{ url('/users/index') }}/?na=1">Alleen niet geactiveerde accounts</a> | 
                        <a href="{{ url('/users/index') }}">Verwijder filter</a><br>
                    Achternaam begint met: 
                        @foreach(range('a','z') as $i)
                            <a href="{{ url('/users/index') }}/?an=".$i>$i</a> |                                        
                        @endforeach

                    <div class="table-responsive">
                        <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                                <thead>
                                <tr>
                    				<th>Gebruiker&nbsp;</th>
                    				<th>&nbsp;<span class="glyphicon glyphicon-envelope" aria-hidden="true" data-toggle="tooltip" title="Email geverifieerd"></span></th>
                                    <th>&nbsp;<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true" data-toggle="tooltip" title="Gebruiker geactiveerd"></span></th>
                                    <th style="max-width: 300px;">Instelling / reden</th>
                                    <th>Rol&nbsp;</th>
                                    <th>Actie&nbsp;</th> 
                                </tr>                 				
                    			</thead>
                                <tbody>
                    					@foreach ($users as $user)
                                                @if (!$user->emailverified || !$user->activated)
                                                    <tr class="danger">
                                                @else
                                                    <tr>
                                                @endif

                    							<td>
                                                    {{ $user->voornaam }}&nbsp;{{ $user->achternaam }}
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
                                                <td style="max-width: 300px;">                                
                                                    &nbsp;{{ $user->organisatienaam }} / <br> {{ $user->reden }}
                                                </td>                                                
                                                <td>
                                                    @if ($user->usertype==1)
                                                        Admin&nbsp;
                                                    @elseif ($user->usertype==2)
                                                        Raadpleger&nbsp;
                                                    @elseif ($user->usertype==3)    
                                                        Intermediair&nbsp;<a href="{{ url('/user/redirecttointermediair') }}/{{ $user->id }}"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a>
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
                                                                <h4 class="modal-title" id="myModalLabel">Wissen van gebruiker {{ $user->achternaam }}?</h4>
                                                              </div>
                                                              <div class="modal-body">
                                                                <p>Let op: als je de gebruiker wist, worden (als de gebruiker een intermediair is) de instelling en alle gezinnen en kinderen die eronder hangen ook <b>permanent</b> gewist.</p></blockquote>
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
});



</script>
@endsection
