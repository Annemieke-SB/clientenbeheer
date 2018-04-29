
<div>
<ul class="nav nav-tabs nav-justified">
  <li role="presentation" 
	@if ($page = "home")
		class="active"
	@endif
	><a href="#">Home</a></li>
  <li role="presentation" 
	@if ($page = "edit")
		class="active"
	@endif
	><a href="{{url('/user/edit/')."/$user->id" }}">Wijzig uw gegevens</a></li>
  <li role="presentation" 
	@if ($page = "add")
		class="active"
	@endif
	><a href="{{url('familie/toevoegen')}}/{{$user->id}}">Gezinnen toevoegen</a></li>
  <li role="presentation" class="disabled" data-trigger="hover" data-placement="bottom" aria-hidden="true" data-toggle="popover" title="Downloads gesloten" data-content="Downloads worden later geopend, u krijgt daarover een bericht van ons."><a href="#">Downloads</a></li>
</ul>

</div>


