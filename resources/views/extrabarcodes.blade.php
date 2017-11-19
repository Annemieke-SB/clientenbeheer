@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">



            <div class="panel panel-default">              
                <ol class="breadcrumb">
                <li><a href="{{ url('/home') }}">Home</a></li>
                <li><a href="{{ url('/barcodes') }}">Barcodes</a></li>
                <li class="active">Extra barcodes</li>
                </ol> 

                <div class="panel-body">
                Hier staan extra downloads. Je kunt hier de PDF's downloaden die extra zijn vrijgemaakt.  
                <br><br>
<a href="{{ url('home') }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                </div>
            </div>

            <!-- Flashmessage -->
            @if (count(Session::get('message')) > 0)
            <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
            @endif
                        
                    @if ($settings['downloads_ingeschakeld'] == 1) {{-- Downloads open --}}
                        


                            <div class="panel panel-default">   <div class="panel-body">
                                    
                                    
                      

                                    <br>
                                        <p><small>Tip: Waar een <span class="glyphicon glyphicon-ok-sign"></span> bij staat is al gedownload.</small><br></p>
                                    @foreach ($extrabarcodes as $extrabarcode)                       
                                    <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                                            <thead>
                                            <tr>                                
                                                     
                                                <th>Download pdf&nbsp;</th> 
                                            </tr>                               
                                            </thead>
                                            <tbody>                                

                                                        @if ($extrabarcodes->barcode)
                                                        <tr>                                        
                                                            
                                                            <td>

                                                            <a href="{{ url('/download/extrapdf/'.$extrabarcodes->id) }}"><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-download-alt"></span>&nbsp;PDF</button></a>                                     
                                        
                                                            @if($extrabarcode->downloadedbarcodepdf)
                                                                <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>                                     
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        @endif
                                                 
                                                
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