
<?php
include "moduleBDD.php";
include "module.php";
connection(true);
$id =  $_POST[ 'pic_id' ];
$usr =  $_POST[ 'usr_id' ];
// fetch all tags
	$annotations = get_annotations($id, $usr);

$data['boxes'] = '';
$data['lists'] = '';
	foreach ($annotations as $annotation) {
     	$data['boxes'] .= '<div class="tagview" style="left:'.$annotation->PositionX.'px;top:'.$annotation->PositionY.'px;" id="view_54">';
		$data['boxes'] .= '<div class="square"></div>';
		$data['boxes'] .= '<div class="person" style="left:'.$annotation->PositionX.'px;top:'.$annotation->PositionY.'px;">'.$annotation->Texte.'</div>';
		$data['boxes'] .= '</div>';
	
		$data['lists'] .= '<li id="48"><a>taotao</a> (<a class="remove">Remove</a>)</li>';
	}
   
	
echo json_encode( $data );

?>