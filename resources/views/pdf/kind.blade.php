<!DOCTYPE html>
<html>
<head>
<link href="{{ url('/css/pdf.css') }}" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>Barcode voor {{ ucfirst($kid->voornaam) }} {{ ucfirst($kid->achternaam) }}</title>
</head>
<body>

<div id="content">
<div id="top">{{ Html::image('img/sintbankpics/logo-Sinterklaasbank_klein.png', 'logo', array('class' => 'logo')) }}&nbsp;<div id=slogan>"Ieder kind heeft recht op Sint"</div></div>

<p class="inspring">
<b>Aan de ouders/verzorgers van</b><br><br>{{ ucfirst($kid->voornaam) }} {{ ucfirst($kid->achternaam) }}<br>
{{ $kid->family->adres }} {{ $kid->family->huisnummer }}{{ $kid->family->huisnummertoevoeging }}<br>
{{ $kid->family->postcode }} {{ $kid->family->woonplaats }}
</p>
<p>
Beste ouders/verzorgers van {{ ucfirst($kid->voornaam) }},</p><br>
<p>
Alstublieft, {{ ucfirst($kid->voornaam) }} mag ter waarde van maximaal 25 euro een cadeau uitkiezen uit de collectie van
Intertoys.</p>
<p>Ga uiterlijk 5 december {{date('Y')}} met <b><u>het volledig ingevulde verlanglijstje en met deze brief</u></b> naar de Intertoys vestiging van  uw keuze om de cadeaus te ontvangen.</p>

<p class="inspring">Cadeaus die niet passen bij de leeftijd van {{ ucfirst($kid->voornaam) }} kunnen worden geweigerd. Gekozen cadeaus kunnen niet worden geruild of ingewisseld voor contant geld. Na 5 december {{date('Y')}} vervalt dit aanbod. Zonder deze brief kan Intertoys u de cadeaus helaas niet overhandigen.</p>

<div id=wrapper>
	<div id='afsluiting'>
		Wij wensen {{ ucfirst($kid->voornaam) }}, u en uw gezin een hele fijne sinterklaasavond.<br><br><br>

	Hartelijke groet,<br><br><br>
	Stichting de Sinterklaasbank&nbsp;

	
	</div>
	<div id="plaatholder">{{ Html::image('img/sintbankpics/plaatje.jpg', 'logo', array('class' => 'plaatje')) }}&nbsp;</div>
</div>
<p>
P.S. Wij zouden het leuk vinden om te horen hoe u deze actie van de Sinterklaasbank heeft ervaren. U kunt ons mailen via info@sinterklaasbank.nl. Een foto vinden wij erg leuk. Alvast dank!
<br><br>Volg ons op facebook (facebook.com/DeSinterklaasbank/) om op de hoogte te blijven van alle activiteiten van de Sinterklaasbank.
	
</p>
<div class="barcode">{!! ucfirst($kid->htmlbarcode) !!}</div>
<div id="bottom">&nbsp;<div id="footernotes">Stichting 'de Sinterklaasbank'<br>Postbus 1007, 1400 BA Bussum<br>KvK 52115885 | IBAN NL40 RABO 0106 7550 13<br><br></div></div>

<div class="page-break"></div>
<center><div>{{ Html::image('img/sintbankpics/verlanglijst_titel.gif', '-', array('class' => 'verlanglijst_titel')) }}</div></center>
<div class="mijter">{{ Html::image('img/mijter.gif', '-', array('class' => 'mijter')) }}&nbsp;</div>
<div class="verlanglijsttextholder">
	
		<p>Madrid, november {{date('Y')}}</p>
	<p>	
	Lieve {{ ucfirst($kid->voornaam) }},
	</p><br>
	<p>Hier een brief van Sinterklaas.</p>
	<p>
	Ik vind het heel fijn dat ik weer in Nederland ben. Samen met mijn Pieten ga ik weer heel veel
	kindjes blij maken met een cadeau. En één van die kindjes ben jij! </p>
	<p>
	Heb je gekeken toen ik met mijn Pieten aankwam op televisie? Wat was het spannend he?
	Gelukkig is alles goed gegaan met de stoomboot.</p><p>
	Omdat ik heel graag wil weten wat jij graag van Sinterklaas wilt hebben vraag ik je het verlanglijstje
	hieronder in te vullen. Je mag plaatjes plakken...of tekenen of als je dat al kunt opschrijven wat je
	graag wilt hebben.</p><p>
	Heb je in het Sinterklaasjournaal gezien dat ik allemaal verschillende Pieten uit Spanje heb
	meegenomen? Pieten in alle kleuren maar ook zwarte, witte en met roetvegen. Wat zijn ze mooi he?
	Maar Sinterklaas is heel benieuwd wat jij nou de allermooiste, liefste en leukste Piet vindt? Zou je
	die voor mij willen tekenen op de achterkant van je verlanglijstje? Alles mag. Als jij vindt dat hij
	stippeltjes moet hebben of een mooie bloem op de wang dan vind ik dat heel mooi. Of misschien
	vind je het wel leuk als Piet een roze jurk aan heeft of een brandweerpak. Maar misschien wil je wel
	een zwarte Piet of een witte? ook die vind ik heel mooi. Ik vind gewoon alle Pieten heel erg lief en
	mooi. Als ik alle tekeningen terug heb dan verloot ik samen met de Pieten een splinternieuwe fiets.
	Hoe cool is dat?</p><p>
	Als je je verlanglijstje hebt ingevuld en de allerliefste en leukste Piet hebt getekend kun je het lijstje
	in je schoen doen. Piet komt het dan bij je ophalen. We gaan dan in de Pakjesboot kijken of het
	cadeautje dat jij graag wilt hebben meegekomen is uit Spanje.</p><p>
	Groetjes van Sinterklaas</p>
</div>


<div id="verlanglijstholder">{{ Html::image('img/sintbankpics/vakjes.gif', '-', array('class' => 'verlanglijst')) }}&nbsp;</div>
</body>
</html>