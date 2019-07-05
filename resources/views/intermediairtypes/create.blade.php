@extends('layouts.app')

@section('content')
<div class="container">


    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default"> 

                <ol class="breadcrumb">
                  <li><a href="{{ url('/home') }}">Home</a></li>
                  <li class="active">Intermediairtype toevoegen</li>
                </ol> 

                <div class="panel-body">
                        <p>
                        <a href="{{ url('intermediairtypes') }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                        </p>
                    <p>Maak een intermediairtype aan.</p>


            <!-- Flashmessage -->
            @if (Session::get('message'))
            <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
	    @endif      




                    {!! Form::open(['url' => 'intermediairtypes/store', 'id' => 'createform']) !!}
                        
                        <div class="form-group">

                            {!! Form::label('omschrijving', 'Omschrijving') !!}
                            {!! Form::text('omschrijving', null, ['class' => 'form-control','required', 'autofocus']) !!}

                        </div>

         		<div class="form-group">

                            <input class="btn btn-primary form-control" type="submit" id="verzendknop" value="Opslaan">
                            

                        </div>                   
                    {!! Form::close() !!}




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
