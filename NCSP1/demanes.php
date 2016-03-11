<?php
		include "module.php";
		include "moduleBDD.php";
		session_start();
		
		startDocument("Page d'accueil");
		navBar();
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
            Members
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">members</li>
          </ol>
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
  
  <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Liste des utilisateurs</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
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
                    <tfoot>
                      <tr>
                        <th>#</th>
						<th>Nom</th>
						<th>Description</th>
						<th>Type</th>
						<th>Demandeur</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
			</div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
<?php include('footer.php'); ?>