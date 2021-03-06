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
                                  
                <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li class="active">Kinderlijst</li>
                    </ol>

                <div class="panel-body">
                                 <a href="{{ url('/home/') }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                                

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <div class="navbar-brand"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        
        <li class="active"><a href="{{ url('/kinderlijst') }}">Reset</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Kies <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ url('/kinderlijst') }}/?wai=1">Toon alleen <span class="badge" data-toggle="tooltip">AI<span></a></li>
            <li><a href="{{ url('/kinderlijst') }}/?gai=1">Toon juist geen <span class="badge" data-toggle="tooltip">AI<span></a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ url('/kinderlijst') }}/?gg=1">Toon alleen <span class="badge" data-toggle="tooltip">A<span></a></li>            
            <li><a href="{{ url('/kinderlijst') }}/?ngg=1">Toon juist geen <span class="badge" data-toggle="tooltip">A<span></a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ url('/kinderlijst') }}/?p=1">Toon alleen <span class="badge" data-toggle="tooltip" title="Gezin is aangemeld bij andere initiatieven.">PDF<span></a></li>            
            <li><a href="{{ url('/kinderlijst') }}/?gp=1">Toon juist geen <span class="badge" data-toggle="tooltip" title="Gezin is aangemeld bij andere initiatieven.">PDF<span></a></li>            
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" action="{{ url('/kinderlijst') }}" method="get">
        <div class="form-group">
          <input type="text" class="form-control" name="achternaam"  placeholder="Achtern gezin (niet kind)">
        </div>
        <button type="submit" class="btn btn-default">Zoek</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li>

            <p class="navbar-text">

            @if (Request::input('wai'))
                <b>wel <span class="badge" data-toggle="tooltip">AI</span></b>
            @elseif(Request::input('gai'))
                <b>geen <span class="badge" data-toggle="tooltip">AI</span></b>
            @elseif(Request::input('gg'))
                <b>wel <span class="badge" data-toggle="tooltip">A</span></b>
            @elseif(Request::input('ngg'))
                <b>geen <span class="badge" data-toggle="tooltip">A</span></b>
            @elseif(Request::input('ngg'))
                <b>wel <span class="badge" data-toggle="tooltip">PDF</span></b>
            @elseif(Request::input('ngg'))
                <b>geen <span class="badge" data-toggle="tooltip">PDF</span></b>
            @elseif(Request::input('achternaam'))
                <b>bevat "{{Request::input('achternaam')}}"</b>
            @else
                Geen filter
            @endif
</p>
        </li>
        <li><p class="navbar-text"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <b>{{$kids->total()}}</b></p></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

                                


                                    <div class="row">
                        <div class="col-sm-8 col-md-offset-2">
                            {{$kids->render()}}

                        </div>

                    </div>
                     <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                            <thead>
                            <tr>
                				<th>Voornaam&nbsp;</th>
                				<th>Achternaam&nbsp;</th>
                				<th>Woonplaats&nbsp;</th>
                                <th><span class="badge" data-toggle="tooltip" title="Gezin is aangemeld bij andere initiatieven.">AI</span></th>
                				<th><span class="badge" data-toggle="tooltip" title="Dit is de leeftijd op aankomend sinterklaasfeest (5/12/{{Custommade::returnNextSinterklaasJaar()}}).">LT</span></th>          
                                <th><span class="badge" data-toggle="tooltip" title="Kind is aangemeld en goedgekeurd.">A</span></th>  
                                <th><span class="badge" data-toggle="tooltip" title="De PDF is gedownload (kan pas na sluiting inschrijvingen).">PDF</span></th>                
                                <th>Toon&nbsp;</th> 
                            </tr>                 				
                			</thead>
                            <tbody>
    					@foreach ($kids as $kid)
    						@if ($kid->disqualified)
    						<tr class="danger">
    						@else
    						<tr>
    						@endif

    							<td>{{ str_limit($kid->voornaam, 8) }}&nbsp;</td>
							<td>
							{{ str_limit($kid->achternaam, 8) }}&nbsp;</td>
    							<td>{{ str_limit($kid->family->woonplaats, 8) }}&nbsp;</td>
                                <td>
                                    @if($kid->familyanderealternatieven)
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    @endif
                                    &nbsp;</td>  
    							<td>{{ $kid->agenextsint }}&nbsp;</td>  
                                <td>
                                    @if ($kid->barcode)

                                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                    @endif
                                &nbsp;</td> 
                                <td>
                                    @if ($kid->barcode)
                                        @if ($kid->barcode->downloadedpdf)
                                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                        @else
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        @endif
                                    @endif
                                &nbsp;</td>                       


                                <td>
                                  
                                        <a href="{{ url('/user') }}/show/{{ $kid->family->user_id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Intermediair</button></a>

										<a href="{{ url('/family') }}/show/{{ $kid->family->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Familie</button></a>
                                        
										<a href="{{ url('/kids') }}/show/{{ $kid->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Kind</button></a>



                                   
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
