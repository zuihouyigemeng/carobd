<?php
include '../DBConnection.php';
require_once '../log4php/Logger.php';
Logger :: configure('../log4php.properties');
$logger = Logger :: getRootLogger();

$opType = isset ($_REQUEST['opType']) ? $_REQUEST['opType'] : null;

$logger->debug("----------------opType:------" . $opType);

//combox
if ($opType == 1 or $opType == '1') {
	mysql_select_db("IOV_demo");
	$query = "select  id as provinceId,name as provinceName from Opm_Organ  where parentId=1 and id <1000";
	$logger->debug("----------------sql:------" . $query);
	//echo $query;
	$result = mysql_query($query);
	$numRows = mysql_num_rows($result);
	$ret = array ();
	$data = array ();
	if ($numRows > 0) {
		while ($row = mysql_fetch_object($result)) {
			$data[] = $row;
		}
		mysql_free_result($result);
	}

	//$ret['rows'] = $data;

	echo json_encode($data);
}



?>