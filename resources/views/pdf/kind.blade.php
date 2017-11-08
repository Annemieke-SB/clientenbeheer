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
<br><br>
<div id="textbody">
		<p>
		Aan de ouders/verzorgers van<br>{{ ucfirst($kid->voornaam) }} {{ ucfirst($kid->achternaam) }}<br>
		{{ $kid->family->adres }} {{ $kid->family->huisnummer }}{{ $kid->family->huisnummertoevoeging }}<br>
		{{ $kid->family->postcode }} {{ $kid->family->woonplaats }}
		</p><br><br>
		<p>
		Beste ouders/verzorgers van {{ ucfirst($kid->voornaam) }},</p><br>
		<p>
		Alstublieft, {{ ucfirst($kid->voornaam) }} mag ter waarde van maximaal 25 euro een cadeau uitkiezen uit de collectie van
		Intertoys.</p>
		<p>Ga uiterlijk 5 december {{date('Y')}} met het volledig ingevulde verlanglijstje en met deze brief naar de Intertoys vestiging van  uw keuze om de cadeaus te ontvangen.</p>

		<p>Cadeaus die niet passen bij de leeftijd van {{ ucfirst($kid->voornaam) }} kunnen worden geweigerd. Gekozen cadeaus kunnen niet worden geruild of ingewisseld voor contant geld. Na 5 december {{date('Y')}} vervalt dit aanbod. Zonder deze brief kan Intertoys u de cadeaus helaas niet overhandigen.</p>

		<div id=wrapper>
			<div id='afsluiting'>
				Wij wensen {{ ucfirst($kid->voornaam) }}, u en uw gezin een hele fijne sinterklaasavond.<br><br><br>

			Hartelijke groet,<br><br><br>
			Stichting de Sinterklaasbank&nbsp;

			
			</div>
			<!-- <div id="plaatholder">{{ Html::image('img/sintbankpics/plaatje.jpg', 'logo', array('class' => 'plaatje')) }}&nbsp;</div> -->
		</div>
		<p>
		P.S. Wij zouden het leuk vinden om te horen hoe u deze actie van de Sinterklaasbank heeft ervaren. U kunt ons mailen via info@sinterklaasbank.nl. Een foto vinden wij erg leuk. Alvast dank!
		<br><br>Volg ons op facebook (facebook.com/DeSinterklaasbank/) om op de hoogte te blijven van alle activiteiten van de Sinterklaasbank.
			
		</p>
</div>

<div id="bottom">&nbsp;<div id="footernotes">Stichting 'de Sinterklaasbank' | Postbus 1007, 1400 BA Bussum | KvK 52115885 | IBAN NL40 RABO 0106 7550 13</div></div>

<div class="page-break"></div>
<div id="top">{{ Html::image('img/sintbankpics/banner_brief2.png', 'logo', array('class' => 'logo')) }}&nbsp;</div>

	<div id="textbody">	
		<table style="width: 100%;"><tr><td style="width: 350px;"><p>Madrid, november {{date('Y')}}</p></td><td><div class="barcode">{!! ucfirst($kid->htmlbarcode) !!}</div></td></tr></table>
			
		<p>	
		Lieve {{ ucfirst($kid->voornaam) }},
		</p>
		<p>Hier een brief van Sinterklaas.</p>
		<p>
		Ik vind het heel fijn dat ik weer in Nederland ben. Samen met mijn Pieten ga ik weer heel veel
		kindjes blij maken met een cadeau.<br>En één van die kindjes ben jij! </p>
		<p>
		Heb je op televisie gezien hoe ik met de boot aankwam? Het is altijd zo spannend maar gelukkig is het weer
		allemaal goed gegaan met de stoomboot.<br>
		Samen met al mijn Pieten gaan we er weer een geweldig feest van maken.</p>
		<p>
		Omdat ik heel graag wil weten wat jij van Sinterklaas wilt hebben vraag ik je het verlanglijstje hieronder in te
		vullen. Je mag plaatjes uitknippen, bijvoorbeeld uit het grote Intertoysboek en die erop plakken.
		Maar je mag ook een tekening maken of, als je dat al kunt, opschrijven wat je graag wilt hebben.
		</p>

		<p>
			Als je je verlanglijstje hebt ingevuld mag je het in je schoen doen. Piet komt het dan bij je ophalen. We gaan dan in de pakjesboot kijken of het cadeauthe dat jij graag wilt hebben is meegekomen uit Spanje. Spannend he!</p>	
		<p><br>
			Groetjes van Sint</p><br><br>

			<p style="font-size: 12px; text-align: center;">Plak hier de kadootjes die je graag wilt hebben. Plak bij nr. 1 het kadootje dat je het allerliefste wilt hebben
			en bij nr. 2 wat je daarna het liefste wilt hebben. De Sint zoekt dan een mooi kadootje voor je uit.</p>
	</div>


<div id="verlanglijstholder">{{ Html::image('img/sintbankpics/hokjes_brief2.png', '-', array('class' => 'verlanglijst')) }}&nbsp;</div>
</body>
</html>