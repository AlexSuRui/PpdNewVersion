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
				<li id="2">
					<div class="membermenu">
						<div class="mid">
							Paramètre
						</div>
					</div>
					<ul>
						<li><a href="profilSetting.php">Paramètre personnel </a></li>
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
		</div>
		<div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
			<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
		    	<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tab-1" aria-labelledby="ui-id-1" aria-selected="true">
		    		<a href="#" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1">Sommaire</a>
		    	</li>


		    </ul>
		</div> 
		<div id="tab-1" aria-labelledby="ui-id-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="true" aria-hidden="false" style="margin-top: 1em; min-height: 200px;">
			<table width="50%" style="margin:1em">
				<tbody>
					<tr>
				    	<td valign="top" width="50%" >
						    <div class="widget-title">Niveau</div>
						    <div class="widget-content">
						    <table width="100%" cellpadding="4" >
						        <tbody>
						        <tr>
						            <td width="130">
						            Etudiant:</td>
						            <td>0</td>
						        </tr>
						    	</tbody>
						    </table>    
						    </div>  
				        </td>
				        <td valign="top">
				        </td>
				    </tr>
				</tbody>
			</table>
		</div>
  </div>
</body>