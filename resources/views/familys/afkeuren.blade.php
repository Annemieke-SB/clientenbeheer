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


                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li><a href="{{ url('/gebruikers') }}">Gebruikers</a></li>
                      <li><a href="{{ url('/user/show/' . $family->user->id) }}">{{$family->user->naam}}</a></li>
                      <li><a href="{{ url('/family') }}/show/{{ $family->id }}">Gezin {{ $family->naam }}</a></li>
                      <li class="active">Afkeuren</li>
                    </ol>

                <div class="panel-body">
                <p>                 <a href="{{ url()->previous() }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a></p>
                 De tekst hoeft niet te worden weggehaald voor goedkeuren, in dat geval gewoon goedkeuren en de tekst verdwijnt.
                </div>
            </div>
                <div class="panel panel-default">   
                
                <div class="panel-body">

            @if (App\Setting::get('downloads_ingeschakeld') == 1) 

                <h1>De downloads zijn al aktief</h1>
                <p>De downloads zijn al aktief, dus het is niet mogelijk om gezinnen af te keuren. Een goedgekeurd gezin kan namelijk al barcodes in het bezit hebben.</p>

            @else


                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li style="margin-left:15px;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {!! Form::open(['url' => 'family/afkeuren']) !!}

                        {!! Form::hidden('id', $family->id) !!}

                        <div class="form-group">

                            {!! Form::label('redenafkeuren', 'Geef hier de reden van afkeuren.') !!}
                            {!! Form::text('redenafkeuren', $family->redenafkeuren, ['class' => 'form-control', 'required']) !!}

                        </div>      

                        <div class="form-group">

                            {!! Form::label('definitiefafkeuren', 'Definitief afkeuren?') !!}
                            {!! Form::checkbox('definitiefafkeuren', $family->definitiefafkeuren, ['class' => 'form-control']) !!}

                        </div>                                                 
                        <div class="form-group">

                            {!! Form::submit('Afkeuren', ['class' => 'btn btn-danger form-control']) !!}                            

                        </div>                   
                    {!! Form::close() !!}
            @endif


  
  <script type="text/javascript">


$(document).ready(function() {
// Hier om de tooltips te activeren
$('[data-toggle="tooltip"]').tooltip();
});



</script>

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
