<?php
require_once('inc/config.php');
$_loadChosen = false;
beginPage('', false);
?>
<div class ="background">
	<div class ="container">
		<h2>Background Information</h2>
		<div class="row">
			<div class="col-md-4">
				<p>
					The Paalgeld was a task levied on incoming ships coming from the “high seas” into the port of Amsterdam. 
					The purpose of this beaconage was to pay for the maintenance of buoys in the Zuiderzee: 
					shallow waters were marked by poles, hence the name of the tax Paalgeld, which means “pole tax”.  
					Taxes like the Paalgeld were levied all along the coast of the Zuiderzee, North Sea and in the Baltic Area.
				</p>
				<p>
					In the fourteenth century the city of Kampen had the right to levy this tax in all Zuiderzee ports. 
					In 1527 this right was transferred to Amsterdam, but in 1573 the Prince of Orange granted this right to Enkhuizen, 
					which had chosen the side of the insurgence against the king of Spain, 
					while Amsterdam wavered to take the side of the insurgence. 
					Even after Amsterdam changed sides in 1578 Enkhuizen  kept the right to levy Paalgeld in all Dutch Zuydersea ports and held it until 1836
					, when the central government took over the task of maintenance of the sea routes.
				</p> 
             </div>
             <div class="col-md-4">
				<p>
					The administration of this taxed has not survived completely: 
					the yearly grand totals can be found in the administration of Enkhuizen, 
					but only the portbooks of Amsterdam have survived. 
                </p>
             
                <p>
                  These portbooks cover the periods 1742, a single year, 
					1771 to 1810, 1814 to 1828, and 1830 to 1836. 
               </p>
            
               <P>
                  These portbooks consist of two parts: 
					the first concerns the European trade of Amsterdam and the second part concerns the trade 
					with the area that was under the monopoly of the Dutch West India Company 
					(i.e. the Americas, and the west coast of Africa). The Dutch East India Company ships were not registered: 
					the company paid a fixed sum for every ship. This administration has not survived.
				</p>
             
				<p>
					All ships paid tax according to the amount or the value of the cargoes they carried. 
					Exempt from this rule were ships coming from London and Archangel, which paid fixed rates. 
               </p>   
             </div>
             <div class="col-md-4">
             	  <p>The cargoes of all other ships are registered in the portbooks. However, 
					the cargoes of the ships coming from the Americas and the west coast of Africa are not registered in the portbooks.
					We know the basis for computation of the Paalgeld, because it was published in a
					printed document, the Observantie van den ontfang van 't Paal-gelt. There are several
					versions of this alphabetic lists of products and the impost to be paid for them. The oldest
					printed list is from 1660 and there are lists from 1695, 1710 and 1747. They differ very little:
					there are only additions of new products.
				</p>
			</div>
		</div>
        <div class="row">
            <div class="md-col-12">
                <p><a class="btn btn-default" href="index.php#info" role="button">&laquo; Back</a></p>
            </div>
        </div>
	</div>
</div>
<?php
endPage();
?>