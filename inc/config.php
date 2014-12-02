<?php
session_start();
// Maak verbinding met de database
$_db = new mysqli('localhost', 'p13544_paalgeld', 'paalgeld2014', 'p13544_paalgeld');
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

?>