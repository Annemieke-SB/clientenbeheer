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
                  <li><a href="{{ url('/home') }}">Home</a></li>
                  <li class="active">Barcodes</li>
              </ol> 

              <div class="panel-body">
                <p>
                    <a href="{{ url('home') }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>&nbsp;
                    <a href="{{ url('extrabarcodes') }}"><button type="button" class="btn btn-warning navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-star-empty"></span>&nbsp;&nbsp;Losse barcodes</button></a>&nbsp;
                    <a href="{{ url('barcodereview') }}"><button type="button" class="btn btn-info navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;Eind Analyse</button></a>&nbsp;
                </p>
                <p>Hier is het overzicht tbv barcodes.</p>

            </div>
        </div>

        <!-- Flashmessage -->
        @if (count(Session::get('message')) > 0)
        <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
        @endif       

        <div class="panel panel-default">
            <div class="panel-heading">Status van barcode-downloads</div>  
            <div class="panel-body">           
                <p>Wanneer de inschrijvingen zijn gesloten kun je hier de voortgang zien van de barcode-downloads.</p>


                
                <table class="table table-condensed table-hover">
                    <thead>
                        <tr><th>Omschrijving</th><th>Aantal</th></tr></thead>
                        <tbody>
                            
                            <tr><td>Uitgegeven barcodes</td><td>{{ $losse_barcodes + $uitgegeven_barcodes }}</td></tr>
                            <tr><td>&#8627;&nbsp;&nbsp;Waarvan gedownload</td><td>{{ $gedownloadde_barcodes }}</td></tr>   
                            <tr><td>Nog te downloaden</td><td>{{ ($losse_barcodes + $uitgegeven_barcodes) - $gedownloadde_barcodes }}</td></tr>   
                            
                            
                        </tbody>
                    </table>                    
                </div>
            </div>                            

            <div class="panel panel-default">  
                <div class="panel-heading">Status van barcode-voorraad</div> 
                <div class="panel-body">      
                   
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr><th>Omschrijving</th><th>Aantal</th></tr></thead>
                            <tbody>
                                <tr><td>Totaal in database</td><td>{{ $aant_barcodes }}</td></tr>
                                <tr><td>&#8627;&nbsp;&nbsp;Waarvan uitgegeven (aan kinderen van goedgekeurde gezinnen)</td><td>{{ $uitgegeven_barcodes }}</td></tr>
                                <tr><td>&#8627;&nbsp;&nbsp;Waarvan geclaimd voor overige doelen (losse barcodes)</td><td>{{ $losse_barcodes }}</td></tr>
                                <tr><td>Totaal uitgegeven</td><td>{{ $losse_barcodes + $uitgegeven_barcodes }}</td></tr>
                                <tr class="info"><td>Nog resterend (huidige voorraad)</td><td>{{ $aant_barcodes - $uitgegeven_barcodes }}</td></tr>
                                <tr><td>Nog niet aangemelde kinderen (definitief afgekeurde gezinnen niet meegeteld)</td><td>{{ $niet_aangemelde_kinderen }}</td></tr>   
                                <tr><td>Aangemelde kinderen (in afwachting van goedkeuring)</td><td>{{ $aangemelde_kinderen }}</td></tr>   
                                
                                @if (($aant_barcodes - $uitgegeven_barcodes - $niet_aangemelde_kinderen - $aangemelde_kinderen)<10)

                                <tr class="danger">
                                    @else
                                    <tr class="success">
                                        @endif

                                        <td>Geschatte toekomstige voorraad</td><td>{{ $aant_barcodes - $uitgegeven_barcodes - $niet_aangemelde_kinderen - $aangemelde_kinderen }}</td></tr>                               
                                    </tbody>
                                </table>                    
                            </div>
                        </div>
                        <div class="panel panel-default">   
                            <div class="panel-heading">Nieuwe codes uploaden
                            </div>           
                            <div class="panel-body"> 

                                <p>Hieronder kun je nieuwe codes uploaden. Het kan een tekst-bestand zijn (.txt) of een Komma Gescheiden-bestand (.csv). Zorg dat de inhoud van het bestand er zo uitziet (zonder lege regels):<br></p>
                                <pre>Voorbeeld<br>
                                    6299930034000122339=49120000000000000,4621
                                    6299930034000122347=49120000000000000,8055
                                    6299930034000122354=49120000000000000,3271
                                    6299930034000122362=49120000000000000,0377
                                    6299930034000122370=49120000000000000,1066
                                </pre>
                                
                                {!! Form::open(array('url'=>'/barcodes/upload', 'method'=>'POST', 'files'=>true)) !!}
                                
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
