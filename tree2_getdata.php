<?php

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

include 'conn.php';

$result = array();
$rs = mysql_query("select * from nodes where parentId=$id");
while($row = mysql_fetch_array($rs)){
	$node = array();
	$node['id'] = $row['id'];
	$node['text'] = $row['name'];
	$node['state'] = has_child($row['id']) ? 'closed' : 'open';
	array_push($result,$node);
}

echo json_encode($result);

function has_child($id){
	$rs = mysql_query("select count(*) from nodes where parentId=$id");
	$row = mysql_fetch_array($rs);
	return $row[0] > 0 ? true : false;
}

?>