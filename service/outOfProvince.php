<?php
include '../DBConnection.php';
require_once '../log4php/Logger.php';
require_once '../common/AES.php';
Logger :: configure('../log4php.properties');
$logger = Logger :: getRootLogger();

$depID = isset ($_REQUEST['depID']) ? $_REQUEST['depID'] : null;

$opType = isset ($_REQUEST['opType']) ? $_REQUEST['opType'] : null;

$id = isset ($_REQUEST['id']) ? $_REQUEST['id'] : null;

$provinceId = isset ($_REQUEST['provinceId']) ? $_REQUEST['provinceId'] : null;


$status = isset ($_REQUEST['status']) ? $_REQUEST['status'] : null;



//list
if ($opType == 1 or $opType == '1') {
	mysql_select_db("IOV_demo");
	$query = "select   op.status,op.id,op.organId,oo1.name as depName, oo.id as provinceId ,oo.name as provinceName from outOfProvince op,Opm_Organ oo ,Opm_Organ oo1 where op.organId =oo1.id  and  op.provinceId =oo.id and op.organId='$depID' order by op.id";
	$logger->debug("----------------sql:------" . $query);
	//echo $query;
	$result = mysql_query($query);
	$numRows = mysql_num_rows($result);
	$ret = array ();
	$data = array ();
	$ret['total'] = $numRows;
	if ($numRows > 0) {
		while ($row = mysql_fetch_object($result)) {
			$data[] = $row;
		}
		mysql_free_result($result);
	}

	$ret['rows'] = $data;

	echo json_encode($ret);
}

//delete 
if ($opType == 2 or $opType == '2') {
	mysql_select_db("IOV_demo");
	$query = "delete from outOfProvince where id='$id'";
	if (!mysql_query($query)) {
		echo 1001;
		return;
	}
	echo 200;
}
//insert
if ($opType == 3 or $opType == '3') {
	mysql_select_db("IOV_demo");
	$query = "insert into outOfProvince (status,organId,provinceId) values ('$status','$depID','$provinceId')";
	$logger->debug("----------------sql:------" . $query);
	if (!mysql_query($query)) {
		echo 1001;
		return;
	}

	echo 200;
}

//update
if ($opType == 4 or $opType == '4') {
	mysql_select_db("IOV_demo");
	$query = "update outOfProvince set provinceId='$provinceId',status='$status' where id=$id";
	$logger->debug("----------------sql:------" . $query);
	if (!mysql_query($query)) {
		echo 1001;
		return;
	}

	echo 200;
}
?>