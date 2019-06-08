@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">



            <div class="panel panel-default">              
                <div class="panel-body">
 
    <h1>Intermediairtypes</h1>

                        <a href="{{ url('intermediairtypes/toevoegen') }}"><button type="button" class="btn btn-info navbar-btn btn-sm text-right">&nbsp;Intermediairtypes toevoegen</button></a>
    <!-- Bootstrap FAQ - START -->
                                     <!-- Flashmessage -->
                        @if (Session::get('message'))
                        <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
                        @endif
            <br />


    <div class="panel-group">
      <table class="table table-striped">
        <thead>
            <th>Omschrijving</th>
            <th>Aantal</th>
            <th>Aktie</th>
        </thead>
      @foreach ($intermediairtypes as $intermediairtype)


        <tr>
            <td>{{ $intermediairtype->omschrijving }}</td>
            <td>{{ $intermediairtype->aantal }}</td>
            <td>
                    @if ($intermediairtype->aantal == 0)
                    
                        <a href="{{ url('intermediairtypes/destroy') }}/{{$intermediairtype->id}}"><button type="button" class="btn btn-danger btn-xs text-right"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;wis</button></a>

                        <a href="{{ url('intermediairtypes/edit') }}/{{$intermediairtype->id}}"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;wijzig</button></a>

                    @elseif

                        <small>Door koppeling niet te wijzigen</small>

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
