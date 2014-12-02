<?php
require_once('inc/config.php');
$_loadChosen = true;
beginPage('Paalgeld Europa - Plaatsen', true, 'Onderzoek a.h.v. plaatsen');
?>
<form class="form-horizontal" role="form" action="plaatsenresult.php" method="POST">
                          <div class="form-group">
                            <label for="inputGebied" class="col-sm-2 control-label">Regio</label>
                            <div class="col-sm-10">
                            <select name="inputRegio" data-placeholder="Kies &eacute;&eacute;n or meerdere Regio(s)" class="chosen-select" multiple style="width:350px;" tabindex="4">
                            </select>
                          </div>
                            </div>
                          <div class="form-group">
                            <label for="inputLand" class="col-sm-2 control-label">Land</label>
                            <div class="col-sm-10">
                            <select name="inputLand" data-placeholder="Kies &eacute;&eacute;n or meerdere Land(en)" class="chosen-select" multiple style="width:350px;" tabindex="4">
                            </select>
                          </div>
                            </div>
                            <div class="form-group">
                            <label for="inputPlaats" class="col-sm-2 control-label">Plaats</label>
                            <div class="col-sm-10">
                            <select name="inputPlaats" data-placeholder="Kies &eacute;&eacute;n or meerdere Plaats(en)" class="chosen-select" multiple style="width:350px;" tabindex="4">
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