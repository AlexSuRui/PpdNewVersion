<?php
		include "module.php";
		include "moduleBDD.php";
		session_start();
		
		//startDocument("Page d'accueil");
		//navBar();
		connection(true);
		$categories = get_categories();
		if (isset($_POST["categorie"]))
			$selected = $_POST["categorie"];
		else
			$selected = 0;
		$demandes = get_demandes($selected);
		if (isset($_SESSION["utilisateur"]))
			$me = $_SESSION["utilisateur"];
		else
			header('Location: index.php'); 
	?>

<?php include('header.php'); ?>
<div class="wrapper">
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="padding-top: 1.5em">
        <section class="content">
		 <div class="row">
            <div class="col-xs-12">
  <?php
			if ($message != "")
				ecrireMessage($message);
			if ($erreur != "")
				ecrireErreur($erreur);
  
  ?>
  <script type="text/javascript">
  		function autoRun(){
  			document.getElementById("tache").className="current";
  			document.getElementById("profil").className="";
  		}
  		window.onload=autoRun();
  		
 
  	
  </script>
  
	  <div class="box" style="border:1px solid #d0d0d0; min-height: 500px;">
	                <div class="box-header">
	                  	<div class="widget-main-title">Liste des demandes d'annotation</div>
	                </div><!-- /.box-header -->
					<div class="row" style="margin:1em"><?php if ($me->Demandeur) { ?>
						<div class="col-sm-3">
							
							<a style="margin-left: 10px;" href="demande.php" class="btn btn-success">Nouvelle image annotable</a>
							
						</div><?php } ?>
						<div class="col-sm-4" style="float: right">
							<form class="form-horizontal" role="form" action="demandes.php" method="post">
							<select class="form-control" name="categorie" onchange="this.form.submit()">
							  <option value=0>Toutes les catégories</option>
							  <?php
								foreach ($categories as $categorie) {
									if ($selected == $categorie->UID)
										echo "<option value=".$categorie->UID." selected>".$categorie->Nom."</option>";
									else
										echo "<option value=".$categorie->UID.">".$categorie->Nom."</option>";
								}
							?>
							</select>
						  </form>
						</div>
					</div>
	                <div class="box-body">
	                  <table id="example1" class="table table-bordered table-striped ">
	                    <thead>
	                      <tr>
	                        <th>#</th>
							<th>Nom</th>
							<th>Description</th>
							<th>Type</th>
							<th>Demandeur</th>
	                      </tr>
	                    </thead>
	                    <tbody>
						   <?php 
								foreach ($demandes as $demande) {
									if ($demande->Verrouille == 1)
										echo '<tr class="danger">';
									else
										echo '<tr>';
										
									echo '
									<td>'.$demande->UID.'</td>
									<td><a href="afficher.php?uid='.$demande->UID.'">'.$demande->Nom.'</a></td>
									<td>'.$demande->Description.'</td><td>'.get_categoriesSelongID($demande->TypeUID).'</td>
									<td>'.get_utilisateur($demande->UserUID).'</td>
									';
									
									echo '</tr>';
								}
							?>
	                    </tbody>

	                  </table>
	                </div><!-- /.box-body -->
	              </div><!-- /.box -->
				</div><!-- /.col -->
	          </div><!-- /.row -->
	        </section><!-- /.content -->
	      </div><!-- /.content-wrapper -->
</div>      

<?php include('footer.php'); ?>