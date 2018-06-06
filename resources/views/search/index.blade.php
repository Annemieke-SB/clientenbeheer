@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">



            <div class="panel panel-default">              
                <div class="panel-body">
 
    <h1>Zoekresulaten</h1>

                        <a href="{{ url()->previous() }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                        @if (count(Session::get('message')) > 0)
                        <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
                        @endif
	        <br />
<p>Zoekresultaten voor <b>'{{ $q }}'</b>. Er is gezocht in de gebruikers, gezinnen en kinderen. Je kan als zoekopdracht een fragment van een voor- of achternaam, plaatsnaam,organisatienaam, emailadres of postcode gebruiken.</p>

<h3>Gebruikers</h3>
@if (count($users)==0)
Geen gebruikers gevonden.
@else
      <table class="table table-striped">
        <thead>
            <th style="width: 80%;">Naam</th>
            <th>Aktie</th>
        </thead>
  
<tbody>
	@foreach ($users as $user)

        <tr>
	    <td>{{ $user->naam }}
		@if ($user->blacklisted)
		&nbsp;<span class="label label-danger"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>&nbsp;Blacklist</span>
		@endif

		</td>
            <td>
                        <a href="{{ url('user/show') }}/{{$user->id}}"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon</button></a>
            </td>
        </tr>

	@endforeach

</tbody>
    </table>
@endif

<h3>Gezinnen</h3>
 @if (count($familys)==0)
Geen gezinnen gevonden.
@else
     <table class="table table-striped">
        <thead>
            <th style="width: 80%;">Naam</th>
            <th>Aktie</th>
        </thead>
  
<tbody>
	@foreach ($familys as $family)

        <tr>
	    <td>{{ $family->naam }}
		@if ($family->blacklisted)
		&nbsp;<span class="label label-danger"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>&nbsp;Blacklist</span>
		@endif
	</td>
            <td>
                        <a href="{{ url('family/show') }}/{{$family->id}}"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon</button></a>
            </td>
        </tr>

	@endforeach
 
</tbody>
   </table>
@endif   

<h3>Kinderen</h3>
  @if (count($kids)==0)
Geen kinderen gevonden.
@else     <table class="table table-striped">
        <thead>
            <th style="width: 80%;">Naam</th>
            <th>Aktie</th>
        </thead>
  
<tbody>
	@foreach ($kids as $kid)

        <tr>
            <td>{{ $kid->naam }}</td>
            <td>
                        <a href="{{ url('kids/show') }}/{{$kid->id}}"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon</button></a>
            </td>
        </tr>

	@endforeach

</tbody>
    </table>
   
@endif   
  


<h3>Instellingen</h3>
  @if (count($organisaties)==0)
Geen organisaties gevonden.
@else     <table class="table table-striped">
        <thead>
            <th style="width: 80%;">Naam</th>
            <th>Aktie</th>
        </thead>
  
<tbody>
	@foreach ($organisaties as $organisatie)

        <tr>
            <td>{{ $organisatie->organisatienaam }}</td>
            <td>
                        <a href="{{ url('users/show') }}/{{$organisatie->id}}"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Toon</button></a>
            </td>
        </tr>

	@endforeach

</tbody>
    </table>
   
@endif   
  

</div>

</div>
</div>


<style>
    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }

    .panel-heading [data-toggle="collapse"]:after {
        font-family: 'Glyphicons Halflings';
        content: "\e072"; /* "play" icon */
        float: right;
        color: #F58723;
        font-size: 18px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
    }

    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
</style>

<!-- Bootstrap FAQ - END -->

</div>
@endsection
