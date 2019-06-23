@extends('layouts.app')
<?php use App\Http\Controllers\IntermediairtypeController; ?>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
                                    <!-- Flashmessage -->
                        @if (Session::get('message'))
                        <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
                        @endif
                        

            <div class="panel panel-default">

      

                @if (Auth::user()->usertype==1)
                    <ol class="breadcrumb">
                      <li><a href="{{ url('home') }}">Home</a></li>
                      <li><a href="{{ url('users/index') }}">Gebruikers</a></li>
                      <li class="active">{{ $user->naam }}</li>
                    </ol>
                @endif

                <div class="panel-body">
@include ('layouts.intermediairnav', ['page'=>'edit'])
<br />
<br />




                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li style="margin-left:15px;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {!! Form::open(['url' => 'user/updatename']) !!}
                        <div class="form-group">

                            {!! Form::label('geslacht', 'Waarmee spreken wij u aan') !!}
                            {!! Form::select('geslacht', ['m'=>'Dhr.', 'v'=>'Mevr.'], $user->geslacht,  ["class"=>"form-control", 'autofocus required']) !!}
                            
                        </div> 

                        <div class="form-group">

                            {!! Form::label('voornaam', 'Voornaam') !!}
                            {!! Form::text('voornaam', $user->voornaam, ['class' => 'form-control', 'required']) !!}

                        </div>

                        <div class="form-group">

                            {!! Form::label('tussenvoegsel', 'Tussenvoegsel') !!}
                            {!! Form::text('tussenvoegsel', $user->tussenvoegsel, ['class' => 'form-control']) !!}

                        </div>                        


                        <div class="form-group">

                            {!! Form::label('achternaam', 'Achternaam') !!}
                            {!! Form::text('achternaam', $user->achternaam, ['class' => 'form-control', 'required']) !!}

                        </div>                        

                        <div class="form-group">

                            {!! Form::label('organisatienaam', 'Instelling') !!}
                            {!! Form::text('organisatienaam', $user->organisatienaam, ['class' => 'form-control', 'required']) !!}

                        </div>  
                        <div class="form-group">

                            {!! Form::label('functie', 'Uw functie bij de instelling&nbsp;') !!}
                            {!! Form::text('functie', $user->functie, ['class' => 'form-control', 'required']) !!}

                        </div>  
                        <div class="form-group">

                            {!! Form::label('website', 'De website van de instelling&nbsp;') !!}
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1" style="font-family: sans-serif; font-size:15px;"><span class="glyphicon glyphicon-link"></span></span>
                            
                            {!! Form::text('website', $user->website, ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>  
                          <div class="form-group">

                            {!! Form::label('telefoon', 'Telefoon (zonder streepjes; 0612345678)') !!}
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1" style="font-family: sans-serif; font-size:15px;"><span class="glyphicon glyphicon-earphone"></span></span>
                                 
                            {!! Form::text('telefoon', $user->telefoon, ['class' => 'form-control', 'required']) !!}                            
                            </div>  
                        </div>                                                  
                        <div class="form-group">

                            {!! Form::label('type', 'Soort instelling') !!}
                            {!! Form::select('intermediairtype', IntermediairtypeController::intermediairlijst(), $user->intermediairtype, ["class"=>"form-control", 'autofocus']) !!}
                        </div>                                                     
                        <div class="form-group">

                            {!! Form::label('postcode', 'Postcode') !!}
                            {!! Form::text('postcode', $user->postcode, ['class' => 'form-control', 'required']) !!}                            
                        </div>                                                  
                        <div class="form-group">

                            {!! Form::label('huisnummer', 'Huisnummer') !!}
                            {!! Form::text('huisnummer', $user->huisnummer, ['class' => 'form-control', 'required']) !!}                            
                        </div>                                                  
                        <div class="form-group">

                            {!! Form::label('huisnummertoevoeging', 'Huisnummertoevoeging') !!}
                                 
                            {!! Form::text('huisnummertoevoeging', $user->huisnummertoevoeging, ['class' => 'form-control' ]) !!}                            
                        </div>                                                   
                        <div class="form-group">

                            {!! Form::label('adres_auto', 'Adres (wordt automatisch ingevuld op basis van postcode)') !!}
                            {!! Form::text('adres_auto', $user->adres, ['class' => 'form-control', 'disabled', 'required']) !!}
                            {!! Form::hidden('adres', $user->adres) !!}

                        </div>
                        <div class="form-group">

                            {!! Form::label('woonplaats_auto', 'Woonplaats (wordt automatisch ingevuld op basis van postcode)') !!}
                            {!! Form::text('woonplaats_auto', $user->woonplaats, ['class' => 'form-control', 'disabled', 'required']) !!}
                            {!! Form::hidden('woonplaats', $user->woonplaats) !!}
                            {!! Form::hidden('id', $user->id) !!}

                        </div>                    

                        <div class="form-group">   
                        {{ Form::hidden('nieuwsbrief', 0) }}                          
                            {!! Form::checkbox('nieuwsbrief', 1, $user->nieuwsbrief, ['id'=>'nieuwsbrief']) !!}
                            {!! Form::label('nieuwsbrief', 'Nieuwsbrief (ong 4 keer per jaar)') !!}&nbsp;<span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-toggle="tooltip" style="color:#1E90FF;" title="Hiermee blijft u op de hoogte van de Sinterklaasbank. Het emailadres wordt niet aan derden verstrekt."></span>
                        </div>

                        <div class="form-group">
                            {!! Form::hidden('id', $user->id) !!}
                            {!! Form::submit('Bovenstaande gegevens wijzigen', ['class' => 'btn btn-primary form-control']) !!}
                            

                        </div>              


                    {!! Form::close() !!}

                </div>
            </div>

             <div class="panel panel-default">   
                <div class="panel-heading"><h3 class="panel-title">Email</h3></div>
                <div class="panel-body">
                
                    <p>Het huidige emailadres is <b>{{ $user->email }}</b>. Geef hieronder twee maal het nieuwe emailadres (1 keer ter controle) op om dit wijzigen.</p>
                    <blockquote>Let op: na het wijzigen van het emailadres wordt je meteen uitgelogd. Verificatie van het email-adres is noodzakelijk (check je email) om weer in te kunnen loggen.</blockquote>
                    {!! Form::open(['url' => 'user/updateemail']) !!}
                        

                        <div class="form-group">

                            {!! Form::label('email1', 'Nieuw emailadres') !!}
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1" style="font-family: sans-serif; font-size:15px;"><span class="glyphicon glyphicon-envelope"></span></span>
                            {!! Form::text('email1', false, ['class' => 'form-control']) !!}
                            </div>

                        </div>
                        <div class="form-group">

                            {!! Form::label('email2', 'Nogmaals het nieuwe emailadres') !!}
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1" style="font-family: sans-serif; font-size:15px;"><span class="glyphicon glyphicon-envelope"></span></span>
                            {!! Form::text('email2', false, ['class' => 'form-control']) !!}
                            </div>

                            {!! Form::hidden('id', $user->id) !!}

                        </div>

                        <div class="form-group">

                            {!! Form::submit('Emailadres wijzigen', ['class' => 'btn btn-primary form-control']) !!}
                            

                        </div>                   
                    {!! Form::close() !!}

                </div>
            </div>           
  
             <div class="panel panel-default">   
                <div class="panel-heading"><h3 class="panel-title">Wachtwoord</h3></div>
                <div class="panel-body">
                    <p>Om het huidige wachtwoord te wijzigen dient hieronder twee maal het nieuwe wachtwoord (1 keer ter controle) opgegeven te worden.</p>
                    {!! Form::open(['url' => 'user/updatepassword']) !!}
                        

                        <div class="form-group">

                            {!! Form::label('pass1', 'Nieuw Wachtwoord') !!}

                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1" style="font-family: sans-serif; font-size:15px;"><span class="glyphicon glyphicon-asterisk"></span></span>
                               
                            {!! Form::password('pass1', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">

                            {!! Form::label('pass2', 'Nogmaals het nieuwe wachtwoord') !!}
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1" style="font-family: sans-serif; font-size:15px;"><span class="glyphicon glyphicon-asterisk"></span></span>
                               
                            {!! Form::password('pass2', ['class' => 'form-control']) !!}

                            {!! Form::hidden('id', $user->id) !!}
                            </div>
                        </div>


                        <div class="form-group">

                            {!! Form::submit('Wachtwoord wijzigen', ['class' => 'btn btn-primary form-control']) !!}
                            

                        </div>                   
                    {!! Form::close() !!}

                </div>
            </div>  

  <script type="text/javascript">



    $(function () {


        
    });

  </script>



                    
                </div>
            </div>
        </div>
    </div>
</div>


  
  <script type="text/javascript">



    $(function () {
        // geen spaties in email                
        $(function(){
          $('input[name="email1"]').bind('input', function(){
            $(this).val(function(_, v){
              return v.replace(/\s+/g, '');
            });
          });
        });

        // geen spaties in email                
        $(function(){
          $('input[name="email2"]').bind('input', function(){
            $(this).val(function(_, v){
              return v.replace(/\s+/g, '');
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
@endsection
