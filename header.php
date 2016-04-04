<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>|Idv</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link href="css/profil/global.css" rel="stylesheet" type="text/css">
    <link href="css/profil/site.css" rel="stylesheet" type="text/css">
    <link href="css/profil/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
 <div class="wrapper">
    <div class="header_1">
        <div id="logo">
        <a href="/"></a>
        </div>
        <div class="top-box">
        <a href=""><img src="" border="0" style="display: none !important;"></a>        </div>
        <div class="clear"></div> 
    </div>
    <div class="header_2 corner-all">
        <ul>
               <li><a href="index.php">Accueil</a></li>
                            <?php if(isset($me)) {?>
                    <li><a href="profil.php" class="current">Profil</a></li>
                    <li><a href="demandes.php">Tâche</a></li>
                            <?php } ?>
                    <form class="form-horizontal" role="form" action="profil.php" method="post">        
                            <button class="btn btn-success " type="submit"  name="deconnexion" style="float: right; margin-right: 10px;margin-top: 2px;">Se déconnecter</button>    
                    </form>
                        </ul>
        <div class="clear"></div>
    </div>
 </div>
