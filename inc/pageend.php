<?php
if($_inContainer){
  ?>
                     </div>

                </div>
            </div>
        </div>
  <?php
  }else{
  ?>


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
            <div class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-1">
                            <h5><a href="#">Links</a></h5>
                        </div>
                        <div class="col-md-1">
                            <h5><a href="#">Contact</a></h5>
                        </div>
                        <div class="col-md-1">
                            <h5><a href="#">Sitemap</a></h5>
                        </div>
                    </div>
                </div>
            </div>
  <?php
}

?>

        <!-- Bootstrap javascript -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <?php
        if($_loadChosen){
        ?>
        <script src="js/chosen.jquery.js" type="text/javascript"></script>
        <script type="text/javascript">
          var config = {
            '.chosen-select'           : {},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
            '.chosen-select-width'     : {width:"95%"}
          }
          for (var selector in config) {
            $(selector).chosen(config[selector]);
          }
        </script>
        <?php
        }
        ?>
    </body>
</html>