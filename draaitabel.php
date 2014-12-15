<?php
require('inc/config.php');
$_loadGoogleCharts = true;
$_loadChosen = true;
beginPage();
$restrictions = array();
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

if(isset($_GET['cargo']) && strlen($_GET['cargo']) > 0){
  $query .= " AND cargo = '".$_db->real_escape_string($_GET['cargo'])."'";
  $restrictions[] = 'cargo = '.$_GET['cargo'];
}
if(isset($_GET['fullNameCaptain']) && strlen($_GET['fullNameCaptain']) > 0){
  $query .= " AND fullNameCaptain like '".$_GET['fullNameCaptain']."'";
  $restrictions[] = 'captain ~ '.$_GET['fullNameCaptain'];
}
if(isset($_GET['startDate']) && strlen($_GET['startDate']) > 0 && isset($_GET['endDate']) && strlen($_GET['endDate']) > 0){
   $query .= " AND year(date) BETWEEN '".$_GET['startDate']."' AND '".$_GET['endDate']."'";
   $restrictions[] = 'date between '.$_GET['startDate'].' and '.$_GET['endDate'];
}elseif(isset($_GET['startDate']) && strlen($_GET['startDate']) > 0){
   $query .= " AND year(date) > '".$_GET['startDate']."'";
   $restrictions[] = 'date > '.$_GET['startDate'];
}elseif(isset($_GET['endDate']) && strlen($_GET['endDate']) > 0){
   $query .= " AND year(date) < '".$_GET['endDate']."'";
   $restrictions[] = 'date < '.$_GET['endDate'];
}
if(isset($_GET['portCode']) && strlen($_GET['portCode']) > 0){
  $query .= " AND ports.portCode = '".$_GET['portCode']."'";
  $restrictions[] = 'departure place = '.$_GET['portCode'];
}
$query .= " GROUP BY year(date)";
echo '<code>'.$query.'</code>';
$res = $_db->query($query);
$success = ($res != null && $res->num_rows > 0);
if($success){
  $chartData = array(array('Year','Frequency'));
  while($row = $res->fetch_assoc()){
    $chartData[] = array($row['year']*1, $row['value']*1);
  }
  $chartData = json_encode($chartData);
}

?>
<div class="row">
  <form class="form-horizontal col-md-8" role="form" action="draaitabel.php" method="get">
    <div class="form-group">
      <label class="control-label col-sm-3" for="mode">Value mode</label>
      <div class="col-sm-6">
        <select name="mode" data-placeholder="mode" class="form-control" style="width:350px;">
            <option value="count" <?php echo (isset($_GET['mode']) && $_GET['mode'] == 'count' ? 'selected="selected"' : '');?>>count</option>
            <option value="sum" <?php echo (isset($_GET['mode']) && $_GET['mode'] == 'sum' ? 'selected="selected"' : '');?>>sum tax</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="cargo">Cargo</label>
      <div class="col-sm-6">
      <select name="cargo" data-placeholder="Cargo" class="chosen-select" style="width:350px;">
            <option value="">Cargo</option>
            <?php
                $query = "SELECT DISTINCT cargo FROM cargo ORDER BY cargo";
                $res = $_db->query($query);
                if($res != null || $res->num_rows > 0){
                    while($row = $res->fetch_assoc()){
                        echo '<option value="'.$row['cargo'].'"'.(isset($_GET['cargo']) && $_GET['cargo'] == $row['cargo'] ? ' selected="selected"' : '').'>'.$row['cargo'].'</option>';
                    }
                }
            ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="portCode">Departure place</label>
      <div class="col-sm-6">
      <select name="portCode" data-placeholder="Choose one port" class="chosen-select" style="width:350px;" tabindex="2">
            <option value="">Choose one port</option>
            <?php
                $query = "SELECT * FROM ports ORDER BY portName";
                $res = $_db->query($query);
                if($res != null || $res->num_rows > 0){
                    while($row = $res->fetch_assoc()){
                        echo '<option value="'.$row['portCode'].'"'.(isset($_GET['portCode']) && $_GET['portCode'] == $row['portCode'] ? ' selected="selected"' : '').'>'.$row['portName'].'</option>';
                    }
                }
            ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="fullNameCaptain">Full name captain</label>
      <div class="col-sm-6">
        <input type="text" name="fullNameCaptain" id="fullNameCaptain" class="form-control" placeholder="Full name captain" value="<?php echo (isset($_GET['fullNameCaptain']) ? $_GET['fullNameCaptain'] : '') ?>" />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="startDate">Start date</label>
      <div class="col-sm-6">
        <input type="number" maxlength="4" min="1742" max="1787" name="startDate" id="startDate" class="form-control" placeholder="Start date" value="<?php echo (isset($_GET['startDate']) ? $_GET['startDate'] : '') ?>" />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="endDate">End date</label>
      <div class="col-sm-6">
        <input type="number" maxlength="4" min="1742" max="1787" name="endDate" id="endDate" class="form-control" placeholder="End date" value="<?php echo (isset($_GET['endDate']) ? $_GET['endDate'] : '') ?>" />
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-3 col-sm-6">
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
  chart.draw(data, {pointSize: 5, title: 'Draaitabel', hAxis: {title: 'Year', format:'#'},
      vAxis: {title: 'Frequency'}});
}
</script>
<?php
}
echo '<h5>Restrictions: '.implode(', ', $restrictions).'</h5>';
?>
<div class="row">
  <div id="activityChart" class="col-md-6" style="height:400px;">
    <div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> No results</div>
  </div>
</div>
<?php

endPage();
?>
