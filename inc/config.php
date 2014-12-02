<?php
session_start();
//$_db = new mysqli('localhost', 'username', 'password', 'tablename');
$_pageName = basename($_SERVER['PHP_SELF']);

$_inContainer = true;
function beginPage($pageTitle = 'Paalgeld Europa', $inContainer = true, $subTitle = ''){
  global $_inContainer, $_pageName;
  $_inContainer = $inContainer;
  require('inc/pagebegin.php');
}

function endPage(){
  global $_inContainer, $_pageName;
  require('inc/pageend.php');
}

?>