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
<body>
  <div class="wrapper">
	<!-- Content -->
		<div class="main_content corner-all">
			<div style="display:table; width:100%">
				<div style="display:table-cell; width:250px">
					<ul class="menubarlist">
						<li id="1">
					        <div class="widget-title">
					                        Globale
					        </div>
					        <ul>
					            <li><a href="profil.php">Information</a></li>
					        </ul>
						</li>
						<li>
							<div class="membermenu">
								<div class="mid">
									Historique
								</div>
							</div>
							<ul>
								<?php if ($me2->Demandeur == 1) { ?>
								<li><a href="myDemandes.php">Mes demandes</a></li>
								<?php }else{ ?>
								<li><a href="myRealisation.php">Mes réalisation</a></li>
								<?php } ?>
							</ul>
						</li>
					</ul>
				</div>
				<div style="display:table-cell; padding-left:20px">
					<!-- Content -->
					<div class="widget-main-title">Tableau de bord</div>
					<div class="widget-content">
						<div class="admin-info">
							<div class="row">
								<div class="col-md-4">
									<img src="images/user.png" id="imgProfil">
								</div>
								<div class="col-md-8">
									<div class="title"><?php echo $me2->Nom." ".$me2->Prenom; ?></div>
								        <div>Member Since: Feb 18, 2016</div>
								        <div>Membership: <strong> <?php if ($me2->Demandeur == 1) { ?>
												   Demandeur
												  <?php } else { ?>
												   Contributeur
												  <?php } ?> </strong>
									</div>
								</div>
							</div>
					    </div>
					    <div class="calendar" style="margin-right: 5%">
					        <div class="top corner-top">Mar</div>
					        <div class="mid">Mardi</div>
					        <div class="bottom corner-bottom">29</div>
					    </div>
					    <div class="clear"></div>
					    <div id="tab">
					    	<ul id="myTab" class="nav nav-tabs">
								   <li>
								      <a href="profil.php" data-toggle="tab">
								         Information
								      </a>
								   </li>
								   <li class="active"><a href="profilSetting.php" data-toggle="tab">Paramètre Personnel</a></li>
								</ul>
								<div id="myTabContent" class="tab-content">
								   <div class="tab-pane fade" id="1">
								      <table width="100%">
										<tbody><tr>
									    	<td valign="top" width="50%">
									    <div class="widget-title">Earning Balance Stats</div>
									    <div class="widget-content">
									    <table width="100%" cellpadding="4">
									        <tbody><tr>
									            <td width="130">
									            Balance:</td>
									            <td>$0.0000</td>
									        </tr>
									    </tbody></table>    
									    </div>   
									        </td>
									        <td valign="top">
									        </td>
									    </tr>
									</tbody></table>
								   </div>
								   <div class="tab-pane fade in active" id="2">
								   		<div class="setting-info">
											<form role="form" action="demande.php" method="post"  enctype="multipart/form-data">
												<ul class="form-style-1" style="margin-left: 20%;">								
													<li>
														<label>Identifiant <span class="required">*</span></label>
														<input type="text" name="identifiant" class="field-divided" value="<?php echo $me2->Identifiant; ?>" readonly="readonly" />&nbsp;
													</li>
													<li>
														<label>Mot de passe actuel <span class="required">*</span></label>
														<input type="password" name="exMotDePasse" class="field-divided" placeholder="Mot de passe actuel" />
													</li>
													<li>
														<label>Nouveau mot de passe <span class="required">*</span></label>
														<input type="password" name="motDePasse" class="field-divided" placeholder="Nouveau mot de passe" />
													</li>
													<li>
														<label>Confirmer mot de passe<span class="required">*</span></label>
														<input type="password" name="confirmerMotDePasse" class="field-divided" placeholder="Confirmez votre nouveau mot de passe" />
													</li>
													<li>
														<label>Email <span class="required">*</span></label>
														<input type="email" name="email" class="field-divided" value="<?php echo $me2->Email; ?>" />&nbsp;
													</li>
													<li>
														<label>Statut <span class="required">*</span></label>
														<select name="statut" onchange="this.form.submit()">
															<option value="Expert" <?php echo $me2->Statut == "Expert" ? "selected='selected'": "" ?>>Expert</option>
															<option value="Student" <?php echo $me2->Statut == "Student" ? "selected=\"selected\"": "" ?>>Etudiant</option>
															<option value="Other" <?php echo $me2->Statut == "Other" ? "selected='selected'" : "" ?>>Autre</option>
														</select>
													</li>
													<li>
														<button type="submit" name="submit" class="btn btn-danger">Envoyer</button>
													</li>
												</ul>
											</form>
										</div>   
								   </div>
								</div>
					    </div>
					</div>
				</div>
  			</div>
  		</div>
  </div>
</body>				


