@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- Flashmessage -->
            @if (count(Session::get('message')) > 0)
            <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
            @endif
                        
            <div class="panel panel-default">
                                  
                <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li class="active">Gezinnenlijst</li>
                    </ol>

                <div class="panel-body">
                <p>                 <a href="{{ url('/home/') }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                </p>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Te beoordelen aanmeldingen</div>
                <div class="panel-body">
                <p>Hieronder staat een lijst met alle <b>aangemelde</b> gezinnen. Dat betekent dat deze gezinnen door de intermediair zijn aangemeld voor goedkeuring. Ook de gezinnen die eerst waren afgekeurd, maar opnieuw zijn aangemeld kunnen ertussen staan. De reden van de vorige afkeuring staat er nog bij vermeld (zie RA).</p>


                     <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                            <thead>
                            <tr>                				
                				<th>Achternaam&nbsp;</th>
                				<th>Woonplaats&nbsp;</th>
                                <th><span class="glyphicon glyphicon-user" aria-hidden="true" style="color:#1E90FF;" data-toggle="tooltip" title="Aantal kinderen in gezin."></span></th>
                                <th><span class="badge" data-toggle="tooltip" title="Gezin is aangemeld bij andere initiatieven.">AI</span></th>       
                                <th><span class="badge" data-toggle="tooltip" title="Er is al een gezin op de postcode/huisnummer bekend.">DP</span></th>      
                                <th><span class="badge" data-toggle="tooltip" title="Dit gezin heeft mogelijk een kind waarvan de voornaam en geboortedatum al een keer voorkomt.">DK</span></th> 
                                <th><span class="badge" data-toggle="tooltip" title="Dit gezin was afgekeurd, maar is opnieuw aangemeld. Mogelijk heeft de intermediair eea aangepast. De reden van de vorige afmelding staat in het envelopje. Als deze aanmelding weer niet goed is keur hem dan weer af. Je kunt dan de reden aanpassen.">RA</span></th>
                                <th>Aktie&nbsp;</th> 
                            </tr>                 				
                			</thead>
                            <tbody>
    					@foreach ($aangemeldefamilies as $aangemeldefamilie)

                                <tr>
                  
       							<td>{{ str_limit($aangemeldefamilie->achternaam, 10) }}&nbsp;</td>
    							<td>{{ str_limit($aangemeldefamilie->woonplaats, 10) }}&nbsp;</td>
                                <td>{{ $aangemeldefamilie->kidscount }}&nbsp;</td>
                                <td>
                                    @if($aangemeldefamilie->andere_alternatieven)
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    @endif
                                    &nbsp;</td>                       
                                <td>
                                    @if($aangemeldefamilie->postcodehuisnummerdubbel)
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    @endif
                                    &nbsp;</td>
                                <td>
                                    @if($aangemeldefamilie->heeftkindmogelijkdubbel)
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    @endif
                                    &nbsp;</td>
                                <td>
                                        @if ($aangemeldefamilie->redenafkeuren)
                                            <span class="glyphicon glyphicon-envelope" data-toggle="tooltip" title="{{$aangemeldefamilie->redenafkeuren}}"></span>
                                        @endif
                                </td>

                                <td>
                                  
                                        <a href="{{ url('/intermediairs') }}/show/{{ $aangemeldefamilie->intermediair_id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Intermed..</button></a>

										<a href="{{ url('/family') }}/show/{{ $aangemeldefamilie->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Gezin</button></a>

                                        
                                            <a href="{{ url('/family') }}/toggleok/{{ $aangemeldefamilie->id }}"><button class="btn btn-success btn-xs" type="button"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;Goedkeuren</button></a>
                                        
                                            <a href="{{ url('/family') }}/afkeuren/{{ $aangemeldefamilie->id }}"><button class="btn btn-danger btn-xs" type="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;Afkeuren</button></a>   
                                        
                                        
                                  
                                </td>
    						</tr>

    					@endforeach
                            </tbody>
                	</table>


                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Definitief aangemelde gezinnen</div>
                <div class="panel-body">
                <p>Hieronder staan alle (in principe) definitief goedgekeurde gezinnen. Deze gezinnen kunnen echter nog wel worden aangepast door de intermediair, of alsnog worden afgekeurd door de beheerder. Het gezin moet dan opnieuw worden aangemeld.</p>
                     <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                            <thead>
                            <tr>                                
                                <th>Achternaam&nbsp;</th>
                                <th>Woonplaats&nbsp;</th>     
                                <th><span class="badge" data-toggle="tooltip" title="Dit gezin was afgekeurd, maar is opnieuw aangemeld. Mogelijk heeft de intermediair eea aangepast. De reden van de vorige afmelding staat in het envelopje. Als deze aanmelding weer niet goed is keur hem dan weer af. Je kunt dan de reden aanpassen.">RA</span></th>                                             
                                <th>Aktie&nbsp;</th>                                 
                            </tr>                               
                            </thead>
                            <tbody>
                        @foreach ($goedgekeurdefamilies as $goedgekeurdefamilie)

                                <tr>


                                <td>{{ str_limit($goedgekeurdefamilie->achternaam, 8) }}&nbsp;</td>
                                <td>{{ str_limit($goedgekeurdefamilie->woonplaats, 8) }}&nbsp;</td>
                                <td>
                                        @if ($goedgekeurdefamilie->redenafkeuren)
                                            <span class="glyphicon glyphicon-envelope" data-toggle="tooltip" title="{{$goedgekeurdefamilie->redenafkeuren}}"></span>
                                        @endif
                                </td>
                                <td>
                                  
                                        <a href="{{ url('/intermediairs') }}/show/{{ $goedgekeurdefamilie->intermediair_id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Intermediair</button></a>

                                        <a href="{{ url('/family') }}/show/{{ $goedgekeurdefamilie->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Gezin</button></a>        

                                        <a href="{{ url('/family') }}/afkeuren/{{ $goedgekeurdefamilie->id }}"><button class="btn btn-danger btn-xs" type="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;Afkeuren</button></a>                                                  
                                  
                                </td>
                            </tr>

                        @endforeach
                            </tbody>
                    </table>
                    
                    
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Nog niet aangemelde (en afgekeurde) gezinnen</div>
                <div class="panel-body">
                <p>Ter informatie staat hieronder een lijst met alle <b>niet aangemelde</b> gezinnen in de database. Dat betekent dat het gezin nog door de intermediair moet worden aangemeld, of dat het gezin definitief is afgekeurd.</p>
                     <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                            <thead>
                            <tr>                                
                                <th>Achternaam&nbsp;</th>
                                <th>Woonplaats&nbsp;</th>
                                <th><span class="badge" data-toggle="tooltip" title="Als het gezin is afgekeurd, staat hier een enveloppe met de reden afmelding.">RA</span></th>
                                <th><span class="badge" data-toggle="tooltip" title="Het gezin is definitief afgekeurd.">DA</span></th>                   
                                <th>Aktie&nbsp;</th> 
                                
                            </tr>                               
                            </thead>
                            <tbody>
                        @foreach ($nietaangemeldefamilies as $nietaangemeldefamilie)

                                @if ($nietaangemeldefamilie->redenafkeuren)
                                <tr class="danger">
                                @else
                                <tr>
                                @endif

                                <td>{{ str_limit($nietaangemeldefamilie->achternaam, 8) }}&nbsp;</td>
                                <td>{{ str_limit($nietaangemeldefamilie->woonplaats, 8) }}&nbsp;</td>
                                <td>
                                        @if ($nietaangemeldefamilie->redenafkeuren)
                                            <span class="glyphicon glyphicon-envelope" data-toggle="tooltip" title="{{$nietaangemeldefamilie->redenafkeuren}}"></span>
                                        @endif
                                </td>
                                <td>
                                        @if ($nietaangemeldefamilie->definitiefafkeuren)
                                            <span class="glyphicon glyphicon-remove" data-toggle="tooltip" title="Definitief afgekeurd"></span>
                                        @endif
                                </td>                                
                                <td>
                                  
                                        <a href="{{ url('/intermediairs') }}/show/{{ $nietaangemeldefamilie->intermediair_id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Intermediair</button></a>

                                        <a href="{{ url('/family') }}/show/{{ $nietaangemeldefamilie->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Gezin</button></a>                            
                                  
                                </td>
                            </tr>

                        @endforeach
                            </tbody>
                    </table>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

// Dit script zorgt voor sorteren in de lijst
$('th').click(function(){
    var table = $(this).parents('table').eq(0)
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
    this.asc = !this.asc
    if (!this.asc){rows = rows.reverse()}
    for (var i = 0; i < rows.length; i++){table.append(rows[i])}
})
function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index), valB = getCellValue(b, index)
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
    }
}
function getCellValue(row, index){ return $(row).children('td').eq(index).html() }

$(document).ready(function() {
// Hier om de tooltips te activeren
$('[data-toggle="tooltip"]').tooltip();
});



</script>
@endsection
