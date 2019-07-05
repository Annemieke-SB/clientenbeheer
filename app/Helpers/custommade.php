<?php // Code within app\Helpers\Helper.php
// kleine letter in bestand


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

            <p><u>Onze doelstelling is gezinnen thuis op traditionele wijze het Sinterklaasfeest te laten vieren ook als dit financieel niet mogelijk is. Wij willen nadrukkelijk aangeven dat wij er niet zijn voor kerstcadeaus, verjaardagscadeaus of gewoon een extra cadeau. Derhalve zijn onze cadeaubonnen niet meer te gebruiken na 5 december ".date('Y').". Wij verzoeken u vriendelijk dit op juiste wijze in te schatten.</u></p>
            <p>Privacy staat bij ons hoog in het vaandel (zie onze <a href="https://www.sinterklaasbank.nl/wp-content/uploads/2018/11/Privacyverklaring.pdf" target="_BLANK">privacyverklaring</a>). Wij zullen uw gegevens en de gegevens van het gezin niet aan derden verstrekken.</p>


        ";
        return $voorwaarden;

        
    }


}


?> 


