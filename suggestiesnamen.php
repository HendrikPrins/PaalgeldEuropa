<?php
require_once('inc/config.php');
echo 'hoi!<br>';
$invoerGebruiker = 'Jansen';

var_dump(naamsuggesties($invoerGebruiker));

echo '<br>functie klaar<br>';

// Returnt een array waarbij het eerste element True of False is, afhankelijk of de naam gevonden is in de database
// De overige elementen zijn naamsuggesties.
function naamsuggesties($invoerGebruiker){
	global $_db;
	// VERANDEREN: MOET HIJ UIT DE DATABASE LEZEN
	// ALLE lastNameCaptain
	// $namenUitDatabase = array('Bruyn', 'Bruin', 'Zwarte', 'Huizinga', 'Jansen', 'Bruyn', 'Bruynen', 'Bruin');
	$namenUitDatabase = array();
	
	$query = 'SELECT distinct lastNameCaptain FROM paalgeldEur';
	$res = $_db->query($query);
	while($row = $res->fetch_assoc()) // WAAROM EEN ENKELE = ?
	{
		// $captain = str_replace(' ', '_', $row['fullNameCaptain']); // Uit oorspronkelijke document
		// echo "$row['lastNameCaptain']";
		$namenUitDatabase[] = $row['lastNameCaptain'];
	}
	echo $namenUitDatabase[143];
	//var_dump($namenUitDatabase);

	
	// Verwijder spaties uit de naam (TUSSENVOEGSELS?)
	// CONVERT TO ALLEEN HOOFDLETTERS AAN HET BEGIN?
	$invoerNaam = explode(" ", $invoerGebruiker);
	$invoerGebruiker = end($invoerNaam);

	// initialisatie van variabelen
	$mogelijkeKandidaten = array();
	$invoerGebruikerGevondenInDatabase = False;

	foreach ($namenUitDatabase as $huidigeNaamUitDatabase) {
		similar_text($huidigeNaamUitDatabase, $invoerGebruiker, $procent);
		
		// als volledig overeenkomt 'afvinken' als gevonden
		if ($procent == 100)
		{
			$invoerGebruikerGevondenInDatabase = True;
		}
		
		// als meer dan 60% overeenkomst met de invoer én nog niet in de kandidatenlijst:
		// dan toevoegen aan kandidatenlijst
		elseif ($procent > 60 and ! in_array($huidigeNaamUitDatabase, $mogelijkeKandidaten))
		{
			$mogelijkeKandidaten[] = $huidigeNaamUitDatabase;
		}
		
	}
	// returnt een array met mogelijke kandidaten.
	// Het eerste element van de array is True of False en geeft aan of de naam gevonden is in de database.
	array_unshift($mogelijkeKandidaten, $invoerGebruikerGevondenInDatabase);
	return $mogelijkeKandidaten;
}



?>
