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
	
	if (isset($_POST["deconnexion"])) {
		session_destroy();
		header('Location: index.php'); 
	}
	
	if (isset($_POST["submit"])) {				
		
		$identifiant = $me2->Identifiant;
		$email = $_POST["email"];
		$emdp = $_POST["exMotDePasse"];
		$mdp = $_POST["motDePasse"];
		$cmdp = $_POST["confirmerMotDePasse"];
	
		
		if (isset($_POST["demandeur"])) 
			$demandeur = 1;
		else
			$demandeur = 0;
		
		
		// if ((get_utilisateur_selon_identifiant($identifiant) != null) && ($identifiant != $me2->Identifiant))
		// {
		// 	$erreur.= "Cet identifiant est déjà pris.<br/>";
		// }
	
		if (get_utilisateur_selon_email($identifiant,$email) != null && $email != $me2->Email)
		{
			$erreur.= "Cet email est déjà pris.<br/>";
			ecrireErreur($erreur);
		}
		if ($utilisateur == null) {
			if ($emdp != $me2->MotDePasse) 
			{
				$erreur.= "L'ancien mot de passe entré est faux.<br/>";
				// echo "$me2->MotDePasse";
				// echo "$emdp";
				ecrireErreur($erreur);
			}
			
			if ($mdp != $cmdp)
			{
				$erreur.= "Les mots de passe entrés sont différents.<br/>";
				ecrireErreur($erreur);
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
			// $me2->Nom = $nom;
			// $me2->Prenom = $prenom;
			$me2->Email = $email;
			// $me2->Statut = $statut;
			$me2 = maj_utilisateur($me2);
			if ($me2 == null) {
				$erreur .= "Erreur lors de la mise à jour du profil.";
				ecrireErreur($erreur);
			} else {
				$message = "Mise à jour du profil faite !";

				ecrireMessage($message);
				// smtp_send_mail($email,"test","test","IDVParisDescartes");
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
					<div class="widget-main-title">Dashbord</div>
					<div class="widget-content">
						<div class="admin-info">
							<div class="row">
								<div class="col-md-4">
									<img src="images/user.png" id="imgProfil">
								</div>
								<div class="col-md-8">
									<div class="title"><?php echo $me2->Nom." ".$me2->Prenom; ?></div>
<!-- 								        <div>Member Since: Feb 18, 2016</div> -->
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
								   <li class="active"><a href="profilSetting.php" data-toggle="tab">Personal parameter</a></li>
								</ul>
								
											<form role="form" action="profilSetting.php" method="post"  enctype="multipart/form-data">
												<table cellpadding="4" width="100%" align="center" class="widget-tbl">
													<tbody>
													<tr>
											    		<td class="widget-title"><strong><?php echo $me2->Identifiant; ?></strong></td>
											    	</tr>
											    	<tr>
											    		<td>
											                <table cellpadding="4" width="100%">
											                	<tbody>
											                	<!-- <tr>
											                		<td align="right" width="50%">Login</td>
											                		<td width="50%"><?php echo $me2->Identifiant; ?></td>
											                	</tr> -->
											                	<tr>
											                    	<td align="right" width="50%">E-mail Address:</td>
											                    	<td><input type="text" name="email" id="email" value="<?php echo $me2->Email; ?>"></td>
											                	</tr>											         
											                	</tbody>
											                </table>
											   			</td>
											    	</tr>
											    	<tr>
											    		<td class="widget-title">Update Password</td>
											    	</tr>
											    	<tr>
											    		<td>
											                <table cellpadding="4" width="100%">
											                <tbody>
											                	<tr>
											                    <td align="right" width="50%">New password:</td>
											                    <td><input type="password" name="motDePasse" id="motDePasse"></td>
											                	</tr>
											                	<tr>
											                    <td align="right">New password confirmation:</td>
											                    <td><input type="password" name="confirmerMotDePasse" id="confirmerMotDePasse"></td>
											                	</tr>
											                	</tbody>
											                </table>
											    		</td>
											    	</tr>
	
													<tr>
											    		<td class="widget-title">Send</td>
											    	</tr>
											    	<tr>
											    		<td>
											        		<div class="info_box">You have to enter your current password to save the new changes</div>
											        		<div class="padding5 " align="center"><input type="password" name="exMotDePasse" id="exMotDePasse"></div>
											        		<div align="center" class="padding5 " style="margin-top:1px">
											        			<input type="submit" name="submit" value="Send" class="orange">
											        		</div>
											        	</td>
											    	</tr>
													</tbody>
												</table>  
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


