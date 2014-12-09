<?php
function sortableHead($namePretty, $nameTable){
  $pageLink = $_SERVER['PHP_SELF'];
  $get = $_GET;
  // Desc als: geen sortmode aangegeven OF sortmode == asc
  // Asc als: niet desc
  $get['sortmode'] = (!isset($get['sortmode']) || $get['sortmode'] == 'asc' ? 'desc' : 'asc');
  $get['sortby'] = $nameTable;
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