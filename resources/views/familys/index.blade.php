@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Intermediairs</div>

                <div class="panel-body">
                    <table><tr>
                				<th>Naam&nbsp;</th>
                				<th>Type&nbsp;</th>
                				<th>Woonplaats&nbsp;</th>
                				<th>Email&nbsp;</th>             				
                			</tr>
					@foreach ($intermediairs as $intermediair)
						<tr>
							<td><a href="intermediairs/show/{{ $intermediair->id }}">{{ $intermediair->name }}</a>&nbsp;</td>
							<td>{{ $intermediair->type }}&nbsp;</td>
							<td>{{ $intermediair->woonplaats }}&nbsp;</td>
							<td>{{ $intermediair->email }}&nbsp;</td>
						</tr>
					@endforeach
                	</table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
