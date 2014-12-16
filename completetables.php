<?php
require_once('inc/config.php');
$_loadChosen = true;
beginPage('Paalgeld Europa - Complete tables', true, 'Get into the data');
?>
<div class="row">
        <div class="col-md-12">
        <p>
        Select a table to view below.
        </p><br/>
    </div>
    <div class="col-md-6">
        <a href="table_captains.php" type="button" class="btn btn-default"><span class="glyphicon glyphicon-user"></span> View the Names table</a><br/><br/>
        <a href="table_ports.php" type="button" class="btn btn-default"><span class="glyphicon glyphicon-screenshot"></span> View the Ports table</a><br/><br/>
        <a href="table_cargoes.php" type="button" class="btn btn-default"><span class="glyphicon glyphicon-random"></span> View the Cargoes table</a><br/><br/>
        <a href="table_arrivals.php" type="button" class="btn btn-default"><span class="glyphicon glyphicon-flag"></span> View the Arrivals table</a><br/><br/>
        <a href="table_date.php" type="button" class="btn btn-default"><span class="glyphicon glyphicon-time"></span> View the Date table</a>
    </div>
</div>
<?php
endPage();
?>