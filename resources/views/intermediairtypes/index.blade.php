@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">



            <div class="panel panel-default">              
                <div class="panel-body">
 
    <h1>Intermediairtypes</h1>
    <p>
                        <a href="{{ url()->previous() }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                        </p>

                        
                        <a href="{{ url('intermediairtypes/toevoegen') }}"><button type="button" class="btn btn-info btn-sm text-right">&nbsp;Intermediairtype toevoegen</button></a>
                        




    <div>

      
      @foreach ($intermediairtypes as $intermediairtype)
      
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $intermediairtype->id }}">{{ $intermediairtype->omschrijving }}</a>

    
                            <a href="{{ url('faq/destroy') }}/{{$intermediairtype->id}}"><button type="button" class="btn btn-danger btn-xs text-right"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;wis</button></a>

                            <a href="{{ url('faq/edit') }}/{{$intermediairtype->id}}"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;wijzig</button></a>
    

</h4>
            </div>
            <div id="collapse{{ $faq->id }}" class="panel-collapse collapse">
                <div class="panel-body">
		{{ $intermediairtype->antwoord }}  
                </div>
            </div>
	</div>
	
	@endforeach

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
