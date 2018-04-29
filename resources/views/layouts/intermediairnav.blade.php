
<div>
<ul class="nav nav-tabs nav-justified">

@if ($page == "home")
  <li role="presentation" class="active"><a href="{{url('user/show'). "/$user->id"}}">Home</a></li>
@else
  <li role="presentation"><a href="{{url('user/show'). "/$user->id"}}">Home</a></li>

@endif

@if ($page == "edit")
  <li role="presentation" class="active"><a href="{{url('/user/edit/')."/$user->id" }}">Wijzig uw gegevens</a></li>
@else
  <li role="presentation"><a href="{{url('/user/edit/')."/$user->id" }}">Wijzig uw gegevens</a></li>
@endif

@if ($page == "add")
  <li role="presentation" class="active"><a href="{{url('familie/toevoegen')}}/{{$user->id}}">Gezinnen toevoegen</a></li>
@else
  <li role="presentation"><a href="{{url('familie/toevoegen')}}/{{$user->id}}">Gezinnen toevoegen</a></li>
@endif

  <li role="presentation" class="disabled" data-trigger="hover" data-placement="bottom" aria-hidden="true" data-toggle="popover" title="Downloads gesloten" data-content="Downloads worden later geopend, u krijgt daarover een bericht van ons."><a href="#">Downloads</a></li>
</ul>

</div>


