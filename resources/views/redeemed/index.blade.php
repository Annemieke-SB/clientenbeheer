<table>




@foreach ($redeemedcodes as $redeemedcode)


<tr><td>{{$redeemedcode->CardNumber}}</td><td>{{}}</td></tr>

@endforeach


</table>