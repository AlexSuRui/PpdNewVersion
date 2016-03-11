<?php 

include "moduleBDD.php";
//hh

debug_mode();

// REINITIALISATION DE LA BDD
connection(false);
drop_database();
create_database();

// CREATION DE LA TABLE Utilisateur
create_table("UTILISATEUR", 
            "UserUID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY",
            "Nom CHAR(32) CHARACTER SET utf8",
            "Prenom CHAR(32) CHARACTER SET utf8",
            "Identifiant CHAR(32) CHARACTER SET utf8",
            "MotDePasse CHAR(32) CHARACTER SET utf8",
            "Email CHAR(255) CHARACTER SET utf8",
            "Statut CHAR(32) CHARACTER SET utf8",
            "Demandeur TINYINT UNSIGNED",
            "Bloque TINYINT UNSIGNED",
            "Reputation DOUBLE UNSIGNED",
            "Administrateur TINYINT UNSIGNED",
            "Institute CHAR(32) CHARACTER SET utf8");

// CREATION DE LA TABLE Catégorie
create_table("CATEGORIE", 
            "CategorieUID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY",
            "Nom CHAR(32) CHARACTER SET utf8",
            "Description TEXT CHARACTER SET utf8",
            "CategorieParente INT UNSIGNED",
			"FOREIGN KEY (CategorieParente) REFERENCES CATEGORIE(CategorieUID) ON UPDATE CASCADE ON DELETE RESTRICT");

// CREATION DE LA TABLE Type
create_table("TYPE", 
            "TypeUID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY",
            "Nom CHAR(32) CHARACTER SET utf8",
            "Description TEXT CHARACTER SET utf8");

// CREATION DE LA TABLE Demande
create_table("DEMANDE", 
            "DemandeUID BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY",
            "Nom CHAR(32) CHARACTER SET utf8",
            "Description TEXT CHARACTER SET utf8",
            "DatePublication DateTime",
            "Echeance DateTime",
            "Verrouille TINYINT UNSIGNED",
            "MasquerLesContributions TINYINT UNSIGNED",
            "UserUID INT UNSIGNED",
			"CategorieUID INT UNSIGNED",
			"TypeUID INT UNSIGNED",
			"FOREIGN KEY (UserUID) REFERENCES UTILISATEUR(UserUID) ON UPDATE CASCADE ON DELETE RESTRICT",
			"FOREIGN KEY (CategorieUID) REFERENCES CATEGORIE(CategorieUID) ON UPDATE CASCADE ON DELETE RESTRICT",
			"FOREIGN KEY (TypeUID) REFERENCES TYPE(TypeUID) ON UPDATE CASCADE ON DELETE RESTRICT");
			
// CREATION DE LA TABLE ImageAnnotable classe fille de Demande
create_table("IMAGEANNOTABLE", 
            "DemandeUID BIGINT UNSIGNED PRIMARY KEY",
            "Chemin VARCHAR(512) CHARACTER SET utf8",
			"FOREIGN KEY (DemandeUID) REFERENCES DEMANDE(DemandeUID) ON UPDATE CASCADE ON DELETE CASCADE");

// CREATION DE LA TABLE Contribution
create_table("CONTRIBUTION", 
            "ContributionUID BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY",
            "DatePublication DateTime",
            "Verrouille TINYINT UNSIGNED",
            "DemandeUID BIGINT UNSIGNED",
            "UserUID INT UNSIGNED",
			"FOREIGN KEY (UserUID) REFERENCES UTILISATEUR(UserUID) ON UPDATE CASCADE ON DELETE RESTRICT",
			"FOREIGN KEY (DemandeUID) REFERENCES DEMANDE(DemandeUID) ON UPDATE CASCADE ON DELETE RESTRICT");

// CREATION DE LA TABLE Contribution
create_table("ANNOTATION", 
            "ContributionUID BIGINT UNSIGNED PRIMARY KEY",
            "Texte CHAR(64) CHARACTER SET utf8",
            "Confiance TINYINT UNSIGNED",
			"PositionX INT UNSIGNED",
			"PositionY INT UNSIGNED",
			"FOREIGN KEY (ContributionUID) REFERENCES CONTRIBUTION(ContributionUID) ON UPDATE CASCADE ON DELETE CASCADE");
			
// CREATION DE LA TABLE Type
create_table("ALGORITHME", 
            "AlgorithmeUID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY",
            "Nom CHAR(32) CHARACTER SET utf8",
            "Description TEXT CHARACTER SET utf8",
			"TypeUID INT UNSIGNED",
			"FOREIGN KEY (TypeUID) REFERENCES TYPE(TypeUID) ON UPDATE CASCADE ON DELETE RESTRICT");

// CREATION DE LA TABLE Enrichissement
create_table("ENRICHISSEMENT", 
            "EnrichissementUID BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY",
            "DemandeUID BIGINT UNSIGNED",
			"AlgorithmeUID INT UNSIGNED",
			"FOREIGN KEY (AlgorithmeUID) REFERENCES ALGORITHME(AlgorithmeUID) ON UPDATE CASCADE ON DELETE RESTRICT");

// CREATION DE LA TABLE Enrichissement
create_table("ANNOTATIONEXTRAITE", 
            "EnrichissementUID BIGINT UNSIGNED PRIMARY KEY",
			"Texte CHAR(64) CHARACTER SET utf8",
			"Sources TEXT CHARACTER SET utf8",
			"FOREIGN KEY (EnrichissementUID) REFERENCES ENRICHISSEMENT(EnrichissementUID) ON UPDATE CASCADE ON DELETE CASCADE");
			
$utilisateur = inserer_utilisateur("Testeur", "Administrateur", "admin", "admin", "Paris Descartes", "admin@admin.fr", "Administrateur", 1, 0, 100, 1);
$utilisateur = inserer_utilisateur("Ghazala", "Ameni", "Ameni.GH", "MDP", "Paris Descartes", "ghazala.ameni@gmail.com", "Etudiante", 1, 0, 100, 1);
// $utilisateur = maj_utilisateur($utilisateur);
supprimer_utilisateur($utilisateur);

$categorie = inserer_categorie("Médicale", "Catégorie regroupant les demandes relatives au domaine médical.");
$categorie = inserer_categorie("Médicale", "Catégorie regroupant les demandes relatives au domaine médical.");
$categorie  = maj_categorie($categorie);
supprimer_categorie($categorie);

$type = inserer_type("Image annotable", "Type de demandes regroupant les images annotables.");
$type = inserer_type("Image annotable", "Type de demandes regroupant les images annotables.");
$type = maj_type($type);
supprimer_type($type);

$algorithme = inserer_algorithme("APriori", "Algorithme de fouille de données basé sur les éléments les plus fréquents.", 1);
$algorithme = inserer_algorithme("APriori", "Algorithme de fouille de données basé sur les éléments les plus fréquents.", 1);
$algorithme = maj_algorithme($algorithme);
supprimer_algorithme($algorithme);

$demande = inserer_demande("Demande de test", "Description de test", date("Y-m-d H:i:s"), 0, 0, 1, 1, 1);
$demande = inserer_demande("Demande de test", "Description de test", date("Y-m-d H:i:s"), 0, 0, 1, 1, 1);
$demande = maj_demande($demande);
supprimer_demande($demande);

$imageannotable = inserer_image_annotable("Image de test", "Description de test", date("Y-m-d H:i:s"), 0, 0, 1, 1, 1, "http://www.babelio.com/users/QUIZ_Au-soleil-soleil_2983.jpeg");
$imageannotable = inserer_image_annotable("Image de test", "Description de test", date("Y-m-d H:i:s"), 0, 0, 1, 1, 1, "https://sandiego.ncsy.org/files/2013/10/mountain-04.jpg");
$imageannotable = maj_image_annotable($imageannotable);
supprimer_image_annotable($imageannotable);

$contribution = inserer_contribution(date("Y-m-d H:i:s"), 0, 1, 1);
$contribution = inserer_contribution(date("Y-m-d H:i:s"), 0, 1, 1);
$contribution = maj_contribution($contribution);
supprimer_contribution($contribution);

$annotation = inserer_annotation(date("Y-m-d H:i:s"), 0, 1, 1, "Jaune", 80, 0, 0);
$annotation = inserer_annotation(date("Y-m-d H:i:s"), 0, 1, 1, "Jaune", 80, 0, 0);
$annotation = maj_annotation($annotation);
supprimer_annotation($annotation);

$enrichissement = inserer_enrichissement(1, 1);
$enrichissement = inserer_enrichissement(1, 1);
$enrichissement = maj_enrichissement($enrichissement);
supprimer_enrichissement($enrichissement);

$annotationExtraite = inserer_annotation_extraite(1, 1, "Soleil", "Rond, Grand, Jaune, Loin");
$annotationExtraite = inserer_annotation_extraite(1, 1, "Soleil", "Rond, Grand, Jaune, Loin");
$annotationExtraite = maj_annotation_extraite($annotationExtraite);
supprimer_annotation_extraite($annotationExtraite);

?>

  	<?php
		include "methodes.php";
		startDocument("Page d'intialisation de la BDD");
		navBar();
	?>
    <div class="container theme-showcase" role="main">
    	
    	<br/><br/><br/><br/>
        
         <?php
			if ($message!="")
				ecrireMessage($message);
			if ($erreur!="")
				ecrireErreur($erreur);
		?>
        
    </div>

<?php
	endDocument();
?>