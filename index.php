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
                          <h4><span>Search by captain name</span></h4>
                          <div class="icon-desc">
                            <p class="small">Find your ancestors</p>
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
                          <h4><span>Search by port name</span></h4>
                          <div class="icon-desc">
                              <p class="small">Get an overview of port arrivals</p>
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
                          <h4><span>Search by cargo</span></h4>
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
                              <h3>About the project</h3>
                              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                              <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                            </div>
                            <div class="col-md-4">
                              <h3>How to use the website</h3>
                              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                              <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                           </div>
                            <div class="col-md-4">
                              <h3>Extra information</h3>
                              <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                              <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                            </div>
                        </div>
                    </div>
            </div>

                        <!--<div class="info3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Content</h2>
                            <p>Ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                        </div>
                    </div>
                </div>
            </div>-->

                <div class="projlink">
                  <div class="container">
                  <h2>Project series</h2>
                  <p>This website is part of a series on historical shipping data</p>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="thumbnail">
                            <img src="..." alt="..." class="img-rounded">
                            <div class="caption">
                              <h3>Main page</h3>
                              <p>Lusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada.</p>
                            </div>
                          </div>
                        </div>
                          <div class="col-md-3">
                          <div class="thumbnail">
                            <img src="..." alt="..." class="img-rounded">
                            <div class="caption">
                              <h3>West Indie</h3>
                              <p>Tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Ligula porta felis euismod semper. Donec id elit non mi porta gravida at.</p>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="thumbnail">
                            <img src="..." alt="..." class="img-rounded">
                            <div class="caption">
                              <h3>Lastgeld</h3>
                              <p>Tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Ligula porta felis euismod semper. Donec id elit non mi porta gravida at.</p>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="thumbnail">
                            <img src="..." alt="..." class="img-rounded">
                            <div class="caption">
                              <h3>Europa</h3>
                              <p>Egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum sit.</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
            </div>
            <div class="info2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Contact us!</h2>
                            <p>Ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                        </div>
                    </div>
                </div>
            </div>

<?php
endPage();
?>