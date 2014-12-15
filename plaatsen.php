<?php
require_once('inc/config.php');
$_loadChosen = true;
beginPage('Paalgeld Europa - Places', true, 'Onderzoek a.h.v. plaatsen');

    //Initialize variables
    $type = $_GET['type'];
?>

<form class="form-horizontal" role="form" action="plaatsenresult.php" method="POST">
    
<?php
if ($type == 'country'){
?>
    
    <div class="form-group">
    <label for="inputLand" class="col-sm-2 control-label">Country 1</label>
	<div class="col-sm-10">
        <select name="countryOne" data-placeholder="Choose one country" class="chosen-select" multiple style="width:350px;" tabindex="4">
            <?php
                $query = "SELECT * FROM portAreas ORDER BY countriesNow";
                $res = $_db->query($query);
                if($res != null || $res->num_rows > 0){
                    while($row = $res->fetch_assoc()){
                        echo '<option value='.$row['countriesNow'].'>'.$row['countriesNow'].'</option>';
                }
                }
            ?>
        </select>
    </div>
  </div>
<div class="form-group">
    <label for="inputLand" class="col-sm-2 control-label">Country 2</label>
    <div class="col-sm-10">
        <select name="countryTwo" data-placeholder="Choose a second country" class="chosen-select" multiple style="width:350px;" tabindex="4">
            <?php
                $query = "SELECT * FROM portAreas ORDER BY countriesNow";
                $res = $_db->query($query);
                if($res != null || $res->num_rows > 0){
                    while($row = $res->fetch_assoc()){
                        echo '<option value='.$row['countriesNow'].'>'.$row['countriesNow'].'</option>';
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
        <select name="countryOne" data-placeholder="Choose one area" class="chosen-select" multiple style="width:350px;" tabindex="4">
            <?php
                $query = "SELECT * FROM portAreas ORDER BY area";
                $res = $_db->query($query);
                if($res != null || $res->num_rows > 0){
                    while($row = $res->fetch_assoc()){
                        echo '<option value='.$row['area'].'>'.$row['area'].'</option>';
                }
                }
            ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="inputLand" class="col-sm-2 control-label">Area 2</label>
    <div class="col-sm-10">
        <select name="countryTwo" data-placeholder="Choose a second area" class="chosen-select" multiple style="width:350px;" tabindex="4">
            <?php
                $query = "SELECT * FROM portAreas ORDER BY area";
                $res = $_db->query($query);
                if($res != null || $res->num_rows > 0){
                    while($row = $res->fetch_assoc()){
                        echo '<option value='.$row['area'].'>'.$row['area'].'</option>';
                    }
                }
            ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="inputLand" class="col-sm-2 control-label">Cargo</label>
    <div class="col-sm-10">
      <select name="countryTwo" data-placeholder="Choose a cargo to compare" class="chosen-select" multiple style="width:350px;" tabindex="4">
        <?php
            $query = "SELECT distinct(cargo) FROM cargo ORDER BY cargo";
            $res = $_db->query($query);
            if($res != null || $res->num_rows > 0){
              while($row = $res->fetch_assoc()){
                echo '<option value='.$row['cargo'].'>'.$row['cargo'].'</option>';
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
        <select name="countryOne" data-placeholder="Choose one area" class="chosen-select" multiple style="width:350px;" tabindex="4">
            <?php
                $query = "SELECT * FROM ports ORDER BY portName";
                $res = $_db->query($query);
                if($res != null || $res->num_rows > 0){
                    while($row = $res->fetch_assoc()){
                        echo '<option value='.$row['portName'].'>'.$row['portName'].'</option>';
                }
                }
            ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="inputLand" class="col-sm-2 control-label">Port 2</label>
    <div class="col-sm-10">
        <select name="countryTwo" data-placeholder="Choose a second area" class="chosen-select" multiple style="width:350px;" tabindex="4">
            <?php
                $query = "SELECT * FROM portAreas ORDER BY area";
                $res = $_db->query($query);
                if($res != null || $res->num_rows > 0){
                    while($row = $res->fetch_assoc()){
                        echo '<option value='.$row['portName'].'>'.$row['portName'].'</option>';
                    }
                }
            ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="inputLand" class="col-sm-2 control-label">Cargo</label>
    <div class="col-sm-10">
      <select name="countryTwo" data-placeholder="Choose a cargo to compare" class="chosen-select" multiple style="width:350px;" tabindex="4">
        <?php
            $query = "SELECT distinct(cargo) FROM cargo ORDER BY cargo";
            $res = $_db->query($query);
            if($res != null || $res->num_rows > 0){
              while($row = $res->fetch_assoc()){
                echo '<option value='.$row['cargo'].'>'.$row['cargo'].'</option>';
                }
            }
        ?>
      </select>
    </div>
</div>

<?php
}
?>
    
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Onderzoek</button>
    </div>
</div>
</form>
<?php
endPage();
?>