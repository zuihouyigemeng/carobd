<?php
include '../DBConnection.php';
require_once '../log4php/Logger.php';
Logger :: configure('../log4php.properties');
$logger = Logger :: getRootLogger();

$brand=$_GET['defDep'] ;

$id = isset($_POST['id']) ? intval($_POST['id']) : $defDep;
$result = array();
mysql_select_db("IOV_demo");
if(!(isset($_POST['id'])) and $id==$defDep){
 $sql="SELECT * FROM  VehBrand  order  by Brand " ;
 $rs = mysql_query($sql);
while($row = mysql_fetch_array($rs)){
	$node = array();
	$node['id'] = $row['BrandID'];
	$node['text'] = $row['Brand'];
	$node['state'] = has_child($row['BrandID']) ? 'closed' : 'open';
	$node['iconCls'] ='icon-depart';
	array_push($result,$node);
}
}

else{
	$sql="select * from VehModel where  BrandID=$id  order  by ModelName";
	$rs = mysql_query($sql);
    while($row = mysql_fetch_array($rs)){
	$node = array();
	$node['id'] = $row['ModelID'];
	$node['text'] = $row['ModelName'];
	$node['state'] = has_child($row['id']) ? 'closed' : 'open';
	$node['iconCls'] ='icon-depart';
	array_push($result,$node);
}
}



echo json_encode($result);

function has_child($id){
	$logger = Logger :: getRootLogger();
	mysql_select_db("IOV_demo");
	$query="select count(*)  from VehModel where  BrandID=$id";
	$rs = mysql_query($query);
	$row = mysql_fetch_array($rs);
	return $row[0] > 0 ? true : false;
}

?>