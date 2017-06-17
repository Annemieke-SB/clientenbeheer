@inject('sintbankemail', 'App\Http\Controllers\SintbankemailController')

@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Contact</div>





                <div class="panel-body">
                    
                        
                            {!! Form::open(['url' => 'contacts/update']) !!}
                            {!! Form::token() !!}
                            {!! Form::hidden('id', $contact->id) !!}
                            <table>
                            <tr><td>{!! Form::label('voornaam', 'Voornaam') !!}</td><td>
                            {!! Form::text('voornaam', $contact->voornaam) !!}</td></tr>
                            <tr><td>{!! Form::label('achternaam', 'Achternaam') !!}</td><td>
                            {!! Form::text('achternaam', $contact->achternaam) !!}</td></tr>
                            <tr><td>{!! Form::label('priveemail', 'Prive-email') !!}</td><td>
                            {!! Form::text('priveemail', $contact->priveemail) !!}</td></tr>
                            <tr><td>{!! Form::label('telefoon', 'Telefoon 1') !!}</td><td>
                            {!! Form::text('telefoon', $contact->telefoon) !!}</td></tr>
                            <tr><td>{!! Form::label('telefoon2', 'Telefoon 2') !!}</td><td>
                            {!! Form::text('telefoon2', $contact->telefoon2) !!}</td></tr>
                            <tr><td>{!! Form::label('functie', 'Functie') !!}</td><td>
                            {!! Form::text('functie', $contact->functie) !!}</td></tr>   
                            <tr><td>{!! Form::label('regio', 'Regio') !!}</td><td>
                            {!! Form::text('regio', $contact->regio) !!}</td></tr>   
                            <tr><td>{!! Form::label('notities', 'Notitie') !!}</td><td>
                            {!! Form::textarea('notities', $contact->notities) !!}</td></tr>   
                            <tr><td></td><td>
                            {!! Form::submit('Wijzig') !!}</td></tr>   
                            </table>
                            {!! Form::close() !!}
<br/>

                            Aangemaakt:&nbsp;{{ $contact->created_at }}<br/>
                            Gewijzigd:&nbsp;{{ $contact->updated_at }}<br/>
                </div>
            </div>
        </div>
    </div>
</div>
       



@endsection