<?php
require_once('inc/config.php');  
beginPage('', false);
?>
<div class="welcome">
  <div class="row">
      <div class="col-md-4">
          <div class="panel panel-default trans">
              <div class="panel-body">
                  <a href="namen.php">
                      <div class="icontext">
                          <h1 class="text-center"><span class="glyphicon glyphicon-user"></span></h1>
                          <h4 class="text-center"><span>Onderzoek a.h.v. namen</span></h4>
                      </div>
                  </a>
              </div>
          </div>
      </div>
      <div class="col-md-4">
          <div class="panel panel-default trans">
              <div class="panel-body">
                  <a href="plaatsen.php">
                      <div class="icontext">
                          <h1 class="text-center"><span class="glyphicon glyphicon-screenshot"></span></h1>
                          <h4 class="text-center"><span>Onderzoek a.h.v. plaatsen</span></h4>
                      </div>
                  </a>
              </div>
          </div>
      </div>
      <div class="col-md-4">
          <div class="panel panel-default trans">
              <div class="panel-body">
                  <a href="lading.php">
                      <div class="icontext">
                          <h1 class="text-center"><span class="glyphicon glyphicon-random"></span></h1>
                          <h4 class="text-center"><span>Onderzoek a.h.v. lading per jaar</span></h4>
                      </div>
                  </a>
              </div>
          </div>
      </div>
  </div>
</div>
<?php
endPage();
?>