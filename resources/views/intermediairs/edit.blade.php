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
                      <li><a href="{{ url('/intermediairs/show') }}/{{$intermediair->id}}">{{$eigenaar->voornaam}}</a></li>
                      <li class="active">Gegevens van de organisatie wijzigen</li>
                    </ol>
                @elseif (Auth::user()->usertype==3)

                          <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li class="active">Gegevens van de organisatie wijzigen</li>
                    </ol>
                @endif

                <div class="panel-body">
                 <p>Wijzig hier de gegevens van de organisatie van de intermediair (dit zijn dus niet de inloggegevens, die vallen onder de 'gebuikersgegevens'.</p>
                 

             </div></div>
<div class="panel panel-default"><div class="panel-body">

                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li style="margin-left:15px;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {!! Form::open(['url' => 'intermediairs/update', 'id' => 'editform']) !!}
                        
                        <div class="form-group">

                            {!! Form::label('type', 'Type organisatie') !!}
                            {!! Form::select('type', Custommade::typenIntermediairs(), $intermediair->type,  ["class"=>"form-control", 'autofocus']) !!}

                        </div>

                        <div class="form-group">

                            {!! Form::label('postcode', 'Postcode (zonder spaties: 1234AA)') !!}
                            {!! Form::text('postcode', $intermediair->postcode, ['class' => 'form-control', 'required']) !!}

                        </div>                        
                        <div class="form-group">

                            {!! Form::label('huisnummer', 'Huisnummer (postbusnummer mag ook)') !!}
                            {!! Form::text('huisnummer', $intermediair->huisnummer, ['class' => 'form-control', 'required']) !!}

                        </div>
                        <div class="form-group">

                            {!! Form::label('huisnummertoevoeging', 'Huisnummertoevoeging') !!}
                            {!! Form::text('huisnummertoevoeging', $intermediair->huisnummertoevoeging, ['class' => 'form-control']) !!}

                        </div>

                        <div class="form-group">

                            {!! Form::label('adres_auto', 'Adres (wordt automatisch ingevuld op basis van postcode)') !!}
                            {!! Form::text('adres_auto', $intermediair->adres, ['class' => 'form-control', 'disabled', 'required']) !!}
                            {!! Form::hidden('adres', $intermediair->adres) !!}

                        </div>
                        <div class="form-group">

                            {!! Form::label('woonplaats_auto', 'Woonplaats (wordt automatisch ingevuld op basis van postcode)') !!}
                            {!! Form::text('woonplaats_auto', $intermediair->woonplaats, ['class' => 'form-control', 'disabled', 'required']) !!}
                            {!! Form::hidden('woonplaats', $intermediair->woonplaats) !!}
                            {!! Form::hidden('id', $intermediair->id) !!}
                            {!! Form::hidden('user_id', $intermediair->user_id) !!}

                        </div>                    


                        <div class="form-group">

                            <input class="btn btn-primary form-control" type="button" id="verzendknop" value="Wijzigen">
                            

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

  </script>



                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
