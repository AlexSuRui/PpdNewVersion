  	<?php
		session_start();
	
	if (isset($_SESSION["utilisateur"]))
		header('Location: profil.php');
	?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <<div class="col-md-10 col-md-offset-1 col-sm-8 col-sm-offset-2">
    		<div class="login-logo">
    			<a href="index.php"><img src="images/logoIDV.png" /></a>
    			<h2>Who are you registering as?</h2>
    		</div>
    		
    		<div class="row"> 
                <div class="col-md-4 col-md-offset-2">
                    <a href="enregistrement.php?type=demandeur" class="thumbnail"> 
                    <img src="images/crowdeur.jpg" alt="user" src=" style="width: 100%; display: block;">
                    <h4 class="text-center">A Requester</h4>
                    </a> 
                </div>
                <div class="col-md-4 col-md-offset-1">
                    <a href="enregistrement.php" class="thumbnail"> 
                    <img src="images/demandeur.jpg" alt="user" src=" style="width: 100%; display: block;">
                    <h4 class="text-center">A Crowder</h4>
                    </a> 
                </div>
            </div>
    </div>
  </body>
</html>
