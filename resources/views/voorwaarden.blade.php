   @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- Flashmessage -->
            @if (Session::get('message'))
            <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
            @endif
                        
            <div class="panel panel-default">
                <div class="panel-heading">Bedankt voor uw interesse</div>

                <div class="panel-body">
                    {!! Custommade::showVoorwaarden() !!}


                    <center><a id="akkoord" href="{{ url('/register') }}"><button type="button" class="btn btn-success"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;Ik ben akkoord met de voorwaarden!</button></a></center><br><br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
