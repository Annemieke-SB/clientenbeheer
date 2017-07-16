@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                            

      


                @if (Auth::user()->usertype==1)
                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li><a href="{{ url('/intermediairs') }}">Intermediairs</a></li>
                      <li><a href="{{ url('/intermediairs/show') }}/{{ $intermediair->id }}">{{ $eigenaar->voornaam }} {{ $eigenaar->achternaam }}</a></li>                      
                      <li class="active">Familie toevoegen</li>
                    </ol>
                @elseif (Auth::user()->usertype==3)

                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>                     
                      <li class="active">Gezin toevoegen</li>
                    </ol>
                @endif

                <div class="panel-body">
                 Op deze pagina staan alle gegevens die betrekking hebben de op de gezinnen en kinderen van het gezin.
                 <a href="{{ url(URL::previous()) }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
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




                    {!! Form::open(['url' => 'familys/store', 'id' => 'createform']) !!}
                        
                        <div class="form-group">

                            {!! Form::label('achternaam', 'Achternaam van het gezin (kind mag straks afwijken)') !!}
                            {!! Form::text('achternaam', null, ['class' => 'form-control', 'required','autofocus']) !!}

                        </div>
                        <div class="form-group">

                            {!! Form::label('postcode', 'Postcode van het gezin (zonder spaties: 1234AA)') !!}
                            {!! Form::text('postcode', null, ['class' => 'form-control', 'required']) !!}

                        </div>                        
                        <div class="form-group">

                            {!! Form::label('huisnummer', 'Huisnummer (postbusnummer mag ook)') !!}
                            {!! Form::text('huisnummer', null, ['class' => 'form-control', 'required']) !!}

                        </div>
                        <div class="form-group">

                            {!! Form::label('huisnummertoevoeging', 'Huisnummertoevoeging') !!}
                            {!! Form::text('huisnummertoevoeging', null, ['class' => 'form-control']) !!}

                        </div>

                        <div class="form-group">

                            {!! Form::label('adres_auto', 'Adres (wordt automatisch ingevuld op basis van postcode)') !!}
                            {!! Form::text('adres_auto', null, ['class' => 'form-control', 'disabled', 'required']) !!}
                            {!! Form::hidden('adres', null) !!}

                        </div>
                        <div class="form-group">

                            {!! Form::label('woonplaats_auto', 'Woonplaats (wordt automatisch ingevuld op basis van postcode)') !!}
                            {!! Form::text('woonplaats_auto', null, ['class' => 'form-control', 'disabled', 'required']) !!}
                            {!! Form::hidden('woonplaats', null) !!}

                        </div>
                        <div class="form-group">

                            {!! Form::label('telefoon', 'Telefoon gezin (zonder streepjes; 0612345678)') !!}
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1" style="font-family: sans-serif; font-size:15px;"><span class="glyphicon glyphicon-earphone"></span></span>
                                                          
                            {!! Form::text('telefoon', null, ['class' => 'form-control', 'required']) !!}
                            </div>

                        </div>  
  
                                        
                        
                            <div class="form-group">

                                {!! Form::label('email', 'Emailadres gezin') !!}&nbsp;<span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-toggle="tooltip" style="color:#1E90FF;" title="Het gezin krijgt GEEN automatische verificatieemail van ons."></span>
                                <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1" style="font-family: sans-serif; font-size:15px;"><span class="glyphicon glyphicon-envelope"></span></span>
                                {!! Form::text('email', null, ['class' => 'form-control' , 'aria-describedby'=>"basic-addon1", 'required']) !!}
                                </div>
                            </div>                       



                        <div class="form-group">
                            
                            {!! Form::hidden('intermediair_id', $intermediair->id) !!}
                        </div>
                        <div class="form-group{{ $errors->has('motivering') ? ' has-error' : '' }}">
                            <label for="reden" class="control-label">Geef een duidelijke motivatie waarom dit gezin in aanmerking moet komen:</label>

                            <div class="">
                                <textarea id="motivering" class="form-control" name="motivering" value="{{ old('motivering') }}" required>{{ old('motivering') }}</textarea>
                                <small><div id="characters">nog 100 karakters</div></small>
                                @if ($errors->has('motivering'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('motivering') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">                            
                            {!! Form::checkbox('bezoek_sintpiet', 1, false, ['id'=>'bezoek_sintpiet']) !!}
                            {!! Form::label('bezoek_sintpiet', 'Geen bezwaar verstrekken gegevens aan Sint en Piet-centrale') !!}&nbsp;<span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-toggle="tooltip" style="color:#1E90FF;" title="Dit geeft de mogelijkheid dat een Sint en Piet aan de deur komt, maar dit is geen garantie!"></span>
                        </div>
                        <div class="form-group">                            
                            {!! Form::checkbox('andere_alternatieven', 1, false, ['id'=>'bezoek_sintpiet']) !!}
                            {!! Form::label('andere_alternatieven', 'Aangemeld bij Sinterklaasbank-alternatieven') !!}&nbsp;<span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-toggle="tooltip" style="color:#1E90FF;" title="Graag opgeven of het gezin wordt ondersteund door andere initiatieven soortgelijk aan de Sinterklaasbank. Bijvoorbeeld 'Linda Foundation' of 'Actie Pepernoot'."></span>
                        </div>
                        <div class="form-group">

                            <input class="btn btn-primary form-control" type="button" id="verzendknop" value="Opslaan">
                            

                        </div>                   
                    {!! Form::close() !!}


  
  <script type="text/javascript">
$(document).ready(function() {
// Hier om de tooltips te activeren
$('[data-toggle="tooltip"]').tooltip();
});

   $('textarea').keyup(updateCount);
    $('textarea').keydown(updateCount);

    function updateCount() {
        var cs = $(this).val().length;
        
        var aantal = String(100-cs)

        if (aantal < 1) {
            var tekst = "Er staan voldoende karakters"
        } else {
            var tekst = "nog " + aantal + " karakters"
        }

        

        $('#characters').text(tekst);
    }

    $(function () {

        // geen spaties in email                
        $(function(){
          $('input[name="email"]').bind('input', function(){
            $(this).val(function(_, v){
              return v.replace(/\s+/g, '');
            });
          });
        });

        // geen , in leefgeld                
        $(function(){
          $('input[name="leefgeld"]').bind('input', function(){
            $(this).val(function(_, v){
              return v.replace(',', '');
            });
          });
        });

        // geen . in leefgeld                
        $(function(){
          $('input[name="leefgeld"]').bind('input', function(){
            $(this).val(function(_, v){
              return v.replace('.', '');
            });
          });
        });

        // telefoonnummer max lengte 10               
        $(function(){
           $('input[name="telefoon"]').attr('maxlength','10');
        });

        // geen spaties in telefoonnummer                
        $(function(){
          $('input[name="telefoon"]').bind('input', function(){
            $(this).val(function(_, v){
              return v.replace(/\s+/g, '');
            });
          });
        });

        // geen - in telefoonnummer                
        $(function(){
          $('input[name="telefoon"]').bind('input', function(){
            $(this).val(function(_, v){
              return v.replace('-', '');
            });
          });
        });

        // geen + in telefoonnummer                
        $(function(){
          $('input[name="telefoon"]').bind('input', function(){
            $(this).val(function(_, v){
              return v.replace('+', '');
            });
          });
        });

        // geen ( in telefoonnummer                
        $(function(){
          $('input[name="telefoon"]').bind('input', function(){
            $(this).val(function(_, v){
              return v.replace('(', '');
            });
          });
        });

        // geen ) in telefoonnummer                
        $(function(){
          $('input[name="telefoon"]').bind('input', function(){
            $(this).val(function(_, v){
              return v.replace(')', '');
            });
          });
        }); 

        // postcode max lengte 6               
        $(function(){
           $('input[name="postcode"]').attr('maxlength','6');
        }); 

        //delay submit om de postcode-gegevens op te halen (2000 = 2 seconden)
        $("#verzendknop").click(function(){

                setTimeout( function () { 
                    $('#createform').submit();
                }, 2000);
            
        });

        // Als postcodeveld wordt gekozen; adresvelden legen
        $( 'input[name="postcode"]' ).focus(function() {

                $('input[name="adres"]').val(''); 
                $('input[name="woonplaats"]').val(''); 
                $('input[name="adres_auto"]').val(''); 
                $('input[name="woonplaats_auto"]').val(''); 
                $('input[name="postcode"]').val(''); 
          
        });

        // Als huisnummerveld wordt gekozen; adresvelden legen
        $( 'input[name="huisnummer"]' ).focus(function() {

                $('input[name="adres"]').val(''); 
                $('input[name="woonplaats"]').val(''); 
                $('input[name="adres_auto"]').val(''); 
                $('input[name="woonplaats_auto"]').val(''); 
                $('input[name="huisnummer"]').val(''); 
          
        });


        //hoofdletters in postcodeveld
        $('input[name="postcode"]').blur( function() {
            $('input[name="postcode"]').val($(this).val().toUpperCase());
          });



        //geen spaties in postcodeveld
        $(function(){
          $('input[name="postcode"]').bind('input', function(){
            $(this).val(function(_, v){
              return v.replace(/\s+/g, '');
            });
          });
        });


        //Fix: wanneer het formulier terugkomt van verkeerde validatie zijn de zichtbare adresvelden niet te zien.
        $(function(){
            $('input[name="adres_auto"]').val($('input[name="adres"]').val());
            $('input[name="woonplaats_auto"]').val($('input[name="woonplaats"]').val());
        });


        //Als anoniem wordt ingeschakeld, dan is het niet mogelijk via intermediair te versturen
        $(function() {
          enable_cb();
          $('input[name="intermediair_anoniem"]').click(enable_cb);
        });

        function enable_cb() {
          if (this.checked) {
            $('input[name="pa_intermediair"]').prop( "checked", false );
            $('input[name="pa_intermediair"]').attr("disabled", true);
            
          } else {
            $('input[name="pa_intermediair"]').removeAttr("disabled");
          }
        }


        //haalt met de postcode + huisnummer de adresgegevens op en vult in
        $("input[name='huisnummer']").blur(function() {

            postcode = $('input[name="postcode"]').val();

            $.ajax({
                method: 'get',
                url: '{{ url('/postcode-nl') }}/address/'+postcode+'/' + $(this).val(),
                dataType: "json",
                success: function(data){
                    //alert("This input field has lost its focus.");
                   
                   $('input[name="adres"]').val(data.street); 
                   $('input[name="woonplaats"]').val(data.city);   
                   $('input[name="adres_auto"]').val(data.street); 
                   $('input[name="woonplaats_auto"]').val(data.city);         
                },
                statusCode: {
                    500: function() {
                        // 
                    },
                    422: function(data) {
                        // 
                    }
                }
            });         
        });
    });

  </script>



                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
