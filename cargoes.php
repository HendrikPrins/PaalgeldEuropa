<?php
require_once('inc/config.php');
$_loadChosen = true;
beginPage('Paalgeld Europa - Analyse', true, 'Analyse by comparing two cargoes');

    //Initialize variables
    $type = $_GET['type'];
?>

<?php

if ($type == 'port'||$type == 'area'||$type =='country'){
?>

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info" role="alert">
            <b>Explanation</b> Choose two cargoes to compare the total tax rate. You can also compare a specifc place and/or period.
        </div>
    </div>
</div>
<script src="js/parsley.min.js"></script>
<form class="form-horizontal" role="form" action="cargoesresult.php" method="get" data-parsley-validate>
    <div class="form-group">
        <label for="inputLand" class="col-sm-2 control-label">Cargo 1</label>
        <div class="col-sm-10">
            <select name="cargoOne" data-placeholder="Choose one cargo" class="chosen-select" style="width:350px;" tabindex="2" required>
            <option value="">Choose one cargo</option>
            <?php
                $query = "SELECT distinct(cargo) FROM cargo ORDER BY cargo";
                $res = $_db->query($query);
                if($res != null || $res->num_rows > 0){
                  while($row = $res->fetch_assoc()){
					$cargo = urlencode($row['cargo']);
                    echo '<option value='.$cargo.'>'.$row['cargo'].'</option>';
                    }
                }
            ?>
          </select>
        </div>
    </div>
    <div class="form-group">
        <label for="inputLand" class="col-sm-2 control-label">Cargo 2</label>
        <div class="col-sm-10">
            <select name="cargoTwo" data-placeholder="Choose a second cargo" class="chosen-select" style="width:350px;" tabindex="2" required>
            <option value="">Choose a second cargo</option>
            <?php
                $query = "SELECT distinct(cargo) FROM cargo ORDER BY cargo";
                $res = $_db->query($query);
                if($res != null || $res->num_rows > 0){
                  while($row = $res->fetch_assoc()){
					$cargo = urlencode($row['cargo']);
                    echo '<option value='.$cargo.'>'.$row['cargo'].'</option>';
                    }
                }
            ?>
          </select>
        </div>
    </div>
<?php
}
if ($type == 'country'){
?>
    
<div class="form-group">
    <label for="inputLand" class="col-sm-2 control-label">Country</label>
	<div class="col-sm-10">
        <select name="country" data-placeholder="Choose a country" class="chosen-select" style="width:350px;" tabindex="2">
            <option value="">Choose a country</option>
            <?php
                $query = "SELECT * FROM ports WHERE arrivalCount > 0 GROUP BY countryNow";
				$res = $_db->query($query);
				if($res != null || $res->num_rows > 0){
					while($row = $res->fetch_assoc()){
						$country = urlencode($row['countryNow']);
						echo '<option value='.$country.'>'.$row['countryNow'].'</option>';
					}
				}
            ?>
        </select>
    </div>
  </div>
    
<?php
}
if ($type == 'area'){
?>
    
<div class="form-group">
    <label for="inputLand" class="col-sm-2 control-label">Area</label>
    <div class="col-sm-10">
        <select name="area" data-placeholder="Choose a area" class="chosen-select" style="width:350px;" tabindex="2">
            <option value="">Choose a area</option>
            <?php
                $query = "SELECT * FROM portAreas ORDER BY area";
                $res = $_db->query($query);
                if($res != null || $res->num_rows > 0){
                    while($row = $res->fetch_assoc()){
                        echo '<option value='.$row['areaCode'].'>'.$row['area'].'</option>';
                }
                }
            ?>
        </select>
    </div>
</div>
    
<?php
}
if ($type == 'port'){
?>

<div class="form-group">
    <label for="inputLand" class="col-sm-2 control-label">Port</label>
    <div class="col-sm-10">
        <select name="port" data-placeholder="Choose a port" class="chosen-select" style="width:350px;" tabindex="2">
            <option value="">Choose a port</option>
            <?php
                $query = "SELECT * FROM ports ORDER BY portName";
                $res = $_db->query($query);
                if($res != null || $res->num_rows > 0){
                    while($row = $res->fetch_assoc()){
                        echo '<option value='.$row['portCode'].'>'.$row['portName'].'</option>';
                }
                }
            ?>
        </select>
    </div>
</div>

<?php
}
if ($type == 'port'||$type == 'area'||$type =='country'){
?>

<div class="form-group">
    <label for="inputStartDate" class="col-sm-2 control-label">Period</label>
    <div class="col-md-2">
    <input type="text" maxlength="4" min="1742" max="1787" class="form-control" name="inputStartDate" placeholder="Start Year" data-parsley-maxlength="4" data-parsley-type="digits">
    </div>
    <div class="col-md-2">
    <input type="text" maxlength="4" min="1742" max="1787" class="form-control" name="inputEndDate" placeholder="End Year" data-parsley-maxlength="4" data-parsley-type="digits">
    </div>
    </div>
    
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Research</button>
    </div>
</div>
</form>
<?php
}
if ($type !=='port'&& $type !=='area' && $type !=='country'){
?>
<div class="row">
        <div class="col-md-12">
        <p>
        Select your analysis method below.
        </p><br/>
    </div>
    <div class="col-md-6">
        <a href="cargoes.php?type=country" type="button" class="btn btn-default">Analyse using Countries</a><br/><br/>
		<a href="cargoes.php?type=area" type="button" class="btn btn-default">Analyse using Areas</a><br/><br/>
        <a href="cargoes.php?type=port" type="button" class="btn btn-default">Analyse using Ports</a>
    </div>
</div>

<?php
}
?>
<?php
endPage();
?>