<?php
include "moduleBDD.php";
include "module.php";
connection(true);
if( !empty( $_POST['type'] ) && $_POST['type'] == "insert" )
{
  $id = $_POST['pic_id'];
  $name = $_POST['name'];
  $usr = $_POST['usr'];
  $confiance = $_POST['confiance'];
  $pic_x = $_POST['pic_x'];
  $pic_y = $_POST['pic_y'];
  $date = date("Y-m-d H:i:s");
  inserer_annotation($date,0,$id,$usr,$name,$confiance,$pic_x,$pic_y);
}


if( !empty( $_POST['type'] ) && $_POST['type'] == "remove")
{
  $tag_id = $_POST['tag_id'];
  $sql = "DELETE FROM image_tag WHERE id = '".$tag_id."'";
  $qry = mysql_query($sql);
}

?>
