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
							   	<td>{{ $kids_qualified + $kids_disqualified }}</td>
							</tr>
						</tfoot>kids_metbarcode
						<tbody>
							<tr>
								<td>Kinderen die aan eisen voldoen maar nog gekeurd moeten worden</td>
								<td>{{ $kids_qualified - $kids_metbarcode }}</td>
							</tr>
							<tr>
								<td>Kinderen die niet aan eisen voldoen</td>
								<td>{{ $kids_disqualified }}</td>
							</tr>
							<tr>
								<td>Kinderen die zijn goedgekeurd en meedoen</td>
								<td>{{ $kids_metbarcode }}</td>
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
							   	<td>{{ $families_totaal}}</td>
							</tr>
						</tfoot>
						<tbody>
							<tr>
								<td>Families in afwachting aanmelden en beoordelen</td>
								<td>{{ $families_totaal - $families_definitiefdisqualified - $families_qualified }}</td>
							</tr>
							<tr>
								<td>Families afgekeurd / waarvan definitief afgekeurd</td>
								<td>{{ $families_disqualified }} / {{$families_definitiefdisqualified}}</td>
							</tr>
	
							<tr>
								<td>Families goedgekeurd</td>
								<td>{{ $families_qualified }}</td>
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
								<td>{{ $intermediairs_totaal }}</td>
							</tr>
						</tbody>
                	</table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
