@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

                        @if (count(Session::get('message')) > 0)
                        <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
                        @endif
            <div class="panel panel-default">



                @if (Auth::user()->usertype==1)

                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li><a href="{{ url('/users/index') }}">Gebruikers</a></li>
                      <li><a href="{{ url('/user/show') }}/{{ $family->user->id }}">{{ $family->user->voornaam }} {{ $family->user->tussenvoegsel }} {{ $family->user->achternaam }}</a></li>
                      <li><a href="{{ url('/family') }}/show/{{ $family->id }}">Fam {{ $family->tussenvoegsel }} {{ $family->achternaam }}</a></li>
                      <li class="active">Kind toevoegen</li>
                    </ol>
                @elseif (Auth::user()->usertype==3)

                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li><a href="{{ url('/family') }}/show/{{ $family->id }}">Fam {{ $family->tussenvoegsel }} { $family->achternaam }}</a></li>
                      <li class="active">Kind toevoegen</li>
                    </ol>
                @endif
                <div class="panel-body">
                 Op deze pagina staan alle gegevens die betrekking hebben de op de familie en kinderen van de familie.
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

                    {!! Form::open(['url' => 'kids/store']) !!}
                        

                        <div class="form-group">

                            {!! Form::label('voornaam', 'Voornaam') !!}
                            {!! Form::text('voornaam', null, ['class' => 'form-control', 'required']) !!}

                        </div>
                        <div class="form-group">

                            {!! Form::label('tussenvoegsel', 'Tussenvoegsel') !!}&nbsp;<small>(alleen invullen als deze afwijkt van de familienaam)</small>
                            {!! Form::text('tussenvoegsel', null, ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group">

                            {!! Form::label('achternaam', 'Achternaam') !!}&nbsp;<small>(alleen invullen als deze afwijkt van de familienaam)</small>
                            {!! Form::text('achternaam', null, ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group">

                            {!! Form::label('geslacht', 'Jongen/Meisje') !!}
                            {!! Form::select('geslacht', array(''=>'-', 'm'=>'Jongen', 'v'=>'Meisje'), '',  ["class"=>"form-control"]) !!}

                        </div>


                        <div class="form-group">

                            {!! Form::label('geboortedatum', 'Geboortedatum') !!}&nbsp;<small>(bv 13-12-2015)</small>
                            <input class="form-control" required="required" name="geboortedatum" type="date" id="geboortedatum" data-date-end-date="0d">
                            {!! Form::hidden('family_id', $family->id) !!}
                        </div>   

                        <div class="form-group">

                            {!! Form::submit('Aanmaken', ['class' => 'btn btn-primary form-control']) !!}
                            

                        </div>                   
                    {!! Form::close() !!}


  
  <script type="text/javascript">



    $(function () {


        
    });

  </script>



                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
