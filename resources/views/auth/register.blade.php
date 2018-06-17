@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Inschrijven</div>
                <div class="panel-body">


                 <h1>U bent intermediair</h1>
                 <p>U heeft aangegeven dat u intermediair bent. Daarmee komt u in aanmerking voor een inschrijving bij de Sinterklaasbank. De inschrijving bestaat uit
                    een paar stappen;



                    <div class="list-group">
                      <a class="list-group-item active">
                        Stappenplan
                    </a>
                    <a class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="badge">1</span> U geeft hieronder uw gebruikersgegevens op.</a>
                    <a class="list-group-item"><span class="badge">2</span>Uw inschrijving zal handmatig beoordeeld worden.</a>
                    <a class="list-group-item"><span class="badge">3</span>Na goedkeuring (u ontvangt daarvan een email) kunt u kinderen aanmelden</a>
                </div>


            </p><p><div style="margin-left:10px;"><h1>Stap <span class="badge">1</span><small> -  Geef uw gebruikersgegevens op</small></div></h1>

             <br><br> <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('geslacht') ? ' has-error' : '' }}">
                    <label for="geslacht" class="col-md-5 control-label">Hoe spreken wij u aan</label>

                    <div class="col-md-6">

                        {!! Form::select('geslacht', [''=>'-', 'm'=>'Dhr.', 'v'=>'Mevr.'], '',  ["class"=>"form-control", 'autofocus required']) !!}
                        @if ($errors->has('geslacht'))
                        <span class="help-block">
                            <strong>{{ $errors->first('geslacht') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('voornaam') ? ' has-error' : '' }}">
                    <label for="voornaam" class="col-md-5 control-label">Uw voornaam</label>

                    <div class="col-md-6">
                        <input id="voornaam" type="text" class="form-control" name="voornaam" value="{{ old('voornaam') }}" required>

                        @if ($errors->has('voornaam'))
                        <span class="help-block">
                            <strong>{{ $errors->first('voornaam') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('tussenvoegsel') ? ' has-error' : '' }}">
                    <label for="tussenvoegsel" class="col-md-5 control-label">Tussenvoegsel</label>

                    <div class="col-md-6">
                        <input id="tussenvoegsel" type="text" class="form-control" name="tussenvoegsel" value="{{ old('tussenvoegsel') }}">

                        @if ($errors->has('tussenvoegsel'))
                        <span class="help-block">
                            <strong>{{ $errors->first('tussenvoegsel') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('achternaam') ? ' has-error' : '' }}">
                    <label for="achternaam" class="col-md-5 control-label">Uw achternaam</label>

                    <div class="col-md-6">
                        <input id="achternaam" type="text" class="form-control" name="achternaam" value="{{ old('achternaam') }}" required>

                        @if ($errors->has('achternaam'))
                        <span class="help-block">
                            <strong>{{ $errors->first('achternaam') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>  
                <div class="form-group{{ $errors->has('organisatienaam') ? ' has-error' : '' }}">
                    <label for="organisatienaam" class="col-md-5 control-label">De naam van uw instelling&nbsp;</label>

                    <div class="col-md-6">
                        <input id="organisatienaam" type="text" class="form-control" name="organisatienaam" value="{{ old('organisatienaam') }}" required>

                        @if ($errors->has('organisatienaam'))
                        <span class="help-block">
                            <strong>{{ $errors->first('organisatienaam') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>                                                 
                <div class="form-group{{ $errors->has('functie') ? ' has-error' : '' }}">
                    <label for="functie" class="col-md-5 control-label">Uw functie bij de instelling&nbsp;</label>

                    <div class="col-md-6">
                        <input id="functie" type="text" class="form-control" name="functie" value="{{ old('functie') }}" required>

                        @if ($errors->has('functie'))
                        <span class="help-block">
                            <strong>{{ $errors->first('functie') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>                        
                <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                    <label for="website" class="col-md-5 control-label">Bedrijfswebsite</label>

                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1" style="font-family: sans-serif; font-size:15px;">http://</span>
                            
                            <input id="website" type="text" class="form-control" name="website" value="{{ old('website') }}" required>

                        </div>

                        @if ($errors->has('website'))
                        <span class="help-block">
                            <strong>{{ $errors->first('website') }}</strong>
                        </span>
                        @endif
                    </div>
                </div> 
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-5 control-label">Uw (persoonlijke) werk-emailadres&nbsp;<span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-toggle="tooltip" style="color:#1E90FF;" title="Wij willen u vragen hier een emailadres te gebruiken, anders dan eindigend op @gmail, hotmail, etc. Mocht u geen ander mailadres hebben, verzoeken wij u vriendelijk een bewijs te mailen dat u werkzaam bent voor deze instelling. Dit kunt u sturen naar info@sinterklaasbank.nl"></span></label>

                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1" style="font-family: sans-serif; font-size:15px;"><span class="glyphicon glyphicon-envelope"></span></span>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        </div>

                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('telefoon') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-5 control-label">Uw telefoonnummer (0612345678)</label>

                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1" style="font-family: sans-serif; font-size:15px;"><span class="glyphicon glyphicon-earphone"></span></span>
                            <input id="telefoon" type="telefoon" class="form-control" name="telefoon" value="{{ old('telefoon') }}" required>
                        </div>

                        @if ($errors->has('telefoon'))
                        <span class="help-block">
                            <strong>{{ $errors->first('telefoon') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>



                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-5 control-label">Soort instelling</label>

                    <div class="col-md-6">
                        {!! Form::select('type', Custommade::typenIntermediairs(), null,  ["class"=>"form-control", 'autofocus']) !!}

                        @if ($errors->has('type'))
                        <span class="help-block">
                            <strong>{{ $errors->first('type') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('postcode') ? ' has-error' : '' }} {{ $errors->has('woonplaats') ? ' has-error' : '' }}">

                    <label for="postcode" class="col-md-5 control-label">Postcode (zonder spaties: 1234AA)</label>
                    <div class="col-md-6">
                        <input class="form-control" required name="postcode" type="text" maxlength="6" length="6" id="postcode">

                        @if ($errors->has('postcode'))
                        <span class="help-block">
                            <strong>{{ $errors->first('postcode') }}</strong>
                        </span>
                        @endif
                      
                        @if ($errors->has('woonplaats'))
                        <span class="help-block">
                            <strong>{{ $errors->first('postcode') }}</strong>
                        </span>
                        @endif  
                    </div>                    
                </div>                        


                <div class="form-group{{ $errors->has('huisnummer') ? ' has-error' : '' }}">

                    <label for="huisnummer" class="col-md-5 control-label">Huisnummer (postbusnummer mag ook)</label>
                    <div class="col-md-6">
                        <input class="form-control" required name="huisnummer" type="text" id="huisnummer">

                        @if ($errors->has('huisnummer'))
                        <span class="help-block">
                            <strong>{{ $errors->first('huisnummer') }}</strong>
                        </span>
                        @endif
                    </div>                        
                </div>                        


                <div class="form-group{{ $errors->has('huisnummertoevoeging') ? ' has-error' : '' }}">

                    <label for="huisnummertoevoeging" class="col-md-5 control-label">Huisnummertoevoeging</label>
                    <div class="col-md-6">
                        <input class="form-control" name="huisnummertoevoeging" type="text" id="huisnummertoevoeging">

                        @if ($errors->has('huisnummertoevoeging'))
                        <span class="help-block">
                            <strong>{{ $errors->first('huisnummertoevoeging') }}</strong>
                        </span>
                        @endif
                    </div>                        
                </div>                        


                <div class="form-group{{ $errors->has('adres_auto') ? ' has-error' : '' }}">

                    <label for="adres_auto" class="col-md-5 control-label">Adres (automatisch)</label>
                    <div class="col-md-6">
                        <input class="form-control" name="adres_auto" disabled required type="text" id="adres_auto">

                        @if ($errors->has('adres_auto'))
                        <span class="help-block">
                            <strong>{{ $errors->first('adres_auto') }}</strong>
                        </span>
                        @endif
                        <input name="adres" type="hidden">
                    </div>                        
                </div>                        


                <div class="form-group{{ $errors->has('woonplaats_auto') ? ' has-error' : '' }}">

                    <label for="woonplaats_auto" class="col-md-5 control-label">Woonplaats (automatisch)</label>
                    <div class="col-md-6">
                        <input class="form-control" name="woonplaats_auto" disabled required type="text" id="woonplaats_auto">

                        @if ($errors->has('woonplaats_auto'))
                        <span class="help-block">
                            <strong>{{ $errors->first('woonplaats_auto') }}</strong>
                        </span>
                        @endif
                        <input name="woonplaats" type="hidden">
                    </div>                        
                </div>                        


                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-5 control-label">Wachtwoord</label>

                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1" style="font-family: sans-serif; font-size:15px;"><span class="glyphicon glyphicon-asterisk"></span></span>

                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="col-md-5 control-label">Bevestig wachtwoord</label>

                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1" style="font-family: sans-serif; font-size:15px;"><span class="glyphicon glyphicon-asterisk"></span></span>

                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('reden') ? ' has-error' : '' }}">
                    <label for="reden" class="col-md-5 control-label">Omschrijf kort wie u bent, uw organisatie, en de reden van inschrijven <br></label>

                    <div class="col-md-6">
                        <textarea id="reden" class="form-control" name="reden" value="{{ old('reden') }}" required autofocus>{{ old('reden') }}</textarea>
                        <small><div id="characters">nog 100 karakters</div></small>

                        @if ($errors->has('reden'))
                        <span class="help-block">
                            <strong>{{ $errors->first('reden') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
  
                <div class="form-group">      
                <div class="col-md-6 col-md-offset-5">                      
                    {!! Form::checkbox('nieuwsbrief', 1, true, ['id'=>'nieuwsbrief']) !!}
                    {!! Form::label('nieuwsbrief', 'Nieuwsbrief (ong 4 keer per jaar)') !!}
                </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-5">
                        <button id="submitbutton" type="submit" class="btn btn-primary">
                            Inschrijven
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
// Hier om de tooltips te activeren
$('[data-toggle="tooltip"]').tooltip();
});
</script>



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


        $(function(){
            if(
                $('input[name="adres"]').val()=='' 
            ) {
                //$("#submitbutton").prop("disabled",true);
            }
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
                    $("#submitbutton").prop("disabled",false);        
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
