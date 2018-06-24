
<div>
  <ul class="nav nav-tabs nav-justified">
    @if ($page == "home")
    <li role="presentation" class="active"><a href="{{url('user/show'). "/$user->id"}}">Home</a></li>
    @else
    <li role="presentation"><a href="{{url('user/show'). "/$user->id"}}">Home</a></li>
    @endif

    @if ($page == "edit")
    <li role="presentation" class="active"><a href="{{url('/user/edit/')."/$user->id" }}">Wijzig gegevens</a></li>
    @else
        @if (Auth::user()->id != Request::segment(3))
        <li role="presentation" class="disabled"><a href="#">Wijzig gegevens</a></li>
        @else
        <li role="presentation"><a href="{{url('/user/edit/')."/$user->id" }}">Wijzig gegevens</a></li>
        @endif
    @endif

    @if ($page == "add")
    <li role="presentation" class="active"><a href="{{url('familie/toevoegen')}}{{$user->id}}">Gezin toevoegen</a></li>
    @else
        @if (App\Setting::get('inschrijven_gesloten')==1)
        <li role="presentation" class="disabled"><a href="#">Gezin toevoegen</a></li>
        @else
            @if (Auth::user()->id != Request::segment(3))
            <li role="presentation" class="disabled"><a href="#">Gezin toevoegen</a></li>
            @else
            <li role="presentation"><a href="{{url('familie/toevoegen')}}/{{$user->id}}">Gezin toevoegen</a></li>
            @endif
        @endif
    @endif

    @if (App\Setting::get('downloads_ingeschakeld')==1)
    <li role="presentation"><a href="{{url('users/downloads')}}/{{$user->id}}">Downloads</a></li>
    @else
    <li role="presentation" class="disabled" data-trigger="hover" data-placement="bottom" aria-hidden="true" data-toggle="popover" title="Downloads gesloten" data-content="Downloads worden later geopend, u krijgt daarover een bericht van ons."><a href="#">Downloads</a></li>
    @endif

  </ul>

</div>


