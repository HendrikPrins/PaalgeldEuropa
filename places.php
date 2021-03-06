<?php
require_once('inc/config.php');
$_loadChosen = true;
beginPage('Paalgeld Europa - Analyse', true, 'Analyse by comparing two places');

    //Initialize variables
    $type = $_GET['type'];
?>
	
<?php

if ($type == 'port'||$type == 'area'||$type =='country'){
?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info" role="alert">
            <b>Explanation</b> Choose two places to compare the total tax rate. You can also compare a specifc cargo and/or period.
        </div>
    </div>
</div>
<?php
}
?>
<script src="js/parsley.min.js"></script>
<form class="form-horizontal" role="form" action="placesresult.php" method="get" data-parsley-validate>   

<?php
	
	if ($type == 'country'){

?>
    
    <div class="form-group">
		<label for="inputLand" class="col-sm-2 control-label">Country 1</label>
		<div class="col-sm-10">
			<select name="countryOne" data-placeholder="Choose one country" class="chosen-select" style="width:350px;" tabindex="2" required>
				<option value="">Choose one country</option>
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
	<div class="form-group">
		<label for="inputLand" class="col-sm-2 control-label">Country 2</label>
		<div class="col-sm-10">
			<select name="countryTwo" data-placeholder="Choose a second country" class="chosen-select" style="width:350px;" tabindex="2" required>
				<option value="">Choose a second country</option>
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
		<label for="inputLand" class="col-sm-2 control-label">Area 1</label>
		<div class="col-sm-10">
			<select name="areaOne" data-placeholder="Choose one area" class="chosen-select" style="width:350px;" tabindex="2" required>
				<option value="">Choose one area</option>
				<?php
					$query = "SELECT portAreas.* FROM portAreas, ports WHERE ports.areaCode = portAreas.areaCode AND ports.arrivalCount > 0 GROUP BY ports.areaCode ORDER BY area";
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
	<div class="form-group">
		<label for="inputLand" class="col-sm-2 control-label">Area 2</label>
		<div class="col-sm-10">
			<select name="areaTwo" data-placeholder="Choose a second area" class="chosen-select" style="width:350px;" tabindex="2" required>
				<option value="">Choose a second area</option>
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
    <label for="inputLand" class="col-sm-2 control-label">Port 1</label>
    <div class="col-sm-10">
        <select name="portOne" data-placeholder="Choose one port" class="chosen-select" style="width:350px;" tabindex="2" required>
            <option value="">Choose one port</option>
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
<div class="form-group">
    <label for="inputLand" class="col-sm-2 control-label">Port 2</label>
    <div class="col-sm-10">
        <select name="portTwo" data-placeholder="Choose a second port" class="chosen-select" style="width:350px;" tabindex="2" required>
            <option value="">Choose a second port</option>
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
    <label for="inputLand" class="col-sm-2 control-label">Cargo</label>
    <div class="col-sm-10">
      <select name="cargo" data-placeholder="Choose a cargo to compare" class="chosen-select" style="width:350px;" tabindex="2">
        <option value="">Choose a cargo to compare</option>
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
        <a href="places.php?type=country" type="button" class="btn btn-default">Analyse using Countries</a><br/><br/>
		<a href="places.php?type=area" type="button" class="btn btn-default">Analyse using Areas</a><br/><br/>
        <a href="places.php?type=port" type="button" class="btn btn-default">Analyse using Ports</a>
    </div>
</div>
<?php
}
?>
<?php
endPage();
?>