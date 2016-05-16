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
	                  	<div class="widget-main-title">List of tasks</div>
	                </div><!-- /.box-header -->
					<div class="row" style="margin:1em"><?php if ($me->Demandeur) { ?>
						<div class="col-sm-3">
							
							<a style="margin-left: 10px;" href="demande.php" class="btn btn-success">New task</a>
							
						</div><?php } ?>
						<div class="col-sm-4" style="float: right">
							<form class="form-horizontal" role="form" action="demandes.php" method="post">
							<select class="form-control" name="categorie" onchange="this.form.submit()">
							  <option value=0>All category</option>
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
	                        <th>View</th>
							<th width="130">Name</th>
							<th>Description</th>
							<th>Type</th>
							<th width="130">Second Type</th>
							<th>Owner</th>

	                      </tr>
	                    </thead>
	                    <tbody>
						   <?php 
								foreach ($demandes as $demande) {
									if ($demande->Verrouille == 1)
										echo '<tr class="danger">';
									else
										echo '<tr>';
									$user = get_utilisateur($demande->UserUID);	
									echo '
									<td>'.$demande->UID.'</td>
									<td><img src="'.get_image_annotable($demande->UID)->Chemin.'" id="view"></td>
									<td><a href="afficher.php?uid='.$demande->UID.'">'.$demande->Nom.'</a></td>
									<td>'.$demande->Description.'</td><td>'.get_categoriesSelongID($demande->CategorieUID).'</td>
									<td>'.get_DemandeExtende($demande->UID).'</td>
									<td>'.$user->Identifiant.'</td>
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