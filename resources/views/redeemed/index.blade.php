<table>




@foreach ($redeemedcodes as $redeemedcode)

{{dd($redeemedcode->barcode)}}

@if($redeemedcode->CardNumber>0)

	<tr><td>{{$redeemedcode->CardNumber}}</td><td>
		@if($redeemedcode->Barcode)
			{{$redeemedcode->Barcode->kid_id}}
		@endif
	</td></tr>

@endif

@endforeach


</table>