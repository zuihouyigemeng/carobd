<?php
include '../DBConnection.php';
require_once '../log4php/Logger.php';
Logger :: configure('../log4php.properties');
$logger = Logger :: getRootLogger();


$searchType = isset ($_GET['searchType']) ? $_GET['searchType'] : 0;

$models = isset ($_GET['models']) ? $_GET['models'] : 0;

$deps = isset ($_GET['deps']) ? $_GET['deps'] : 0;

$cus = isset ($_GET['cus']) ? $_GET['cus'] : 0;

$searchValue = isset ($_GET['searchValue']) ? $_GET['searchValue'] : "";

$data = array ();
mysql_select_db("IOV_demo");


$page = isset ($_REQUEST['page']) ? $_REQUEST['page'] : null;
$rows = isset ($_REQUEST['rows']) ? $_REQUEST['rows'] : null;
$total = 0;

$page = ($page -1) * $rows;



if($searchType==0){
	$sqlCount = "select count(*) as total from VehicleInfo v ,provision_obd.Devices d,Devices_MT dm,obd_demo.LocationStatus l,Customers c,Opm_Organ oo   where d.deviceID=dm.deviceID and dm.vin=v.vin  and d.depID=oo.id and d.depID  in (" . $deps . ") and d.deviceID=l.deviceID  and dm.customerID=c.id";
	
	$query = "select oo.name as depName,c.name as customerName,dm.nickName,d.deviceIndex,d.registerKey,d.deviceID,v.vin,d.d_esn,v.licenseNumber,l.ign,l.onlineStatus,l.address_num,l.baidu_latitude as latitude ,l.baidu_longitude as longitude,l.heading,concat( l.gpsDate, ' ', l.gpsTime ) as time ,(l.alertStatus1+l.alertStatus2+l.alertStatus3+l.alertStatus4+l.alertStatus5+l.alertStatus6+l.alertStatus7+l.alertStatus8) as alertStatus from VehicleInfo v ,provision_obd.Devices d,Devices_MT dm,obd_demo.LocationStatus l,Customers c,Opm_Organ oo   where d.deviceID=dm.deviceID and dm.vin=v.vin  and d.depID=oo.id and d.depID  in (" . $deps . ") and d.deviceID=l.deviceID  and dm.customerID=c.id limit $page,$rows";
}
else if($searchType==1){
	$arrDeptID=getDeptLowerId($deps);
	$arrDeptID[]=$deps;
	$deptIDs = implode(",", $arrDeptID);
	$sqlCount = "select  count(*) as total from VehicleInfo v ,provision_obd.Devices d,Devices_MT dm,obd_demo.LocationStatus l,VehModel vm,VehModelNumber vn,Customers c  where d.deviceID=dm.deviceID and dm.vin=v.vin and  dm.ModelNumID =vn.ModelNumID and  vn.ModelID=vm.ModelID  and vm.ModelID   in (" . $models . ") and  d.depID  in ($deptIDs) and d.deviceID=l.deviceID and dm.customerID=c.id ";

	$query = "select  c.name as customerName,dm.nickName,d.registerKey,d.deviceID,v.vin,d.d_esn,v.licenseNumber,l.ign,l.onlineStatus,l.address_num,l.baidu_latitude as latitude ,l.baidu_longitude as longitude,l.heading,concat( l.gpsDate, ' ', l.gpsTime ) as time,(l.alertStatus1+l.alertStatus2+l.alertStatus3+l.alertStatus4+l.alertStatus5+l.alertStatus6+l.alertStatus7+l.alertStatus8) as alertStatus  from VehicleInfo v ,provision_obd.Devices d,Devices_MT dm,obd_demo.LocationStatus l,VehModel vm,VehModelNumber vn,Customers c  where d.deviceID=dm.deviceID and dm.vin=v.vin and  dm.ModelNumID =vn.ModelNumID and  vn.ModelID=vm.ModelID  and vm.ModelID   in (" . $models . ") and  d.depID  in ($deptIDs) and d.deviceID=l.deviceID and dm.customerID=c.id  limit $page,$rows";
}

else if($searchType==11){
	$arrDeptID=getCousLowerId($cus);
	$arrDeptID[]=$cus;
	$deptIDs = implode(",", $arrDeptID);
	$sqlCount = "select  count(*) as total from VehicleInfo v ,provision_obd.Devices d,Devices_MT dm,obd_demo.LocationStatus l,VehModel vm,VehModelNumber vn,Customers c  where d.deviceID=dm.deviceID and dm.vin=v.vin and  dm.ModelNumID =vn.ModelNumID and  vn.ModelID=vm.ModelID  and vm.ModelID   in (" . $models . ") and  dm.customerID  in (" . $deptIDs . ") and d.deviceID=l.deviceID and dm.customerID=c.id ";
	

	$query = "select  c.name as customerName,dm.nickName,d.registerKey,d.deviceID,v.vin,d.d_esn,v.licenseNumber,l.ign,l.onlineStatus,l.address_num,l.baidu_latitude as latitude ,l.baidu_longitude as longitude,l.heading,concat( l.gpsDate, ' ', l.gpsTime ) as time,(l.alertStatus1+l.alertStatus2+l.alertStatus3+l.alertStatus4+l.alertStatus5+l.alertStatus6+l.alertStatus7+l.alertStatus8) as alertStatus  from VehicleInfo v ,provision_obd.Devices d,Devices_MT dm,obd_demo.LocationStatus l,VehModel vm,VehModelNumber vn,Customers c  where d.deviceID=dm.deviceID and dm.vin=v.vin and  dm.ModelNumID =vn.ModelNumID and  vn.ModelID=vm.ModelID  and vm.ModelID   in (" . $models . ") and  dm.customerID  in (" . $deptIDs . ") and d.deviceID=l.deviceID and dm.customerID=c.id  limit $page,$rows";
}

else if($searchType==2){
	$arrDeptID=getDeptLowerId($deps);
	$arrDeptID[]=$deps;
	$deptIDs = implode(",", $arrDeptID);
	$sqlCount = "select  
				count(*) as total
			from 
				VehicleInfo v ,
				provision_obd.Devices d,
				Devices_MT dm,
				obd_demo.LocationStatus l,
				Customers c 
			where 
				d.deviceID=dm.deviceID and 
				dm.vin=v.vin and  
				dm.customerID  in (" . $cus . ")  and  
				d.depID  in ($deptIDs) and 
				d.deviceID=l.deviceID  and 
				dm.customerID=c.id";
	
	

	$query = "select  
				c.name as customerName,
				dm.nickName,
				d.registerKey,
				d.deviceID,
				v.vin,
				d.d_esn,
				v.licenseNumber,
				l.ign,l.onlineStatus,
				l.address_num,
				l.baidu_latitude as latitude ,
				l.baidu_longitude as longitude,
				l.heading,
				concat( l.gpsDate, ' ', l.gpsTime ) as time ,
				(l.alertStatus1+l.alertStatus2+l.alertStatus3+l.alertStatus4+l.alertStatus5+l.alertStatus6+l.alertStatus7+l.alertStatus8) as alertStatus
			from 
				VehicleInfo v ,
				provision_obd.Devices d,
				Devices_MT dm,
				obd_demo.LocationStatus l,
				Customers c 
			where 
				d.deviceID=dm.deviceID and 
				dm.vin=v.vin and  
				dm.customerID  in (" . $cus . ")  and  
				d.depID  in ($deptIDs) and 
				d.deviceID=l.deviceID  and 
				dm.customerID=c.id  limit $page,$rows";
}

else if($searchType==3){
	
	$sqlCount = "select  
				count(*) as total
			from 
				VehicleInfo v ,
				provision_obd.Devices d,
				Devices_MT dm,
				obd_demo.LocationStatus l,
				Customers c 
			where 
				d.deviceID=dm.deviceID and 
				dm.vin=v.vin and  
				dm.customerID  in (" . $cus . ")  and 
				d.deviceID=l.deviceID  and 
				dm.customerID=c.id";
	
	$query = "select  
				c.name as customerName,
				dm.nickName,
				d.registerKey,
				d.deviceID,
				v.vin,
				d.d_esn,
				v.licenseNumber,
				l.ign,l.onlineStatus,
				l.address_num,
				l.baidu_latitude as latitude ,
				l.baidu_longitude as longitude,
				l.heading,
				concat( l.gpsDate, ' ', l.gpsTime ) as time,
				(l.alertStatus1+l.alertStatus2+l.alertStatus3+l.alertStatus4+l.alertStatus5+l.alertStatus6+l.alertStatus7+l.alertStatus8) as alertStatus
			from 
				VehicleInfo v ,
				provision_obd.Devices d,
				Devices_MT dm,
				obd_demo.LocationStatus l,
				Customers c 
			where 
				d.deviceID=dm.deviceID and 
				dm.vin=v.vin and  
				dm.customerID  in (" . $cus . ")  and 
				d.deviceID=l.deviceID  and 
				dm.customerID=c.id limit $page,$rows";
}else if($searchType==6){//部门用户登录 input 查找
	$arrDeptID=getDeptLowerId($deps);
	$arrDeptID[]=$deps;
	$deptIDs = implode(",", $arrDeptID);
	$sqlCount = "select count(*) as total from(
				select 
					c.`name` as customerName,
					dm.nickName,
					d.registerKey,
					d.deviceID,
					v.vin,
					d.d_esn,
					v.licenseNumber,
					l.ign,l.onlineStatus,
					l.address_num,
					l.baidu_latitude as latitude ,
					l.baidu_longitude as longitude,
					l.heading,concat( l.gpsDate, ' ', l.gpsTime ) as `time`,
					(l.alertStatus1+l.alertStatus2+l.alertStatus3+l.alertStatus4+l.alertStatus5+l.alertStatus6+l.alertStatus7+l.alertStatus8) as alertStatus  
				from 
					VehicleInfo v ,
					provision_obd.
					Devices d,
					Devices_MT dm,
					obd_demo.
					LocationStatus l,
					Customers c  
				
				where 
					d.deviceID=dm.deviceID 
					and dm.vin=v.vin 
					and d.depID  in ($deptIDs) 
					and d.deviceID=l.deviceID  
					and dm.customerID=c.id) b 
			
			where  b.licenseNumber like '%$searchValue%' or b.d_esn like '%$searchValue%'";



	$query = "select * from(
				select 
					c.`name` as customerName,
					dm.nickName,
					d.registerKey,
					d.deviceID,
					v.vin,
					d.d_esn,
					o.name as depName,
					v.licenseNumber,
					l.ign,l.onlineStatus,
					l.address_num,
					l.baidu_latitude as latitude ,
					l.baidu_longitude as longitude,
					l.heading,concat( l.gpsDate, ' ', l.gpsTime ) as `time` ,
					(l.alertStatus1+l.alertStatus2+l.alertStatus3+l.alertStatus4+l.alertStatus5+l.alertStatus6+l.alertStatus7+l.alertStatus8) as alertStatus 
				from 
					VehicleInfo v ,
					provision_obd.Devices d,
					Devices_MT dm,
					IOV_demo.Opm_Organ o,
					obd_demo.LocationStatus l,
					Customers c  
				
				where 
					d.deviceID=dm.deviceID 
					and dm.vin=v.vin 
					and d.depID=o.id 
					and d.depID  in ($deptIDs) 
					and d.deviceID=l.deviceID  
					and dm.customerID=c.id) b 
			
			where  b.licenseNumber like '%$searchValue%' or b.d_esn like '%$searchValue%' limit $page,$rows";
}else if($searchType==7){//客户用户登录 input 查找
	$arrDeptID=getCousLowerId($cus);
	$arrDeptID[]=$cus;
	$cusIDs = implode(",", $arrDeptID);
	$sqlCount = "select count(*) as total from(
				select 
					c.`name` as customerName,
					dm.nickName,
					d.registerKey,
					d.deviceID,
					v.vin,
					d.d_esn,
					v.licenseNumber,
					l.ign,l.onlineStatus,
					l.address_num,
					l.baidu_latitude as latitude ,
					l.baidu_longitude as longitude,
					l.heading,concat( l.gpsDate, ' ', l.gpsTime ) as `time` 
				from 
					VehicleInfo v ,
					provision_obd.
					Devices d,
					Devices_MT dm,
					obd_demo.
					LocationStatus l,
					Customers c  
				
				where 
					d.deviceID=dm.deviceID 
					and dm.vin=v.vin 
					and dm.customerID in ($cusIDs) 
					and d.deviceID=l.deviceID  
					and dm.customerID=c.id) b 
			
			where  b.licenseNumber like '%$searchValue%' or b.d_esn like '%$searchValue%'";


	$query = "select * from(
				select 
					c.`name` as customerName,
					dm.nickName,
					d.registerKey,
					d.deviceID,
					v.vin,
					d.d_esn,
					o.name as depName,
					v.licenseNumber,
					l.ign,l.onlineStatus,
					l.address_num,
					l.baidu_latitude as latitude ,
					l.baidu_longitude as longitude,
					l.heading,concat( l.gpsDate, ' ', l.gpsTime ) as `time`,
					(l.alertStatus1+l.alertStatus2+l.alertStatus3+l.alertStatus4+l.alertStatus5+l.alertStatus6+l.alertStatus7+l.alertStatus8) as alertStatus  
				from 
					VehicleInfo v ,
					provision_obd.Devices d,
					Devices_MT dm,
					IOV_demo.Opm_Organ o,
					obd_demo.LocationStatus l,
					Customers c  
				
				where 
					d.deviceID=dm.deviceID 
					and dm.vin=v.vin 
					and d.depID=o.id 
					and dm.customerID in ($cusIDs) 
					and d.deviceID=l.deviceID  
					and dm.customerID=c.id) b 
			
			where  b.licenseNumber like '%$searchValue%' or b.d_esn like '%$searchValue%' limit $page,$rows";
}



#echo $sqlCount;
$result = mysql_query($sqlCount);
$numRows = mysql_num_rows($result);
if ($numRows > 0) {
	while ($row = mysql_fetch_object($result)) {
		$total = $row->total;
	}
	mysql_free_result($result);
}

$logger->debug("-----------vehicles4dep-----sql:------" . $query);
//echo $query;
$result = mysql_query($query);
$numRows = mysql_num_rows($result);
$ret = array ();
//$ret['total'] = $numRows;
$ret['total'] = $total;
if ($numRows > 0) {
	while ($row = mysql_fetch_array($result)) {
		$node = array ();
		if($row['depName']!=null){
			$node['depName'] = $row['depName'];
		}
		$node['customerName'] = $row['customerName'];
		$node['nickName'] = $row['nickName'];
		$node['registerKey'] = $row['registerKey'];
		$node['licenseNumber'] = $row['licenseNumber'];
		$node['d_esn'] = $row['d_esn'];
		$node['address_num'] = $row['address_num'];
		$node['latitude'] = $row['latitude'];
		$node['longitude'] = $row['longitude'];
		
		if($row['time'] <>'0000-00-00 00:00:00'){
			$node['time'] =date("Y-m-d H:i:s", strtotime($row['time'] . '+8hour'));
		}
		else{
			$node['time']=$row['time'];
		}
		$node['vin'] = $row['vin'];
		$node['deviceID'] = $row['deviceID'];
		$node['heading'] = $row['heading'];
		$node['deviceIndex'] = $row['deviceIndex'];
		$node['ign'] = $row['ign'];
		$node['alertStatus'] = $row['alertStatus'];
		if($node['ign']==1){
			if($row['onlineStatus']==0){
				$node['online']='离线';
			}
			else{
				$node['online']='运行中';
			}
			
		}
		else {
			$node['online']='熄火';
		}
		
		if($node['latitude']=="0.000000" and $node['longitude']=="0.000000" and  $node['ign']<>-1){
			$his=getHistoryLocation($node['deviceID']);
			if($his<>null){
				$node['address_num'] =($his->address_num)."（最近有效位置）";
		        $node['latitude'] = $his->latitude;
		        $node['longitude'] =$his->longitude;
		        $node['time']=date("Y-m-d H:i:s", strtotime($his->time . '+8hour'));
			}
		    else{
		    	$node['address_num'] ="无有效位置";
		        $node['latitude'] = "31.243639";
		        $node['longitude'] ="121.508418";
		    }
		}
//		else if($node['ign']==-1){
//			$node['online']='熄火';
//			$node['time']="0000-00-00 00:00:00";
//		}
		
		array_push($data, $node);
	}
	mysql_free_result($result);
}

$ret['rows'] = $data;

echo json_encode($ret);



	//获取部门下所有部门id
	function getDeptLowerId($deptID) {
		mysql_select_db("IOV_demo");
		//	$query = "select id from Departments where parentId=$deptID ";
		$query = "select id from Opm_Organ where parentId=$deptID ";
		$result = mysql_query($query);
		$numRows = mysql_num_rows($result);
		$ret = array ();
		$data = array ();
		if ($numRows > 0) {
			for ($d = 0; $d < $numRows; $d++) {
				$row = mysql_fetch_array($result);
				array_push($ret, $row["id"]); //set
				$data =getDeptLowerId($row["id"]); //query
				for ($i = 0; $i < count($data); $i++) { //set again
					array_push($ret, $data[$i]);
				}
			}
			mysql_free_result($result);
		}
		return $ret;
	}
	
	//获取客户下所有部门id
	function getCousLowerId($deptID) {
		mysql_select_db("IOV_demo");
		//	$query = "select id from Departments where parentId=$deptID ";
		$query = "select id from Customers where parentId=$deptID ";
		$result = mysql_query($query);
		$numRows = mysql_num_rows($result);
		$ret = array ();
		$data = array ();
		if ($numRows > 0) {
			for ($d = 0; $d < $numRows; $d++) {
				$row = mysql_fetch_array($result);
				array_push($ret, $row["id"]); //set
				$data =getCousLowerId($row["id"]); //query
				for ($i = 0; $i < count($data); $i++) { //set again
					array_push($ret, $data[$i]);
				}
			}
			mysql_free_result($result);
		}
		return $ret;
	}
	
	function getHistoryLocation($deviceID) {
		mysql_select_db("obd_demo");
		$sql = "select l.address_num,
					l.baidu_latitude as latitude ,
					l.baidu_longitude as longitude,
					l.heading,concat( l.gpsDate, ' ', l.gpsTime ) as `time` from LocationHistory l 
				    where deviceID='$deviceID' and latitude <>'0.000000' and longitude<>'0.000000' order by locIndex  desc limit 1";
		$selectresult = mysql_query($sql);
		$selectRows = mysql_num_rows($selectresult);
		if ($selectRows > 0) {
			$row = mysql_fetch_object($selectresult);
			return $row;
		}
		return null;

	}
?>