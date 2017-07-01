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

                    <ol class="breadcrumb">
                      <li><a href="{{ url('home') }}">Home</a></li>
                      <li><a href="{{ url('users/index') }}">Gebruikers</a></li>
                      <li class="active">{{$user->voornaam}} {{$user->achternaam}}</li>
                    </ol>

                <div class="panel-body">
                 Op deze pagina staan alle gegevens die betrekking hebben deze gebruiker. Dit overzicht is alleen toegankelijk voor admins en raadplegers. 
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Gebruikersgegevens</div>

                <div class="panel-body">

                  <table>

                        <tr style="min-width: 100px;"><td>Voornaam&nbsp;</td><td> : </td><td>&nbsp;&nbsp;{{ $user->voornaam }}&nbsp;</td></tr>
                        <tr><td>Achternaam&nbsp;</td><td> : </td><td>&nbsp;&nbsp;{{ $user->achternaam }}&nbsp;</td></tr>
                        <tr><td>Geslacht&nbsp;</td><td> : </td><td>&nbsp;&nbsp;{{ $user->geslacht }}&nbsp;</td></tr>
                        <tr><td>Organisatie&nbsp;</td><td> : </td><td>&nbsp;&nbsp;{{ $user->organisatienaam }}&nbsp;</td></tr>
                        <tr><td>Functie&nbsp;</td><td> : </td><td>&nbsp;&nbsp;{{ $user->functie }}&nbsp;</td></tr>
                        <tr><td>Website&nbsp;</td><td> : </td><td>&nbsp;&nbsp;{{ $user->website }}&nbsp;<a href="http://{{ $user->website }}" target="_BLANK"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a></td></tr>
                        <tr><td>Telefoon&nbsp;</td><td> : </td><td>&nbsp;&nbsp;{{ $user->telefoon }}&nbsp;</td></tr>
                        <tr><td>Email&nbsp;</td><td> : </td><td>&nbsp;&nbsp;{{ $user->email }}&nbsp;<a href="mailto:{{ $user->email }}"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a></td></tr>
                        <tr><td>Type&nbsp;</td><td> : </td><td>&nbsp;
                          @if ($user->usertype==1)
                                Admin
                            @elseif ($user->usertype==2)
                                Raadpleger
                            @elseif ($user->usertype==3)    
                                Intermediair&nbsp;<a href="{{ url('/user/redirecttointermediair') }}/{{ $user->id }}"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a>
                            @endif     
                            &nbsp;</td></tr>
                        <tr><td>Email&nbsp;geverifieerd&nbsp;</td><td> : </td><td>&nbsp;
                                    @if ($user->emailverified)
                                        <span class="glyphicon glyphicon-ok-sign" aria-hidden="true" style="color:green;"></span>
                                    @else
                                        <span class="glyphicon glyphicon-remove-sign" aria-hidden="true" style="color:red;"></span>
                                    @endif 
                          &nbsp;</td></tr>
                        <tr><td>Geactiveerd&nbsp;</td><td> : </td><td>&nbsp;
                                    @if ($user->activated)
                                        <span class="glyphicon glyphicon-ok-sign" aria-hidden="true" style="color:green;"></span>&nbsp;<a href="{{ url('/user') }}/toggleactive/{{ $user->id }}">Wijzig</a>
                                    @else
                                        <span class="glyphicon glyphicon-remove-sign" aria-hidden="true" style="color:red;" data-toggle="tooltip" title="{{$user->reden}}"></span>&nbsp;
                                        @if ($user->emailverified)
                                            <a href="{{ url('/user') }}/toggleactive/{{ $user->id }}">Wijzig</a>
                                        @endif
                                    @endif  
                                  </td></tr>
                        <tr><td>Reden&nbsp;bij&nbsp;inschrijven&nbsp;</td><td> : </td><td>&nbsp;{{ $user->reden }}&nbsp;</td></tr>
                        <tr><td>Aangemaakt&nbsp;</td><td> : </td><td>&nbsp;{{ $user->created_at->format('d-m-Y H:i:s') }}&nbsp;</td></tr>
                        <tr><td>Gewijzigd&nbsp;</td><td> : </td><td>&nbsp;{{ $user->updated_at->format('d-m-Y H:i:s') }}&nbsp;</td></tr>

                    </table>
                    
                

                    <a href="{{ url('/user/edit/'.$user->id) }}"><button type="button" class="btn btn-primary navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Wijzig</button></a>
                    
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
@endsection

