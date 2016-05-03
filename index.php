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
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Accueil</title>
  	<!-- 
	//////////////////////////////////////////////////////

	FREE HTML5 TEMPLATE 
	DESIGNED & DEVELOPED by FREEHTML5.CO
		
	Website: 		http://freehtml5.co/
	Email: 			info@freehtml5.co
	Twitter: 		http://twitter.com/fh5co
	Facebook: 		https://www.facebook.com/fh5co

	//////////////////////////////////////////////////////
	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">
	
	<!-- Google Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700|Monsterrat:400,700|Merriweather:400,300italic,700' rel='stylesheet' type='text/css'>
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">
	
	<!-- Cards -->
	<link rel="stylesheet" href="css/cards.css">

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	</head>
	<body>
	
	<div >
		<nav class="fh5co-nav-style-1" role="navigation" data-offcanvass-position="fh5co-offcanvass-left">
			<div class="container">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 fh5co-logo">
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
                                echo $me->Identifiant;
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

                              <button class="btn btn-outline btn-md " type="submit"  name="deconnexion">Log off</button>
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
		  	<span class="scroll-btn wow fadeInUp" data-wow-duration="1s" data-wow-delay="1.4s">
				<!-- <a href="#">
					<span class="mouse"><span></span></span>
				</a> -->
			</span>
			<div class="fh5co-overlay"></div>
			<div class="fh5co-cover-text">
                <div class="container">
                  <div class="row" >
                    <div class="col-md-10 col-md-offset-1 full-height js-full-height col-xs-10">
                      <div class="fh5co-cover-intro">
                        <h3 class="cover-text-lead wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">Semantic enrichment of Biomedical images</h3>
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
	<!-- END page-->

	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
   <script src="js/jquery.waypoints.min.js"></script>
	<!-- Owl Carousel -->
	<script src="js/owl.carousel.min.js"></script>
	<!-- Magnific Popup -->
	<script src="js/jquery.magnific-popup.min.js"></script>
	<!-- Stellar -->
	<script src="js/jquery.stellar.min.js"></script>
	<!-- countTo -->
	<script src="js/jquery.countTo.js"></script>
	<!-- WOW -->
	<script src="js/wow.min.js"></script>
	<script>
		new WOW().init();
	</script>
	<!-- Main -->
	<script src="js/main.js"></script>

	</body>
</html>
