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

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
<!--         <section class="content-header">
          <h1>
            Demandes
          </h1>

        </section> -->

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
  
  <div class="box" style="border:1px solid #d0d0d0;">
                <div class="box-header">
                  	<h3 class="box-title">Liste des demandes d'annotation</h3>
                </div><!-- /.box-header -->
				<div class="row" style="margin-bottom:10px"><?php if ($me->Demandeur) { ?>
					<div class="col-sm-3">
						
						<a style="margin-left: 10px;" href="demande.php" class="btn btn-defaul	t">Nouvelle image annotable</a>
						
					</div><?php } ?>
					<div class="col-sm-4">
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
									
								echo '<td>'.$demande->UID.'</td><td><a href="afficher.php?uid='.$demande->UID.'">'.$demande->Nom.'</a></td><td>'.$demande->Description.'</td><td>'.$demande->TypeUID.'</td><td>'.get_utilisateur($demande->UserUID).'</td>';
								
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
      
<?php include('footer.php'); ?>