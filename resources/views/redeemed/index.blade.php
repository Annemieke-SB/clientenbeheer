@extends('layouts.app')

@section('content')
<div class="container">

	<div class="row">
        <div class="col-md-8 col-md-offset-2">



                <div class="panel-body">
<table>
<thead><tr><td>Barcode</td><td>Kind</td><td>Uitgegeven</td></thead>



@foreach ($redeemedcodes as $redeemedcode)



@if($redeemedcode->CardNumber>0)

	<tr><td>{{$redeemedcode->CardNumber}}</td><td>
		@if($redeemedcode->barcode)
			{{$redeemedcode->barcode->kid_id}}
		@endif
	</td>

	<td>{{$redeemedcode->ValueOfRedemptions}}</td></tr>

@endif

@endforeach


</table>

@endsection