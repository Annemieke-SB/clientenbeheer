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
                      <li><a href="{{ url('/users/index') }}">Gebruikers</a></li>
                      <li><a href="{{ url('/users/show') }}/{{ $eigenaar->id }}">{{ $eigenaar->naam }}</a></li>
                      <li><a href="{{ url('/family') }}/show/{{ $family->id }}">Gezin {{ $family->naam }}</a></li>
                      <li class="active">Wijzigen</li>
                    </ol>
                @elseif (Auth::user()->usertype==3)

                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li><a href="{{ url('/family') }}/show/{{ $family->id }}">Fam {{ $family->naam }}</a></li>
                      <li class="active">Wijzigen</li>
                    </ol>
                @endif
                <div class="panel-body">
                 Op deze pagina wijzig je de gegevens van het gezin.
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

                    {!! Form::open(['url' => 'family/update', 'id' => 'editform']) !!}
                         
                      <div class="form-group">

                            {!! Form::label('tussenvoegsel', 'Tussenvoegsel achternaam') !!}
                            {!! Form::text('tussenvoegsel', $family->tussenvoegsel, ['class' => 'form-control' ]) !!}

                        </div>
                        
                      <div class="form-group">

                            {!! Form::label('achternaam', 'Achternaam van het gezin (kind kan afwijken)') !!}
                            {!! Form::text('achternaam', $family->achternaam, ['class' => 'form-control', 'required']) !!}

                        </div>
                        <div class="form-group">

                            {!! Form::label('postcode', 'Postcode van het gezin (zonder spaties: 1234AA)') !!}
                            {!! Form::text('postcode', $family->postcode, ['class' => 'form-control', 'required']) !!}

                        </div>                        
                        <div class="form-group">

                            {!! Form::label('huisnummer', 'Huisnummer (postbusnummer mag ook)') !!}
                            {!! Form::text('huisnummer', $family->huisnummer, ['class' => 'form-control', 'required']) !!}

                        </div>
                        <div class="form-group">

                            {!! Form::label('huisnummertoevoeging', 'Huisnummertoevoeging') !!}
                            {!! Form::text('huisnummertoevoeging', $family->huisnummertoevoeging, ['class' => 'form-control']) !!}

                        </div>

                        <div class="form-group">

                            {!! Form::label('adres_auto', 'Adres (wordt automatisch ingevuld op basis van postcode)') !!}
                            {!! Form::text('adres_auto', $family->adres, ['class' => 'form-control', 'disabled', 'required']) !!}
                            {!! Form::hidden('adres', $family->adres) !!}

                        </div>
                        <div class="form-group">

                            {!! Form::label('woonplaats_auto', 'Woonplaats (wordt automatisch ingevuld op basis van postcode)') !!}
                            {!! Form::text('woonplaats_auto', $family->woonplaats, ['class' => 'form-control', 'disabled', 'required']) !!}
                            {!! Form::hidden('woonplaats', $family->woonplaats) !!}

                        </div>
                        <div class="form-group">

                            {!! Form::label('telefoon', 'Telefoon gezin (zonder streepjes; 0612345678)') !!} 
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1" style="font-family: sans-serif; font-size:15px;"><span class="glyphicon glyphicon-earphone"></span></span>

                            {!! Form::text('telefoon', $family->telefoon, ['class' => 'form-control', 'required']) !!}
                            </div>

                        </div>       
                                       
                            <div class="form-group">

                                {!! Form::label('email', 'Emailadres gezin') !!} <span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-toggle="tooltip" style="color:#1E90FF;" title="Het gezin krijgt GEEN automatische verificatieemail van ons."></span>
                                <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1" style="font-family: sans-serif; font-size:15px;"><span class="glyphicon glyphicon-envelope"></span></span>
                                {!! Form::text('email', $family->email, ['class' => 'form-control' , 'aria-describedby'=>"basic-addon1", 'required']) !!}

                            </div>
                        </div>

                        <div class="form-group">  
                            {{ Form::hidden('bezoek_sintpiet', 0) }}                         
                            {!! Form::checkbox('bezoek_sintpiet', 1, $family->bezoek_sintpiet, ['id'=>'bezoek_sintpiet']) !!}
                            {!! Form::label('bezoek_sintpiet', 'Geen bezwaar verstrekken gegevens aan Sint en Piet-centrale') !!}&nbsp;<span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-toggle="tooltip" style="color:#1E90FF;" title="Dit geeft de mogelijkheid dat een Sint en Piet aan de deur komt, maar dit is geen garantie!"></span>
                        
                        </div>
                      
                        <div class="form-group">
                            
                            {!! Form::hidden('user_id', $family->user_id) !!}
                            {!! Form::hidden('id', $family->id) !!}
                        </div>

                        <div class="form-group{{ $errors->has('motivering') ? ' has-error' : '' }}">
                            <label for="reden" class="control-label">Geef een duidelijke motivatie waarom dit gezin in aanmerking moet komen:</label>

                            <div class="">
                                <textarea id="motivering" class="form-control" name="motivering" value="{{ $family->motivering }}" required autofocus>{{ $family->motivering }}</textarea>
                                <small><div id="characters">nog 100 karakters</div></small>
                                @if ($errors->has('motivering'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('motivering') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">    
                            {{ Form::hidden('andere_alternatieven', 0) }}                            
                            {!! Form::checkbox('andere_alternatieven', 1, $family->andere_alternatieven, ['id'=>'andere_alternatieven']) !!}
                            {!! Form::label('andere_alternatieven', 'Aangemeld bij Sinterklaasbank-alternatieven') !!}&nbsp;<span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-toggle="tooltip" style="color:#1E90FF;" title="Graag opgeven of het gezin wordt ondersteund door andere initiatieven soortgelijk aan de Sinterklaasbank. Bijvoorbeeld 'Linda Foundation' of 'Actie Pepernoot'."></span>
                        </div>                                                  
                        <div class="form-group">

                            <input class="btn btn-primary form-control" type="button" id="verzendknop" value="Wijzigen">
                            

                        </div>                   
                    {!! Form::close() !!}


  
  <script type="text/javascript">

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

       //delay submit om de postcode-gegevens op te halen (2000 = 2 seconden)
        $("#verzendknop").click(function(){

                setTimeout( function () { 
                    $('#editform').submit();
                }, 2000);
            
        });
        
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
