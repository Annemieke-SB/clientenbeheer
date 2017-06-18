@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default"> 

                <ol class="breadcrumb">
                  <li><a href="{{ url('/home') }}">Home</a></li>
                  <li class="active">Gebruikers</li>
                </ol> 

                <div class="panel-body">
                    <h1>Barcode afhandeling</h1>

                    @if($errorvlag)
                    <p>Er ging iets fout. De barcodes zijn niet toegevoegd aan de database!</p>
                        @if($no_19>0)
                            <p>Er zijn {{$no_19}} barcodes aangetroffen die niet voldoen aan 19 cijfers. Dit betekent dat er mogelijk te korte of te lange reeksen zijn, of dat er letters tussen staan.</p> 
                        @endif

                        @if($skipped)
                            

                            @if (count($skipped) == $aant_barcodes)
                                <p>Alle barcodes staan al in de database.</p>
                            @else
                                <p>Van de {{ $aant_barcodes }} barcodes, staan er {{ count($skipped) }} al in de database. Er zit dus een dubbele in het bestand. De bewerking is afgebroken omdat de integriteit van het bestand niet klopt. Dit zijn de barcodes die dubbel zijn; </p>
                                
                                <p>
                                @foreach($skipped as $key => $val) 
                                     {{ $val }}, 
                                @endforeach
                                </p>
                            @endif
                            <br><br>
                        @endif

                        @if($aant_barcodes==0)
                            <p>Er zijn geen barcodes in het bestand aangetroffen.</p> 
                        @endif

                        @if($foutformaat)
                            <p>Er is geen '='-teken in het bestand aangetroffen (of in ieder geval één vermelding). Intertoys heeft aangegevens altijd in dit formaat aan te leveren:</p>
                            <pre>6299930034000122453=49120000000000000,8109</pre> 
                        @endif

                    @endif

                    @if(!$errorvlag)
                        <p>Er zijn {{$aant_barcodes}} barcodes in de database geplaatst!</p>
                    @endif

                    <a href="{{ url('/barcodes/') }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                </div>
            </div>       
        </div>
    </div>
</div>


<script type="text/javascript">

$(document).ready(function() {
// Hier om de tooltips te activeren
$('[data-toggle="tooltip"]').tooltip();
});

</script>
@endsection
