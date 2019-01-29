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
                  <li class="active">Eind Analyse</li>
              </ol> 

              <div class="panel-body">
                <p>
                    <a href="{{ url('barcodes') }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>&nbsp;
                </p>


                <!-- Flashmessage -->
                @if (count(Session::get('message')) > 0)
                <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
                @endif       

                
                <p>Als de eindlijst van Intertoys is binnengekomen, kan je die hier uploaden. Je krijgt dan onder andere een overzicht van kinderen waarvan de barcode niet is gebruikt.</p>

                <ul class="list-group">
                  <li class="list-group-item">
                    <span class="badge">&#8364; {{str_replace('.', ',', $totaaluitgegeven)}}</span>
                    Totaal uitgegeven aan barcodes volgens eindlijst
                </li>
                <li class="list-group-item">
                    <span class="badge">{{count($nietgebruiktebarcodes)}}</span>
                    Totaal aantal uitgegeven barcodes <b>niet</b> ingewisseld
                </li>
                <li class="list-group-item">
					<span class="badge">{{ $welgebruiktebarcodes }}</span>
                    Totaal aantal uitgegeven barcodes <b>wel</b> ingewisseld
                </li>
            </ul>

        </div>
    </div>        


    <div class="panel panel-default">   
        <div class="panel-heading">Overzicht ongebruikte barcodes per intermediair</div>           
        <div class="panel-body"> 
           
                    @if(count($arrayIntermediairAantalOnverzilverdeBarcodes) == 0)
                        Er zijn nog geen gebruikte barcodes in de database te zien. 
                    @else

                    <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Kind</th>
                                <th>Gezin</th>
                                <th>Intermediair</th>
                                <th>Aktie</th>
                            </tr>
                        </thead>
                        <tbody>

                           


                             @foreach($arrayIntermediairAantalOnverzilverdeBarcodes as $ngb)
                            
                            <tr>
                                <td>
                                    {{$ngb->organisatienaam}}
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    {{$ngb->voornaam}}
                                </td>                                                                        
                                <td>
                                    <a href="{{ url('/kids') }}/show/{{ $ngb->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Intermediair</button></a>&nbsp;
                                </td>
                            </tr>
                            
                            @endforeach     
 
                        </tbody>
                    </table>  
            @endif                  
        </div>
    </div>    

                    

    <div class="panel panel-default">   
        <div class="panel-heading">Overzicht ongebruikte barcodes per kind</div>           
        <div class="panel-body"> 
           
                    @if($welgebruiktebarcodes == 0)
                        Er zijn nog geen gebruikte barcodes in de database te zien. 
                    @else

                    <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Kind</th>
                                <th>Gezin</th>
                                <th>Intermediair</th>
                                <th>Aktie</th>
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
                                {{$ngb->kid->user->naam}}
                            </td>                                                                        
                            <td>
                                <a href="{{ url('/kids') }}/show/{{ $ngb->kid->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Kind</button></a>&nbsp;
                                <a href="{{ url('/family') }}/show/{{ $ngb->kid->family->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Gezin</button></a>&nbsp;
                                <a href="{{ url('/user') }}/show/{{ $ngb->kid->user->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Intermediair</button></a>&nbsp;
                            </td>
                        </tr>
                        
                        @endforeach    
 
                        </tbody>
                    </table>  
            @endif                  
        </div>
    </div>    

    <div class="panel panel-default">   
        <div class="panel-heading">Overzicht ongebruikte losse barcodes</div>           
        <div class="panel-body"> 
           
            @if($welgebruiktebarcodes == 0)
                Er zijn nog geen gebruikte barcodes in de database te zien. 
            @else

                <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>Doel (opmerking)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nietgebruiktelossebarcodes as $nglb)
                        
                        <tr>
                            <td>
                                Barcode {{$nglb->opmerking}} is niet gebruikt. Doel/opmerking: 
                                @if (!$nglb->opmerking)
                                Niet opgegeven
                                @else
                                {{$nglb->opmerking}}
                                @endif
                            </td>   
                        </tr>
                        
                        @endforeach                                
                        
                    </tbody>
                </table>   
            @endif                   
        </div>
    </div>                          

    <div class="panel panel-default">   
        <div class="panel-heading">Eindlijst uploaden
        </div>           
        <div class="panel-body"> 

            <p>Hieronder kun je de eindlijst met gebruikte codes uploaden. Het kan een tekst-bestand zijn (.txt) of een Komma Gescheiden-bestand (.csv), maar het scheidingsteken moet ";" (puntkomma) zijn. Zorg dat de inhoud van het bestand er zo uitziet (zonder lege regels):<br></p>
            <pre>Voorbeeld<br>

                CardNumber              CardStatus  Load_Value  AccountBalance  DateFirstLoad   ShopIdFirstLoad NoOfRedemptions ValueOfRedemptions  Date last Redemption
                629993 900540 0000011   1           25          0,02            14.11.2017      300             1               24,98               02.12.2017
                629993 900540 0000029   1           25          0               14.11.2017      300             1               25                  04.12.2017
                629993 900540 0000037   1           25          0               14.11.2017      300             1               25                  03.12.2017

            </pre>
            
            {!! Form::open(array('url'=>'/barcodes/eindlijst_upload', 'method'=>'POST', 'files'=>true)) !!}
            
            {{ csrf_field() }}
            <div class="form-group">
                <label for="file">Selecteer hier het bestand: </label>
                <input type="file" name="uploadedfilename">                
            </div>
            
            <button type="submit" class="btn btn-primary">Uploaden</button>
            {!! Form::close() !!}
            
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
