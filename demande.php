
<?php
		include "module.php";
		include "moduleBDD.php";
		// include "select.php";
		session_start();
		/*startDocument("Demande");
		navBar();*/
		connection(true);
		
		if (isset($_SESSION["utilisateur"]))
			$me = $_SESSION["utilisateur"];
		else
			header('Location: index.php'); 
			
		if ($me->Demandeur == 0)
			header('Location: demandes.php'); 

		if (isset($_POST["submit"])) {
			$nom = addslashes($_POST["nom"]);
			$description = addslashes($_POST["description"]);
			$categorie = $_POST["categorie"];
			$souscategorie = $_POST["sub-category"];
			$date = date("Y-m-d H:i:s");
			$verrouille = 0;
			// $masquer = $_POST["masquer"];
			
			$Image = inserer_image_annotable($nom, $description, $date, $verrouille, 0, $me->UID, $categorie, $souscategorie, 1, "");
			
			$uploaddir = 'images/TaskImg';
			
			if ($Image != null) {
			$DirectoryURL = $uploaddir;
			$FileURL = $uploaddir ."/Task".$Image->UID."-".basename($_FILES['image']['name']);
			echo $DirectoryURL;
				if (!is_dir($DirectoryURL)){
				mkdir($DirectoryURL, 0777, true);
				}
				if (move_uploaded_file($_FILES['image']['tmp_name'], $FileURL)) {
						$message .= "Le fichier est valide.<br/>";
						$Image->Chemin = $FileURL;
						echo $FileURL;
						maj_image_annotable($Image);
						header('Location: demandes.php');
				} else {
						$erreur .= "Attaque potentielle par téléchargement de fichiers.<br/>";
						supprimer_image_annotable($Image);
				}
				
			}
			else
				 $erreur = "Erreur lors de la création de l'image annotable.";			
		}
		
		$categories = get_categories();
	?>

<?php include('header.php'); ?>
<div class="wrapper">
	<div class="content-wrapper" style="padding-top: 1.5em">
        <!-- Main content -->
        <section class="content">
		 <div class="row">
            <div class="col-xs-12">
			  <?php
				if ($message != "")
					ecrireMessage($message);
				if ($erreur != "")
					ecrireErreur($erreur);
			  ?>
			      <!-- Content Wrapper. Contains page content -->
			    <div class="box" style="border:1px solid #d0d0d0;">
					<div class="box-header">
				        <div class="widget-main-title">New task</div>
				    </div>
				    <div class="box-body">
				    	<form role="form" action="demande.php" method="post"  enctype="multipart/form-data" name="demandeForm">
							<ul class="form-style-1">
								
							    <li><label>Title <span class="required">*</span></label><input type="text" name="nom" class="field-divided" placeholder="Title de tâche" />&nbsp;</li>
							    <li>
							        <label>Description <span class="required">*</span></label>
							        <input type="text" name="description" class="field-long" placeholder="Description de cette tâche" />
							    </li>
							    <li>
							    	<label>Category <span class="required">*</span></label>
							        <select id="categorie" name="categorie" onChange="get_CousCat(this.options[this.selectedIndex].value)">
							        	<option value="">Please choose a category</option>
							          <?php
							            foreach ($categories as $categorie) {
							                if ($selected == $categorie->UID)
							                    echo "<option value=".$categorie->UID." selected>".$categorie->Nom."</option>";
							                else
							                    echo "<option value=".$categorie->UID.">".$categorie->Nom."</option>";
							            }
							            ?>
							        </select>
							    </li>
								
							    <li>
							    	<label for="">Second category</label>
							    	<select  name="sub-category" id="sub-category">
							    		<option value="">Please choose a seconde category</option>

							    	</select>
							    </li>
							    <li>
							        <label for="image">Select an image to be published <span class="required">*</span></label>
									<input type="file" name="image" id="image" multiple >
							    </li>
								<li>
									
								</li>
<!-- 							    <li>
							    	<label> Masquer les contributions </label>
							    	<input type="radio" name="masquer" value="1" />Oui
								    <input type="radio" name="masquer" value="0" checked />Non
							    </li> -->
							    <li>

							        <button type="submit" class="btn btn-success btn-lg" name="submit">Submit the request</button>
							    </li>
							</ul>

						</form>
				    </div>
			    </div> 
			</div>
		</div>
		</section>	
</div>      
<?php include('footer.php'); ?>
