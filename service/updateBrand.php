<?php
include '../../zend_obd/Vehicle.php';

$device = new Vehicle();

$Brand = $_POST["brandName"];
$BrandID = $_POST["brandId"];

$imageUrl = $_POST["imageURL"];

$fileElementName = 'brand_carImage';

if(!empty($_FILES[$fileElementName]['error']) 
	|| empty($_FILES['brand_carImage']['tmp_name']) 
	|| $_FILES['brand_carImage']['tmp_name'] == 'none'){
	
	$obj = $device->updateBrand($BrandID,$Brand,0);
}else{
	if ($_FILES['brand_carImage'] != "none" && $_FILES['brand_carImage'] != "") {  
	
		#echo "have img---";
	
		#$time_limit = 60;  
		
		#set_time_limit ( $time_limit );  
		
		$file_size = $_FILES ['brand_carImage'] ['size']; 
		 
		$fp = fopen ( $_FILES ['brand_carImage'] ['tmp_name'], "rb" ); 
		 
		if (! $fp){  
		
			die ( "file open error" );  
			
		}
		
		$file_data = file_get_contents($_FILES["brand_carImage"]['tmp_name']); 
		fclose ( $fp );  
		
		#set_time_limit ( 30 ); //恢复缺省超时设置 
		
		$obj = $device->updateBrand($BrandID,$Brand,base64_encode($file_data));  
	}else{
		$obj = $device->updateBrand($BrandID,$Brand,0);
	}
}


$veh = $obj['resultCode'];

echo json_encode($veh);

?>