<?php
require_once('inc/config.php');  
beginPage('', false);
?>
<div class="welcome">
  <div class="row">
      <div class="col-md-3">
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
      <div class="col-md-3">
          <div class="panel panel-default trans">
              <div class="panel-body">
                  <a href="plaatsen.php">
                      <div class="icontext">
                        <div class="text-center">
                          <h1><span class="glyphicon glyphicon-screenshot"></span></h1>
                          <h4><span>Analyse using places</span></h4>
                          <div class="icon-desc">
                              <p class="small">Compare two places using cargo</p>
                          </div>
                        </div>
                      </div>
                  </a>
              </div>
          </div>
      </div>
      <div class="col-md-3">
          <div class="panel panel-default trans">
              <div class="panel-body">
                  <a href="lading.php">
                      <div class="icontext">
                        <div class="text-center">
                          <h1><span class="glyphicon glyphicon-random"></span></h1>
                          <h4><span>Analyse using cargoes</span></h4>
                          <div class="icon-desc">
                            <p class="small">Compare two cargoes using places</p>
                          </div>
                        </div>
                      </div>
                  </a>
              </div>
          </div>
      </div>
      <div class="col-md-3">
          <div class="panel panel-default trans">
              <div class="panel-body">
                  <a href="draaitabel.php">
                      <div class="icontext">
                        <div class="text-center">
                          <h1><span class="glyphicon glyphicon-tasks"></span></h1>
                          <h4><span>Analyse using a pivot table</span></h4>
                          <div class="icon-desc">
                            <p class="small">Get nice graph views by combining data</p>
                          </div>
                        </div>
                      </div>
                  </a>
              </div>
          </div>
      </div>
  </div>
  <div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
          <div class="panel panel-default trans">
              <div class="panel-body">
                  <a href="completetables.php">
                      <div class="icontext">
                        <div class="text-center">
                          <h1><span class="glyphicon glyphicon-book"></span></h1>
                          <h4><span>Complete tables</span></h4>
                          <div class="icon-desc">
                            <p class="small">Get into the data</p>
                          </div>
                        </div>
                      </div>
                  </a>
              </div>
          </div>
      </div>
      <div class="col-md-4">
      </div>
  </div>
    <div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-4" id="info">
        <a href="#info">
          <div class="text-center">
              <br />
                <h2 style="color:white;">More information</h2>
                <span style="font-size:50px;" class="glyphicon glyphicon-chevron-down"></span>
          </div>
        </a>
      </div>
      <div class="col-md-4">
      </div>
  </div>
</div>

<div class="info">
                <div class="container">
                    <h2>Paalgeld Europa</h2>
                        <div class="row">
                            <div class="col-md-4">
                              <h3>About the project</h3>
                              <p>The goal of project Paalgeld Europa is to make the raw dataset of the Paalgeld-registers more accessible for academic and amateur research. With a main focus on usability and searchability, this web application employs user-friendly interfaces, predefined search categories, access to complete tables, and the option to download selected data in order to facilitate this goal. This project was realised by a team of 14 university students for the course 
                                <a href="http://www.rug.nl/ocasys/let/vak/show?code=LIX021B05">Database driven Webtechnology</a> 
                                at the <a href="http://www.rug.nl/">University of Groningen</a>.</p>
                              <p><a class="btn btn-default" href="about_project.php" role="button">View details &raquo;</a></p>
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
                            <div class="col-md-4">
                              <h3>How to use the website</h3>
                              <p>This website supplies information about all the shippings that arrived in Amsterdam during the year 1742 and the periods 1771 to 1810, 1814 to 1828, and 1830 to 1836. The information is based on tax administrations of the cargo of those ships. For more information about this history see Background Information.
                              Search is based on names, ports of departure, countries, cargo, name of captain, year and relations between. 
                              </p>                            
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
                              <h3>Main page</h3>
                              <p>This page gives an overview of the three projects.</p>
                               <p><a href="../" class="btn btn-default btn-sm" role="button">View this page &raquo;</a></p>
                            </div>
                          </div>
                        </div>
                          <div class="col-md-3">
                          <div class="thumbnail">
                            <img src="img/logo-db3-cut.png" alt="..." class="img-rounded">
                            <div class="caption">
                              <h3>West Indie</h3>
                              <p>Go to the web-application of the Paalgeld West Indië project.</p>
                               <p><a href="../paalgeld_win" class="btn btn-default btn-sm" role="button">View this page &raquo;</a></p>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="thumbnail">
                            <img src="img/logo-db2-cut.png" alt="..." class="img-rounded">
                            <div class="caption">
                              <h3>Lastgeld</h3>
                              <p>Go to the web-application of the Lastgeld project.</p>
                              <p><a href="../lastgeld/" class="btn btn-default btn-sm" role="button">View this page &raquo;</a></p>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="thumbnail">
                            <img src="img/apple/touch-icon-ipad-retina.png" alt="..." class="img-rounded">
                            <div class="caption">
                              <h3>Europa</h3>
                              <p>You are currently on the Paalgeld Europa project website.</p>
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
                            <p>Got questions, remarks or feedback about the website or about the project itself?  Send us an email at <a href="mailto:#">first.last@example.com</a>.</p>
                        </div>
                    </div>
                </div>
            </div>

<?php
endPage();
?>