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
		
		if (isset($_SESSION["utilisateur"]))
			$me = $_SESSION["utilisateur"];
		else
			header('Location: index.php'); 
		$demande = get_DemandesByUser($me->UID);
	?>

<?php include('header.php'); ?>
<body>
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
  		<div class="box" style="border:1px solid #d0d0d0;">
	                <div class="box-header">
	                  	<div class="widget-main-title">My requests</div>
	                </div><!-- /.box-header -->
	                <div class="box-body">
	                  <table id="example1" class="table table-bordered table-striped ">
	                    <thead>
	                      <tr>
	                        <th>#</th>
	                        <th colspan="5">View</th>
							<th>Title</th>
							<th>Description</th>
							<th>Date</th>
							<th colspan="1">State</th>
	                      </tr>
	                    </thead>
	                    <tbody>
						   <?php 
								foreach ($demande as $demande) {
									if ($demande->Verrouille == 1)
										echo '<tr class="danger">';
									else
										echo '<tr>';	

									echo '<td>'.$demande->UID.'</td><td colspan="5">
									<a href="#" id="view"><img src="'.get_image_annotable($demande->UID)->Chemin.'" id="view"></a></td><td><a href="afficher.php?uid='.$demande->UID.'">'.$demande->Nom.'</a></td><td>'.$demande->Description.'</td><td>'.$demande->DatePublication.'</td>';

									switch ($demande->Verrouille) {
										case '0':
											echo '<td>En attent</td>';
											break;
										case '1':
											echo '<td>Validée</td>';
											break;
										default:
											echo '<td>Refusée</td>';
											break;
											}
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
</body>