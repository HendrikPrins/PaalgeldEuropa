<?php
require_once('inc/config.php');
beginPage('Paalgeld Europa - Namen', true, 'Onderzoek a.h.v. namen');
?>
<form class="form-horizontal" role="form" action="namenresult.php" method="post">
                          <div class="form-group">
                            <label for="inputAchternaam" class="col-sm-2 control-label">Achternaam</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputAchternaam" placeholder="Achternaam">
                          </div>
                            </div>
                          <div class="form-group">
                            <label for="inputVoornaam" class="col-sm-2 control-label">Voornaam</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputVoornaam" placeholder="Voornaam">
                          </div>
                            </div>
                            <div class="form-group">
                            <label for="inputDatum" class="col-sm-2 control-label">Datum</label>
                            <div class="col-xs-2">
                            <input type="date" class="form-control" id="inputBegindatum" placeholder="Begin">
                            </div>
                            <div class="col-xs-2">
                            <input type="date" class="form-control" id="inputEinddatum" placeholder="Eind">
                            </div>
                            </div>
                            <div class="form-group">
                            <label for="inputPlaatsvertrek" class="col-sm-2 control-label">Plaats van vertrek</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputPlaatsvertrek" placeholder="Plaats">
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