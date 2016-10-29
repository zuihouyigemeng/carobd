<?php
include  dirname(__FILE__).'/tj_speed.php';

$opType = isset ($_REQUEST['opType']) ? $_REQUEST['opType'] : null;
$startDate = isset ($_REQUEST['startDate']) ? $_REQUEST['startDate'] : null;
$stopDate = isset ($_REQUEST['stopDate']) ? $_REQUEST['stopDate'] : null;
$devices = isset ($_REQUEST['devices']) ? $_REQUEST['devices'] : null;
$speed = isset ($_REQUEST['speed']) ? $_REQUEST['speed'] : null;

$tj = new tj_speed();
if ($opType == '0' or $opType == 0) {
	
	$tj->searchOverSpeedResult($devices, $startDate, $stopDate, $speed);

} else
	if ($opType == '1' or $opType == 1) {
		$tj = new tj_speed();
		$tj->searchOverSpeedDetailResult($devices, $startDate, $stopDate, $speed);
	} else {
		echo 'optype error!';
	}
	
	?>