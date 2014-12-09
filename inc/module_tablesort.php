<?php
/*
Table sort module. Voor het sorteren van HTML tabellen.
Door Hendrik

sortableHead(string, string);
sortableHead - Maakt een link naar dezelfde pagina, maar met andere sorteer instellingen.

queryOrderPart(array(strings), string);
queryOrderPart - Maakt het ORDER BY gedeelte van de query gebaseerd op variabelen uit $_GET. De argumenten zijn nodig voor validatie en standaard kolom.

Zie table_arrivals.php voor een voorbeeld van de implementatie.
*/

function sortableHead($namePretty, $nameTable){
  // Pagina gegevens voor genereren van url
  $pageLink = $_SERVER['PHP_SELF'];
  $get = $_GET;
  // Desc als: geen sortmode aangegeven OF sortmode == asc
  // Asc als: niet desc
  $get['sortmode'] = (!isset($get['sortmode']) || $get['sortmode'] == 'asc' ? 'desc' : 'asc');
  $get['sortby'] = $nameTable;
  // Maak een link met
  return '<a href="'.$pageLink.'?'.http_build_query($get).'">'.$namePretty.'</a>';
}

function queryOrderPart($allowedFields, $defaultField){
  $orderField = isset($_GET['sortby']) ? $_GET['sortby'] : $defaultField;
  $orderMode = isset($_GET['sortmode']) ? $_GET['sortmode'] : 'asc';
  // Valideer order mode, standaard asc
  if($orderMode != 'asc' && $orderMode != 'desc'){
    $orderMode = 'asc';
  }
  // Valideer order field, anders default field
  if(!in_array($orderField, $allowedFields)){
    $orderField = $defaultField;
  }
  return " ORDER BY ".$orderField." ".$orderMode;
}
?>