@extends('layouts.app')

@section('content')
<div class="container">

    @if(!empty($new_barcodes))
    {{dd($new_barcodes)}}
    @endif

    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default"> 

                <ol class="breadcrumb">
                  <li><a href="{{ url('home') }}">Home</a></li>
                  <li><a href="{{ url('/barcodes') }}">Barcodes</a></li>
                  <li class="active">Niet gebruikte codes van intermediair {{$intermediair->achternaam}} (tabel)</li>
              </ol> 

              <div class="panel-body">
                <p>
                    <a href="{{ url('barcodereview/intermediairsmetongebruiktecodes') }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>&nbsp;

                      </p>


                <!-- Flashmessage -->
                @if (Session::get('message'))
                <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
                @endif       

        </div>
    </div>        



    <div class="panel panel-default">   
        <div class="panel-heading">Overzicht ongebruikte barcodes intermediair {{$intermediair->achternaam}}</div>           
        <div class="panel-body"> 
           

                    <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Kind</th>
                                <th>Gezin</th>
                                <th>Reden niet gebruikt</th>
                            </tr>
                        </thead>
                        <tbody>


                        @foreach($nietgebruiktebarcodes as $ngb)
                        
                        <tr>
                            <td>
                                {{$ngb->kid->naam}}
                            </td>
                            <td>
                                {{$ngb->kid->family->naam}}
                            </td>
                            <td>

                                {!! Form::open(['url' => 'barcodes/doorgeven_reden_nietgebruik']) !!}
                                {!! Form::token() !!}

                                <div class="form-group">

                                    {!! Form::text('reden_nietgebruikt', $ngb->reden_nietgebruikt) !!}
                                    {!! Form::hidden('id', $ngb->id) !!}
                                    {!! Form::submit('verwerk') !!}

                                </div>    
                                {!! Form::close() !!}
                
                                &nbsp;
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

function goBack() {
  window.history.back();
}


</script>
@endsection
