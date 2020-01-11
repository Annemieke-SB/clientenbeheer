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
                  <li class="active">Niet gebruikte codes per intermediair</li>
              </ol> 

              <div class="panel-body">
                <p>
                    <button onclick="goBack()" type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button>&nbsp;
                </p>


                <!-- Flashmessage -->
                @if (Session::get('message'))
                <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
                @endif       

        </div>
    </div>        



    <div class="panel panel-default">   
        <div class="panel-heading">Overzicht ongebruikte barcodes per intermediair</div>           
        <div class="panel-body"> 
           
                    <b>Email:</b> <br>{{$intermediair->email}}<br><br>

                    <b>Inhoud:</b> <br>
                                <br>
                                @if ($intermediair->geslacht == "m")
                                Geachte heer
                                @else
                                Geachte mevrouw                                        
                                @endif

                                @if ($intermediair->tussenvoegsel)
                                {{ $intermediair->tussenvoegsel }}&nbsp;{{$intermediair->achternaam}},
                                @else
                                {{$intermediair->achternaam}},                                    
                                @endif
                                
                                <br><br>
                                <p>Uit onze administratie is gebleken dat er in de onderstaande gezinnen (gedeeltelijk) geen gebruik is gemaakt van de door ons verstrekte kadocode.</p>





                    <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Kind</th>
                                <th>Gezin</th>
                                <th>Code gebruikt</th>
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
                                @if ($ngb->kid->verzilverd)
                                Ja
                                @else
                                Nee                                        
                                @endif
                                &nbsp;
                            </td>                                                                     
                        </tr>
                        
                        @endforeach    
 
                        </tbody>
                    </table>           


                    <p>Wij verzoeken u vriendelijk bij het gezin na te vragen wat de reden hiervan is. Op die manier weten wij wat er mis is gegaan en kunnen wij daar lering uit trekken.</p>
                    <p>Zou u ons dat kunnen laten weten? Alvast ontzettend bedankt!</p>
                    <p>Met vriendelijke groet,</p>
                    <br><br>
                    <p>Stichting de Sinterklaasbank</p>
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
