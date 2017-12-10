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

@foreach ($redeemedcodes as $redeemedcode)
<tr><td>{{$redeemedcode->CardNumber}}</td><td>{{}}</td></tr>

@endforeach

</tbody>
</table>