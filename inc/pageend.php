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
                    <h3>Paalgeld Europa</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <h4>About the website</h4>
                                <p>Lorem ipsum.</p>
                            </div>
                            <div class="col-md-6">
                                <h4>The assignment</h4>
                                <p>Lorem ipsum2.</p>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <h4>Sitemap</h4>
                            <p>Lorem ipsum.</p>
                        </div>
                        <div class="col-md-4">
                            <h4>Links</h4>
                            <p>Lorem ipsum.</p>
                        </div>
                        <div class="col-md-4">
                            <h4>Contact</h4>
                            <p>Lorem ipsum.</p>
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