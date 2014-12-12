<?php
session_start();
// Maak verbinding met de database
if($_SERVER["SERVER_NAME"] == 'localhost' || $_SERVER["SERVER_NAME"] == '127.0.0.1'){
  $_db = new mysqli('localhost', 'f111433', 'mi3ahch3ei', 'f111433');
}elseif($_SERVER["SERVER_NAME"] == 'hendrikprins.nl' || $_SERVER["SERVER_NAME"] == 'www.hendrikprins.nl'){
  $_db = new mysqli('localhost', 'p13544_paalgeld', 'paalgeld2014', 'p13544_paalgeld');
}else{
  $_db = new mysqli('mysql01.service.rug.nl', 'f111433', 'mi3ahch3ei', 'f111433');
}
// Sla de pagina naam op, handig bijv. voor het menu (class=active)
$_pageName = basename($_SERVER['PHP_SELF']);
// Zit de content in een container
$_inContainer = true;
// Moet de chosen javascript library worden geladen?
$_loadChosen = false;

// Print de "bovenkant" van de pagina
function beginPage($pageTitle = 'Paalgeld Europa', $inContainer = true, $subTitle = ''){
  global $_inContainer, $_pageName, $_loadChosen;
  $_inContainer = $inContainer;
  require('inc/pagebegin.php');
}

// Print de "onderkant" van de pagina
function endPage(){
  global $_inContainer, $_pageName, $_loadChosen;
  require('inc/pageend.php');
}

function download_knop($query, $array = null){
	echo '<form action="download.php" method="post">';
	echo '<input type="hidden" name="download_query" value="'.$query.'""><br>';
  if ($array) {
    echo '<input type="hidden" name="column_names" value="'.$array.'""><br>';
  }
	echo '<input class="btn btn-primary" type="submit" value="Download CSV">';
	echo '</form>';
}

?>