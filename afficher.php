<?php
		include "module.php";
		include "moduleBDD.php";
		session_start();
		connection(true);
		if (isset($_SESSION["utilisateur"]))
			$me = $_SESSION["utilisateur"];
		else
			header('Location: index.php'); 
		
		if (isset($_GET["uid"]))
		{
				$Image = get_image_annotable($_GET["uid"]);
				if ($Image == null)
					header('Location: demandes.php');
		} else 
			header('Location: demandes.php');
			
		if (isset($_POST["supprimer"])) {
			$Image = supprimer_image_annotable($Image);
			if ($Image!=null) {
				header('Location: demandes.php');
			} else {
				$erreur = "Erreur lors de la suppression de la demande.";
			}
		}
		
		if (isset($_GET["ano"])) {
			$annotation = get_annotation($_GET["ano"]);
			if ($annotation->Verrouille==0)
				supprimer_annotation($annotation);
			header('Location: afficher.php?uid='.$_GET["uid"]);
		}
		
		if (isset($_POST["verrouiller"])) {
			$Image->Verrouille = $_POST["verrouiller"];
			maj_image_annotable($Image);
			header('Location: afficher.php?uid='.$_GET["uid"]);
		}
		
		if (isset($_POST["bloquer"])){
			$bDemande = $Image->UID;
			$bUserUID = $_POST["bloquer"];
			bloquer_Personne($bDemande, $bUserUID);
			header('Location: afficher.php?uid='.$_GET["uid"]);

		}

		if (isset($_POST["analyser"])){
			
		}

		if (isset($_POST["annoter"])) {
			
			if(isset($_POST["annotation"]) && !empty($_POST["annotation"]))
			{
				$annotation = addslashes($_POST["annotation"]);
				$confiance = $_POST["confiance"];
				$date = date("Y-m-d H:i:s");
				$objet = inserer_annotation($date, 0, $Image->UID, $me->UID, $annotation, $confiance, 0, 0);
				
				if ($objet == null)
					$erreur = "Impossible d'ajouter l'annotation.";
				else
					$message = "L'annotation a été ajoutée avec succès.";
			
			}else{
				$erreur = "Veuillez saisir une annotation";
			}
		}
		if ($me->Administrateur || $me->Demandeur){
			$annotations = get_annotations($_GET["uid"]);
		}else{
			$annotations = get_annotations($_GET["uid"], $me->UID);
		}
		
		/*startDocument("Demande");
		navBar();*/
	?>

<?php include('header.php'); ?>
<body>
	<div class="wrapper">
		<div class="content-wrapper" style="padding-top: 1.5em">
			<section class="content">
					<?php
							if ($message != "")
								ecrireMessage($message);
							if ($erreur != "")
								ecrireErreur($erreur);
				  
				  	?>
				  	<div class="box" style="border:1px solid #d0d0d0;" id="boxAff">
				  		<div class="box-header">
				  			<div class="widget-main-title">Annotation</div>
				  		</div>
				  		<div class="box-body">
				  			<div class="row">
					  			<div class="col-md-7 col-xs-10" >
					  				<center>
						  				<div id="imgtag">	
											<img class= "imgAnnotation" src=<?php echo '"'.$Image->Chemin.'"'; ?> id=<?php echo '"'.$Image->UID.'"' ?> />
											<div id="tagbox">
	    									</div>
										</div>
										<div class="taglist">
											<ol>
												
											</ol>
										</div>	
									</center>

						  		</div>
						  		<div class="col-md-5 col-xs-10">
						  				<table width="100%" id="tbInfo">
						  					<tbody>
						  						<tr>
						  							<td valign="top" width="50%">
						  								<div class="widget-title">Information</div>
						  								<div class="widget-content">
						  									<table width="100%" cellpadding="4">
						  										<tbody>
						  											<tr>
						  												<td width="130">Ttitle: </td>
						  												<td><?php echo $Image->Nom; ?></td>
						  											</tr>
						  											<tr>
						  												<td width="130">Client: </td>
						  												<td><?php echo get_utilisateur($Image->UserUID)->Identifiant; ?></td>
						  											</tr>
						  											<tr>
						  												<td width="130">Description </td>
						  												<td><?php echo $Image->Description; ?></td>
						  											</tr>
						  											<tr>
						  												<td>Categorie</td>
						  												<td><?php echo get_categoriesSelongID($Image->CategorieUID )?></td>
						  											</tr>
						  											<tr>
						  												<td>Type</td>
						  												<td><?php echo get_DemandeExtende($Image->UID) ?></td>
						  											</tr>
						  										</tbody>
						  									</table>
						  								</div>
						  							</td>
						  						</tr>
						  					</tbody>
						  				</table>
						  				<table width="100%" id="tbAnno">
						  					<tbody>
						  						<tr>
						  							<td valign="top" width="50%">
						  								<div class="widget-title">Annotation</div>
						  								<div class="widget-content">
						  									<form class="form-horizontal" role="form" action="http://localhost:9080/apriori/analyseur" method="get">
							  									<table width="100%" cellpadding="4">
							  										<thead>
															          <tr>
															            <th>User</th>
															            <th>Annotations</th>
																		<!-- <th>Bloquer</th> -->
															          </tr>
															        </thead>
							  										<!-- <tbody>
							  											<?php
																		 $last = -1;
																		 $first = true;
																		 $fanno = true;
																		 foreach ($annotations as $annotation) {			
																			if ($Image->MasquerLesContributions == 0 or ($annotation->UserUID == $me->UID))
																			{
																			if($last != $annotation->UID) {
																				if ($first)
																					$first = false;
																				else
																					echo "</td></tr>";
																					
																				$fanno = true;
																				
																				if ($annotation->UserUID == $me->UID)
																					echo '<tr class="success">';
																				else
																					echo '<tr>';
										
																				echo "<td>".get_utilisateur($annotation->UserUID)->Identifiant." (<strong>".get_utilisateur($annotation->UserUID)->Reputation."</strong>)</td>";
																				$utilisateur = get_utilisateur($annotation->UserUID);
																				$operation.=$utilisateur->UID.";".$utilisateur->Reputation;
																				$last = $annotation->UID;

																			}
																			if ($fanno)
																				$fanno = false;
																			else
																				echo "";
																				
																			if ($annotation->UserUID == $me->UID and $annotation->Verrouille == 0 and $Image->Verrouille == 0)	
																				echo '<a href="afficher.php?uid='.$_GET["uid"].'&ano='.$annotation->UID.'"<span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
																			echo "<td>".$annotation->Texte."</td><td>".$annotation->Confiance."</td>";
																			}
																		}

																		echo '</tr>';	
							  										?>

							  										</tbody> -->
							  										<tbody id="annotation">
														        <?php
																 $last = -1;
																 $first = true;
																 $fanno = true;
																 $operation = "";
																foreach ($annotations as $annotation) {
																	
																	if ($Image->MasquerLesContributions == 0 or ($annotation->UserUID == $me->UID))
																	{
																		if($last != $annotation->UserUID) 
																		{
																			if ($first)
																				$first = false;
																			else {
																				echo "</td></tr>";
																				$operation .= "|";
																				}
																			$fanno = true;
																			
																			echo '<tr>';
																			
																			$utilisateur = get_utilisateur($annotation->UserUID);
																			
																			echo "<td>".$utilisateur->Identifiant." (<strong>".$utilisateur->Reputation."</strong>)</td><td>";
																			
																			$operation.=$utilisateur->UID.";".$utilisateur->Reputation;
																			
																			$last = $annotation->UserUID;
																		}
																		
																		if ($fanno)
																			$fanno = false;
																		else
																			echo "; ";
																		
																		$traite = str_replace('"', " ", $annotation->Texte);
																		$traite = str_replace("'", " ", $traite);
																		
																		$operation.=";".$traite.";".$annotation->Confiance;	
																		echo $annotation->Texte;
																		

																	}
																		
																}
																$operation = addslashes($operation);
																echo "</td></tr> <input type='hidden' name='operation' id='operation' value='$operation'></input>";
															?>
						            										</tbody>
							  									</table>
							  								<?php if ($Image->Verrouille == 1&&($Image->UserUID == $me->UID || $me->Administrateur)) { ?>
						  									<button type="submit" class="btn btn-success" style="float: right; margin-top: 5%" name="analyser">Analyze</button>
						  									<?php } ?>
						  								</form>
						  								</div>
						  							</td>
						  						</tr>
						  					</tbody>
						  				</table>
						  				<?php if ($Image->UserUID == $me->UID || $me->Administrateur) { ?>
						  				<div class="box"style="border:1px solid #d0d0d0;" id="boxVerro">
						  					<div class="box-header">
	                  							<div class="widget-title">Operation on image</div>
	                  						</div>
	                  						<div class="box-body">
	                  							<ul class="form-style-1">
	                  							<form role="form" action=<?php echo '"afficher.php?uid='.$Image->UID.'"'; ?> method="post">
	                  									<li style="display: inline;">
	                  										<button type="submit" class="btn btn-danger" name="supprimer" value = "1">Delete</button>
	                  									</li>
														<?php if ($Image->Verrouille == 0) { ?>
														<li style="display: inline;">
															<button type="submit"  style="margin-left: 0%" class="btn btn-success " name="verrouiller" value = "1">Lock</button>															
														</li>
														<li style="display: inline;">
															<button type="submit" style="margin-left: 0%" class="btn btn-success disabled " name="verrouiller" value = "0">Unlock</button>
														</li>

														<?php } else { ?>
														<li style="display: inline;">
															<button type="submit" style="margin-left: 0%" class="btn btn-success disabled" name="verrouiller" value = "1">Lock</button>															
														</li>
														<li style="display: inline;">
															<button type="submit" style="margin-left: 0%" class="btn btn-success " name="verrouiller" value = "0">Unlock</button>
															
														</li>
													
												</form>
										        </ul>
											</div>
										</div>
					
												<?php } ?>
						  				<?php } else if(!$me->Demandeur && $Image->Verrouille == 0){ ?>
						  				<div class="box"style="border:1px solid #d0d0d0;" id="boxAnno">
						  					<div class="box-header">
	                  							<div class="widget-title">Annotate image</div>
	                  						</div>
	                  						<div class="box-body">
	                  							<form id="form11" role="form" action=<?php echo '"afficher.php?uid='.$Image->UID.'"'; ?> method="post">
		                  							<ul class="form-style-1">
		                  								<li>
		                  									<label>Annotation <span class="required">*</span></label><input type="text" name="annotation" class="field-long" placeholder="Entrez une annotation" />&nbsp;</li>
		                  								</li>
		                  								<li>
		                  									<label>Confiance <span class="required">*</span></label>
		                  									<input type="radio" name="confiance" value="100" checked />
												            <font color="#5cb85c">Confident</font>
												            <input type="radio" name="confiance" value="80" />
												            <font color="#f0ad4e">Average confident</font>
												            <input type="radio" name="confiance" value="40" />
												            <font color="#d9534f">Hesitant</font> 
		                  								</li>
		                  								<li>
		                  									<button type="submit" class="btn btn-success" name="annoter" >Submit the annotation</button>
		                  								</li>
		                  							</ul>
	                  							</form>
	                  						</div>
						  					
						  				</div>
						  				<?php } ?>
						  		</div>
						  	</div>
					  	</div>
				  	</div>
			</section>
		</div>
	</div>
</body>
<?php include('footer.php'); ?>