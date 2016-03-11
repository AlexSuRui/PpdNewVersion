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
		navBar();
	?>

<?php include('header.php'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Soumettre une demande
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>demande</li>
			<li class="active">Analyser</li>
          </ol>
        </section>

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
  <?php if (!isset($resultats)) { ?>
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Lancer l'analyse de « <strong><?php echo $Image->Nom; ?></strong> » ?</h3>
      </div>
      <div class="panel-body">
        <form class="form-horizontal" role="form" action="http://localhost:8080/apriori/analyseur" method="get">
        <?php echoInput("support", "Support :", "Entrez un support entre 0 et 1", "text", null, "required");
		echoInput("ontologie", "Ontologie :", "Entrez un support entre 0 et 1", "text", null, "required"); ?>
          <table class="table table-hover">
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
				
				echo "<td>".$utilisateur." (<strong>".$utilisateur->Reputation."</strong>)</td><td>";
				
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
          <button type="submit" class="btn btn-success" name="annoter">Soumettre à l'analyse APriori</button>
        </form>
      </div>
    </div>
    <?php } else { ?>
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Les concepts suivants ont été retenus</h3>
      </div>
      <div class="panel-body"><strong><?php echo str_replace(";", " - ", $resultats); ?></strong></div>
    </div>
    <?php } ?>
</div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
<?php include('footer.php'); ?>