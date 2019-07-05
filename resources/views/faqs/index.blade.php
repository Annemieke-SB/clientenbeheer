@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">



            <div class="panel panel-default">              
                <div class="panel-body">
 
    <h1>FAQ <small>Veelgestelde vragen</small></h1>

@if (!Auth::guest())
                        @if (Auth::user()->usertype==1)
                        <a href="{{ url('faq/toevoegen') }}"><button type="button" class="btn btn-info navbar-btn btn-sm text-right">&nbsp;Vraag toevoegen</button></a>
                        @endif
@endif
    <!-- Bootstrap FAQ - START -->
                                     <!-- Flashmessage -->
                        @if (Session::get('message'))
                        <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
                        @endif
	        <br />

		    <div class="alert alert-warning alert-dismissible" role="alert">
		            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
Hier vindt u de veelgestelde vragen met betrekking tot de Cliëntenbeheer-applicatie van de Sinterklaasbank. Mocht uw vraag er niet tussenstaan, neem dan contact op met ons; <a href="mailto:info@sinterklaasbank.nl">info@sinterklaasbank.nl</a>. 
					        </div>


    <div class="panel-group" id="accordion">
      <div class="faqHeader">Algemene vragen</div>
      
      @foreach ($faqs as $faq)
      @if ($faq->category == 1)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $faq->id }}">{{ $faq->vraag }}</a>
@if (!Auth::guest())
    @if (Auth::user()->usertype==1)
                            <a href="{{ url('faq/destroy') }}/{{$faq->id}}"><button type="button" class="btn btn-danger btn-xs text-right"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;wis</button></a>

                            <a href="{{ url('faq/edit') }}/{{$faq->id}}"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;wijzig</button></a>
    @endif
@endif
</h4>
            </div>
            <div id="collapse{{ $faq->id }}" class="panel-collapse collapse">
                <div class="panel-body">
		{{ $faq->antwoord }}  
                </div>
            </div>
	</div>
	@endif
	@endforeach

      <div class="faqHeader">Privacy vragen</div>
      
      @foreach ($faqs as $faq)
      @if ($faq->category == 2)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $faq->id }}">{{ $faq->vraag }}</a>
@if (!Auth::guest())
    @if (Auth::user()->usertype==1)
                            <a href="{{ url('faq/destroy') }}/{{$faq->id}}"><button type="button" class="btn btn-danger btn-xs text-right"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;wis</button></a>

                            <a href="{{ url('faq/edit') }}/{{$faq->id}}"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;wijzig</button></a>
    @endif
@endif

		</h4>
            </div>
            <div id="collapse{{ $faq->id }}" class="panel-collapse collapse">
                <div class="panel-body">
		{{ $faq->antwoord }}  
                </div>
            </div>
	</div>
	@endif
	@endforeach
     

      <div class="faqHeader">Gebruiker cliëntenbeheer</div>
      
      @foreach ($faqs as $faq)
      @if ($faq->category == 3)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $faq->id }}">{{ $faq->vraag }}</a>
@if (!Auth::guest())
    @if (Auth::user()->usertype==1)

                            <a href="{{ url('faq/destroy') }}/{{$faq->id}}"><button type="button" class="btn btn-danger btn-xs text-right"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;wis</button></a>

                            <a href="{{ url('faq/edit') }}/{{$faq->id}}"><button type="button" class="btn btn-info btn-xs text-right"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;wijzig</button></a>
    @endif
@endif

		</h4>
            </div>
            <div id="collapse{{ $faq->id }}" class="panel-collapse collapse">
                <div class="panel-body">
		{{ $faq->antwoord }}  
                </div>
            </div>
	</div>
	@endif
	@endforeach

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
