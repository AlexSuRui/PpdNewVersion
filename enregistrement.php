<?php
	
	session_start();
	
	if (isset($_SESSION["utilisateur"]))
		header('Location: profil.php');
	
	include "module.php";
	include "moduleBDD.php";
	
	if (isset($_POST["submit"])) {				
		$identifiant = $_POST["identifiant"];
		$mdp = $_POST["motDePasse"];
		$cmdp = $_POST["confirmerMotDePasse"];
		$nom = $_POST["nom"];
		$prenom = $_POST["prenom"];
		$email = $_POST["email"];
		$statut = $_POST["statut"];
		$institute = $_POST["institute"];
		$code = $_POST["codeIDV"];
		
		if (isset($_POST["demandeur"])) 
			$demandeur = 1;
		else
			$demandeur = 0;
		
		$erreur = "";
		
		if(empty($_POST["identifiant"]) || empty($_POST["motDePasse"]) || empty($_POST["confirmerMotDePasse"]) 
			|| empty($_POST["email"]) || empty($_POST["statut"]) || empty($_POST["codeIDV"]))
			{
				$erreur.= "Veuillez remplir tout les champs !";
			}
		
		connection(true);
		
		if (get_utilisateur_selon_identifiant($identifiant) != null)
		{
			$erreur.= "Cet identifiant est déjà pris.<br/>";
		}
		
		if (get_utilisateur_selon_email($email) != null)
		{
			$erreur.= "Cet email est déjà pris.<br/>";
		}
		
		if ($mdp != $cmdp)
		{
			$erreur.= "Les mots de passe entrés sont différents.<br/>";
		}
		
		if ($erreur == "") 
		{
			$utilisateur = inserer_utilisateur($nom, $prenom, $identifiant, $mdp, $institute, $email, $statut, $demandeur, 0, 80, 0);
			if ($utilisateur == null) {
				$erreur .= "Erreur lors de la création du profil.";
			}
			else 
			{
				$message = "Profil créé avec succès.";
				header('Location: connexion.php');
			}
		}
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Register a new membership</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition register-page">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-2" style="margin-top: 2%;">
      <div class="register-logo">
        <a href="index.php"><img src="images/logoIDV.png" /></a>
      </div>
  <?php
			if ($message != "")
				ecrireMessage($message);
			if ($erreur != "")
				ecrireErreur($erreur);
		?>
		<div class="register-box-body">
        <p class="login-box-msg">S'inscrire comme <strong>
		<?php if (isset($_GET["type"]) && $_GET['type'] == 'demandeur') 
				{ 
					echo "requester";
				}else{
					echo "crouder";
				} ?></strong></p>
        <form action="enregistrement.php" method="post">
          <div class="form-group has-feedback">
            <input name="identifiant" type="text" class="form-control" placeholder="Identifiant *">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input name="email" type="email" class="form-control" placeholder="Email *">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input name="motDePasse" type="password" class="form-control" placeholder="Mot de passe *">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input name="confirmerMotDePasse" type="password" class="form-control" placeholder="Confirmer mot de passe *">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          <div class="row top-margin">
			  <div class="form-group has-feedback col-sm-6">
	            <input name="prenom" type="text" class="form-control" placeholder="Prenom">
	          </div>
			  <div class="form-group has-feedback col-sm-6">
	            <input name="nom" type="text" class="form-control" placeholder="Nom">
	          </div>
	      </div>
	       <div class="row top-margin">
			  <div class="form-group has-feedback col-sm-6">
	            <input name="institute" type="text" class="form-control" placeholder="Institut">
	          </div>
			  <div class="form-group has-feedback col-sm-6">
	            <input name="codeIDV" type="text" class="form-control" placeholder="code *" pattern="idv">
	          </div>
	      </div>
		  <div class="form-group has-feedback">
			<select name="statut" class="form-control"  id="statut *">
				<option value="Expert" selected="selected">Expert</option>
				<option value="Student">Etudiant</option>
				<option value="Other">Autre</option>
			</select>
			<?php if (isset($_GET["type"]) && $_GET['type'] == 'demandeur') { ?>
              <input type="hidden" name="demandeur" value="1">
            <?php } ?>
          </div>
		  
		  
		  
		  
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> J'accepte les <a href="#" data-toggle="modal" data-target="#myModal">terms</a>
                </label>
				<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Condition general</h4>
					  </div>
					  <div class="modal-body">
						<ol>
							<li>Article un<br /> blabla blabla</li>
							<li>Article deux<br /> blabla blabla</li>
						
						</ol>
					  </div>
					</div>
				  </div>
				</div>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">S'incrire</button>
            </div><!-- /.col -->
          </div>
        </form>

        <a href="connexions.php" class="text-center">Je suis déja inscrit</a>
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->

<!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>