<?php
require_once('inc/config.php');
$_loadChosen = true;
beginPage('Paalgeld Europa - Names', true, 'Research based on names');
?>
<form class="form-horizontal" role="form" action="namenresult.php" method="get">
                          <div class="form-group">
                            <label for="inputname" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputName" placeholder="Name">
                            </div>
                            </div>
                            <div class="form-group">
                            <label for="inputStartDate" class="col-sm-2 control-label">Year</label>
                            <div class="col-xs-2">
                            <input type="number" maxlength="4" min="1742" max="1787" class="form-control" name="inputStartDate" placeholder="Start Year">
                            </div>
                            <div class="col-xs-2">
                            <input type="number" maxlength="4" min="1742" max="1787" class="form-control" name="inputEndDate" placeholder="End Year">
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
                        <button type="submit" class="btn btn-default">Research</button>
                        </div>
                        </div>
                        </form>
<?php
endPage();
?>
