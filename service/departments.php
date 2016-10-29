<?php
include '../DBConnection.php';
require_once '../log4php/Logger.php';
Logger :: configure('../log4php.properties');
$logger = Logger :: getRootLogger();

$defDep=$_GET['defDep'] ;

$id = isset($_POST['id']) ? intval($_POST['id']) : $defDep;
$result = array();
mysql_select_db("IOV_demo");
$logger->debug("----------------departments:-----------defDep:" . $defDep);

$logger->debug("----------------departments:-----------id:" . $id);

if(!(isset($_POST['id'])) and $id==$defDep){
 $sql="select * from Opm_Organ where id=$id and id>1000";
}

else{
	$sql="select * from Opm_Organ where  parentId=$id and id>1000";
}

$logger->debug("----------------departments:------" . $sql);
$rs = mysql_query($sql);
 $n=0;
while($row = mysql_fetch_array($rs)){
	$node = array();
	$node['id'] = $row['id'];
	$node['text'] = $row['name'];
	$node['state'] = has_child($row['id']) ? 'closed' : 'open';
	$node['iconCls'] ='icon-depart';
//	if($n==0){
//		$node['checked']="true"; 
//	}
	
	array_push($result,$node);
//	$n++;
}

echo json_encode($result);

function has_child($id){
	$logger = Logger :: getRootLogger();
	mysql_select_db("IOV_demo");
	$query="select count(*)  from Opm_Organ where parentId=$id and id>1000";
	$logger->debug("----------------departments:------" . $query);
	$rs = mysql_query($query);
	$row = mysql_fetch_array($rs);
	return $row[0] > 0 ? true : false;
}

?>