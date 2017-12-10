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