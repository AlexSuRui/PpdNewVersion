  	<?php
		include "module.php";
		include "moduleBDD.php";
		session_start();
		
		startDocument("Page d'accueil");
		connection(true);
		if (isset($_SESSION["utilisateur"]))
			$me = $_SESSION["utilisateur"];
	?>
    
<!DOCTYPE html>
<html class=" js flexbox canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Accueil</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	  <!-- CSS Sytle -->
    <link rel="stylesheet" href="css/cards.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body id="header">

     <div id="fh5co-page">
          <nav class="fh5co-nav-style-1 " role="navigation" data-offcanvass-position="fh5co-offcanvass-left">
              <div class="container">
                <div class="col-md-3 fh5co-logo">
                  <a href="#" class="js-fh5co-mobile-toggle fh5co-nav-toggle"><i></i></a>
                  <a href="#">IDV Paris Descartes</a>
                </div>
                <div class="col-md-3 col-md-offset-4 text-center fh5co-link-wrap">
                  <ul data-offcanvass="yes">
                     <?php 
                              if(isset($me)) {?>
                          <li>
                            <a href="profil.php">
                              <?php 
                                echo $me->Prenom." ".$me->Nom;
                              ?>
                            </a>
                          </li>
                              <?php } ?>
                  </ul>
                </div> 
                <div class="col-md-2 text-right fh5co-link-wrap">
                  <ul class="fh5co-special" data-offcanvass="yes">
                     <?php 
                              if(isset($me)) {?>
                          
                          <li>
                            <form class="form-horizontal" role="form" action="profil.php" method="post">

                              <button class="btn btn-outline btn-md " type="submit"  name="deconnexion">Se déconnecter</button>
                            </form>
                          </li>
                              <?php }else{?>
                          <li><a href="connexions.php" class="btn  btn-outline btn-md" >Login</a></li>
                       <!--  <li><a href="enregistrements.php" class="btn btn-info btn-flat" >S'enregistrer</a></li>-->
                              <?php } ?>
                  </ul>
                </div>
              </div>
          </nav>
          
          <div class="fh5co-cover fh5co-cover-style-2 js-full-height" data-stellar-background-ratio="0.5" data-next="yes"  style="background-image: url(images/full_1.jpg);">

              <div class="fh5co-overlay">
              </div>
              <div class="fh5co-cover-text">
                <div class="container">
                  <div class="row" >

                    <div class="col-md-10 col-md-offset-1 full-height js-full-height col-xs-10">

                      <div class="fh5co-cover-intro">

                        <h3 class="cover-text-lead wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">Enrichissement sémantique des images biomédicales</h3>
                        <div class="fh5co-post wow fadeInLeft"  data-wow-duration="1s" data-wow-delay="1.1s">
                          <img src ="images/bg.jpg" height="250px" width="750px">
                        </div>
                        
                      </div>

                    </div>
                  </div>
                </div>  
              </div>

          </div>
     </div>
  </body>

  <script src="js/jquery.min.js"></script>
  <!-- jQuery Easing -->
  <script src="js/jquery.easing.1.3.js"></script>
  <!-- Bootstrap -->
  <script src="js/bootstrap.min.js"></script>
  <!-- Waypoints -->
   <script src="js/jquery.waypoints.min.js"></script>
  <!-- Owl Carousel -->
  <script src="js/owl.carousel.min.js"></script>
  <!-- Stellar -->
  <script src="js/jquery.stellar.min.js"></script>
  <!-- countTo -->
  <script src="js/jquery.countTo.js"></script>
  <!-- WOW -->
  <script src="js/wow.min.js"></script>
  <script>
    new WOW().init();
  </script>
	<script>
	$(document).ready(function() {
    $('#Carousel').carousel({
        interval: 3000
    })
});
	</script>
  </body>

</html>
