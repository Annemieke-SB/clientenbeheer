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
                

                <div class="panel-body">
                    <h1>U bent particulier</h1>
                    <p>U kunt zich helaas alleen inschrijven als u intermediair bent. Als u vindt dat u ondersteuning nodig heeft van de Sinterklaasbank, dan kunt u contact op te nemen met een hulpverlenende instantie, school of een professionele begeleider. Deze kunnen zich namelijk inschrijven als intermediair van de Sinterklaasbank, en u vervolgens aanmelden. </p><p>Enkele voorbeelden van organisaties die intermediair kunnen zijn; budgetcoach, budgetbeheer, huisarts, directeur basisschool, wijkcoach, HR-adviseur etc.. </p>
               <div class="media">
<br>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
