@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">



            <div class="panel panel-default">              
                <ol class="breadcrumb">
                <li><a href="{{ url('/home') }}">Home</a></li>
                <li class="active">Downloads</li>
                </ol> 

                <div class="panel-body">
                Hier staan uw downloads. U kunt hier de PDF's voor de kinderen downloaden nadat de inschrijvingen zijn gesloten.  
                <br><br>
<a href="{{ url('home') }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                </div>
            </div>

            <!-- Flashmessage -->
            @if (count(Session::get('message')) > 0)
            <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
            @endif
                        
                    @if (App\Setting::get('downloads_ingeschakeld') == 1) {{-- Downloads open --}}
                        


                            <div class="panel panel-default">   <div class="panel-body">
                                    
                                    
                      

                                    <br>
                                        <p><small>Tip: Waar een <span class="glyphicon glyphicon-ok-sign"></span> bij staat is al gedownload.</small><br></p>
                                    @foreach ($families as $family)                       
                                    <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                                            <thead>
                                            <tr>                                
                                                <th>Downloads voor het gezin {{ $family->achternaam }}&nbsp;</th>       
                                                <th>Download pdf&nbsp;</th> 
                                            </tr>                               
                                            </thead>
                                            <tbody>                                
                                                    @foreach ($family->kids as $kid)
                                                        @if ($kid->barcode)
                                                        <tr>                                        
                                                            <td>{{ $kid->voornaam }}&nbsp;{{ $kid->achternaam }}&nbsp;</td>
                                                            <td>

                                                            <a href="{{ url('/download/kidpdf/'.$kid->id) }}"><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-download-alt"></span>&nbsp;PDF</button></a>                                     
                                        
                                                            @if($kid->downloadedbarcodepdf)
                                                                <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>                                     
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    @endforeach
                                                
                                            </tbody>
                                    </table>
                                    @endforeach
                      

                                </div>
                            </div>

                    @endif
        </div>
    </div>
</div>




<script type="text/javascript">

// Dit script zorgt voor sorteren in de lijst
$('pdfdownload').click(function(){
    setTimeout(function(){
       window.location.reload(1);
    }, 5000);
})
function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index), valB = getCellValue(b, index)
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
    }
}
function getCellValue(row, index){ return $(row).children('td').eq(index).html() }


$(document).ready(function() {

$('[data-toggle="tooltip"]').tooltip();
});



</script>
@endsection
