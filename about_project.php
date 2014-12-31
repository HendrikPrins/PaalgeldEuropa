<?php
require_once('inc/config.php');
$_loadChosen = false;
beginPage('', false);
?>
<div class ="aboutproj">
	<div class ="container">
		<h2>About the Project</h2>
		<div class="row">
			<div class="col-md-12">
				<p>
                  The Paalgeld-registers exist of portbooks covering the periods 1742, a single year, 
					1771 to 1810, 1814 to 1828, and 1830 to 1836. These portbooks consist of two parts: 
					the first concerns the European trade of Amsterdam and the second part concerns the trade 
					with the area that was under the monopoly of the Dutch West India Company 
					(i.e. the Americas, and the west coast of Africa). 
				</p>
				
				<p>
					The books inform us of the name of the ships, the captain's name, the cargo of the ships and the tax paid per cargo, and 
					the harbour the ship sailed from. One can search on ship name, captain name, cargo, departing harbour and period. 
               </p>   
			</div>
		</div>
	</div>
</div>
<?php
endPage();
?>