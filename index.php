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
                              <p>This project bridges the gap between the raw data of the Paalgeld-registers and the ease 
                                of finding the data you wish to have. Along with Paalgeld West-Indië en Lastgeld this project 
                                was about making a web-application to facilitate that functionallity.
                                Created with a team of 14, this project was created for the course 
                                <a href="http://www.rug.nl/ocasys/let/vak/show?code=LIX021B05">Database driven Webtechnology"</a> 
                                at the <a href="http://www.rug.nl/">University of Groningen</a>.</p>
                              <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                            </div>
                            <div class="col-md-4">
                              <h3>How to use the website</h3>
                              <p>Donec id elit non mi porta gravida at eget metus. 
                                Fusce dapibus, tellus ac cursus commodo, 
                                tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. 
                                Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                              <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                           </div>
                            <div class="col-md-4">
                              <h3>Background information</h3>
                              <p>The Paalgeld was a task levied on incoming ships coming from the “high seas” into the port of Amsterdam. 
                                The purpose of this beaconage was to pay for the maintenance of buoys in the Zuiderzee: 
                                shallow waters were marked by poles, hence the name of the tax Paalgeld, which means “pole tax”.  
                                Taxes like the Paalgeld were levied all along the coast of the Zuiderzee, 
                                North Sea and in the Baltic Area.</p>
                              <p><a class="btn btn-default" href="background_info.php" role="button">View details &raquo;</a></p>
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
                            <img src="img/logo-db1-cut.png" alt="..." class="img-rounded">
                            <div class="caption">
                              <a href="../"><h3>Main page</h3></a>
                              <p>An overview of all the project's pages.</p>
                            </div>
                          </div>
                        </div>
                          <div class="col-md-3">
                          <div class="thumbnail">
                            <img src="..." alt="..." class="img-rounded">
                            <div class="caption">
                              <a href="../paalgeld_win"><h3>West Indie</h3></a>
                              <p>Go to the web-application of the Paalgeld West Indië project.</p>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="thumbnail">
                            <img src="..." alt="..." class="img-rounded">
                            <div class="caption">
                              <a href="../lastgeld/"><h3>Lastgeld</h3></a>
                              <p>Go to the web-application of the Lastgeld project.</p>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="thumbnail">
                            <img src="img/apple/touch-icon-ipad-retina.png" alt="..." class="img-rounded">
                            <div class="caption">
                              <a href="../paalgeld_weu"><h3>Europa</h3></a>
                              <p>Go to the web-application of the Paalgeld Europa project.</p>
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
                            <h2>Contact us</h2>
                            <p>Ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                        </div>
                    </div>
                </div>
            </div>

<?php
endPage();
?>