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
                      <li><a href="{{ url('/user/show') }}/{{ $family->user->id }}">{{ $user->getNaam() }}</a></li>
                      <li><a href="{{ url('/family') }}/show/{{ $family->id }}">Gezin {{ $family->getNaam() }}</a></li>
                      <li class="active">Kind toevoegen</li>
                    </ol>
                @elseif (Auth::user()->usertype==3)

                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li><a href="{{ url('/family') }}/show/{{ $family->id }}">Gezin {{ $family->getNaam() }}</a></li>
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

                            {!! Form::label('tussenvoegsel', 'Tussenvoegsel') !!}
                            {!! Form::text('tussenvoegsel', $family->tussenvoegsel, ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group">

                            {!! Form::label('achternaam', 'Achternaam') !!}
                            {!! Form::text('achternaam', $family->achternaam, ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group">

                            {!! Form::label('geslacht', 'Jongen/Meisje') !!}
                            {!! Form::select('geslacht', array(''=>'-', 'm'=>'Jongen', 'v'=>'Meisje'), '',  ["class"=>"form-control"]) !!}

                        </div>


                        <div class="form-group">

                            {!! Form::label('geboortedatum', 'Geboortedatum') !!}&nbsp;<small>(bv 13-12-2015)</small>
                            <input class="form-control" required="required" name="geboortedatum" type="date" id="geboortedatum" data-date-end-date="0d">
                        </div>   
                            {!! Form::hidden('family_id', $family->id) !!}
                            {!! Form::hidden('user_id', $family->user->id) !!}

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
