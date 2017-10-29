@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">



            <div class="panel panel-default">              
                          <ol class="breadcrumb">
                      <li><a href="{{ url('/home') }}">Home</a></li>
                      <li class="active">Intermediairs</li>
                    </ol> 

                <div class="panel-body"><h1>Ik ben hier even aan het werk, groet Henrique!</h1>
                                                <p>


                                                <a href="{{ url('/home/') }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                                                </p>
                 Hier is het overzicht van intermediairs. Dit overzicht is alleen beschikbaar voor administrators en raadplegers. Intermediairs zien alleen hun eigen profiel. 


                  
              

                </div>
            </div>

            <!-- Flashmessage -->
            @if (count(Session::get('message')) > 0)
            <div class="alert alert-info fade in">{{ Session::get('message')}}<a href="#" class="close" data-dismiss="alert">&times;</a></div>
            @endif
                        


   <div class="panel panel-default">   <div class="panel-body">
                    
                    
      

                    <br>
                        <p><small>Tip: Ga met je muis over <span class="badge">&nbsp;&nbsp;&nbsp;</span>-balonnen voor extra info.</small><br>
                        </p>



<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <div class="navbar-brand"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        
        <li class="active"><a href="{{ url('/intermediairs') }}">Reset</a></li>

      </ul>
      <form class="navbar-form navbar-left" action="{{ url('/intermediairs') }}" method="get">
        <div class="form-group">
          <input type="text" class="form-control" name="achternaam"  placeholder="Naam instelling">
        </div>
        <button type="submit" class="btn btn-default">Zoek</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li>

            <p class="navbar-text">

                @if (Request::input('naam'))
                    <b>bevat "{{Request::input('naam')}}"</b>          
                @elseif (Request::input('na'))
                    <b>niet aktief</b>  
                @else
                    Geen filter
                @endif

            </p>
        </li>
        <li><p class="navbar-text"><p class="navbar-text"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <b>{{$intermediairs->total()}}</b></p></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>




                                        <div class="row">
                        <div class="col-sm-8 col-md-offset-2">
                            {{$intermediairs->render()}}
                        </div>

                    </div><small>Sortering: Laatste komt als eerste</small>
                    <table id="table" name="table" class="table table-striped table-bordered table-hover table-condensed">
                            <thead>
                            <tr>
                				
                				<th>Instelling&nbsp;</th>
                                <th><span class="badge" data-toggle="tooltip" title="Hier staat het aantal gediskwaliceerde families aangetroffen bij deze intermediair. Dat zijn familie's zonder kinderen in de doelgroep. Klik op 'Toon' voor meer info.">DF</span></th>
                                <th><span class="badge" data-toggle="tooltip" title="Hier staat het aantal gediskwalificeerde kinderen aangetroffen bij de intermediair. Dit zijn kinderen die niet in de doelgroep vallen en ook niet onder de categorie 'broertjes of zusjes'. Klik op 'Toon' voor meer info.">DK</span></th>
                                <th><span class="badge" data-toggle="tooltip" title="Mogelijke dubbelen. Klik op 'Toon' voor meer info.">DB</span></th>
                                <th><span class="badge" data-toggle="tooltip" title="Aantal families die door deze intermediair zijn toegevoegd.">AF</span></th>
                                <th><span class="badge" data-toggle="tooltip" title="Familie's zonder kinderen. Klik op 'Toon' voor meer info.">GK</span></th>

                                <th>Actie&nbsp;</th> 
                            </tr>                 				
                			</thead>
                            <tbody>
    					@foreach ($intermediairs as $intermediair)
    						<tr>
    							
    							<td>
                                @if(isset($intermediair->user->organisatienaam))
                                {{ $intermediair->user->organisatienaam }}&nbsp;
                                @else
                                !!FOUT!! Im-id: {{$intermediair->id}} 
                                @endif
                                </td>
                                
                                @if ($intermediair->disqualifiedfams == 0)
                                <td>
                                @else
                                <td class="danger">
                                @endif
                                {{ $intermediair->disqualifiedfams }}&nbsp;</td>
                                @if ($intermediair->disqualifiedkids == 0)
                                <td>
                                @else
                                <td class="danger">
                                @endif
                                {{ $intermediair->disqualifiedkids }}&nbsp;</td>
                                @if ($intermediair->famheeftpostcodehuisnummerdubbel == 0)
                                <td>
                                @else
                                <td class="danger">
                                @endif
                                {{ $intermediair->famheeftpostcodehuisnummerdubbel }}&nbsp;</td>


                                @if ($intermediair->hasfams > 0)
                                <td>
                                @else
                                <td class="danger">
                                @endif
                                {{ $intermediair->hasfams }}&nbsp;</td>


                                @if ($intermediair->hasfamszonderkids == 0)
                                <td>
                                @else
                                <td class="danger">
                                @endif
                                {{ $intermediair->hasfamszonderkids }}&nbsp;</td>


                                <td>
                                    <a href="{{ url('/intermediairs') }}/show/{{ $intermediair->id }}"><button class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Toon</button></a>
                                        

                                        
                                        @if ( Auth::user()->usertype == 1 ) 
                                        <a href="#" data-toggle="modal" data-target="#deleteModal{{ $intermediair->id }}"><button class="btn btn-danger btn-xs" type="button"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>&nbsp;Wis</button></a>
                                        

                                        <!-- Modal om te deleten -->
                                        <div class="modal fade" id="deleteModal{{ $intermediair->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                          <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Wissen van intermediair 

                                                                  @if(isset($intermediair->user->achternaam))
                                {{ $intermediair->user->achternaam }}&nbsp;
                                @else
                                !!FOUT!! Im-id: {{$intermediair->id}} 
                                @endif
                                
                                                    ?</h4>
                                              </div>
                                              <div class="modal-body">
                                                <blockquote><p>Let op: als je de instelling van de intermediair wist, worden alle gezinnen en kinderen die eronder hangen ook <b>permanent</b> gewist. De gebruiker (de intermediair zelf) wordt niet gewist! Dat betekent dat de gebruiker nog steeds kan inloggen, maar verplicht een nieuwe instelling moet aanmaken. Is het de bedoeling dat de gebruiker ook wordt gewist, ga dan naar het gebruikersoverzicht en verwijder diegene daar. Alles wat eronder ligt (zoals de instelling, families en kinderen) worden dan automatisch ook gewist.</p></blockquote>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
                                                <a id="deletehref" href="{{ url('/intermediairs') }}/destroy/{{ $intermediair->id }}"><button type="button" class="btn btn-primary">Doorgaan</button></a>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        @endif



                                    </center>
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
