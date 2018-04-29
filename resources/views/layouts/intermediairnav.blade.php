
<div>
<ul class="nav nav-tabs nav-justified">
  <li role="presentation" class="active"><a href="#">Home</a></li>
  <li role="presentation"><a href="{{url('/user/edit/')."/$user->id" }}">Wijzig uw gegevens</a></li>
  <li role="presentation"><a href="{{url('familie/toevoegen')}}/{{$user->id}}">Gezinnen toevoegen</a></li>
  <li role="presentation" class="disabled" data-trigger="hover" data-placement="bottom" aria-hidden="true" data-toggle="popover" title="Downloads gesloten" data-content="Downloads worden later geopend, u krijgt daarover een bericht van ons."><a href="#">Downloads</a></li>
</ul>

</div>


