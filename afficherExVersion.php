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

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->

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
      <div class="box">

				<div class="box-body">
      <?php if ($Image->UserUID == $me->UID || $me->Administrateur) { ?>
      <div class="row">
	  <?php if ($me->Administrateur) { ?>
	  <div class="col-xs-2 col-md-2">
        <div class="btn-group" role="group">
          <form class="form-horizontal" role="form" action=<?php echo '"afficher.php?uid='.$Image->UID.'"'; ?> method="post">
            <button type="submit" class="btn btn-danger" name="supprimer" value = "1">Supprimer la demande</button>
          </form>
        </div>
		</div>
      <?php } ?>
        <div class="col-xs-2 col-md-2">
          <form class="form-horizontal" role="form" action=<?php echo '"afficher.php?uid='.$Image->UID.'"'; ?> method="post">
                <?php if ($Image->Verrouille == 0) { ?>
                <button type="submit" class="btn btn-danger" name="verrouiller" value = "1">Verrouiller</button>
                <?php } else { ?>
                <button type="submit" class="btn btn-success" name="verrouiller" value = "0">Déverrouiller</button>
                <?php } ?>
          </form>
        </div>
        <div class="col-xs-2 col-md-2">
          <form class="form-horizontal" role="form" action=<?php echo '"analyser.php?uid='.$Image->UID.'"'; ?> method="post">
            <div class="btn-group btn-group-justified" role="group">
              <div class="btn-group" role="group">
                <button type="submit" class="btn btn-info" name="analyser">Analyser</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <br/>
      <?php } ?>
      </div>	
      <div class="col-md-10 col-md-offset-1 col-xs-10" >	  
      	  <center>
	      	<img src=<?php echo '"'.$Image->Chemin.'"'; ?> width="60%" /> <br/>
		  </center>
	      <br/>
	      <center>
	        Par <?php echo get_utilisateur($Image->UserUID); ?><br/>
	        <strong><?php echo $Image->Description; ?></strong>
	      </center>
      </div>

      <br/>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Utilisateur</th>
            <th>Annotations</th>
			<th>fiabilité</th>
          </tr>
        </thead>
        <tbody>
          <?php
		 $last = -1;
		 $first = true;
		 $fanno = true;
		foreach ($annotations as $annotation) {
			
			if ($Image->MasquerLesContributions == 0 or ($annotation->UserUID == $me->UID))
			{
			if($last != $annotation->UserUID) {
				if ($first)
					$first = false;
				else
					echo "</td></tr>";
					
				$fanno = true;
				
				if ($annotation->UserUID == $me->UID)
					echo '<tr class="success">';
				else
					echo '<tr>';
					
				echo "<td>".get_utilisateur($annotation->UserUID)."</td><td>";
				$last = $annotation->UserUID;
			}
			
			if ($fanno)
				$fanno = false;
			else
				echo "; ";
				
			if ($annotation->UserUID == $me->UID and $annotation->Verrouille == 0 and $Image->Verrouille == 0)	
				echo '<a href="afficher.php?uid='.$_GET["uid"].'&ano='.$annotation->UID.'"<span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
			echo $annotation->Texte;
			}
				
		}
		echo '</td></tr>';
	?>
	
	<!--echo "<td><a href=''> reduire</a></td>";-->
        </tbody>
      </table>
      <br/>
      <?php if ($Image->Verrouille == 0) { ?>
      <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title">Annoter l'image</h3>
        </div>
        <div class="panel-body">
          <form class="form-horizontal" role="form" action=<?php echo '"afficher.php?uid='.$Image->UID.'"'; ?> method="post">
            <?php
			  	echoInput("annotation", "Annotation :", "Entrez une annotation");
			  ?>
            <center>
              <strong>Confiance :
              <input type="radio" name="confiance" value="100" checked />
              <font color="#5cb85c">Confiant</font>
              <input type="radio" name="confiance" value="80" />
              <font color="#f0ad4e">Presque confiant</font>
              <input type="radio" name="confiance" value="40" />
              <font color="#d9534f">Hésitant</font> </strong>
            </center>
              <div class="col-md-2 col-md-offset-5 	btn-group " role="group">
                <button type="submit" class="btn btn-success" name="annoter" >Soumettre l'annotation</button>
              </div>
          </form>
        </div>
      </div>
      <?php } ?>
</div>

</div>
</div><!-- /.box -->
			</div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
<?php include('footer.php'); ?>