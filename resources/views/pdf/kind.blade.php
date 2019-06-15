<!DOCTYPE html>
<html>
<head>
<link href="{{ url('/css/pdf.css') }}" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>Barcode voor {{ ucfirst($kid->voornaam) }} {{ ucfirst($kid->achternaam) }}</title>
</head>
<body>

<div id="content">
	<div id="top">{{ Html::image('img/sintbankpics/banner_brief1.png', 'logo', array('class' => 'logo')) }}&nbsp;</div>
	<div id="textbody">
			<p>
			<small>Aan de ouders/verzorgers van</small><br><br>{{ $kid->naam }}<br>
			{{ $kid->family->adres }} {{ $kid->family->huisnummer }}{{ $kid->family->huisnummertoevoeging }}<br>
			{{ $kid->family->postcode }} {{ $kid->family->woonplaats }}
			</p><br>
			<p>
			Beste ouders/verzorgers van {{ ucfirst($kid->voornaam) }},</p><br>
			<p>Alstublieft, {{ ucfirst($kid->voornaam) }} mag ter waarde van maximaal 25 euro een Sinterklaas cadeau uitkiezen uit de collectie van Top1Toys.</p>
			<p>U ontvangt van ons deze brief en een apart verlanglijstje. Laat {{ ucfirst($kid->voornaam) }} het verlanglijstje invullen. Hierbij mag {{ ucfirst($kid->voornaam) }} plakken en knippen of tekenen wat {{ ucfirst($kid->voornaam) }} graag wil hebben van Sinterklaas.  
			Rechtsbovenin het vierkant staat een code. Deze code vertegenwoordigt een waarde van 25 euro! 
			</p>

			<p>Ga uiterlijk 5 december {{date('Y')}} met het volledig ingevulde verlanglijstje (deze brief is niet nodig) naar de website van Top1toys (www.top1toys.nl). Dit mag 1 cadeau van 25 euro zijn, of 25 cadeaus van 1 euro. Bijbetalen mag, maar de bestelling moet wel in één keer gebeuren. Het is namelijk niet mogelijk om de code meer dan één keer te gebruiken. <b>Na 5 december {{date('Y')}} is de waardebon niet meer geldig.</b></p>

			<p>Een cadeau dat niet past bij de leeftijd van {{ ucfirst($kid->voornaam) }} kan worden geweigerd. Gekozen cadeaus kunnen niet worden geruild of ingewisseld voor contant geld. 
			<p>
			Wij wensen {{ ucfirst($kid->voornaam) }}, u en uw gezin een hele fijne sinterklaasavond.<br>
			<br>
			Hartelijke groet,<br>
			<br>
			<br>
			Stichting de Sinterklaasbank&nbsp;
			</p><br>


			<small>P.S. Wilt u ons laten weten hoe {{ ucfirst($kid->voornaam) }}, u en uw gezin deze actie van de Sinterklaasbank hebben ervaren? Dit kan via info@sinterklaasbank.nl. Een foto of video vinden wij erg leuk.
			Om meer bekendheid aan en inzage in de activiteiten van Stichting de Sinterklaasbank te geven willen wij graag een foto of video op social media of onze website publiceren. Publicatie vindt niet plaats zonder dat u hier specifiek toestemming voor hebt gegeven.
			<br>Volg ons op facebook (facebook.com/DeSinterklaasbank/) om op de hoogte te blijven van alle activiteiten van de Sinterklaasbank.</small>


<br><br><br><br><br>
			<div id="footernotes">Stichting 'de Sinterklaasbank' | Postbus 1007, 1400 BA Bussum | KvK 52115885 | IBAN NL40 RABO 0106 7550 13</div>
	</div>
</div>



<div class="page-break"></div>

<div id="content">
	<div id="top">{{ Html::image('img/sintbankpics/banner_brief2.png', 'logo', array('class' => 'logo')) }}&nbsp;</div>

	<div id="textbody">	
		

		<p id="dagtekening">Madrid, november {{date('Y')}}</p>
		<div class="barcode">{!! ucfirst($kid->htmlbarcode) !!}</div>
		<p>
		Lieve {{ ucfirst($kid->voornaam) }},
		</p>
		<p>Hier een brief van Sinterklaas.</p>
		<p>
		Ik vind het heel fijn dat ik weer in Nederland ben. Samen met mijn Pieten ga ik weer heel veel
		kinderen blij maken met een cadeau. En één van die kinderen dat ben jij! </p>
		<p>
		Samen met al mijn Pieten gaan we er weer een geweldig feest van maken.</p>
		<p>
		Omdat ik heel graag wil weten wat jij van Sinterklaas wil hebben, vraag ik je het verlanglijstje hieronder in te
		vullen. Je mag plaatjes uitknippen, bijvoorbeeld uit het grote Intertoysboek en die erop plakken.
		Maar je mag ook een tekening maken of, als je dat al kunt, opschrijven wat je graag wil hebben.
		</p>

		<p>
		Als je je verlanglijstje hebt ingevuld, mag je het in je schoen doen. Piet komt het dan bij je ophalen. Wij gaan dan in de pakjesboot kijken of het cadeau dat jij graag wil hebben is meegekomen uit Spanje. Spannend he!</p>	
		<p>
		<br>			
		Groetjes van Sint
		</p>
		
		<div id="verlanglijstholder">Plak of teken hier het cadeau die je graag wil hebben. De Sint zoekt dan een mooi cadeau voor je uit.</div>
	</div>
</div>


</body>
</html>
