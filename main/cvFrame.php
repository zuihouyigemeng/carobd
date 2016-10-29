<?php //include("session.php"); ?>
<?php
	// url: http://127.0.0.1:8080/obd_web/main/tripListView.php?deviceId=6C500CBD&startTime=2014-07-02%2000:00:00&stopTime=2014-07-24%2023:59:59
	// url: http://192.168.0.163/obd_web_dev/main/tripListView.php?deviceId=6C500CBD&startTime=2014-07-02%2000:00:00&stopTime=2014-07-24%2023:59:59
?>
<!DOCTYPE html>
<html>   
<head>   
<meta name="viewport" content="initial-scale=1.0, user-scalable=yes" />   
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />   
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="../themes/icon.css">
	<link rel="stylesheet" type="text/css" href="../demo.css">
	<script type="text/javascript" src="../jquery.min.js"></script>
	<script type="text/javascript" src="../jquery.easyui.min.js"></script>
	<script type="text/javascript" src="../locale/easyui-lang-zh_CN.js"></script> 
	<script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/changeMore.js"></script>
<title>conv</title>   
<style type="text/css">   
html{height:100%}   
body{height:100%;margin:0px;padding:0px;bg-color:#505050}  
#container{height:100%;width:100%}   
</style>   
<script>
function convertCoords1(pointsGPS, callbackFunc ){
	parent.showAlert ("convertCoords");
	callback = function (pointsBaidu){
		//parent.setCallbackResult(pointsBaidu);
		//var pointsBaidu = "points of Baidu";
		callbackFunc (pointsBaidu);
	} 

	//setTimeout(callback, 100);	
	BMap.Convertor.transMore(pointGPS,0,callback);
	return "ok";
}

function convertCoords(pointsGPS, callbackFunc ){
	//alert ("convertCoords");
	
	var size = pointsGPS.length;
	var allResults = new Array();
	callback = function (xyResults){ //百度多次回调，每次仅返回20个点
		allResults = allResults.concat(xyResults);
		
		if (allResults.length >= size ){
			callbackFunc(allResults);			
		}
	}
	BMap.Convertor.transMore(pointsGPS,0,callback);
}	 
	
</script>    
</head>   
<body>   
<h1>OK,conv</h1>

</table>
</body>   
</html>
<?php
?>