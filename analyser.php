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
				
		$annotations = get_annotations($_GET["uid"]);
		} elseif (isset($_GET["resultat"])) {
			$resultats = $_GET["resultat"];
		} else
			header('Location: demandes.php');
		
		
		startDocument("Demande");

	?>

<?php include('header.php'); ?>
<body>
	<div class="wrapper">
		<!-- Content Wrapper. Contains page content -->
      	<div class="content-wrapper" style="padding-top: 1.5em">
      		<section class="content">
				 <?php
					if ($message != "")
						ecrireMessage($message);
					if ($erreur != "")
						ecrireErreur($erreur);
				  ?>
				<div class="box" style="border:1px solid #d0d0d0;" id="boxAff">
						<?php if (!isset($resultats)) { ?>
				  		<div class="box-header">
				  			<div class="widget-main-title">Lancer l'analyse</strong>  ?</div>
				  		</div>
				  		<div class="box-body">
				  			<div class="row">
				  				<div class="col-xs-12">
										<form class="form-horizontal" role="form" action="http://localhost:9080/apriori/analyseur" method="get">
								        <?php echoInput("support", "Support :", "Entrez un support entre 0 et 1", "text", null, "required");
										echoInput("ontologie", "Ontologie :", "Entrez un support entre 0 et 1", "text", null, "required"); ?>
								          <table class="table table-hover" >
								            <thead>
								              <tr>
								                <th>Utilisateur</th>
								                <th>Annotations</th>
								              </tr>
								            </thead>
								          	<tbody>
								              <?php
										 $last = -1;
										 $first = true;
										 $fanno = true;
										 $operation = "";
										foreach ($annotations as $annotation) {
											
											if ($Image->MasquerLesContributions == 0 or ($annotation->UserUID == $me->UID))
											{
											if($last != $annotation->UserUID) {
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
										echo "</td></tr> <input type='hidden' name='operation' id='operation' value='$operation'";
									?>
            										</tbody>
          										</table>
          									<button type="submit" class="btn btn-success" style="margin-left: 40%; margin-top: 20%" name="annoter">Soumettre à l'analyse APriori</button>
        								</form>
      							</div>
   							 </div>
   							 <?php } else { ?>
						     <div class="box-header">
					  			<div class="widget-main-title">Lancer l'analyse</strong>  ?</div>
					  		</div>
						     <div class="box-body"><strong><?php echo str_replace(";", " - ", $resultats); ?></strong></div>
						     	<center><input type ="button" onclick="javascript:location.href='demandes.php'" style="margin-top: 10%" value="Retour" ></input>
						     	</center>
						    </div>
						    <?php } ?>

      					</div>
        <!-- Content Header (Page header) -->
				</div>
			</section>
		</div>
	</div>		
</body>
<?php include('footer.php'); ?>