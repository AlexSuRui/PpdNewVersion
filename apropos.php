  	<?php
		include "module.php";
		include "moduleBDD.php";
		session_start();
		
		//startDocument("Page d'accueil");
		//navBar();
		connection(true);
		if (isset($_SESSION["utilisateur"]))
			$me = $_SESSION["utilisateur"];
	?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NCSP | Accueil</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	
	 <link rel="stylesheet" href="style.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<STYLE>
.carousel {
    margin-bottom: 0;
    padding: 0 40px 30px 40px;
}
/* The controlsy */
.carousel-control {
	left: -12px;
    height: 40px;
	width: 40px;
    background: none repeat scroll 0 0 #222222;
    border: 4px solid #FFFFFF;
    border-radius: 23px 23px 23px 23px;
    margin-top: 90px;
}
.carousel-control.right {
	right: -12px;
}
/* The indicators */
.carousel-indicators {
	right: 50%;
	top: auto;
	bottom: -10px;
	margin-right: -19px;
}
/* The colour of the indicators */
.carousel-indicators li {
	background: #cecece;
}
.carousel-indicators .active {
background: #428bca;
}
	</STYLE>
  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">

      <header class="main-header">
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="index.php"><img style="max-height: 50px;" src="images/logoIDV.png" /></a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              <ul class="nav navbar-nav">
                <li><a href="index.php">Accueil</a></li>
                <li  class="active"><a href="apropos.php">A propos</a></li>
				<?php if(isset($me)) {?>
					<li><a href="demandes.php">Tasks</a></li>
				<?php } ?>
              </ul>
            </div><!-- /.navbar-collapse -->
            <!-- Navbar Right Menu -->
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <?php 
				  if(isset($me)) {?>
				  <li>
                <a href="profil.php">
				  <?php 
					  echo $me->Prenom." ".$me->Nom;
				  ?>
                </a>
                
              </li><?php }else{?>
			  <li><a href="connexions.php" class="btn btn-info btn-flat" >Se connecter</a></li>
			  <li><a href="enregistrements.php" class="btn btn-info btn-flat" >S'enregistrer</a></li>
			  <?php } ?>
			  <?php if(isset($me)) {?>
			  <li>
					<form class="form-horizontal" role="form" action="profil.php" method="post">
						<button style="margin-top: 5px; margin-right: 10px;" type="submit" class="btn btn-danger" name="deconnexion">Se déconnecter</button>
					</form>
				</li>
			  <?php } ?>
            </ul>
              </div><!-- /.navbar-custom-menu -->
          </div><!-- /.container-fluid -->
        </nav>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container">
		<br />
          <!-- Main content -->
          <section class="content">
            <div class="box box-default">
              <div class="box-body">
			  <h1>A propos</h1>
  <p>The great content goes here</p>
  <p><a class="btn btn-primary btn-lg" href="#" role="button">try it now</a></p>
                
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </section><!-- /.content -->
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="container">
          <div class="pull-right hidden-xs">
            <b>Version</b> 1.0 beta
        </div>
        <strong>Copyright &copy; 2016-2017 <a href="http://NCSP.com">NCSP idv</a>.</strong> All rights reserved.
        </div><!-- /.container -->
      </footer>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
	<script>
	$(document).ready(function() {
    $('#Carousel').carousel({
        interval: 3000
    })
});
	</script>
  </body>
</html>
