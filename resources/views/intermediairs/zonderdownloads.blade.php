
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- Flashmessage -->
            @if (count(Session::get('message')) > 0)
            <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
            @endif
                        
            <div class="panel panel-default">
                <div class="panel-heading">Hier de emaiadressen van de intermediair die nog niet alles hebben gedownload</div>

                <div class="panel-body">
                    

                  @foreach ($emails as $email)
                  {{ $email }}; 
                  @endforeach

                  <hr>

                  @foreach ($foutebarcodes as $foutebarcode)
                  {{ $foutebarcode }}; 
                  @endforeach


                  @foreach ($goedeintermediairs as $goedeintermediair)
                  <a href="{{ url('/intermediairs/show/'.$goedeintermediair) }}"><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-download-alt"></span>&nbsp;check</button></a>&nbsp;
                  @endforeach


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
