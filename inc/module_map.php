<?php
/*

*/

function makeGoogleMapsArray($geoQuery){

  echo '<script type="text/javascript">';
  $ports = array();
  $arrlength = count($geoQuery);
  for($i=0; $i < $arrlength; $i++) {
    $ports[]= '["'.
    $geoQuery[$i][0].'", '.
    $geoQuery[$i][1].', "'.
    $geoQuery[$i][2].'", '.
    $geoQuery[$i][3].', '.
    $geoQuery[$i][4].']';
  }
  echo '$(document).ready(function(){';
  echo '  var table = Array('.implode(',', $ports).');';
  echo '  initialize(table);
  });';
  echo '</script>';
  echo '<div id="map-canvas" style="width:400px;height:400px;"></div>';
}

function makeGoogleMapsQuery($query, $valueField, $titleField1) {
  global $_db;
  $result = $_db->query($query);
  // create return array
  while($row = $result->fetch_array()) {
    $queryList[] = array($row[$titleField1],$row[$valueField], $row['portName'],$row['lat'],$row['lng']);
  }
  makeGoogleMapsArray($queryList);
}


?>