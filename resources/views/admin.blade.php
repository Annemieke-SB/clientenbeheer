\@extends('layouts.app')


@section('css')

.pulse {

  
  cursor: pointer;
  box-shadow: 0 0 0 rgba(204,169,44, 0.4);
  animation: pulse 2s infinite;
}
.pulse:hover {
  animation: none;
}

@-webkit-keyframes pulse {
  0% {
    -webkit-box-shadow: 0 0 0 0 rgba(204,169,44, 0.4);
  }
  70% {
      -webkit-box-shadow: 0 0 0 10px rgba(204,169,44, 0);
  }
  100% {
      -webkit-box-shadow: 0 0 0 0 rgba(204,169,44, 0);
  }
}
@keyframes pulse {
  0% {
    -moz-box-shadow: 0 0 0 0 rgba(204,169,44, 0.4);
    box-shadow: 0 0 0 0 rgba(204,169,44, 0.4);
  }
  70% {
      -moz-box-shadow: 0 0 0 10px rgba(204,169,44, 0);
      box-shadow: 0 0 0 10px rgba(204,169,44, 0);
  }
  100% {
      -moz-box-shadow: 0 0 0 0 rgba(204,169,44, 0);
      box-shadow: 0 0 0 0 rgba(204,169,44, 0);
  }
}

@stop




@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">              
      
                    <ol class="breadcrumb">
                      <li class="active">Home</li>

                    </ol>                

                <div class="panel-body">




                    @if (App\Setting::get('inschrijven_gesloten') == 1 && App\Setting::get('downloads_ingeschakeld') == 1) {{-- Inschrijvingen gesloten downloads aktief --}}
                        <div class="panel panel-danger">
                              <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> | De inschrijvingen zijn gesloten! Er kan niets meer worden gewijzigd of toegevoegd door de intermediairs. De downloadpagina is ook aktief, dus intermediairs kunnen downloaden</div>
                        </div>                        
                    @elseif (App\Setting::get('inschrijven_gesloten') == 1 && App\Setting::get('downloads_ingeschakeld') == 0) {{-- Downloads aktief --}}
                        <div class="panel panel-danger">
                              <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> | De downloadpagina is niet actief!!! De inschrijvingen zijn wel gesloten! Er kan niets meer worden gewijzigd of toegevoegd door de intermediairs maar ze kunnen nog niets downloaden!.
                              </div> 
                        </div>                                           
                    @endif


            <!-- Flashmessage -->
            @if (Session::get('message'))
            <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>

	    @endif


                       
@if (count($nogtekeuren_users)>0)


    <div class="panel-group" id="accordion">
      
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse1"><span class="badge">{{ $nogtekeuren_users }}</span> nieuwe gebruikers moeten worden geactiveerd.</a>&nbsp;<a href="{{ url('users/index') }}/?filter=na"><button type="button" class="btn btn-success btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon in gebruikersoverzicht</button></a>
		        </h4>
            </div>
        </div>
	</div>
<br />

@endif 
 
@if (count($nogtekeuren_families)>0)


    <div class="panel-group" id="accordion">
      
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2"><span class="badge">{{ $nogtekeuren_families }}</span> families moeten worden gekeurd.</a>&nbsp;<a href="{{ url('users/index') }}/?filter=igg"><button type="button" class="btn btn-success btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon de intermediairs</button></a>
		</h4>
            </div>
        </div>
	</div>
<br />

@endif 

                       
@if (count($intermediairzonderfamilies)!=0)


    <div class="panel-group" id="accordion">
      
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse3"><span class="badge">{{ $intermediairzonderfamilies }}</span> intermediairs hebben geen gezinnen toegevoegd.</a>&nbsp;<a href="{{ url('users/index') }}/?filter=izg"><button type="button" class="btn btn-success btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon in gebruikersoverzicht</button></a>
		</h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse">

            </div>
        </div>
	</div>
<br />

@endif 

@if (count($familieszonderkinderen)>0)


    <div class="panel-group" id="accordion">
      
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse4"><span class="badge">{{ $familieszonderkinderen }}</span> gezinnen hebben geen kinderen.</a>&nbsp;<a href="{{ url('users/index') }}/?filter=izk"><button type="button" class="btn btn-success btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon intermediairs in gebruikersoverzicht</button></a>
		        </h4>
            </div>
		</div>
    </div>
	
<br />

@endif 

@if (count($intermediairmetnietgedownloadepdfs)>0)

    <div class="panel-group" id="accordion">
      
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse5"><span class="badge">{{ $intermediairmetnietgedownloadepdfs }}</span> intermediairs moeten nog PDF's downloaden.</a>&nbsp;<a href="{{ url('users/index') }}/?filter=ipd"><button type="button" class="btn btn-success btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon gebruikersoverzicht</button></a>
        </h4>
            </div>
        </div>    
    </div>
<br />

@endif 



                </div>
            </div>
        </div>
    </div>

<style>
    .niaHeader {
        font-size: 27px;
        margin: 20px;
    }

    .panel-heading [data-toggle="collapse"]:after {
        font-family: 'Glyphicons Halflings';
        content: "\e072"; /* "play" icon */
        float: right;
        color: #F58723;
        font-size: 18px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
    }

    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
</style>



</div>

@endsection
