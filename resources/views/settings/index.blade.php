@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">


            <div class="panel panel-default">              
      
                        <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li class="active">Instellingen</li>
                    </ol>        

                <div class="panel-body">

                 Hier zijn de instellingen. Dit overzicht is alleen beschikbaar voor administrators en raadplegers, maar raadplegers kunnen niets aanpassen.
         
              

                </div>
            </div>

            <!-- Flashmessage -->
            @if (Session::get('message'))
            <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
            @endif
                                  

            <!-- min Leeftijd -->
            <div class="panel panel-default">
                <div class="panel-heading">Minimum leeftijd</div>
                <div class="panel-body">   
                    
                    <p>Geef hier aan wat de minimum leeftijd is van een kind, op 5 december. 
                        </p><p>Let op: 
                        <ul>
                            <li>het is <b>vanaf</b> onderstaande leeftijd.</li>
                            <li>als de inschrijvingen al zijn begonnen, kan het conflicten opleveren met bestaande inschrijvingen.</li>
                        </ul>

                    {!! Form::open(['url' => 'settings/update/1']) !!}
                        <div class="form-group">
                            {!! Form::select('value',[0=>'vanaf 0 jaar',1=>'vanaf 1 jaar',2=>'vanaf 2 jaar',3=>"vanaf 3 jaar",4=>'vanaf 4 jaar',5=>'vanaf 5 jaar'],$settingarray[1]['value'],  ['class' => 'form-control']) !!}
                            {!! Form::hidden('id', '1') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('wijzig', ['class' => 'btn btn-primary form-control']) !!}
                        </div>                   
                    {!! Form::close() !!}

                    <small><i>Deze instelling is laatst gewijzigd door {{$userarray[$settingarray[1]['lastTamperedUser_id']]}} op {{ Carbon\Carbon::parse($settingarray[1]['updated_at'])->format('d-m-Y H:i') }} uur.</i></small>

                </div>
            </div>


            <!-- max Leeftijd -->
            <div class="panel panel-default">
                <div class="panel-heading">Maximum leeftijd</div>
                <div class="panel-body">   
                    
                    <p>Geef hier aan wat de maximum leeftijd is van een kind, op 5 december. 
                        </p><p>Let op: 
                        <ul>
                            <li>het is <b>tot en met</b> onderstaande leeftijd.</li>
                            <li>als de inschrijvingen al zijn begonnen, kan het conflicten opleveren met bestaande inschrijvingen.</li>
                        </ul>

                    {!! Form::open(['url' => 'settings/update/2']) !!}
                        <div class="form-group">
                            {!! Form::select('value',[8=>'tm 8 jaar',9=>'tm 9 jaar',10=>'tm 10 jaar',11=>"tm 11 jaar",12=>'tm 12 jaar',13=>'tm 13 jaar'],$settingarray[2]['value'],  ['class' => 'form-control']) !!}
                            {!! Form::hidden('id', '2') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('wijzig', ['class' => 'btn btn-primary form-control']) !!}
                        </div>                   
                    {!! Form::close() !!}

                    <small><i>Deze instelling is laatst gewijzigd door {{$userarray[$settingarray[2]['lastTamperedUser_id']]}} op {{ Carbon\Carbon::parse($settingarray[2]['updated_at'])->format('d-m-Y H:i') }} uur.</i></small>

                </div>
            </div>



            <!-- max Leeftijd -->
            <div class="panel panel-default">
                <div class="panel-heading">Maximum leeftijd broertjes/zusjes</div>
                <div class="panel-body">   
                    
                    <p>Als er binnen een gezin minimaal 1 kind is dat aan bovenstaande instellingen (min/max-leeftijd) voldoet, mogen broertjes en zusjes tot de onderstaande leeftijd meedoen.  
                        </p><p>Let op: 
                        <ul>
                            <li>het is <b>tot en met</b> onderstaande leeftijd.</li>
                            <li>minimaal 1 kind in het gezien moet in de leeftijdscategorie tussen {{$settingarray[1]['value']}} tm {{$settingarray[2]['value']}} (bovenstaande instellingen) vallen.</li>
                            <li>als de inschrijvingen al zijn begonnen, kan het conflicten opleveren met bestaande inschrijvingen.</li>
                        </ul>

                    {!! Form::open(['url' => 'settings/update/3']) !!}
                        <div class="form-group">
                            {!! Form::select('value',[8=>'tm 8 jaar',9=>'tm 9 jaar',10=>'tm 10 jaar',11=>"tm 11 jaar",12=>'tm 12 jaar',13=>'tm 13 jaar'],$settingarray[3]['value'],  ['class' => 'form-control']) !!}
                            {!! Form::hidden('id', '3') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('wijzig', ['class' => 'btn btn-primary form-control']) !!}

                        </div>                   
                    {!! Form::close() !!}

                    <small><i>Deze instelling is laatst gewijzigd door {{$userarray[$settingarray[3]['lastTamperedUser_id']]}} op {{ Carbon\Carbon::parse($settingarray[3]['updated_at'])->format('d-m-Y H:i') }} uur.</i></small>

                </div>
            </div>


            <!-- Open/gesloten -->
            <div class="panel panel-default">
                <div class="panel-heading">Inschrijvingen sluiten</div>
                <div class="panel-body">   
                    
                    <p>Geef hier aan of de inschrijvingen zijn gesloten. <br><br><b>Let op: Wanneer de inschrijvingen zijn gesloten kunnen er geen intermediairs, gezinnen en kinderen worden toegevoegd, verwijderd of gewijzigd. Alles is dan definitief! </b><br><br></p>


                    {!! Form::open(['url' => 'settings/update/4', 'id'=>'sluitform']) !!}
                        <div class="form-group">
                            {!! Form::select('value',[0=>'inschrijvingen zijn geopend',1=>'inschrijvingen zijn gesloten'],$settingarray[4]['value'],  ['class' => 'form-control']) !!}
                            {!! Form::hidden('id', '4') !!}
                        </div>
                        <div class="form-group">
                           
                            <input type="button" name="btn" value="Wijzig" id="sluitsubmitbtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-primary form-control" />
                        </div>         
                        @if ($settingarray[4]['value'] == 0) {{--inschrijvingen momenteel open--}}
                        <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        Inschrijvingen sluiten?
                                    </div>
                                    <div class="modal-body">
                        Weet je zeker dat je de inschrijvingen wilt sluiten? Er kan dan niets meer gewijzigd worden: alle invoer is dan definitief. De intermediairs krijgen automatisch een email!
                                    </div>

                                    <div class="modal-footer">
                                    <a href="{{ url('/settings') }}"><button type="button" class="btn btn-default">Nee</button></a>
                                    <a href="#" id="sluitsubmit" class="btn btn-success success">Ja, sluiten maar!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        Inschrijvingen openen?
                                    </div>
                                    <div class="modal-body">
                        Weet je zeker dat je de inschrijvingen wilt openen? De intermediairs krijgen automatisch een email!
                                    </div>

                                    <div class="modal-footer">
                                     <a href="{{ url('/settings') }}"><button type="button" class="btn btn-default">Nee</button></a>
                                     <a href="#" id="sluitsubmit" class="btn btn-success success">Ja, openen maar!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                    {!! Form::close() !!}

                    <small><i>Deze instelling is laatst gewijzigd door {{$userarray[$settingarray[4]['lastTamperedUser_id']]}} op {{ Carbon\Carbon::parse($settingarray[4]['updated_at'])->format('d-m-Y H:i') }} uur.</i></small>

                </div>
            </div>     

           <!-- Downloads open -->
            <div class="panel panel-default">
                <div class="panel-heading">Downloadpagina open?</div>
                <div class="panel-body">   
                    
                    <p>Geef hier aan of de downloadpagina geactiveerd moet zijn. <br><br><b>Let op: Kan alleen wanneer de inschrijvingen zijn gesloten!</b><br><br></p>


                    {!! Form::open(['url' => 'settings/update/6', 'id'=>'sluitform2']) !!}
                        <div class="form-group">
                            {!! Form::select('value',[0=>'downloadspagina gesloten',1=>'Downloadspagina open'],$settingarray[6]['value'],  ['class' => 'form-control']) !!}
                            {!! Form::hidden('id', '6') !!}
                        </div>
                        <div class="form-group">
                           
                            <input type="button" name="btn" value="Wijzig" id="sluitsubmitbtn2" data-toggle="modal" data-target="#confirm-submit-downloads" class="btn btn-primary form-control" />
                        </div>         
                        @if ($settingarray[6]['value'] == 0) {{--downloads momenteel gesloten--}}
                        <div class="modal fade" id="confirm-submit-downloads" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        Downloadpagina openen?
                                    </div>
                                    <div class="modal-body">
                        Weet je zeker dat je de downloadpagina wil openen? Let op: de inschrijvingen moeten eerst zijn gesloten voordat deze instelling kan worden gewijzigd!! Als de downloads worden geopend krijgen de intermediairs automatisch een email dat ze vanaf nu de PDF's kunnen downloaden!
                                    </div>

                          <div class="modal-footer">
                                    <a href="{{ url('/settings') }}"><button type="button" class="btn btn-default">Nee</button></a>
                                    <a href="#" id="sluitsubmit2" class="btn btn-success success">Ja, openen maar!</a>
                                </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="modal fade" id="confirm-submit-downloads" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        Downloadpagina sluiten?
                                    </div>
                                    <div class="modal-body">
                        Weet je zeker dat je de downloadpagina wil sluiten? De intermediairs krijgen automatisch een email!
                                    </div>

                          <div class="modal-footer">
                                    <a href="{{ url('/settings') }}"><button type="button" class="btn btn-default">Nee</button></a>
                                    <a href="#" id="sluitsubmit2" class="btn btn-success success">Ja, sluiten maar!</a>
                                </div>
                                </div>
                            </div>
                        </div>
                        @endif

                    {!! Form::close() !!}

                    <small><i>Deze instelling is laatst gewijzigd door {{$userarray[$settingarray[6]['lastTamperedUser_id']]}} op {{ Carbon\Carbon::parse($settingarray[6]['updated_at'])->format('d-m-Y H:i') }} uur.</i></small>

                </div>
            </div>  

            <!-- Notificatieemail -->
            <div class="panel panel-default">
                <div class="panel-heading">Notificatie emailadres voor nieuwe gebruikers</div>
                <div class="panel-body">   
                    
                    <p>Het notificatie-adres is het emailadres dat op de hoogte wordt gehouden van nieuwe inschrijvingen. Nieuwe inschrijvingen moeten namelijk geactiveerd worden.


                    {!! Form::open(['url' => 'settings/update/5']) !!}
                        <div class="form-group">
                            {!! Form::text('setting', $settingarray[5]['setting'],  ['class' => 'form-control']) !!}
                            {!! Form::hidden('id', '5') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('wijzig', ['class' => 'btn btn-primary form-control']) !!}
                        </div>                   
                    {!! Form::close() !!}

                    <small><i>Deze instelling is laatst gewijzigd door {{$userarray[$settingarray[4]['lastTamperedUser_id']]}} op {{ Carbon\Carbon::parse($settingarray[4]['updated_at'])->format('d-m-Y H:i') }} uur.</i></small>

                </div>
            </div>   


        </div>
    </div>
</div>


                                                          



<script type="text/javascript">

$('#sluitsubmitbtn').click(function() {

});

$('#sluitsubmit').click(function(){
     /* when the submit button in the modal is clicked, submit the form */
    
    $('#sluitform').submit();
});


$('#sluitsubmitbtn2').click(function() {

});

$('#sluitsubmit2').click(function(){
     /* when the submit button in the modal is clicked, submit the form */
    
    $('#sluitform2').submit();
});

</script>

@endsection

