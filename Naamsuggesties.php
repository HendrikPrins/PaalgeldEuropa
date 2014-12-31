<?php

$gestandaardiseerdeNamen = array('Bruin', 'Zwarte', 'Huizinga', 'Jansen');
$invoerGebruiker = 'A de Bruin';
var_dump(onderdeelNaamSugg($gestandaardiseerdeNamen, $invoerGebruiker));

/* Als de volledige naam word ingevoerd wordt alleen het laatse deel van de string gebruikt
Als de ingevoerde naam overeenkomt met een naam uit gestandaardiseerde namen, dan wordt
deze naam ook toegevoegd aan geregistreerde namen.
Als de ingevoerde naam voor 75% uitdezelfde characters bestaat, dan kan de naam, met toe-
stemming van de gebruiker, worden toegevoegd aan geregistreerde namen. */

function onderdeelNaamSugg($gestandaardiseerdeNamen, $schoneInvoer){

$geregistreerdeNaam = array();

$invoerNaam = explode(" ", $schoneInvoer);
$schoneInvoer = end($invoerNaam);

foreach ($gestandaardiseerdeNamen as $invoer){
//	if (similar_text($invoer, $invoerGebruiker) > 4){
	similar_text($invoer, $schoneInvoer, $percent);
	if ($percent > 75) {
//	if ($invoer == $invoerGebruiker){
		$geregistreerdeNaam[] = $invoer;
		}
	}
	return $geregistreerdeNaam;
}

?>
