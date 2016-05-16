<?Php

include "moduleBDD.php";
include "module.php";
connection(true);
if(isset($_POST['get_option'])){
	$temp_local=$_POST['get_option'];
	$Souscategories = get_sousCategorie($temp_local);
	foreach ($Souscategories as $SousCategorie) 
	{
		echo "<option value=".$SousCategorie->ChildCategorieUID.">".$SousCategorie->Nom."</option>";
	}
}
else {
	echo "no one";
}

?>
