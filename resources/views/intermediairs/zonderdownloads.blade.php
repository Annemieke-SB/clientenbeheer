
@extends('layouts.app')

@section('content')

@foreach ($emails as $email)
{{$email}; 
@endforeach

@endsection
