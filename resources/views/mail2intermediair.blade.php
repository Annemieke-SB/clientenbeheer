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
                      <li class="active">Email naar alle gebruikers</li>
                    </ol>

                <div class="panel-body">
                <p>                 <a href="{{ url('/home/') }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a></p>
                 Geef hier de korte tekst op voor de email die je wilt sturen. De email wordt meteen verzonden aan alle gebruikers, dus intermediairs <b>en beheerders</b>. </p>
                <p>Gebruik deze functie <b>niet</b> om de volgende redenen, omdat die mails al automatisch worden verzonden:</p>
                    <ul>
                    <li>De melding dat de inschrijvingen zijn gesloten.</li>
                    <li>De melding dat de inschrijvingen zijn geopend</li>
                    </ul>
                </div>
            </div>
                <div class="panel panel-default">   
                
                <div class="panel-body">

           


                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li style="margin-left:15px;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {!! Form::open(['url' => 'sendmail']) !!}

                        <div class="form-group">

                            {!! Form::label('tekstvooremail', 'Geef hier de tekst voor de email. Het geven van "enters" en opmaak is uitgeschakeld.') !!}
                            {!! Form::text('tekstvooremail', false, ['class' => 'form-control', 'required']) !!}

                        </div>                              
                        <div class="form-group">

                            {!! Form::submit('Verstuur', ['class' => 'btn btn-success form-control']) !!}                            

                        </div>                   
                    {!! Form::close() !!}
         


  
  <script type="text/javascript">


$(document).ready(function() {
// Hier om de tooltips te activeren
$('[data-toggle="tooltip"]').tooltip();
});


//hier code om de enter key uit te zetten
$(document).keypress(
    function(event){
     if (event.which == '13') {
        event.preventDefault();
      }
});


</script>

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
