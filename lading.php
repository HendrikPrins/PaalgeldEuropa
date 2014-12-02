<?php
require_once('inc/config.php');
beginPage('Paalgeld Europa - Lading', true, 'Onderzoek a.h.v. lading');
?>
 <form class="form-horizontal" role="form" action="ladingresult.php" method="POST" >
                          <div class="form-group">
                            <label for="inputLading" class="col-sm-2 control-label">Lading</label>
                            <div class="col-sm-10">
                            <select name="inputLading" data-placeholder="Kies één or meerdere ladingen" class="chosen-select" multiple style="width:350px;" tabindex="4">
                                <option value=""></option>
                                <option value='Houwelen'>Houwelen</option>
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