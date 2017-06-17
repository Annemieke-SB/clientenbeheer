<?php // Code within app\Helpers\Helper.php
// kleine letter in bestand


use App\Setting;
namespace App\Helpers;

class Custommade {



    public static function returnNextSinterklaasJaar() {
        
        $thisDate = date('m/d/Y', time());
		$thisYear = date('Y', time());
		$thisDayMonth = date('m/d', time());
		$sinterklaasDitJaar = $thisYear . "-12-5"; 
        
		if(strtotime($sinterklaasDitJaar) < strtotime($thisDate))
		{
		   // Sinterklaas is geweest dit jaar
			return intval($thisYear)+1;
		}
		else
		{
		   return intval($thisYear);
		}
    }


    public static function sendNewUserNotificationEmailToAdmin() {

    	$to = Setting::find(5)->setting;    	

		$headers = 'From: noreply@sinterklaasbank.nl' . "\r\n" .
					'Reply-To: noreply@sinterklaasbank.nl' . "\r\n" .
					'Content-type: text/html; charset=iso-8859-1'. "\r\n" .
					'MIME-Version: 1.0'. "\r\n" .
					'X-Mailer: PHP/' . phpversion();

		$message = "Er is een nieuwe gebruiker ingeschreven in clientenbeheer. Deze gebruiker moet nog door een admin geactiveerd worden. Ga naar het gebruikersoverzicht om deze gebruiker te activeren.";

		mail($to, 'Nieuwe gebruiker in clientenbeheer', $message, $headers); 	
    }



    public static function sendUserEmail($to, $message) {

    	    	

		$headers = 'From: noreply@sinterklaasbank.nl' . "\r\n" .
					'Reply-To: noreply@sinterklaasbank.nl' . "\r\n" .
					'Content-type: text/html; charset=iso-8859-1'. "\r\n" .
					'MIME-Version: 1.0'. "\r\n" .
					'X-Mailer: PHP/' . phpversion();

		mail($to, 'Bericht van clientenbeheer', $message, $headers); 	
    }

    public static function typenIntermediairs($id=false) {

    	$set = array(
    		'' => "-",
    		1 => "Voedselhulp / bank",
    		2 => "Schuldhulpverlening",
    		3 => "Geestelijke hulpverlening",
    		4 => "Medische hulpverlening",
    		5 => "BSO / Kinderopvang",
    		6 => "Basisschool",
    		7 => "Voortgezet onderwijs",
    		8 => "Daklozenopvang",
    		9 => "Sociale wijkteam",
    		10 => "Sportvereniging",
    		11 => "Vakbond",
            12 => "Religieuze instelling",
    		30 => "Overige overheid",
    		31 => "Overige stichtingen",
    		32 => "Overige bedrijven",
    		33 => "Overige verenigingen",
    		34 => "Overige organisaties",
    		35 => "Overige onderwijs",
    	);

        if ($id) {
            return $set[$id];
        } else {
            return $set;
        }

        
    }


    public static function showVoorwaarden() {


        $voorwaarden = "

        <h4>Voorwaarden</h4>

            <p>Let op, er zijn een paar regels waar u mee akkoord moet gaan;</p>
            <ul>
            <li>U bent verantwoordelijk voor de juiste invoer van de gegevens en vult de gegevens naar waarheid in.</li>
            <li>U krijgt automatisch rode velden te zien als er bepaalde problemen zijn en zult die problemen op moeten lossen (zoals dubbele invoer, gezinnen die niet in aanmerking komen verwijderen).</li>
            <li>De gezinnen die u aanmeldt zijn op de hoogte van de aanmelding.</li>
            <li>Wij zullen u zien als ons contactpersoon voor het gezin, de correspondentie loopt via u.</li>
            <li>De Sinterklaasbank kan in bepaalde gevallen contact opnemen met het gezin (bijvoorbeeld om de gegevens te controleren) en kan daarbij uw gegevens aan het gezin verstrekken.</li>
            </ul>
            <p>Privacy staat bij ons hoog in het vaandel. Wij zullen uw gegevens en de gegevens van het gezin niet aan derden verstrekken.</p>


        ";
        return $voorwaarden;

        
    }


}


?> 


