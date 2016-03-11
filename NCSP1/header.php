<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>NCSP | Idv</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.css">
	    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue">
    <div class="wrapper">
      <div class="header1">
          <div class="logo">
            <a href=""><img src="images/logoIDV.png" alt=""></a>
          </div>
      </div>
      <header class="main-header">

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-default" role="navigation">
      
		  <!-- Collect the nav links, forms, and other content for toggling -->

            <div class=" navbar-collapse pull-left" id="navbar-collapse" style="padding-left:0px">
              <ul class="nav navbar-nav">
                
                <li><a href="index.php">Accueil</a></li>
              				<?php if(isset($me)) {?>
                        <li><a href="profil.php">Profil</a></li>
              					<li><a href="demandes.php">Tasks</a></li>
              				<?php } ?>
              </ul>
            </div><!-- /.navbar-collapse -->
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <?php 
      				  if(isset($me)) {?>

                <?php }else{?>
          			  <li><a href="connexions.php" class="btn btn-danger" >Se connecter</a></li>
          			  <?php } ?>
        				<li>
        					<form class="form-horizontal" role="form" action="profil.php" method="post">
        						<button style="margin-top: 5px; margin-right: 10px;" type="submit" class="btn btn-danger" name="deconnexion">Se déconnecter</button>
        					</form>
        				</li>
              </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
