<?php
include dirname(__FILE__).'/../DBConnection.php';
require_once dirname(__FILE__).'/../log4php/Logger.php';
Logger :: configure(dirname(__FILE__).'/../log4php.properties');

class resoveledAlert {
	function getAlerts($devices, $startDate, $stopDate,$objType,$alertTypes) {
		$logger = Logger :: getRootLogger();
		$values= Array();
		$keys=array(0=>"'疲劳驾驶告警'",1=>"'出省告警'",2=>"'规定时间非法启动告警'",3=>"'超速告警'",4=>"'电池电量低告警'",5=>"'制冷剂水温告警'",6=>"'DTC告警'",7=>"'拔出告警'");
		$keys1=array();
		$array=explode(',',$alertTypes); 
		$tmp="";
		if(sizeof($array)>0){
			for($i=0;$i<sizeof($array);$i++){
				$str=$keys[$array[$i]];
				$keys1[]=$str;	
		}
		$tmp=implode(',',$keys1);
		}
		else{
			$tmp=implode(',',$keys);
		}
		
		$devices = str_replace(',', '\',\'', $devices);
		$devices = ' \'' . $devices . '\'';
		$sql = "select vm.ModelName,c.name as customer,d.d_esn,vi.licenseNumber,n.content,n.title,n.dealTime,n.createTime" .
		" from  Notifaction n  ,provision_obd.Devices d,VehModelNumber vn,VehModel vm,Devices_MT dm,VehicleInfo vi,Customers c " .
		" where dm.ModelNumID=vn.ModelNumID" .
		" and vn.ModelID=vm.ModelID" .
		" and dm.customerID=c.id" .
		" and n.vin=dm.vin" .
		" and d.deviceID=dm.deviceID" .
		" and  dm.vin=vi.vin and dm.deviceID in (" . $devices . ")" .
		" and n.createTime >'$startDate' and n.createTime <'$stopDate'".
		" and n.title in(".$tmp.") and dealFlag=1 order  by  n.createTime desc";
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
              	$tmp[5]=$row->dealTime;
              	$data[]=$tmp;
              }
				
			}
		}
		return $data;

	}
}
?>