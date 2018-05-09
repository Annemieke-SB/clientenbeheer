@extends('layouts.app')


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


                    @if ($settings['inschrijven_gesloten'] == 1 && $settings['downloads_ingeschakeld'] == 1) {{-- Inschrijvingen gesloten downloads aktief --}}
                        <br><br>
                        <div class="panel panel-danger">
                              <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | De inschrijvingen zijn gesloten! Er kan niets meer worden gewijzigd of toegevoegd door de intermediairs. De downloadpagina is ook aktief, dus intermediairs kunnen downloaden</b></div>
                        </div>                        
                    @elseif ($settings['inschrijven_gesloten'] == 1 && $settings['downloads_ingeschakeld'] == 0) {{-- Downloads aktief --}}
                        <br><br>
                        <div class="panel panel-danger">
                              <div class="panel-heading"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><b> | De downloadpagina is niet actief!!! De inschrijvingen zijn wel gesloten! Er kan niets meer worden gewijzigd of toegevoegd door de intermediairs maar ze kunnen nog niets downloaden!.</b>
                              </div> 
                        </div>                                           
                    @endif


            <!-- Flashmessage -->
            @if (count(Session::get('message')) > 0)
            <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>

	    @endif
 
                @if(count($nogtekeuren_users)>0)


    <div class="panel-group" id="accordion">
      
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseKnia"><span class="badge">{{ count($nogtekeuren_users) }}</span>&nbsp;nieuwe gebruikers moeten worden geactiveerd.</a>


</h4>
            </div>
            <div id="collapseKnia" class="panel-collapse collapse">
                <div class="panel-body">
		

		    <div class="alert alert-danger" role="alert"><b>O nee!</b> Er zijn kinderen die niet in aanmerking komen! Kijk hier <a href="{{ url('/kinderlijst') }}"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a> welke kinderen dat zijn.</div>
                        <a href="{{ url('kid/show') }}/id"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;Toon</button></a>

		</div>
            </div>
	</div>
<br />

                @endif                    


                @if(count($nogtekeuren_families)>0)


    <div class="panel-group" id="accordion">
      
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseKnia"><span class="badge">{{ count($nogtekeuren_families) }}</span> families moeten worden gekeurd.</a>


</h4>
            </div>
            <div id="collapseKnia" class="panel-collapse collapse">
                <div class="panel-body">
		

		    <div class="alert alert-danger" role="alert"><b>O nee!</b> Er zijn kinderen die niet in aanmerking komen! Kijk hier <a href="{{ url('/kinderlijst') }}"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a> welke kinderen dat zijn.</div>
                        <a href="{{ url('kid/show') }}/id"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;Toon</button></a>

		</div>
            </div>
	</div>
<br />

                @endif                    

                       
            @if (count($intermediairzonderfamilies)>0)


    <div class="panel-group" id="accordion">
      
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseKnia"><span class="badge">{{ count($intermediairzonderfamilies) }}</span> intermediairs hebben geen gezinnen toegevoegd.</a>


</h4>
            </div>
            <div id="collapseKnia" class="panel-collapse collapse">
                <div class="panel-body">
		

		    <div class="alert alert-danger" role="alert"><b>O nee!</b> Er zijn kinderen die niet in aanmerking komen! Kijk hier <a href="{{ url('/kinderlijst') }}"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a> welke kinderen dat zijn.</div>
                        <a href="{{ url('kid/show') }}/id"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;Toon</button></a>

		</div>
            </div>
	</div>
<br />

                @endif 

                @if(count($familieszonderkinderen)>0)

    <div class="panel-group" id="accordion">
      
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseKnia"><span class="badge">{{ count($familieszonderkinderen) }}</span> families hebben geen kinderen.</a>


</h4>
            </div>
            <div id="collapseKnia" class="panel-collapse collapse">
                <div class="panel-body">
		

		    <div class="alert alert-danger" role="alert"><b>O nee!</b> Er zijn kinderen die niet in aanmerking komen! Kijk hier <a href="{{ url('/kinderlijst') }}"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a> welke kinderen dat zijn.</div>
                        <a href="{{ url('kid/show') }}/id"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;Toon</button></a>

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
