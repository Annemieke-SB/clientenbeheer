<table>




@foreach ($redeemedcodes as $redeemedcode)

@if($redeemedcode->CardNumber>0)

	<tr><td>{{$redeemedcode->CardNumber}}</td><td>{{$redeemedcode->Barcode->kid_id}}</td></tr>

@endif

@endforeach


</table>