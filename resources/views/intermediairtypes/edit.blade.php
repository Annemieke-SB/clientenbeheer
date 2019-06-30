@extends('layouts.app')

@section('content')
<div class="container">


    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default"> 

                <ol class="breadcrumb">
                  <li><a href="{{ url('/home') }}">Home</a></li>
                  <li><a href="{{ url('/blacklist') }}">Intermediairtypes</a></li>
                  <li class="active">Item wijzigen</li>
                </ol> 

                <div class="panel-body">
                        <p>
                        <a href="{{ url('intermediairtypes') }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                        </p>


            <!-- Flashmessage -->
            @if (Session::get('message'))
            <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
        @endif      




                    {!! Form::open(['url' => 'intermediairtypes/update', 'id' => 'createform']) !!}
                        
                        <div class="form-group">

                            {!! Form::label('omschrijving', 'Omschrijving') !!}
                            {!! Form::text('omschrijving', $intermediairtype->omschrijving, ['class' => 'form-control','required', 'autofocus']) !!}

                        </div>
                      
                <div class="form-group">
                            {!! Form::hidden('id', $intermediairtype->id) !!}

                            <input class="btn btn-primary form-control" type="submit" id="verzendknop" value="Opslaan">
                            

                        </div>                   
                    {!! Form::close() !!}




            </div>
        </div>
    </div>
</div>


@endsection
