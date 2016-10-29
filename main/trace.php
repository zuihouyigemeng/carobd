
<?php include("session.php"); ?>
<?php
ob_start();
session_start();
$deviceIDs = isset ($_GET['deviceID']) ? $_GET['deviceID'] : '';
//echo $deviceIDs;
?>
<!DOCTYPE html>   
<html>   
<head> 
<link rel="stylesheet" type="text/css" href="../themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="../themes/icon.css">
	<link rel="stylesheet" type="text/css" href="../demo.css">
	<script type="text/javascript" src="../jquery.min.js"></script>
	<script type="text/javascript" src="../jquery.easyui.min.js"></script>
	<script type="text/javascript" src="../map_utils.js"></script>
<meta name="viewport" content="initial-scale=1.0, user-scalable=yes" />   
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />   
<title>车辆监控</title>   
<style type="text/css">   
html{height:100%}   
body{height:100%;margin:0px;padding:0px}  
#container{height:100%}   

a:hover img{
background-color: #ffffff
}
 
.xxdiv1 { width:100%; height:100%; border:0px #CCCCCC solid; background:#F6F6F6; margin:0px 0px 0px 0px; padding: 0; float:left; }
.xxdiv2 { width:49%; height:99%; border:1px #CCCCCC solid; background:#F6F6F6; margin:0px 0px 0px 0px; padding: 0; float:left; }
.xxdiv3 { width:49%; height:49%; border:1px #CCCCCC solid; background:#F6F6F6; margin:0px 0px 0px 0px; padding: 0; float:left; }
.xxdiv4 { width:49%; height:49%; border:1px #CCCCCC solid; background:#F6F6F6; margin:0px 0px 0px 0px; padding: 0; float:left; }
.xxdiv5 { width:33%; height:49%; border:1px #CCCCCC solid; background:#F6F6F6; margin:0px 0px 0px 0px; padding: 0; float:left; }
.xxdiv6 { width:33%; height:49%; border:1px #CCCCCC solid; background:#F6F6F6; margin:0px 0px 0px 0px; padding: 0; float:left; }
.xxdiv7 { width:24.85%; height:49.85%; border:1px #CCCCCC solid; background:#F6F6F6; margin:0px 0px 0px 0px; padding: 0; float:left; }
.xxdiv8 { width:24.85%; height:49.85%; border:1px #CCCCCC solid; background:#F6F6F6; margin:0px 0px 0px 0px; padding: 0; float:left; }


.blank1 { width:100%; height:100%; border:0px #CCCCCC solid; background:#000000; margin:0px 0px 0px 0px; padding: 0; float:left; }
.blank2 { width:49%; height:99%; border:1px #CCCCCC solid; background:#000000; margin:0px 0px 0px 0px; padding: 0; float:left; }
.blank3 { width:49%; height:49%; border:1px #CCCCCC solid; background:#000000; margin:0px 0px 0px 0px; padding: 0; float:left; }
.blank4 { width:49%; height:49%; border:1px #CCCCCC solid; background:#000000; margin:0px 0px 0px 0px; padding: 0; float:left; }
.blank5 { width:33%; height:49%; border:1px #CCCCCC solid; background:#000000; margin:0px 0px 0px 0px; padding: 0; float:left; }
.blank6 { width:33%; height:49%; border:1px #CCCCCC solid; background:#000000; margin:0px 0px 0px 0px; padding: 0; float:left; }
.blank7 { width:24.85%; height:49.85%; border:1px #CCCCCC solid; background:#000000; margin:0px 0px 0px 0px; padding: 0; float:left; }
.blank8 { width:24.85%; height:49.85%; border:1px #CCCCCC solid; background:#000000; margin:0px 0px 0px 0px; padding: 0; float:left; }
</style>   
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=oCbw1Qz8ayXfZKlgDHKyfsWG"></script> 
<script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script> 
</head>   
    
<body> 
<div  style="width:100%;height:4%;padding:0px;">
	<span style="padding:0 0 0 5px;">路数选择：</span>
	<select  id="routeSelect" class="easyui-combobox"   daa-options="panelHeight:'auto'" name="routeSwitch" style="width:200px;">
		<option value="0"></option>
		<option value="1">1*1路</option>
		<option value="2">2*1路</option>
		<option value="4">2*2路</option>
		<option value="6">3*2路</option>
		<option value="8">4*2路</option>
	</select>
</div>
<div id="trace"   style="width:100%;height:96%;padding:0px">

	  <div  id="dlgFortification" class="easyui-dialog" title="车辆选择"  closed="true"  style="width:250px;height:200px;padding:10px">
		
		<div class="easyui-tabs" style="width:250px;height:200px" id='tt1'>	

		<div title="部门"  style="overflow:auto;padding:10px;">
			<ul class="easyui-tree"   url="../service/departments.php?defDep=<?php echo  $userVo->depID ?>" data-options="animate:true,checkbox:true,onlyLeafCheck:true"  id="depID">
				
			</ul>
		</div>
		<div title="车系"  style="overflow:auto;padding:10px;">
				
			<ul class="easyui-tree"   url="../service/vehicleNumber.php?defDep=<?php echo  $userVo->depID ?>" data-options="animate:true,checkbox:true,onlyLeafCheck:true"  id="v_modelID">
				
			</ul>
		</div>

		<div title="客户"  style="overflow:auto;padding:10px;">
				
			<ul class="easyui-tree"   url="../service/customer.php?defDep=<?php echo  $userVo->depID ?>" data-options="animate:true,checkbox:true,onlyLeafCheck:true"  id="v_cusID">
				
			</ul>
		</div>

		</div>
		
		
		

	    </div>
	    
	    
	    
	    
	    
	    
	    
</div>  
<script type="text/javascript"> 



var deviceIDs='<?php echo $deviceIDs?>';
var  devicesArr=deviceIDs.split(","); 

var routNumber=1;
var vehicleNumber=devicesArr.length;
var vehicleNumber1=vehicleNumber;

//alert("vehicleNumber:"+vehicleNumber);
if(vehicleNumber==1 || vehicleNumber==2  ){
	routNumber=vehicleNumber;
}
else if(vehicleNumber>2 &&  vehicleNumber<5){
	routNumber=4;
}
else if(vehicleNumber>4 && vehicleNumber<7){
	routNumber=6;
}
else {
	routNumber=8;
}

//alert("----routNumber:"+routNumber);






//定义一个控件类,即function
 
  var vehicleNumber1=vehicleNumber;
  var arr=new Array(); 
  var mu= new Map_Utils();
  

 
  
$('#routeSelect').combobox({
	onSelect: function(record){
//		alert("select:"+record.value);
		if(record.value<vehicleNumber){
			alert("至少选择"+vehicleNumber+"路！");
			return ;
		}
		mu.clear();
		routNumber=record.value;
		vehicleNumber1=vehicleNumber;
		 createDivs();
		  getLocations(deviceIDs);
	}
});


 // createDivs();
//getLocations(deviceIDs);
  
  
 function  getLocations(dd){
  	$.post("../service/locations.php",
		  {
			 deviceIDS:dd
		  },
		  function(data,status){
			 var rows=eval(data);
			 for ( var i=0 ; i < rows.length ; ++i ){
			 	deviceID=rows[i].deviceID;
			 	longitude=rows[i].longitude;
			 	latitude=rows[i].latitude;
			 	address_num=rows[i].address_num;
			 	time=rows[i].time;
	//		 	alert("time :"+time);
			 	speed=rows[i].speed;
			 	engineRPM=rows[i].engineRPM;
			 	batt_level=rows[i].batt_level;
			 	fuel_level_now=rows[i].fuel_level_now;
			 	ign=rows[i].ign;
			 	licenseNumber=rows[i].licenseNumber;
			 	heading =rows[i].heading;
				alertStatus = rows[i].alertStatus;
			 	bindDiv (deviceID,longitude,latitude,address_num,time,speed,engineRPM,batt_level,fuel_level_now,ign,licenseNumber,heading,alertStatus);
	
	 
	
			 }
			  
		  });
  	
  }
  
  function divClick(){
  	alert("aha");
  	 $('#dlgFortification').dialog('open');
  }
  
  function createDivs(){
   //   alert("createDivs:"+vehicleNumber);
	  var div = "";
	  for ( var i=0 ; i < routNumber ; ++i ){
		  if(vehicleNumber1>0){
			  div=(div+"<div class='xxdiv"+routNumber+ "' id='container_"+devicesArr[i]+"'></div>");
		  }
		  else{
			  div=(div+"<div class='blank"+routNumber+ "' title='单击添加车辆'  onclick='divClick()' id='container_"+i+"'></div>");
		  }
		  vehicleNumber1--;
	  }
//	  alert(div);
	  $("#trace").html(div);
  }
  
  function ZoomControl(){
	  // 默认停靠位置和偏移量
	  this.defaultAnchor = BMAP_ANCHOR_TOP_RIGHT;
	  this.defaultOffset = new BMap.Size(10, 5);
	}

	
	
   function bindDiv (deviceID,longitude,latitude,address_num,time,speed,engineRPM,batt_level,fuel_level_now,ign,licenseNumber,heading,alertStatus){
	var map;
	if(!mu.containsKey(deviceID)){
	map = new BMap.Map("container_"+deviceID);
	var opts = {type: BMAP_NAVIGATION_CONTROL_ZOOM }    
	map.addControl(new BMap.NavigationControl(opts));
	map.addControl(new BMap.ScaleControl());    
	map.addControl(new BMap.OverviewMapControl());  
	mu.put(deviceID,map);
	}
	else{
		map=mu.get(deviceID);
	}
	var point = new BMap.Point(longitude, latitude);
//	BMap.Convertor.translate(gpsPoint,0,function (point){
//		 var point = new BMap.Point(longitude, latitude);

 var sContent =
	"<div style='width:200px'><h4 style='margin:0 0 5px 0;padding:0.2em 0'>"+licenseNumber+"</h4>"
	+"<hr/>"
	+"定位时间："+time+"</br>"
	+"位置："+address_num+"</div>";
	
var iconImg = null;//createIcon();
		
if(alertStatus == 0){//无告警
	if(ign==1){
		if(onlineStatus==0){
			iconImg = createIcon("offline");
		}
		else{
			iconImg = createIcon("run");
		}
	}else{
		iconImg = createIcon("flameout");
	}			
}else{
	iconImg = createIcon("no");
}

var s="";
if(ign==1){
	//s="运行";
	if(onlineStatus==0){
		s='离线';
	}
	else{
		s='运行中';
	}
}
else{
	s="熄火";
}
var marker = new BMap.Marker(point,{icon:iconImg});
var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
marker.addEventListener("click", function(){
   this.openInfoWindow(infoWindow);
});
map.centerAndZoom(point, 15);
marker.setRotation(heading);
marker.setRotation(90);
map.addOverlay(marker);
/*var s="";
if(ign==1){
	s="运行";
}
else{
	s="熄火";
}*/
var tmp="车牌号："+licenseNumber +"&nbsp;引擎状态："+s;
    tmp+="</br>引擎转速："+engineRPM+"RPM"+"&nbsp;速度："+speed+"KM/H" ;
    tmp+="</br>剩余油量："+fuel_level_now+"%"+"&nbsp;电压："+batt_level+"V";
function ZoomControl(){
	  // 默认停靠位置和偏移量
	  this.defaultAnchor = BMAP_ANCHOR_TOP_RIGHT;
	  this.defaultOffset = new BMap.Size(10, 5);
	}

	//通过JavaScript的prototype属性继承于BMap.Control
	ZoomControl.prototype = new BMap.Control();

	// 自定义控件必须实现自己的initialize方法,并且将控件的DOM元素返回
	// 在本方法中创建个div元素作为控件的容器,并将其添加到地图容器中
	ZoomControl.prototype.initialize = function(map){
	  // 创建一个DOM元素
	  var div = document.createElement("div");
	  div.style.background="red";
	  div.innerHTML =tmp+"</div>";
	  // 设置样式
	  div.style.cursor = "pointer";
	  div.style.border = "1px solid gray";
	  div.style.backgroundColor = "white";
	  // 添加DOM元素到地图中
	  map.getContainer().appendChild(div);
	  // 将DOM元素返回
	  return div;
	}
	// 创建控件
	var myZoomCtrl = new ZoomControl();
	// 添加到地图当中

	map.addControl(myZoomCtrl);
//	 });
	
	

  }

var t=10;
timename=setInterval("flesh()",1000); 
function ZoomControl1(){
	  // 默认停靠位置和偏移量
	  this.defaultAnchor = BMAP_ANCHOR_TOP_LEFT;
	  this.defaultOffset = new BMap.Size(50, 5);
	}

function flesh(){
	
	if(t==0){
		t=10;
		getLocations(deviceIDs);
	
	}
	
	for ( var i=0 ; i < mu.size() ; ++i ) {
		var map =mu.element(i).value;
		// 创建控件
		var myZoomCtrl = new ZoomControl1();
		// 添加到地图当中

		map.addControl(myZoomCtrl);
		
}
		t=t-1;
}


		ZoomControl1.prototype = new BMap.Control();

		// 自定义控件必须实现自己的initialize方法,并且将控件的DOM元素返回
		// 在本方法中创建个div元素作为控件的容器,并将其添加到地图容器中
		ZoomControl1.prototype.initialize = function(map){
			 // 创建一个DOM元素
			  var div = document.createElement("div");
			  div.innerHTML ="还有"+t+"秒刷新";
			  // 设置样式
			  div.style.cursor = "pointer";
			  div.style.border = "1px solid gray";
			  div.style.backgroundColor = "red";
			  
			  // 添加DOM元素到地图中
			  map.getContainer().appendChild(div);
			  // 将DOM元素返回
			  return div;
		}

$(document).ready(function(){
	$('#routeSelect').combobox('select', routNumber);
	}); 
	
	
function createIcon(){
    var icon = new BMap.Icon("http://180.166.124.142:9983/obd_web/mapPic/car.png", new BMap.Size(43,23));
    return icon;
}

</script>   
</body>   
</html>