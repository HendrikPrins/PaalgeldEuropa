<?php
require_once('inc/config.php');
beginPage('Paalgeld Europa - Plaatsen', true, 'Onderzoek a.h.v. plaatsen');
?>
<form class="form-horizontal" role="form" action="plaatsenresult.php" method="POST">
                          <div class="form-group">
                            <label for="inputGebied" class="col-sm-2 control-label">Regio</label>
                            <div class="col-sm-10">
                            <select name="inputRegio" data-placeholder="Kies één or meerdere Regio(s)" class="chosen-select" multiple style="width:350px;" tabindex="4">
                                <option value=""></option>
                                <option value='The Baltic'>The Baltic</option><option value='North Sea (German/Danish coast)'>North Sea (German/Danish coast)</option><option value='Arctic (Archangel, Murmansk)'>Arctic (Archangel, Murmansk)</option><option value='Norway'>Norway</option><option value='Great Britain'>Great Britain</option><option value='Atlantic Coasts of France Spain and Portugal'>Atlantic Coasts of France Spain and Portugal</option><option value='The Mediterranean'>The Mediterranean</option><option value='Far East'>Far East</option><option value='Iceland, Faroer, Green Land and Davis Straits'>Iceland, Faroer, Green Land and Davis Straits</option><option value='Africa outside the Mediterranean'>Africa outside the Mediterranean</option><option value='West Indies'>West Indies</option><option value='North America'>North America</option><option value='South America'>South America</option><option value='Central America'>Central America</option><option value='Unknown'>Unknown</option><option value='Dutch Republic'>Dutch Republic</option>
                            </select>
                          </div>
                            </div>
                          <div class="form-group">
                            <label for="inputLand" class="col-sm-2 control-label">Land</label>
                            <div class="col-sm-10">
                            <select name="inputLand" data-placeholder="Kies één or meerdere Land(en)" class="chosen-select" multiple style="width:350px;" tabindex="4">
                                <option value=""></option>
                                <option value='Denmark'>Denmark</option>
                            </select>
                          </div>
                            </div>
                            <div class="form-group">
                            <label for="inputPlaats" class="col-sm-2 control-label">Plaats</label>
                            <div class="col-sm-10">
                            <select name="inputPlaats" data-placeholder="Kies één or meerdere Plaats(en)" class="chosen-select" multiple style="width:350px;" tabindex="4">
                                <option value=""></option>
                                <option value='Unknown'>Unknown</option>
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