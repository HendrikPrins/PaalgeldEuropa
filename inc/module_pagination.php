<?php


function pagination($page, $size, $totalSize){
  // Door Hendrik
  // Deze functie geeft HTML met bootstrap pagination terug. De fucntie gebruikt geen echo, zo kan de output op meerdere plaatsen getoond worden.
  // Input: 3x integer: $page: huidig pagina nummer, $size: aantal records per pagina, $totalSize: totaal aantal records

  // Offset records (aantal records voor het eerste van deze pagina)
  $offset = ($page * $size);
  // Variabelen om link op te bouwen:
  $pageLink = $_SERVER['PHP_SELF'];
  $get = $_GET;
  $out = '<nav>';
  $out .= '  <ul class="pagination">';

  $hasPrevious = ($offset > 0);
  $hasNext = ($offset < $totalSize-$size);

  if($page != 0){
    $get['page'] = 0;
    $out .= '<li><a href="'.$pageLink.'?'.http_build_query($get).'"><span aria-hidden="true">&laquo;</span><span class="sr-only">Eerste</span></a></li>';
  }
  if($hasPrevious){
    $get['page'] = $page-1;
    $out .= '<li><a href="'.$pageLink.'?'.http_build_query($get).'"><span aria-hidden="true">&lsaquo;</span><span class="sr-only">Vorige</span></a></li>';
  }else{
    $out .= '<li class="disabled"><a href="#"><span aria-hidden="true">&lsaquo;</span><span class="sr-only">Vorige</span></a></li>';
  }

  // Start twee pagina's terug, ga TOT 3 verder
  $start = $page - 2;
  $end = $page + 3;
  for($i = $start;$i < $end;$i++){
    if($i == $page){
      $out .= '<li class="active"><a href="'.$pageLink.'?'.http_build_query($get).'">'.($i+1).' <span class="sr-only">(huidige)</span></a></li>';
    }else{
      if($i >= 0 && $i*$size < $totalSize){
        $get['page'] = $i;
        $out .= '<li><a href="'.$pageLink.'?'.http_build_query($get).'">'.($i+1).'</a></li>';
      }
    }
  }

  if($hasNext){
    $get['page'] = $page+1;
    $out .= '<li><a href="'.$pageLink.'?'.http_build_query($get).'"><span aria-hidden="true">&rsaquo;</span><span class="sr-only">Volgende</span></a></li>';
  }else{
    $out .= '<li class="disabled"><a href="#"><span aria-hidden="true">&rsaquo;</span><span class="sr-only">Volgende</span></a></li>';
  }
  if($page != ceil($totalSize/$size)){
    $get['page'] = ceil($totalSize/$size);
    $out .= '<li><a href="'.$pageLink.'?'.http_build_query($get).'"><span aria-hidden="true">&raquo;</span><span class="sr-only">Laatste</span></a></li>';
  }

  $out .= '  </ul>';
  $out .= '</nav>';
  return $out;
}

?>