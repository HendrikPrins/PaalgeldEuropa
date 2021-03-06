<?php
require_once('inc/config.php');
$_loadChosen = true;
beginPage('Paalgeld Europa - Search', true, 'Search through the database finding Names');
?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info" role="alert">
            <b>Hint!</b> Don't know exactly how to spell a name? Or want to get results for multiple name variations? Use the % sign or the _ sign as a wildcard. _ replaces only one letter, % replaces any letter or letter combination and it can also be empty. Example: Jans%en will cover both Jansen and Janssen. Also, when you don't know the first name of a captain, use the % sign to get all the first names. Example: %jansen will cover every name that ends with jansen.
        </div>
    </div>
</div>
<script src="js/parsley.min.js"></script>
<form class="form-horizontal" role="form" action="captainsresult.php" method="get" data-parsley-validate>
  <div class="form-group">
    <label for="inputname" class="col-sm-2 control-label">Name</label>
    <div class="col-sm-10">
    <input type="text" class="form-control" name="inputName" placeholder="Full Name">
    </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <div class="checkbox">
                <label>
                  <input name="exact" value="yes" type="checkbox"> Strict search
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
    <label for="inputStartDate" class="col-sm-2 control-label">Period</label>
    <div class="col-xs-2">
    <input type="text" maxlength="4" min="1742" max="1787" class="form-control" name="inputStartDate" placeholder="Start Year" data-parsley-maxlength="4" data-parsley-type="digits">
    </div>
    <div class="col-xs-2">
    <input type="text" maxlength="4" min="1742" max="1787" class="form-control" name="inputEndDate" placeholder="End Year" data-parsley-maxlength="4" data-parsley-type="digits">
    </div>
    </div>
    <div class="form-group">
      <label for="inputPlaats" class="col-sm-2 control-label">Place of departure</label>
        <div class="col-sm-10">
          <select name="departurePlace" data-placeholder="Choose a place" class="chosen-select" style="width:350px;" tabindex="2">
            <option value="">Select a place</option>
            <?php
            $query = "SELECT departurePort, portCode FROM paalgeldEur GROUP BY departurePort ORDER BY departurePort";
            $res = $_db->query($query);
              while($row = $res->fetch_array()){
                echo '<option value="'.$row['portCode'].'">'.$row['departurePort'].'</option>';
                }
            ?>  
          </select>
        </div>
      </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
<button type="submit" class="btn btn-default">Search</button>
</div>
</div>
</form>
<?php
endPage();
?>
