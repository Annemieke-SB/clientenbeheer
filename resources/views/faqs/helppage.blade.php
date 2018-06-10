

             
                <div class="panel-body">
 
    		  <p>
Staat de door u gezochte informatie er niet bij, neem dan contact met ons op; <a href="mailto:info@sinterklaasbank.nl">info@sinterklaasbank.nl</a>. 
					        </p>


    <div class="panel-group" id="accordion">
      <div class="faqHeader">Algemeen</div>
      
      @foreach ($faqs as $faq)
      @if ($faq->category == 1)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $faq->id }}">{{ $faq->vraag }}</a>

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

      <div class="faqHeader">Privacy</div>
      
      @foreach ($faqs as $faq)
      @if ($faq->category == 2)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $faq->id }}">{{ $faq->vraag }}</a>


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
     

      <div class="faqHeader">Gebruik</div>
      
      @foreach ($faqs as $faq)
      @if ($faq->category == 3)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $faq->id }}">{{ $faq->vraag }}</a>


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

