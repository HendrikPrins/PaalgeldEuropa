<?php
require('inc/config.php');
$_loadGoogleCharts = true;
$_loadChosen = true;
beginPage('Paalgeld Europa - Analyze', true, 'Analyse using a pivot table');
$restrictions = array();
// Alleen tekenen als het vanuit het formulier komt (draw is een hidden input)
if(isset($_GET['draw'])){
  if(isset($_GET['mode'])){
    if($_GET['mode'] == 'count'){
      $mode = 'COUNT(*)';
    }elseif($_GET['mode'] == 'sum'){
      $mode = 'SUM(taxGuilders)*500';
    }else{
      $mode = 'COUNT(*)';
    }
  }else{
    $mode = 'COUNT(*)';
  }
  $query = "SELECT ".$mode." AS value, year(date) AS `year` FROM cargo, paalgeldEur, ports WHERE ports.portCode = paalgeldEur.portCode AND cargo.idEur = paalgeldEur.idEur ";

  if(isset($_GET['cargo'])){
    $cargoes = array();
    foreach($_GET['cargo'] as $cargo){
      $cargoes[] = validate($cargo);
    }
    if(count($cargoes) > 1){
      $query .= " AND cargo IN('".implode('\',\'', $cargoes)."')";
      $restrictions[] = array('cargo', 'is any of', implode(', ', $cargoes));
    }elseif(count($cargoes) == 1){
      $query .= " AND cargo = '".$cargoes[0]."'";
      $restrictions[] = array('cargo', '=', $cargoes[0]);
    }
  }
  if(isset($_GET['fullNameCaptain']) && strlen($_GET['fullNameCaptain']) > 0){
    $query .= " AND fullNameCaptain like '".$_GET['fullNameCaptain']."'";
    $restrictions[] = array('captain', 'like', $_GET['fullNameCaptain']);
  }
  if(isset($_GET['startDate']) && strlen($_GET['startDate']) > 0 && isset($_GET['endDate']) && strlen($_GET['endDate']) > 0){
     $query .= " AND year(date) BETWEEN '".$_GET['startDate']."' AND '".$_GET['endDate']."'";
     $restrictions[] = array('date', 'between', $_GET['startDate'].' and '.$_GET['endDate']);
  }elseif(isset($_GET['startDate']) && strlen($_GET['startDate']) > 0){
     $query .= " AND year(date) > '".$_GET['startDate']."'";
     $restrictions[] = array('date', '>', $_GET['startDate']);
  }elseif(isset($_GET['endDate']) && strlen($_GET['endDate']) > 0){
     $query .= " AND year(date) < '".$_GET['endDate']."'";
     $restrictions[] = array('date', '<', $_GET['endDate']);
  }


  // Ports, areas or countries
  if(isset($_GET['portCode'])){
    $ports = array();
    foreach($_GET['portCode'] as $port){
      $ports[] = validate($port);
    }
  }
  if(isset($_GET['areaCode'])){
    $areas = array();
    foreach($_GET['areaCode'] as $area){
      $areas[] = validate($area);
    }
  }
  if(isset($_GET['countryNow'])){
    $countries = array();
    foreach($_GET['countryNow'] as $country){
      $countries[] = validate($country);
    }
  }

  $placeQueryParts = array();
  if(count($ports) > 1){
    $placeQueryParts[] = "ports.portCode IN('".implode('\',\'', $ports)."')";
    $restrictions[] = array('departure port', 'is any of', implode(', ', $ports));
  }elseif(count($ports) == 1){
    $placeQueryParts[] = "ports.portCode = '".$ports[0]."'";
    $restrictions[] = array('departure port', '=', $ports[0]);
  }
  if(count($areas) > 1){
    $placeQueryParts[] = "ports.areaCode IN('".implode('\',\'', $areas)."')";
    $restrictions[] = array('departure area', 'is any of', implode(', ', $areas));
  }elseif(count($areas) == 1){
    $placeQueryParts[] = "ports.areaCode = '".$areas[0]."'";
    $restrictions[] = array('departure area', '=', $areas[0]);
  }
  if(count($countries) > 1){
    $placeQueryParts[] = "ports.countryNow IN('".implode('\',\'', $countries)."')";
    $restrictions[] = array('departure country', 'is any of', implode(', ', $countries));
  }elseif(count($countries) == 1){
    $placeQueryParts[] = "ports.countryNow = '".$countries[0]."'";
    $restrictions[] = array('departure country', '=', $countries[0]);
  }

  if(count($placeQueryParts) > 0){
    $query .= ' AND ('.implode(' OR ', $placeQueryParts).')';
  }

  $query .= " GROUP BY year(date)";
  //echo '<code>'.$query.'</code>';
  $res = $_db->query($query);
  $success = ($res != null && $res->num_rows > 0);
  if($success){
    $chartData = array(array('Year',($mode == 'COUNT(*)' ? 'Frequency' : 'Total Tax')));
    while($row = $res->fetch_assoc()){
      $chartData[] = array($row['year']*1, $row['value']*1);
    }
    $chartData = json_encode($chartData);
  }
}else{
  $success = false;
}

?>
<div class="row">
  <form class="form-horizontal col-md-10" role="form" action="pivottable.php" method="get">
    <input type="hidden" name="draw" value="" />
    <div class="form-group">
      <label class="control-label col-sm-3" for="mode">Value mode</label>
      <div class="col-sm-5">
        <select name="mode" data-placeholder="mode" class="form-control" style="width:350px;">
            <option value="count" <?php echo (isset($_GET['mode']) && $_GET['mode'] == 'count' ? 'selected="selected"' : '');?>>Frequency</option>
            <option value="sum" <?php echo (isset($_GET['mode']) && $_GET['mode'] == 'sum' ? 'selected="selected"' : '');?>>Total tax</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="cargo">Cargo</label>
      <div class="col-sm-5">
      <select name="cargo[]" multiple="multiple" data-placeholder="Cargo" class="chosen-select" style="width:350px;">
            <option value="">Cargo</option>
            <?php
            $cargoes = array();
            if(isset($_GET['cargo'])){
              foreach($_GET['cargo'] as $cargo){
                $cargoes[] = validate($cargo);
              }
            }
            $res = $_db->query("SELECT DISTINCT cargo FROM cargo ORDER BY cargo");
            if($res != null || $res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                    echo '<option value="'.$row['cargo'].'"'.(in_array($row['cargo'], $cargoes) ? ' selected="selected"' : '').'>'.$row['cargo'].'</option>';
                }
            }
            ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="portCode">Port of departure</label>
      <div class="col-sm-5">
      <select name="portCode[]" multiple="multiple" data-placeholder="Choose one port" class="chosen-select" style="width:350px;" tabindex="2">
            <option value="">Choose one port</option>
            <?php
            $ports = array();
            if(isset($_GET['portCode'])){
              foreach($_GET['portCode'] as $port){
                $ports[] = validate($port);
              }
            }
            $res = $_db->query("SELECT * FROM ports WHERE arrivalCount > 0 ORDER BY portName");
            if($res != null || $res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                    echo '<option value="'.$row['portCode'].'"'.(in_array($row['portCode'], $ports) ? ' selected="selected"' : '').'>'.$row['portName'].'</option>';
                }
            }
            ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="areaCode">Area of departure</label>
      <div class="col-sm-5">
      <select name="areaCode[]" multiple="multiple" data-placeholder="Choose one area" class="chosen-select" style="width:350px;" tabindex="2">
            <option value="">Choose one area</option>
            <?php
            $areas = array();
            if(isset($_GET['areaCode'])){
              foreach($_GET['areaCode'] as $area){
                $areas[] = validate($area);
              }
            }
            $res = $_db->query("SELECT portAreas.area, portAreas.areaCode FROM portAreas, ports WHERE ports.areaCode = portAreas.areaCode AND ports.arrivalCount > 0 GROUP BY ports.areaCode ORDER BY area");
            if($res != null || $res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                    echo '<option value="'.$row['areaCode'].'"'.(in_array($row['areaCode'], $areas) ? ' selected="selected"' : '').'>'.$row['area'].'</option>';
                }
            }
            ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="countryNow">Country of departure</label>
      <div class="col-sm-5">
      <select name="countryNow[]" multiple="multiple" data-placeholder="Choose one country" class="chosen-select" style="width:350px;" tabindex="2">
            <option value="">Choose one country</option>
            <?php
            $countries = array();
            if(isset($_GET['countryNow'])){
              foreach($_GET['countryNow'] as $country){
                $countries[] = validate($country);
              }
            }
            $res = $_db->query("SELECT DISTINCT countryNow FROM ports WHERE arrivalCount > 0 ORDER BY countryNow");
            if($res != null || $res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                    echo '<option value="'.$row['countryNow'].'"'.(in_array($row['countryNow'], $countries) ? ' selected="selected"' : '').'>'.$row['countryNow'].'</option>';
                }
            }
            ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="fullNameCaptain">Full name captain</label>
      <div class="col-sm-5">
        <input type="text" name="fullNameCaptain" id="fullNameCaptain" class="form-control" placeholder="Full name captain" value="<?php echo (isset($_GET['fullNameCaptain']) ? $_GET['fullNameCaptain'] : '') ?>" />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="startDate">Period</label>
      <div class="col-sm-3">
        <input type="number" maxlength="3" min="1742" max="1787" name="startDate" id="startDate" class="form-control" placeholder="Start year" value="<?php echo (isset($_GET['startDate']) ? $_GET['startDate'] : '') ?>" />
      </div>
      <div class="col-sm-3">
        <input type="number" maxlength="3" min="1742" max="1787" name="endDate" id="endDate" class="form-control" placeholder="End year" value="<?php echo (isset($_GET['endDate']) ? $_GET['endDate'] : '') ?>" />
      </div>
    </div>
    <div class="col-sm-offset-3 col-sm-5">
      <div class="alert alert-info" role="alert">
            <b>Hint!</b> You can use wildcards for the name of the captain. Use <b>_</b> for one unknown position, or <b>%</b> for multiple positions.
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-3 col-sm-5">
        <button type="submit" class="btn btn-primary">Search</button>
      </div>
    </div>
  </form>
</div>
<?php
if($success){
?>
<script type="text/javascript">
// Laad de visualization API
google.load("visualization", "1", {packages:["corechart"]});
// Teken als het is geladen
google.setOnLoadCallback(drawCharts);
function drawCharts(){
  // Zet de data om naar een DataTable
  var data = new google.visualization.arrayToDataTable(<?php echo $chartData ?>);
  // Maak een LineChart
  var chart = new google.visualization.LineChart(document.getElementById('activityChart'));
  // Teken de chart met de data en bepaalde opties
  chart.draw(data, {pointSize: 5, title: 'Pivot Table', hAxis: {title: 'Year', format:'#'},
      vAxis: {title: '<?php echo ($mode == 'COUNT(*)' ? 'Frequency' : 'Total Tax');?>'}});
}
</script>
<?php
}

if(isset($_GET['draw'])){
    ?>
<div class="row">
  <div id="activityChart" class="col-md-9" style="height:500px;">
    <div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> No results</div>
  </div>
  <div class="col-md-3">
  <?php
  echo '<h5>Restrictions:</h5>';
  echo '<table class="table table-condensed">';
  foreach($restrictions as $restriction){
    echo '<tr><td>'.$restriction[0].'</td><td>'.$restriction[1].'</td><td>'.$restriction[2].'</td></tr>';
  }
  echo '</table>';
  ?>
  </div>
  <?php
  echo download_knop($query);
  }
  ?>
</div>
<?php
endPage();
?>
