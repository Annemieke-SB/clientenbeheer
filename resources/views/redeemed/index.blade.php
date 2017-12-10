@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
        <div class="col-md-8 col-md-offset-2">



            <div class="panel panel-default">              
                          <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li class="active">Intermediairs</li>
                    </ol> 

                <div class="panel-body">
<table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
<thead>
	<tr>
		<th>Barcode</th>
		<th>Kind</th>
		<th>Uitgegeven</th>
	</tr>
</thead>
<tbody>


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

</tbody>
</table>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

// Dit script zorgt voor sorteren in de lijst
$('th').click(function(){
    var table = $(this).parents('table').eq(0)
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
    this.asc = !this.asc
    if (!this.asc){rows = rows.reverse()}
    for (var i = 0; i < rows.length; i++){table.append(rows[i])}
})
function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index), valB = getCellValue(b, index)
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
    }
}
function getCellValue(row, index){ return $(row).children('td').eq(index).html() }

$(document).ready(function() {
// Hier om de tooltips te activeren
$('[data-toggle="tooltip"]').tooltip();
});



</script>

@endsection