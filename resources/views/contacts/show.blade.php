@inject('sintbankemail', 'App\Http\Controllers\SintbankemailController')

@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Contact</div>





                <div class="panel-body">
                	<table>
						<tr>
							<td>ID&nbsp;</td><td>{{ $contact->id }}&nbsp;</td>
                        </tr><tr>
							<td>Voornaam&nbsp;</td><td>{{ $contact->voornaam }}&nbsp;</td>
                        </tr><tr>
							<td>Achternaam&nbsp;</td><td>{{ $contact->achternaam }}&nbsp;</td>
                        </tr><tr>
							<td>Priveemail&nbsp;</td><td>{{ $contact->priveemail }}&nbsp;</td>
                        </tr><tr>
							<td>Telefoon&nbsp;</td><td>{{ $contact->telefoon }}&nbsp;</td>
                        </tr><tr>
                            <td>Telefoon 2&nbsp;</td><td>{{ $contact->telefoon2 }}&nbsp;</td>
                        </tr><tr>
                            <td>Functie&nbsp;</td><td>{{ $contact->functie }}&nbsp;</td>
                        </tr><tr>
                            <td>Regio&nbsp;</td><td>{{ $contact->regio }}&nbsp;</td>
                        </tr><tr>
							<td>Sinterklaasbankemail&nbsp;</td><td>@if ($contact->sintbankemail_id)
								<a href="sintbankemaill\show\{{ $contact->sintbankemail_id }}">
									{{ $sintbankemail->getEmailById($contact->sintbankemail_id) }}
								</a>&nbsp;
								@else
								-&nbsp;
								@endif
							</td>
                        </tr><tr>
                            <td>Aangemaakt&nbsp;</td><td>{{ $contact->created_at }}&nbsp;</td>
                        </tr><tr>
                            <td>Gewijzigd&nbsp;</td><td>{{ $contact->updated_at }}&nbsp;</td>
                        </tr><tr>
                            <td>Notities&nbsp;</td><td>{{ $contact->notities }}&nbsp;</td>
						</tr>
                	</table>
                </div>
            </div>
        </div>
    </div>
</div>
       



@endsection