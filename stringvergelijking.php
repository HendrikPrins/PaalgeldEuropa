<?php

$gestandaardiseerdeNamen = array('Bruin', 'Zwarte', 'Huizinga', 'Jansen');
$invoerGebruiker = 'A de Bruin';
var_dump(onderdeelNaamSugg($gestandaardiseerdeNamen, $invoerGebruiker));

/* wanneer er in de invoer spaties voorkomen
/* zoek naar de laatst voorkomende spatie in de string
/* vergelijk de string vanaf dat punt met de ingevoerde naam

function onderdeelNaamSugg($gestandaardiseerdeNamen, $invoerGebruiker){

$geregistreerdeNaam = array();

foreach ($gestandaardiseerdeNamen as $invoer)
	if (eregi($gestandaardiseerdeNamen, &invoerGebruiker {
	$geregistreerdeNaam[] = $invoer;
	}
	
	elif (similar_text($invoer, $invoerGebruiker, $percent));
		if ($percent > 75) {
		$geregistreerdeNaam[] = $invoer;
		}
	}
	return $geregistreerdeNaam;
}
