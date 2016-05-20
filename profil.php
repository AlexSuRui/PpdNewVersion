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
									History
								</div>
							</div>
							<ul>
								<?php if ($me2->Demandeur == 1) { ?>
								<li><a href="myDemandes.php">My requests</a></li>
								<?php }else{ ?>
								<li><a href="myRealisation.php">My achievements</a></li>
								<?php } ?>
							</ul>
						</li>
					</ul>
				</div>
				<div style="display:table-cell; padding-left:20px">
					<!-- Content -->
					<div class="widget-main-title">Dashboard</div>
					<div class="widget-content">
						<div class="admin-info">
							<div class="row">
								<div class="col-md-4">
									<img src="images/user.png" id="imgProfil">
								</div>
								<div class="col-md-8">
									<div class="title"><?php echo $me2->Identifiant; ?></div>
								        
								        <div>Membership: <strong> <?php if ($me2->Demandeur == 1) { ?>
												   Requester
												  <?php } else { ?>
												   Crowder
												  <?php } ?> </strong>
									</div>
								</div>
							</div>
					    </div>
					   <div class="calendar" style="margin-right: 5%">
					        <div class="top corner-top"><?php echo date("F");  ?></div>
					        <div class="mid"><?php echo date("D");  ?></div>
					        <div class="bottom corner-bottom"><?php echo date("j");  ?></div>
					    </div>
					    <div class="clear"></div>
					    <div id="tab">
					    	<ul id="myTab" class="nav nav-tabs">
								   <li class="active">
								      <a href="profil.php" data-toggle="tab">
								         Information
								      </a>
								   </li>
								   <li><a href="profilSetting.php" data-toggle="tab">Personal parameter</a></li>
								</ul>
								<div id="myTabContent" class="tab-content">
								   <div class="tab-pane fade in active" id="home">
								      <table width="100%">
										<tbody><tr>
									    	<td valign="top" width="50%">
									    <div class="widget-title">Stat</div>
									    <div class="widget-content">
									    <table width="100%" cellpadding="4">
									        <tbody><tr>
									            <td width="130">
									            <?php echo $me2->Statut ?></td>
									            <td>0.0000</td>
									        </tr>
									    </tbody></table>    
									    </div>   
									        </td>
									        <td valign="top">
									        </td>
									    </tr>
									</tbody></table>
								   </div>
								   <div class="tab-pane fade" id="ios">
								      
								   </div>
								</div>
					    </div>
					</div>
				</div>
  			</div>
  		</div>
  </div>
</body>