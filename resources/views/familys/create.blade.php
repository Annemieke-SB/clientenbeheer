@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                            

      


                @if (Auth::user()->usertype==1)
                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li><a href="{{ url('/users/index') }}">Gebruikers</a></li>
                      <li><a href="{{ url('/user/show') }}/{{ $user->id }}">{{ $user->naam }}</a></li>                      
                      <li class="active">Familie toevoegen</li>
                    </ol>
                @endif

                <div class="panel-body">
@include ('layouts.intermediairnav',['page'=>'add'])

                    @if ($errors->any())
                        <br>
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li style="margin-left:15px;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

<br />
<br />
<p>Hieronder kunt u de gegevens van het gezin invoeren.</p>



                    {!! Form::open(['url' => 'familys/store', 'id' => 'createform']) !!}
                        
                        <div class="form-group">

                            {!! Form::label('tussenvoegsel', 'Tussenvoegsel achternaam') !!}
                            {!! Form::text('tussenvoegsel', null, ['class' => 'form-control', 'autofocus']) !!}

                        </div>
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
                            
                            {!! Form::hidden('user_id', $user->id) !!}
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
                            {!! Form::checkbox('andere_alternatieven', 1, false, ['id'=>'andere_alternatieven']) !!}
                            {!! Form::label('andere_alternatieven', 'Aangemeld bij Sinterklaasbank-alternatieven') !!}&nbsp;<span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-toggle="tooltip" style="color:#1E90FF;" title="Graag opgeven of het gezin wordt ondersteund door andere initiatieven soortgelijk aan de Sinterklaasbank. Bijvoorbeeld 'Linda Foundation' of 'Actie Pepernoot'."></span>
                        </div>
                        <div class="form-group">

                            <input class="btn btn-primary form-control" type="button" id="verzendknop" data-toggle="modal" data-target="#confirm-submit" value="Opslaan">
                            

                        </div>                   
                    {!! Form::close() !!}




<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Controleer de ingevoerde gegevens:
            </div>
            <div class="modal-body">
                    <table>
                        <tr><td>Gezin&nbsp;</td><td id="tvoeg"></td><td id="lname"></td><td></td></tr>
                        <tr><td>Adres&nbsp;</td><td id="tstraat"></td><td id="thuisnum"></td><td id="thuisnumbij"></td></tr>
                        <tr><td>&nbsp;</td><td id="tpostc"></td><td id="twoonp"></td><td></td></tr>
                        <tr><td>&nbsp;</td><td id="tphone"></td><td></td><td></td></tr>
                        <tr><td>&nbsp;</td><td id="temail"></td><td></td><td></td></tr>
                        <tr><td colspan=4>&nbsp;</td><td id="temail"></td><td></td><td></td></tr>
                        <tr><td colspan=4 id="tand">&nbsp;</td><td id="temail"></td><td></td><td></td></tr>
                        
                    </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Aanpassen</button>
                <a href="#" id="submit" class="btn btn-success success">Opslaan</a>
            </div>
        </div>
    </div>
</div>






  
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

        // geen - in huisnummer                
        $(function(){
          $('input[name="huisnummer"]').bind('input', function(){
            $(this).val(function(_, v){
                if(v.includes("-")) {
                    alert('Een "-" is niet toegestaan bij huisnummer, het wordt weggehaald (gebruik de huisnummer-toevoeging)');
                }
              return v.replace('-', '');
            });
          });
        });


        // postcode max lengte 6               
        $(function(){
           $('input[name="postcode"]').attr('maxlength','6');
        }); 

        //de verzendmodal
        $("#verzendknop").click(function(){

             $('#tvoeg').text($('#tussenvoegsel').val() + ' ' + $('#achternaam').val());
             $('#tstraat').text($('#adres_auto').val() + ' ' + $('#huisnummer').val());  
             $('#tpostc').text($('#postcode').val() + ' ' + $('#woonplaats_auto').val());
             $('#tphone').text($('#telefoon').val());
             $('#temail').text($('#email').val());

             if ($("#andere_alternatieven").is(':checked')) {
                $('#tand').html("Dit gezin is <b>WEL</b> aangemeld bij andere Sinterklaasbank-alternatieven"); 
             } else {
                $('#tand').html("Dit gezin is <b>NIET</b> aangemeld bij andere Sinterklaasbank-alternatieven"); 
             }


            
        });

        //delay submit om de postcode-gegevens op te halen (2000 = 2 seconden)

        $('#submit').click(function(){
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
