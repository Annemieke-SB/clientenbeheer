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
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li><a href="{{ url('/gezinnenlijst') }}">Gezinnenlijst</a></li>
                      <li class="active">Goedgekeurde gezinnen</li>
                    </ol>

                <div class="panel-body">
                                 <a href="{{ url('/gezinnenlijst/') }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                                

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <div class="navbar-brand"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        
        <li class="active"><a href="{{ url('/gezinnenlijst_goedgekeurd') }}">Reset</a></li>
        
      </ul>
      <form class="navbar-form navbar-left" action="{{ url('/gezinnenlijst_goedgekeurd') }}" method="get">
        <div class="form-group">
          <input type="text" class="form-control" name="achternaam"  placeholder="Achternaam gezin">
        </div>
        <button type="submit" class="btn btn-default">Zoek</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li>

            <p class="navbar-text">

                @if (Request::input('achternaam'))
                    <b>bevat "{{Request::input('achternaam')}}"</b>          
                @else
                    Geen filter
                @endif

            </p>
        </li>
        <li><p class="navbar-text"><p class="navbar-text"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <b>{{$goedgekeurdefamilies->total()}}</b></p></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

                                


                                    <div class="row">
                        <div class="col-sm-8 col-md-offset-2">
                            {{$goedgekeurdefamilies->render()}}

                        </div>

                    </div>


                     <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                            <thead>
                            <tr>                                
                                <th>Achternaam&nbsp;</th>
                                <th>Woonplaats&nbsp;</th>     
                                <th><span class="badge" data-toggle="tooltip" title="Dit gezin was afgekeurd, maar is opnieuw aangemeld. Mogelijk heeft de intermediair eea aangepast. De reden van de vorige afmelding staat in het envelopje. Als deze aanmelding weer niet goed is keur hem dan weer af. Je kunt dan de reden aanpassen.">RA</span></th>                                             
                                <th>Aktie&nbsp;</th>                                 
                            </tr>                               
                            </thead>
                            <tbody>
                        @foreach ($goedgekeurdefamilies as $goedgekeurdefamilie)

                                <tr>


                                <td>{{ str_limit($goedgekeurdefamilie->achternaam, 14)  }}&nbsp;</td>
                                <td>{{ str_limit($goedgekeurdefamilie->woonplaats, 14)  }}&nbsp;</td>
                                <td>
                                        @if ($goedgekeurdefamilie->redenafkeuren)
                                            <span class="glyphicon glyphicon-envelope" data-toggle="tooltip" title="{{$goedgekeurdefamilie->redenafkeuren}}"></span>
                                        @endif
                                </td>
                                <td>
                                  
                                        <a href="{{ url('/intermediairs') }}/show/{{ $goedgekeurdefamilie->intermediair_id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Intermediair</button></a>

                                        <a href="{{ url('/family') }}/show/{{ $goedgekeurdefamilie->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Gezin</button></a>        

                                        <a href="{{ url('/family') }}/afkeuren/{{ $goedgekeurdefamilie->id }}"><button class="btn btn-danger btn-xs" type="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;Afkeuren</button></a>                                                  
                                  
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
