@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">



            <div class="panel panel-default">              
                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li class="active">Maillijsten</li>
                    </ol> 

                <div class="panel-body">
                                <!-- Flashmessage -->
            @if (count(Session::get('message')) > 0)
                <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
            @endif 
                    <p>


                        <a href="{{ url()->previous() }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                    </p>
                    
                    <p>
                        Hier kunnen de admins maillijsten opvragen, en deze zelf in een BCC-veld plakken van hun email. LET OP: Wees er zeker van dat ze in het BCC-veld terecht komen, anders lekken we alle adressen naar buiten!
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
        
        <li class="active"><a href="{{ url('/maillijsten') }}">Reset</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Kies <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ url('/maillijsten/') }}/?lijst=zkg">Intermediairs zonder kinderen OF gezinnen</a></li>               
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li>

            <p class="navbar-text">

                @if (Request::input('lijst')=='zkg')
                    <b>Intermediairs zonder kinderen OF gezinnen</b>                 
                @else
                    Geen lijst gekozen
                @endif

            </p>
        </li>
        <li><p class="navbar-text"><p class="navbar-text"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <b>{{count($lijst)}}</b></p></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

                   

                    
                        @isset($lijst)
                            @foreach($lijst as $item)
                                {{$item}}
                            @endforeach
                        @endisset


                   
                    <div>

                    
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
