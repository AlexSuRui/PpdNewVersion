<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>|Idv</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link href="css/profil/global.css" rel="stylesheet" type="text/css">
    <link href="css/profil/site.css" rel="stylesheet" type="text/css">
   
	    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      <div class="wrapper">
          <div class="header_1">
                <div id="logo">
                    <a href=""><img src="images/logoIDV.png" alt=""></a>
                    <div class="top-box">
                        
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="top-box">
                           
                </div>
                <div class="clear"></div> 
          </div>
          <div class="header_2 corner-all">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                            <?php if(isset($me)) {?>
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href="demandes.php">Tasks</a></li>
                            <?php } ?>
                </ul>
                <div class="clear"></div>
          </div>
      </div>

  </body>