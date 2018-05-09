@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">



            <div class="panel panel-default">              
                <div class="panel-body">
 
    <h1>Blacklist</h1>

                        <a href="{{ url('blacklist/toevoegen') }}"><button type="button" class="btn btn-info navbar-btn btn-sm text-right">&nbsp;Email toevoegen</button></a>
    <!-- Bootstrap FAQ - START -->
                                     <!-- Flashmessage -->
                        @if (count(Session::get('message')) > 0)
                        <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
                        @endif
	        <br />


    <div class="panel-group">
      <table class="table table-striped">
        <thead>
            <th>Email</th>
            <th>Reden</th>
            <th>Door</th>
            <th>Sinds</th>
            <th>Aktie</th>
        </thead>
      @foreach ($blacklisted_items as $item)

        <tr>
            <td>{{ $item->email }}</td>
            <td>{{ $item->reden }}</td>
            <td>{{ $item->user->naam }}</td>
            <td>{{ $item->created_at }}</td>
            <td>
                        <a href="{{ url('blacklist/destroy') }}/{{$item->id}}"><button type="button" class="btn btn-danger btn-xs text-right"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;wis</button></a>

                        <a href="{{ url('blacklist/edit') }}/{{$item->id}}"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;wijzig</button></a>
            </td>
        </tr>

	@endforeach
    </table>
   

   </div>
</div>

</div>
</div>


<style>
    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }

    .panel-heading [data-toggle="collapse"]:after {
        font-family: 'Glyphicons Halflings';
        content: "\e072"; /* "play" icon */
        float: right;
        color: #F58723;
        font-size: 18px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
    }

    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
</style>

<!-- Bootstrap FAQ - END -->

</div>
@endsection
