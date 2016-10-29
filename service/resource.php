<?php
include '../DBConnection.php';
require_once '../log4php/Logger.php';
Logger :: configure('../log4php.properties');
$logger = Logger :: getRootLogger();
$result = array();
mysql_select_db("IOV_demo");
$id = isset($_POST['id']) ? intval($_POST['id']) :null;
if($id==null){
	$sql="select id,name from obd_Resource where parent_menu_id=0";
}
else {
	$sql="select id,name from obd_Resource where parent_menu_id=$id";
}
$logger->debug("----------------resource:------" . $sql);
$rs = mysql_query($sql);


while($row = mysql_fetch_array($rs)){
	$node = array();
	$node['id'] = $row['id'];
	$node['text'] = $row['name'];
	$has_child= has_child($row['id']) ? 'closed' : 'open';
	$node['state'] =$has_child;
	if($has_child=='closed'){
		$node['children']=getChildren( $row['id']);
	}
	
	$node['iconCls'] ='icon-depart';
	array_push($result,$node);
}

echo json_encode($result);

function has_child($id){
	$logger = Logger :: getRootLogger();
	mysql_select_db("IOV_demo");
	$query="select count(*)  from obd_Resource where parent_menu_id=$id ";
	$logger->debug("----------------departments:------" . $query);
	$rs = mysql_query($query);
	$row = mysql_fetch_array($rs);
	return $row[0] > 0 ? true : false;
}

function getChildren($id){
	$logger = Logger :: getRootLogger();
	mysql_select_db("IOV_demo");
	$query="select id,name  from obd_Resource where parent_menu_id=$id ";
	$logger->debug("----------------getChildren:------" . $query);
	$rs = mysql_query($query);
	$ret = array();
  while($row = mysql_fetch_array($rs)){
	$node = array();
	$node['id'] = $row['id'];
	$node['text'] = $row['name'];
	$has_child= has_child($row['id']) ? 'closed' : 'open';
	$node['state'] =$has_child;
	$node['iconCls'] ='icon-depart';
	if($has_child=='closed'){
		$node['children']=getChildren($row['id']);
	}
	$ret[]=$node;
  }
  return $ret;
}
?>