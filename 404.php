<?php
require_once('inc/config.php');
$_loadChosen = false;
beginPage('',false);
?>
<div class="page404">
	<div class="container">
			<div class="center-block">
			<h1>404</h1>
			<p>Page not found</p>
				<a class="btn btn-default btn-lg" href="index.php" role="button">Go home</a>
		</div>
	</div>
</div>

<?php
endPage();
?>

