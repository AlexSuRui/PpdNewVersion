<?php
	include "module.php";
	include "moduleBDD.php";
	session_start();
	if (!isset($_SESSION["utilisateur"]))
		header('Location: enregistrement.php');  
		
	$me = $_SESSION["utilisateur"];
	
	if ($me->Administrateur != 1 && $me->Demandeur != 1) {
		header('Location: profil.php'); 
	}
	
	startDocument("Liste des utilisateurs");
	navBar();
	?>

<?php include('header.php'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
       <!--  <section class="content-header">
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
  
  connection(true);
  $utilisateurs = get_utilisateurs();
  
  ?>
  
  <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Liste des utilisateurs</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Email contact</th>
                      </tr>
                    </thead>
                    <tbody>
					  <?php
					  foreach ($utilisateurs as $utilisateur) 
						{
						  echo '<tr>
							<td>'.$utilisateur->UID.'</th>
							<td>'.$utilisateur->Prenom.'</td>
							<td>'.$utilisateur->Nom.'</td>
							<td><a href="profil.php?uid='.$utilisateur->UID.'">'.$utilisateur->Identifiant.'</a></td>
							<td><a href="mailto:'.$utilisateur->Email.'">'.$utilisateur->Email.'</a></td>
						  </tr>';
						}
					  
					  ?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
			</div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
<?php include('footer.php'); ?>