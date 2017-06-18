@extends('layouts.app')


@if($match) 
	@section('meta')
	    {!! $meta !!}
	@stop
@endif

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

                    <div class="panel panel-default">
                    <div class="panel-heading">Uw download wordt voorbereid</div>
                    	<div class="panel-body">

                    	@if($match)
	                    	De download begint over 2 seconden, als dat niet zo is, klik hier 
	                    	{{ Html::link('/download/pdfvoorkind/'.$id, 'hier', 'download', array(), false)}} .<br><br><br>
	                    
							<div class="progress">
								<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
							</div>
                    	@else
                    		U probeert de barcode van een ander kind te downloaden. Dit is niet toegestaan. Uw aktie is gelogd en de beheerder zal op de hoogte worden gesteld. Als er iets fout gaat neem dan contact op met de <a href="mailto:webmaster@sinterklaasbank.nl">webmaster</a> (webmaster@sinterklaasbank.nl).
                    	@endif
                    	<br>


                    	{{ Html::link('/intermediair/downloads/', '<button type="button" class="btn btn-primary navbar-btn btn-sm text-right pdfdownload"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button>', 'PDF', array(), false)}}   
                    	</div>
                	</div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">


$(document).ready(function() {
	// Code voor de voortgangsbalk
	var i = 0;

	var counterBack = setInterval(function () {
	  i++;
	  if (i <= 100) {
	    $('.progress-bar').css('width', i + '%');
	  } else {
	    clearInterval(counterBack);
	  }

	}, 100);
});



</script>


@endsection


