<?php
require_once('inc/config.php');
$_loadGoogleCharts = true;
beginPage('Paalgeld Europa - Charttest', true, '');

// Maak een array met de data
$jsArray = array();
// Eerste rij de namen
$jsArray[] = array('Date',  'Count', 'Count');
// Daarna de data: x-as, y-as 1, y-as 2
for ($i =0; $i < 10; $i++){
  $jsArray[] = array($i."", $i*$i, $i*$i*$i);
}
// PHP array naar javascript array
$jsArray = json_encode($jsArray);


?>
<script type="text/javascript">
    // Laad de visualization API
    google.load("visualization", "1", {packages:["corechart"]});
    // Teken als het is geladen
    google.setOnLoadCallback(drawCharts);
    function drawCharts(){
      // Zet de data om naar een DataTable
      var data = new google.visualization.arrayToDataTable(<?php echo $jsArray ?>);
      // Maak een LineChart
      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      // Teken de chart met de data en bepaalde opties
      chart.draw(data, {title: 'Test Chart', curveType: 'function'});
    }
</script>
<!-- De div waar de chart in komt -->
<div id="chart_div"></div>

<?php
endPage();
?>