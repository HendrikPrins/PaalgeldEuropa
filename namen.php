<?php
require_once('inc/config.php');
$_loadChosen = true;
beginPage('Paalgeld Europa - Namen', true, 'Onderzoek a.h.v. namen');
?>
<form class="form-horizontal" role="form" action="namenresult.php" method="post">
                          <div class="form-group">
                            <label for="inputname" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputName" placeholder="Name">
                            </div>
                            </div>
                            <div class="form-group">
                            <label for="checkSearch" class="col-sm-2 control-label">Search Exact</label>
                            <div class="col-sm-10">
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox"> I want to search exact
                                </label>
                              </div>
                            </div>
                            </div>
                            <div class="form-group">
                            <label for="inputStartDate" class="col-sm-2 control-label">Date</label>
                            <div class="col-xs-2">
                            <input type="date" min="1742-01-01" max="1787-12-31" class="form-control" id="inputStartDate" placeholder="Start">
                            </div>
                            <div class="col-xs-2">
                            <input type="date" min="1742-01-01" max="1787-12-31" class="form-control" id="inputEndDate" placeholder="End">
                            </div>
                            </div>
                            <div class="form-group">
                              <label for="inputPlaats" class="col-sm-2 control-label">Place of departure</label>
                                <div class="col-sm-10">
                                  <select name="inputPlaats" data-placeholder="Choose a place" class="chosen-select" style="width:350px;" tabindex="2">
                                    <?php
                                    $query = "SELECT departurePort FROM paalgeldEur GROUP BY departurePort ORDER BY departurePort";
                                    $res = $_db->query($query);
                                      while($row = $res->fetch_array()){
                                        echo '<option value='.$row['departurePort'].'>'.$row['departurePort'].'</option>';
                                        }
                                    ?>  
                                  </select>
                                </div>
                              </div>
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Onderzoek</button>
                        </div>
                        </div>
                        </form>
<?php
endPage();
?>
