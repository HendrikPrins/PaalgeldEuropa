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
            <div class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Copyright &copy; <?php echo date("Y"); ?> Rijksuniversiteit Groningen</h5>
                        </div>
                    </div>
                </div>
            </div>
  <?php
}

?>

        <!-- Bootstrap javascript -->                                                           
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