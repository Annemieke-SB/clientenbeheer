<table>




@foreach ($redeemedcodes as $redeemedcode)

@if($redeemedcode->CardNumber>0)

	<tr><td>{{$redeemedcode->CardNumber}}</td><td>{{}}</td></tr>

@endif

@endforeach


</table>