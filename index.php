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
                        <div class="text-center">
                          <h1><span class="glyphicon glyphicon-user"></span></h1>
                          <h4><span>Onderzoek a.h.v. namen</span></h4>
                          <div class="icon-desc">
                            <p class="small">Find your ancestors here</p>
                          </div>
                        </div>
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
                        <div class="text-center">
                          <h1><span class="glyphicon glyphicon-screenshot"></span></h1>
                          <h4><span>Onderzoek a.h.v. plaatsen</span></h4>
                          <div class="icon-desc">
                              <p class="small">Get an overview of selected ports</p>
                          </div>
                        </div>
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
                        <div class="text-center">
                          <h1><span class="glyphicon glyphicon-random"></span></h1>
                          <h4><span>Onderzoek a.h.v. lading per jaar</span></h4>
                          <div class="icon-desc">
                            <p class="small">View cargo data from ships</p>
                          </div>
                        </div>
                      </div>
                  </a>
              </div>
          </div>
      </div>
  </div>
</div>
<div class="info">
                <div class="container">
                    <h2>Paalgeld Europa</h2>
                        <div class="row">
                            <div class="col-md-4">
                              <h3>About the Website</h3>
                              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                              <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                            </div>
                            <div class="col-md-4">
                              <h3>About the assignment</h3>
                              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                              <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                           </div>
                            <div class="col-md-4">
                              <h3>Something else here</h3>
                              <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                              <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="info2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Some more content here</h2>
                            <p>Ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                        </div>
                    </div>
                </div>
            </div>
<?php
endPage();
?>