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
                      <li class="active">Tellingen</li>
                    </ol>

                <div class="panel-body">

                                 <a href="{{ url('/home/') }}"><button type="button" class="btn btn-default navbar-btn btn-sm text-right"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Terug</button></a>
                
                	<table class="table"><caption>Kinderen</caption>
                		<thead>
                			<tr>
                				<th>Categorie</th><th>Aantal</th>
                			</tr>
                		</thead>
                		<tfoot>
							<tr>
							   	<td>Totaal</td>
							   	<td>{{ $kids }}</td>
							</tr>
						</tfoot>
						<tbody>
							<tr>
								<td>Kinderen die zijn goedgekeurd</td>
								<td>{{ $kids_goedgekeurd }}</td>
							</tr>
							<tr>
								<td>Kinderen die nog niet zijn aangemeld</td>
								<td>{{ $kids_nog_niet_aangemeld }}</td>
							</tr>
							<tr>
								<td>Aangemelde kinderen die nog moeten worden gekeurd</td>
								<td>{{ $kids_in_afwachting_van_keuring }}</td>
							</tr>							
							<tr>
								<td>Kinderen afgekeurd ({{ $kids_disqualified }}) + definitief afgekeurd ({{ $kids_definitiefdisqualified }}) = </td>
								<td>{{ $kids_disqualified + $kids_definitiefdisqualified }}</td>
							</tr>
						</tbody>
                	</table>

					<table class="table"><caption>Families</caption>
                		<thead>
                			<tr>
                				<th>Categorie</th><th>Aantal</th>
                			</tr>
                		</thead>
                		<tfoot>
							<tr>
							   	<td>Totaal</td>
							   	<td>{{ $families}}</td>
							</tr>
						</tfoot>
						<tbody>
						<tr>
							<td>Families zonder kinderen</td>
							<td>{{ $familieszonderkinderen }}</td>
						</tr>	
						
						<tr>
								<td>Families goedgekeurd</td>
								<td>{{ $families_goedgekeurd }}</td>
						</tr>	
						<tr>
								<td>Families te keuren</td>
								<td>{{ $families_tekeuren }}</td>
						</tr>	

						<tr>
							<td>Families afgekeurd (tijdelijk)</td>
							<td>{{ $families_disqualified }}</td>
						</tr>	
						<tr>
							<td>Families afgekeurd (definitief)</td>
							<td>{{ $families_definitiefdisqualified }}</td>
						</tr>													
						</tbody>
                	</table>                	
                    
					<table class="table"><caption>Intermediairs</caption>
                		<thead>
                			<tr>
                				<th>Categorie</th><th>Aantal</th>
                			</tr>
                		</thead>
						<tbody>
							<tr>
								<td>Totaal aantal intermediairs</td>
								<td>{{ $intermediairs }}</td>
							</tr>
						<tr>
								<td>Intermediairs met gezin maar zonder kinderen</td>
								<td>{{ $intermediairzonderkids }}</td>
							</tr>	
						<tr>
								<td>Intermediairs zonder gezin</td>
								<td>{{ $intermediairzonderfamilies }}</td>
							</tr>	
						</tbody>
                	</table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
