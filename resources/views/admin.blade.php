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
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse1"><span class="badge">{{ count($nogtekeuren_users) }}</span> nieuwe gebruikers moeten worden geactiveerd.</a>&nbsp;<a href="{{ url('users/index') }}/?filter=na"><button type="button" class="btn btn-success btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon in gebruikersoverzicht</button></a>
            </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
    <div class="panel-body">

          <table class="table table-striped">
          <thead>
                <th style="width: 40%;">Naam</th>
                <th style="width: 38%;">Email</th>
                <th>Aktie</th>
          </thead>
  
    <tbody>


    @foreach ($nogtekeuren_users as $ntku)

                <tr data-trigger="hover" data-placement="bottom" aria-hidden="true" data-toggle="popover" title="Reden van inschrijven" data-content="{{ $ntku->reden }}">
      <td>
        {{ $ntku->naam }}
        @if ($ntku->blacklisted)
          &nbsp;<span class="label label-danger"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>&nbsp;Blacklist</span>
        @endif
                                <br><b><i>{{ $ntku->organisatienaam}} </i></b>
      </td>
      <td>{{$ntku->email}}</td>
                <td>
                          <a href="{{ url('user/show') }}/{{$ntku->id}}"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon</button></a>
                          <a href="{{ url('user/toggleactive') }}/{{$ntku->id}}"><button type="button" class="btn btn-warning btn-xs text-right"><span class="glyphicon glyphicon-ok"></span>&nbsp;Activeer</button></a>
                </td>
          </tr>
    
    @endforeach 
    
    </tbody>
    </table>

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
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2"><span class="badge">{{ count($nogtekeuren_families) }}</span> families moeten worden gekeurd.</a>&nbsp;<a href="{{ url('users/index') }}/?filter=igg"><button type="button" class="btn btn-success btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon de intermediairs</button></a>
    </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse">
    <div class="panel-body">

          <table class="table table-striped">
          <thead>
                <th style="width: 80%;">Naam</th>
                <th>Aktie</th>
          </thead>
  
    <tbody>


    @foreach ($nogtekeuren_families as $ntkf)

          <tr>
      <td>
        {{ $ntkf->naam }}
        @if ($ntkf->blacklisted)
          &nbsp;<span class="label label-danger"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>&nbsp;Blacklist</span>
        @endif
      </td>
                <td>
                          <a href="{{ url('family/show') }}/{{$ntkf->id}}"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon</button></a>
                </td>
          </tr>
    
    @endforeach 
    
    </tbody>
    </table>

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
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse3"><span class="badge">{{ count($intermediairzonderfamilies) }}</span> intermediairs hebben geen gezinnen toegevoegd.</a>&nbsp;<a href="{{ url('users/index') }}/?filter=izg"><button type="button" class="btn btn-success btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon in gebruikersoverzicht</button></a>
    </h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse">
    <div class="panel-body">

          <table class="table table-striped">
          <thead>
                <th style="width: 80%;">Naam</th>
                <th>Aktie</th>
          </thead>
  
    <tbody>


    @foreach ($intermediairzonderfamilies as $izf)

          <tr>
      <td>
        {{ $izf->naam }}
        @if ($izf->blacklisted)
          &nbsp;<span class="label label-danger"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>&nbsp;Blacklist</span>
        @endif
      </td>
                <td>
                          <a href="{{ url('user/show') }}/{{$izf->id}}"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon</button></a>
                </td>
          </tr>
    
    @endforeach 
    
    </tbody>
    </table>

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
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse4"><span class="badge">{{ count($familieszonderkinderen) }}</span> gezinnen hebben geen kinderen.</a>&nbsp;<a href="{{ url('users/index') }}/?filter=izk"><button type="button" class="btn btn-success btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon intermediairs in gebruikersoverzicht</button></a>
    </h4>
            </div>
            <div id="collapse4" class="panel-collapse collapse">
    <div class="panel-body">

          <table class="table table-striped">
          <thead>
                <th style="width: 60%;">Naam</th>
                <th>Aktie</th>
          </thead>
  
    <tbody>


    @foreach ($familieszonderkinderen as $fzk)

          <tr>
      <td>
        {{ $fzk->naam }}
        @if ($fzk->blacklisted)
          &nbsp;<span class="label label-danger"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>&nbsp;Blacklist</span>
        @endif
      </td>
                <td>
                          <a href="{{ url('family/show') }}/{{$fzk->id}}"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon gezin</button></a>&nbsp;
                          <a href="{{ url('user/show') }}/{{$fzk->user->id}}"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon intermediair</button></a>
                </td>
          </tr>
    
    @endforeach 
    
    </tbody>
    </table>

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
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse5"><span class="badge">{{ count($intermediairmetnietgedownloadepdfs) }}</span> intermediairs moeten nog PDF's downloaden.</a>&nbsp;<a href="{{ url('users/index') }}/?filter=ipd"><button type="button" class="btn btn-success btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon gebruikersoverzicht</button></a>
        </h4>
            </div>
            <div id="collapse5" class="panel-collapse collapse">
        <div class="panel-body">

            <table class="table table-striped">
            <thead>
                    <th style="width: 80%;">Naam</th>
                    <th>Aktie</th>
            </thead>
  
        <tbody>


        @foreach ($intermediairmetnietgedownloadepdfs as $indp)

            <tr>
            <td>
                {{ $indp->naam }}
                @if ($indp->blacklisted)
                    &nbsp;<span class="label label-danger"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>&nbsp;Blacklist</span>
                @endif
            </td>
                    <td>
                            <a href="{{ url('user/show') }}/{{$indp->id}}"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon</button></a>
                    </td>
            </tr>
        
        @endforeach 
        
        </tbody>
        </table>

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
