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

                @if (Auth::user()->usertype==1)
                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li><a href="{{ url('/intermediairs') }}">Intermediairs</a></li>
                      <li><a href="{{ url('/intermediairs/show') }}/{{ $intermediair->id }}">{{ $eigenaar->voornaam }} {{ $eigenaar->achternaam }}</a></li>
                      <li><a href="{{ url('/family') }}/show/{{ $family->id }}">Fam {{ $family->achternaam }}</a></li>
                      <li class="active">{{ $kid->voornaam }} wijzigen</li>
                    </ol>
                @elseif (Auth::user()->usertype==3)
                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li><a href="{{ url('/family') }}/show/{{ $family->id }}">Fam {{ $family->achternaam }}</a></li>
                      <li class="active">{{ $kid->voornaam }} wijzigen</li>
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

                    {!! Form::open(['url' => 'kids/update']) !!}
                        
                        <div class="form-group">
                            {!! Form::label('voornaam', 'Voornaam') !!}
                            {!! Form::text('voornaam', $kid->voornaam, ['class' => 'form-control', 'required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('achternaam', 'Achternaam') !!}&nbsp;<small>(alleen invullen als deze afwijkt van de familienaam)</small>
                            {!! Form::text('achternaam', $kid->achternaam, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">

                            {!! Form::label('geslacht', 'Jongen/Meisje') !!}
                            {!! Form::select('geslacht', array(''=>'-', 'm'=>'Jongen', 'v'=>'Meisje'), $kid->geslacht,  ["class"=>"form-control"]) !!}
                        </div>
                        <div class="form-group">

                            {!! Form::label('geboortedatum', 'Geboortedatum') !!}&nbsp;<small>(bv 13-12-2015)</small>
                            {!! Form::date('geboortedatum', \Carbon\Carbon::createFromFormat('d-m-Y', $kid->geboortedatum)->format('Y-m-d'), ['class' => 'form-control', 'required']) !!}
                            {!! Form::hidden('family_id', $family->id) !!}
                            {!! Form::hidden('id', $kid->id) !!}
                        </div>   

                        <div class="form-group">

                        {!! Form::submit('Wijzigen', ['class' => 'btn btn-primary form-control']) !!}
                            
                        </div>                   
                    {!! Form::close() !!}
                    
{{ Html::link('/kids/show/'.$kid->id, '<button type="button" class="btn btn-danger navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Annuleren</button>', 'Annuleren', array(), false)}}

  
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
