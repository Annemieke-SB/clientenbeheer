@extends('layouts.app')

@section('content')
<div class="container">


    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default"> 

                <ol class="breadcrumb">
                  <li><a href="{{ url('/home') }}">Home</a></li>
                  <li><a href="{{ url('/blacklist') }}">Blacklist</a></li>
                  <li class="active">Item toevoegen</li>
                </ol> 

                <div class="panel-body">

<p>
    Hier kan je een emailadres aan de blacklist toevoegen. De blacklist is alleen een 'vlaggetje' en doet verder niets. Het is een geheugensteuntje, zorg dus dat je een duidelijke reden vermeld. De blacklist blijft altijd bewaard en bestaat alleen uit een emailadres. Het emailadres wordt gecheckt bij de intermediairs en gezinnen. 
</p>



                        <p>
                        <a href="{{ url()->previous() }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                        </p>
                   


            <!-- Flashmessage -->
            @if (Session::get('message'))
            <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
	    @endif      







@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


                    {!! Form::open(['url' => 'blacklist/store', 'id' => 'createform']) !!}
                        
                        <div class="form-group">

                            {!! Form::label('email', 'E-mail') !!}
                            {!! Form::text('email', $email, ['class' => 'form-control','required', 'autofocus']) !!}

                        </div>
                        <div class="form-group">

                            {!! Form::label('reden', 'Reden') !!}
                            {!! Form::textarea('reden', null, ['class' => 'form-control', 'required','autofocus']) !!}

                        </div>
                        
         		<div class="form-group">
                            {!! Form::hidden('user_id', $user_id) !!}

                            <input class="btn btn-primary form-control" type="submit" id="verzendknop" value="Opslaan">
                            

                        </div>                   
                    {!! Form::close() !!}




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
