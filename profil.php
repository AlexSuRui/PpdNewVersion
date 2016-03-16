<?php
	include "module.php";
	include "moduleBDD.php";
	session_start();
	
	connection(true);
		
	if (!isset($_SESSION["utilisateur"]))
		header('Location: enregistrement.php');  
		
	$me = $_SESSION["utilisateur"];
	$me2 = $_SESSION["utilisateur"];
	
	$mydemandes = getCurrentUserDemande($me->UID);
	$utilisateur = null;
	$erreur = "";
	
	if (isset($_GET["uid"]) and $me->Administrateur==1)
	{
		$utilisateur = get_utilisateur($_GET["uid"]);
		if (isset($utilisateur) && $utilisateur->UID == $me->UID) {
			$utilisateur = null;
		} elseif(isset($utilisateur)) {
			$me2 = $utilisateur;
		}else{
			$me2 = new Utilisateur();
			$erreur .= "Erreur !! aucun utilisateur ne correspond à votre recherche.";
			
		}
	}
	if (isset($_POST["deconnexion"])) {
		session_destroy();
		header('Location: index.php'); 
	}
	
	/*startDocument("Profil");
	navBar();*/
	
	if (isset($_POST["bloquer"])){
		$me2->Bloque = $_POST["bloquer"];
		$mee = maj_utilisateur($me2);
		if ($mee == null) {
			$erreur .= "Erreur lors de la mise à jour du profil.";
		} else {
			$message = "Mise à jour du profil faite !";
		}
	}
	
	if (isset($_POST["admin"])){
		$me2->Administrateur = $_POST["admin"];
		$mee = maj_utilisateur($me2);
		if ($mee == null) {
			$erreur .= "Erreur lors de la mise à jour du profil.";
		} else {
			$message = "Mise à jour du profil faite !";
		}
	}
	
	if (isset($_POST["submit"])) {				
		$identifiant = $_POST["identifiant"];
		if ($utilisateur == null) {
			$emdp = $_POST["exMotDePasse"];
			$mdp = $_POST["motDePasse"];
			$cmdp = $_POST["confirmerMotDePasse"];
		}
		$nom = $_POST["nom"];
		$prenom = $_POST["prenom"];
		$email = $_POST["email"];
		$statut = $_POST["statut"];
		
		if (isset($_POST["demandeur"])) 
			$demandeur = 1;
		else
			$demandeur = 0;
		
		
		if ((get_utilisateur_selon_identifiant($identifiant) != null) && ($identifiant != $me2->Identifiant))
		{
			$erreur.= "Cet identifiant est déjà pris.<br/>";
		}
		
		if (get_utilisateur_selon_email($email) != null && $email != $me2->Email)
		{
			$erreur.= "Cet email est déjà pris.<br/>";
		}
		if ($utilisateur == null) {
			if ($emdp != $me2->MotDePasse) 
			{
				$erreur.= "L'ancien mot de passe entré est faux.<br/>";
			}
			
			if ($mdp != $cmdp)
			{
				$erreur.= "Les mots de passe entrés sont différents.<br/>";
			}
		}
		if ($erreur == "") 
		{
			$me2->Identifiant = $identifiant;
			if ($utilisateur == null) {
				if ($mdp != "") {
					$me2->MotDePasse = $mdp;
				}
			}
			$me2->Nom = $nom;
			$me2->Prenom = $prenom;
			$me2->Email = $email;
			$me2->Statut = $statut;
			$me2 = maj_utilisateur($me2);
			if ($me2 == null) {
				$erreur .= "Erreur lors de la mise à jour du profil.";
			} else {
				$message = "Mise à jour du profil faite !";
				if ($utilisateur == null)
					$_SESSION["utilisateur"] = $me;
			}
		}
	}
	?>
<?php include('header.php'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
     <!--    <section class="content-header">
          <h1>
            User Profile
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User profile</li>
          </ol>
        </section>
 -->
        <!-- Main content -->
        <section class="content">

          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="box box-primary" style="width: 300px;">
                <div class="box-body box-profile" >
                  <h3 class="profile-username text-center"><?php echo $me2->Nom." ".$me2->Prenom; ?></h3>
                  <p class="text-muted text-center">
				  <?php if ($me2->Demandeur == 1) { ?>
					  profil Demandeur
					  <?php } else { ?>
					  profil Contributeur
					  <?php } ?></p>

                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>réputation</b> <a class="pull-right"> <?php echo $me2->Reputation; ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Statut du profil</b> <a class="pull-right">
						  <?php if ($me2->Bloque == 1) { ?>
						  bloqué
						  <?php } else { ?>
						  Actif
						  <?php } ?>
						</a>
                    </li>
					<?php if ($me2->Administrateur == 1) { ?>
						<li class="list-group-item">
						  Ce profil dispose <strong>des droits d'administration</strong>.
						</li>
					<?php } ?>
                  </ul>
					<?php if ($me->Administrateur == 1 ) { ?>
					<a href="utilisateurs.php" class="btn btn-primary btn-block"><b>Afficher la liste des utilisateurs</b></a> <br />
					
					<form class="form-horizontal" role="form" action="profil.php?uid=<?php echo $me2->UID; ?>" method="post">
					<?php 
			if (true) {
				if ($me2->Bloque == 0)
					echo ' <button type="submit" class="btn btn-danger btn-block" name="bloquer" value=1>Bloquer ce profil</button>';
				else
					echo ' <button type="submit" class="btn btn-warning btn-block" name="bloquer" value=0>Débloquer ce profil</button>';
				
				if ($me2->Administrateur == 0)
					 echo ' <button type="submit" class="btn btn-warning btn-block" name="admin" value=1>Rendre administrateur</button>';
				else 
					echo ' <button type="submit" class="btn btn-danger btn-block" name="admin" value=0>Retirer les droits d\'administration</button>';
					 }?>
					 <?php } ?>
                  </form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-7 col-md-offset-2" >
              <div class="nav-tabs-custom "style="border:1px solid #d0d0d0;">
                <ul class="nav nav-tabs">
                  <li><a href="#allrequest" data-toggle="tab">My last request</a></li>
                  <li class="active"><a href="#settings" data-toggle="tab">User count settings</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane" id="allrequest">
				  <!-- Post -->
					 <div class="post">
                      <div class='row'>
					  <?php 
						foreach($mydemandes as $demande)
						{ 
						echo '<div class="col-sm-3">
						  <a href="afficher.php?uid='.$demande['DemandeUID'].'" title=""><img class="img-responsive" src="'.$demande['Chemin'].'" alt="'.$demande['Nom'].'"></a>
						</div>';
						}
					  ?>
                      </div><!-- /.row -->
                    </div><!-- /.post -->
                    
                  </div><!-- /.tab-pane -->

                  <div class="active tab-pane" id="settings">
                    <?php
						if (isset($_GET["uid"])) {
					
					  echo '<form class="form-horizontal" role="form" action="profil.php?uid='.$_GET["uid"].'" method="post">';
					   } else { ?>
					   <form class="form-horizontal" role="form" action="profil.php" method="post">
					   <?php } ?> 
					  <?php
						if ($message != "")
							ecrireMessage($message);
						if ($erreur != "")
							ecrireErreur($erreur);
					  ?>
					  <?php
		if (isset($_GET["uid"]))
			echo '<input type="hidden" name="navigateur" value='.$_GET["uid"].'>';
			?>
			<div class="form-group">
                        <label for="inputName" class="col-sm-4 control-label">User name:</label>
                        <div class="col-sm-8">
                          <input name="identifiant"  type="text" class="form-control" id="inputName" value="<?php echo $me2->Identifiant; ?>">
                        </div>
                      </div>
			<?php 
		if ($utilisateur == null) { 
		?>
					<div class="form-group">
						<label for="inputPSD" class="col-sm-4 control-label">Actual Password:</label>
						<div class="col-sm-8">
						  <input name="exMotDePasse" type="password" class="form-control" id="inputPSD" placeholder="Mot de passe actuel">
						</div>
					</div>
					<div class="form-group">
						<label for="inputNPSD" class="col-sm-4 control-label">New Password:</label>
						<div class="col-sm-8">
						  <input name="motDePasse" type="password" class="form-control" id="inputNPSD" placeholder="Nouveau mot de passe">
						</div>
					</div>
					<div class="form-group">
						<label for="inputRPSD" class="col-sm-4 control-label">Retype Password</label>
						<div class="col-sm-8">
						  <input name="confirmerMotDePasse" type="password" class="form-control" id="inputRPSD" placeholder="Confirmez votre nouveau mot de passe">
						</div>
					</div>
					<div class="form-group">
						<label for="inputNom" class="col-sm-4 control-label">Nom:</label>
						<div class="col-sm-8">
						  <input name="nom" type="text" class="form-control" id="inputNom" value="<?php echo $me2->Nom; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputPrenom" class="col-sm-4 control-label">Prénom:</label>
						<div class="col-sm-8">
						  <input name="prenom" type="text" class="form-control" id="inputPrenom" value="<?php echo $me2->Prenom; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail" class="col-sm-4 control-label">Email:</label>
						<div class="col-sm-8">
						  <input name="email" type="email" class="form-control" id="inputEmail"value="<?php echo $me2->Email; ?>">
						</div>
					</div>
					
	<!-- 	<?php }
		echoInput("nom", "Nom :", "Entrez votre nom", "text", $me2->Nom);
		echoInput("prenom", "Prénom :", "Entrez votre prénom", "text", $me2->Prenom);
		echoInput("email", "Courriel :", "Entrez un courriel", "email", $me2->Email);
		//echoInput("statut", "Statut :", "Entrez un statut", "text", $me2->Statut);
		?> -->
		<div class="form-group">
			<label class="control-label col-sm-4" for="statut">Statut :</label>
			<div class="col-sm-8"> 
				<select name="statut" class="form-control"  id="statut">
					<option value="Expert" <?php echo $me2->Statut == "Expert" ? "selected='selected'": "" ?>>Expert</option>
					<option value="Student" <?php echo $me2->Statut == "Student" ? "selected=\"selected\"": "" ?>>Student</option>
					<option value="Other" <?php echo $me2->Statut == "Other" ? "selected='selected'" : "" ?>>Other</option>
				</select>
			</div>
		 </div>
                      <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-10">
                          <button type="submit" name="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
<?php include('footer.php'); ?>