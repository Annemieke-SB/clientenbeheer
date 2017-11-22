
@extends('layouts.app')

@section('content')

@foreach ($emails as $email)
{{ $email }}; 
@endforeach

<hr>

@foreach ($foutebarcodes as $foutebarcode)
{{ $foutebarcode }}; 
@endforeach


@endsection
