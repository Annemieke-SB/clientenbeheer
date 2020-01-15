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
                  <li><a href="{{ url('/barcodereview') }}">Eind Analyse</a></li>
                  <li class="active">Overzicht ongebruikt codes bij intermediairs</li>
              </ol> 

              <div class="panel-body">
                <p>
                    <a href="{{ url('barcodereview') }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>&nbsp;
                </p>


                <!-- Flashmessage -->
                @if (Session::get('message'))
                <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
                @endif       

                
            

        </div>
    </div>    


    <div class="panel panel-default">   
        <div class="panel-heading">Overzicht ongebruikte barcodes per intermediair</div>           
        <div class="panel-body"><p>Uit deze lijst zijn de extra barcodes (gegenereerd door de sinterklaasbank) niet meegenomen.</p>
           
                    @if ( $welgebruiktebarcodes == 0 )
                        Er zijn nog geen gebruikte barcodes in de database te zien. 
                    @else

                    <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Intermediair</th>
                                <th>Aantal onverzilverd / zonder reden</th>
                                <th>Aktie</th>
                            </tr>
                        </thead>
                        <tbody>

                           <!--
        foreach ($nietgebruiktebarcodes->unique('user_id') as $v) {
            dd($v->user->naam);    
        }
                           -->

                            @foreach ($intermediairsmetongebruiktecodes as $v)
                            
                            <tr>
                                <td>
                                    {{ $v['naam'] }}
                                </td>
                                <td>
                                    {{ $v['aantal'] }} /
                                    {{ $v['zonderreden'] }}
                                </td>                                                                                                   
                                <td>
                                    <a href="{{ url('/user') }}/show/{{ $v['id'] }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Intermediair</button></a>&nbsp;
                                     <a href="{{ url('/barcodes') }}/ongebruikt/{{ $v['id'] }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Mail</button></a>&nbsp;                                   
                                     <a href="{{ url('/barcodes') }}/tabelongebruikt/{{ $v['id'] }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Memo</button></a>&nbsp;
                                </td>
                            </tr>
                            
                            @endforeach     
 
                        </tbody>
                    </table>  
            @endif                  
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
