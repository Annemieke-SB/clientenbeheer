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
			<div class="barcode">{!! ucfirst($kid->htmlbarcode) !!}</div>
			<p>
			Beste ouders/verzorgers van {{ ucfirst($kid->voornaam) }},</p><br>
			
			<p>Alstublieft, {{ ucfirst($kid->voornaam) }} mag ter waarde van maximaal 25 euro een Sinterklaas cadeau uitkiezen uit de collectie van Top1Toys.</p>
			
			<p>Rechts boven in het vierkant staat een code. Deze code vertegenwoordigt een waarde van 25 euro!</p>

			<p>Naast deze brief ontvangt u een verlanglijstje. Laat {{ ucfirst($kid->voornaam) }} het verlanglijstje invullen. Hierbij mag {{ ucfirst($kid->voornaam) }} plakken en knippen of tekenen wat {{ ucfirst($kid->voornaam) }} graag wil hebben van Sinterklaas.</p>

			<p>Bestel uiterlijk <b>5 december {{date('Y')}}</b> de door {{ ucfirst($kid->voornaam) }} gevraagde Sinterklaas cadeaus op de website van Top1Toys (www.top1toys.nl). Dit mag 1 cadeau van 25 euro zijn, of 25 cadeaus van 1 euro. Bij het afrekenen kan de code uit deze brief als kortingscode bij Top1Toys gebruikt worden. Bijbetalen mag, maar de bestelling moet wel in één keer gebeuren. De code kan maar één keer gebruikt te worden. <b>Na 5 december {{date('Y')}} is de code niet meer geldig.</b></p>

			<p>Een cadeau dat niet past bij de leeftijd van {{ ucfirst($kid->voornaam) }} kan worden geweigerd. Gekozen cadeaus kunnen niet worden geruild of ingewisseld voor contant geld.</p>
			<p>
			Wij wensen {{ ucfirst($kid->voornaam) }}, u en uw gezin een hele fijne sinterklaasavond.</p><br>
			<br>
			Hartelijke groet,<br>
			<br>
			<br>
			Stichting de Sinterklaasbank&nbsp;
			<br>


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
		Omdat ik heel graag wil weten wat jij van Sinterklaas wilt hebben, vraag ik jou het verlanglijstje hieronder in te vullen. Jij mag plaatjes uitknippen, bijvoorbeeld uit het grote Top1Toys boek en die erop plakken. Maar jij mag ook een tekening maken of, als jij dat al kunt, opschrijven wat jij graag wilt hebben.
		</p>

		<p>
		Als jij jouw verlanglijstje hebt ingevuld, mag jij het in jouw schoen doen. Piet komthet dan bij jou ophalen. De pieten gaan dan in de pakjesboot kijken of het cadeaudat jij graag wilt hebben is meegekomen uit Spanje. Spannend he!</p>	
		<p>
		<br>			
		Groetjes van Sint
		</p>
		
		<div id="verlanglijstholder">Plak of teken hier het cadeau die je graag wil hebben. De Sint zoekt dan een mooi cadeau voor je uit.</div>
	</div>
</div>


</body>
</html>
