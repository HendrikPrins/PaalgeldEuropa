
<!DOCTYPE html>
<html lang="nl">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title><?php echo $pageTitle;?></title>
        <meta name="apple-mobile-web-app-title" content="Orderstatus">
        <link rel="apple-touch-icon" href="img/apple/touch-icon-iphone.png">
        <link rel="apple-touch-icon" sizes="76x76" href="img/apple/touch-icon-ipad.png">
        <link rel="apple-touch-icon" sizes="120x120" href="img/apple/touch-icon-iphone-retina.png">
        <link rel="apple-touch-icon" sizes="152x152" href="img/apple/touch-icon-ipad-retina.png">
        <link rel="shortcut icon" href="img/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <!-- Bootstrap Style -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/chosen.css">
        <!-- Own Style -->
        <link rel="stylesheet" href="css/paalgeld.css">
        <?php
        if($_loadGoogleCharts){
          echo '<script type="text/javascript" src="https://www.google.com/jsapi"></script>';
        }
        if($_loadGoogleMaps){
          echo '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHmhz1TT9nJ1RH0OlptIxXDiu8THJ7vWI"></script>';
          echo '<script src="js/module_maps.js"></script>';
        }
        ?>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <!-- Menu -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Navigatie aan/uit</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php"><img src="img/logo.png" class="img-responsive" id="hummellogo"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li<?php echo ($_pageName == 'index.php' ? ' class="active"' : '')?>><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                <!--<li<?php echo ($_pageName == 'namen.php' ? ' class="active"' : '')?>><a href="namen.php"><span class="glyphicon glyphicon-user"></span> Names</a></li>     

                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-screenshot"></span> Places<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="plaatsen.php?type=country"><span class="glyphicon glyphicon-map-marker"></span> Country</a></li>
                    <li><a href="plaatsen.php?type=area"><span class="glyphicon glyphicon-fullscreen"></span> Area</a></li>
                    <li><a href="plaatsen.php?type=port"><span class="glyphicon glyphicon-screenshot"></span> Port</a></li>      
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-random"></span> Cargoes<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="lading.php?type=country"><span class="glyphicon glyphicon-map-marker"></span> Country</a></li>
                    <li><a href="lading.php?type=area"><span class="glyphicon glyphicon-fullscreen"></span> Area</a></li>
                    <li><a href="lading.php?type=port"><span class="glyphicon glyphicon-screenshot"></span> Port</a></li>      
                  </ul>
                </li>-->

                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-search"></span> Search<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="namen.php"><span class="glyphicon glyphicon-user"></span> Names</a></li>
                    <li><a href="plaatsen.php"><span class="glyphicon glyphicon-screenshot"></span> Places</a></li>
                    <li><a href="lading.php"><span class="glyphicon glyphicon-random"></span> Cargoes</a></li>      
                  </ul>
                </li>

                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-wrench"></span> Analyze<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="#"><span class="glyphicon glyphicon glyphicon-user"></span> Names</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-screenshot"></span> Places</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-random"></span> Cargoes</a></li>      
                  </ul>
                </li>

                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-book"></span> Complete tables<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="table_captains.php"><span class="glyphicon glyphicon-user"></span> Names</a></li>
                    <li><a href="table_ports.php"><span class="glyphicon glyphicon-screenshot"></span> Places</a></li>
                    <li><a href="table_cargoes.php"><span class="glyphicon glyphicon-random"></span> Cargoes</a></li>
                    <li><a href="table_arrivals.php"><span class="glyphicon glyphicon-flag"></span> Arrivals</a></li>
                    <li><a href="table_date.php"><span class="glyphicon glyphicon-time"></span> Date</a></li>           
                  </ul>
                </li>
              </ul>


              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list"></span> Paalgeld<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a target="_blank" href="../paalgeld_weu/">Paalgeld Europa</a></li>
                    <li><a target="_blank" href="../paalgeld_win/">Paalgeld West-Indie</a></li>
                    <li><a target="_blank" href="../lastgeld/">Lastgeld</a></li>
                    <li class="divider"></li>
                    <li><a target="_blank" href="http://www.rug.nl">Rijksuniversiteit Groningen</a></li>
                  </ul>
                </li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>

        <!-- Body -->
        <?php
        if($_inContainer){
          ?>
          <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                            <h3>Paalgeld Europa
                            <small><?php echo $subTitle; ?></small></h3>
                    </div>
                    <div>
          <?php
        }
        ?>