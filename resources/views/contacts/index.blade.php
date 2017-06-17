@inject('sintbankemail', 'App\Http\Controllers\SintbankemailController')

@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Contacts</div>

                <div class="panel-body">
                	<table><tr>
                				<th>ID&nbsp;</th>
                				<th>Voornaam&nbsp;</th>
                				<th>Achternaam&nbsp;</th>
                				<th>Prive-email&nbsp;</th>
                				<th>Telefoon&nbsp;</th>
                				<th>Sinterklaasbankemail&nbsp;</th>
                			</tr>
					@foreach ($contacts as $contact)
						<tr>
							<td>{{ $contact->id }}&nbsp;</td>
							<td><a href="show\{{ $contact->id }}">{{ $contact->voornaam }}</a>&nbsp;</td>
							<td>{{ $contact->achternaam }}&nbsp;</td>
							<td>{{ $contact->priveemail }}&nbsp;</td>
							<td>{{ $contact->telefoon }}&nbsp;</td>
							<td>@if ($contact->sintbankemail_id)
								<a href="\sintbankemaill\show\{{ $contact->sintbankemail_id }}">
									{{ $sintbankemail->getEmailById($contact->sintbankemail_id) }}
								</a>&nbsp;
								@else
								-&nbsp;
								@endif
							</td>
						</tr>
					@endforeach
                	</table>
                </div>
            </div>
        </div>
    </div>
</div>
       



@endsection