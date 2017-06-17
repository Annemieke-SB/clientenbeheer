@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- Flashmessage -->


                        
            <div class="panel panel-default">
                <div class="panel-heading">Verifieer uw emailadres!</div>

                <div class="panel-body">

                @if (Auth::user())
                    <div class="alert alert-info fade in">Sorry: u moet eerst uitloggen en daarna pas op de link klikken!<a href="#" class="close" data-dismiss="alert">&times;</a></div>
                @endif

                    U kunt bijna inloggen. Omdat u net bent ingeschreven, of omdat uw emailadres is gewijzigd, hebben we u een email gestuurd met een link. U dient op deze link te klikken om uw email te verifieren. Daarna kunt u pas inloggen. Heeft u de mail niet ontvangen, check dan uw spam-map in uw emailprogramma. Als dat ook niet lukt, neemt u dan contact op met <a href="mailto:webmaster@sinterklaasbank.nl">de Webmaster</a> (webmaster@sinterklaasbank.nl). <br><br>Met vriendelijke groet, <br><br>Stichting de Sinterklaasbank
                </div>
            </div>
        </div>
    </div>
</div>
@endsection