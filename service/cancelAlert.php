<?php
include dirname(__FILE__).'/../DBConnection.php';
require_once dirname(__FILE__).'/../log4php/Logger.php';
Logger :: configure(dirname(__FILE__).'/../log4php.properties');

class cancelAlert {
	function getAlerts($devices, $startDate, $stopDate,$objType) {
		$logger = Logger :: getRootLogger();
		$devices = str_replace(',', '\',\'', $devices);
		$devices = ' \'' . $devices . '\'';
//		$sql = "select vm.ModelName,c.name as customer,d.d_esn,vi.licenseNumber,n.content,n.title,n.cancelTime,n.createTime" .
//		" from  Notifaction n  ,provision_obd.Devices d,VehModelNumber vn,VehModel vm,Devices_MT dm,VehicleInfo vi,Customers c " .
//		" where dm.ModelNumID=vn.ModelNumID" .
//		" and vn.ModelID=vm.ModelID" .
//		" and dm.customerID=c.id" .
//		" and n.vin=dm.vin" .
//		" and d.deviceID=dm.deviceID" .
//		" and  dm.vin=vi.vin and dm.deviceID in (" . $devices . ")" .
//		" and n.createTime >'$startDate' and n.createTime <'$stopDate' and n.title  in ('拔出告警') and cancelFlag=1 order by n.vin,n.createTime";
		
		
		$sql = "select vm.ModelName,c.name as customer,d.d_esn,vi.licenseNumber,n.content,n.title,n.cancelTime,n.createTime" .
		" from  provision_obd.Devices d  ".
		" join  Devices_MT dm  on d.deviceID=dm.deviceID".
		" join  VehicleInfo vi  on vi.vin=dm.vin".
		" left join  VehModelNumber vn on  dm.ModelNumID=vn.ModelNumID".
		" left join  VehModel vm on  vn.ModelID=vm.ModelID".
		" left join  Customers c on  dm.customerID=c.id".
		" join  Notifaction n on (n.vin=dm.vin and  n.createTime >'$startDate' and n.createTime <'$stopDate' and n.title  in ('拔出告警') and n.cancelFlag=1) ".
	//	" where d.deviceiD in (" . $devices . ") order by n.vin,n.createTime";
	    " where d.deviceiD in (" . $devices . ") order by  n.createTime desc";
		
		
		
		//echo $sql;
		$logger->debug("----------------sql:------" . $sql);
		mysql_select_db("IOV_demo");
		$result = mysql_query($sql);
		$numRows = mysql_num_rows($result);
		$data = array ();
		if ($numRows > 0) {
			while ($row = mysql_fetch_object($result)) {
              if($objType==0){
              	array_push($data, $row);
              }
              else{
              	$tmp = array ();
              	$tmp[0]=$row->licenseNumber;
              	$tmp[1]=$row->d_esn;
              	$tmp[2]=$row->title;
              	$tmp[3]=$row->content;
              	$tmp[4]=$row->createTime;
              	$tmp[5]=$row->cancleTime;
              	$data[]=$tmp;
              }
				
			}
		}
		return $data;

	}
}
?>