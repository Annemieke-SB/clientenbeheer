@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                           




            @if(Auth::user()->usertype != 3 )
            <div class="panel panel-default">    

                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li><a href="{{ url('/intermediairs') }}">Intermediairs</a></li>
                      <li class="active">{{ $eigenaar->voornaam }}&nbsp;{{ $eigenaar->achternaam }}</li>
                    </ol>

                <div class="panel-body">
                 
                </div>
            </div>
            @endif
            @if (Auth::user()->usertype==3)

            <div class="panel panel-default">    

                    <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li class="active">Instelling toevoegen</li>
                    </ol>

                <div class="panel-body">
                 <p>Op deze pagina staan alle gegevens die betrekking hebben de op uw gebruikers- en intermediairgegevens. (De gebruikersgegevens worden gebruikt om in de loggen.)</p>
                </div>
            </div>

            @endif                    

                <div class="panel-body">
                 <p>Op deze pagina kunnen de gegevens van de instelling worden ingevuld.</p>
                 
             </div></div>
<div class="panel panel-default"><div class="panel-body">

                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li style="margin-left:15px;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {!! Form::open(['url' => 'intermediairs', 'id' => 'createform']) !!}

                        <div class="form-group">

                            {!! Form::label('type', 'Soort instelling') !!}
                            {!! Form::select('type', Custommade::typenIntermediairs(), null,  ["class"=>"form-control", 'autofocus']) !!}

                        </div>                        


                        <div class="form-group">

                            {!! Form::label('postcode', 'Postcode (zonder spaties: 1234AA)') !!}
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
                            {!! Form::hidden('user_id', $user->id) !!}

                            <div class="form-group">
                                <input name="user_id" type="hidden" value="173">
                                <input class="btn btn-primary form-control" type="button" id="verzendknop" value="Aanmaken">
                                

                            </div> 
                           
                            

                        </div>                   
                    {!! Form::close() !!}


  
  <script type="text/javascript">



    $(function () {


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

        //delay submit om de postcode-gegevens op te halen (2000 = 2 seconden)
        $("#verzendknop").click(function(){
            $('#createform').delay(5000).submit();
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



                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
