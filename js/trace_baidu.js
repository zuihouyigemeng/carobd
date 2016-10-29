
  function ZoomControl(){
	  // 默认停靠位置和偏移量
	  this.defaultAnchor = BMAP_ANCHOR_TOP_RIGHT;
	  this.defaultOffset = new BMap.Size(10, 5);
	}
	var calcAttr = [];
	var count = 0;
	var calcTimer = "<div style='cursor: pointer; border: 1px solid #3C7691; position: absolute; z-index: 10; bottom: auto; right: auto; top: 5px; left: 50px; background-color: rgb(201,14,26);background-color: rgba(201,14,26,0.7);padding:4px;border-radius:4px;' class='myTimer BMap_noprint anchorTL'></div>";
   function bindDiv (times,deviceID,longitude,latitude,address_num,time,speed,engineRPM,batt_level,fuel_level_now,ign,licenseNumber,onlineStatus,heading,alertStatus){
	var map;	

	if(times == 2){
		
		mu.removeByKey(gDeviceId);
		
		map = new BMap.Map("container_"+deviceID,{enableMapClick:false});
		var opts = {type: BMAP_NAVIGATION_CONTROL_ZOOM }    
		map.addControl(new BMap.NavigationControl(opts));
		map.addControl(new BMap.ScaleControl());    
		map.addControl(new BMap.OverviewMapControl());  
		mu.put(deviceID,map);
		gDeviceId = deviceID;//更新全局变量
		//clearInterval(calcAttr[--count]);
		
		calcAttr.length = count-1;
		
		calcAttr[count++] = setInterval("flesh()",1000);
		
		$("#container_"+deviceID).append(calcTimer);

	}else if(times == 1){
		gDeviceId = deviceID;
		mu.removeByKey(gDeviceId);
		map = new BMap.Map("container_"+deviceID,{enableMapClick:false});
		var opts = {type: BMAP_NAVIGATION_CONTROL_ZOOM }    
		map.addControl(new BMap.NavigationControl(opts));
		map.addControl(new BMap.ScaleControl());    
		map.addControl(new BMap.OverviewMapControl());  
		mu.put(deviceID,map);
		calcAttr[count++] = setInterval("flesh()",1000);
		$("#container_"+deviceID).append(calcTimer);
		
	}else if(times == 0){
		if(!mu.containsKey(deviceID)){
			map = new BMap.Map("container_"+deviceID,{enableMapClick:false});
			var opts = {type: BMAP_NAVIGATION_CONTROL_ZOOM }    
			map.addControl(new BMap.NavigationControl(opts));
			map.addControl(new BMap.ScaleControl());    
			map.addControl(new BMap.OverviewMapControl());  
			mu.put(deviceID,map);
		}
		else{
			map=mu.get(deviceID);	
		}	
	}
	var point = new BMap.Point(longitude, latitude);
//	BMap.Convertor.translate(gpsPoint,0,function (point){
//		 var point = new BMap.Point(longitude, latitude);

	  if(marker_mu.containsKey(deviceID)){
		  var markerold=marker_mu.get(deviceID);
			map.removeOverlay(markerold);
			marker_mu.removeByKey(deviceID);
	  }
 var sContent =
	"<div style='width:200px;'><h4 style='margin:0 0 5px 0;padding:0.2em 0'>"+licenseNumber+"</h4>"
	+"<hr/>"
	+"定位时间："+time+"</br>"
	+"位置："+address_num+"</div>";
	
//var iconImg = createIcon();
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

var zoom = 15;
if(map.getZoom() > 3){
	zoom = map.getZoom();	
}
//console.info(map.getZoom());
map.centerAndZoom(point,zoom);
//marker.setRotation(heading);
//marker.setRotation(90);
marker.setRotation(parseInt(heading)+90);
map.addOverlay(marker);
marker_mu.put(deviceID,marker);
map.enableScrollWheelZoom();    // 启动鼠标滚轮操作
if(control_mu.containsKey(deviceID)){
	  var controlold=control_mu.get(deviceID);
		map.removeControl(controlold);
		control_mu.removeByKey(deviceID);
}



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
	  div.innerHTML =tmp+"</div>";
	  // 设置样式
	  div.style.cursor = "pointer";
	  div.style.border = "1px solid #3C7691";
	  
	  
	  if($.browser.msie&&($.browser.version  < 9)){
		  div.style.backgroundColor = "rgb(91,192,222)";	  
	  }else{
		  div.style.backgroundColor = "rgba(91,192,222,0.65)";
		  div.style.borderRadius = "4px";
	  }
	  
	  div.style.color = "#000";
	  div.style.padding = "8px";
	 
	  div.style.fontSize = "13px";
	  
	  // 添加DOM元素到地图中
	  map.getContainer().appendChild(div);
	  // 将DOM元素返回
	  return div;
	}
	// 创建控件
	var myZoomCtrl = new ZoomControl();
	// 添加到地图当中

	map.addControl(myZoomCtrl);
	control_mu.put(deviceID,myZoomCtrl);
//	 });
	
		
  }


function ZoomControl1(){
	  // 默认停靠位置和偏移量
	  this.defaultAnchor = BMAP_ANCHOR_TOP_LEFT;
	  this.defaultOffset = new BMap.Size(50, 5);
	}


var t = 11;
function flesh(){
	
	$(".myTimer").html("还有"+t+"秒刷新");
	
}

setInterval("updateNumber()",1000);
function updateNumber(){
	if(t==1){
		t=11;
		getLocations(0,deviceIDs);
	}	
	t = t - 1;
}

		ZoomControl1.prototype = new BMap.Control();

		// 自定义控件必须实现自己的initialize方法,并且将控件的DOM元素返回
		// 在本方法中创建个div元素作为控件的容器,并将其添加到地图容器中
		ZoomControl1.prototype.initialize = function(map){
			 // 创建一个DOM元素
			  var div = document.createElement("div");
			  div.innerHTML ="还有"+(t<10 ? '0' + t : t)+"秒刷新";
			  // 设置样式
			  div.style.cursor = "pointer";
			  div.style.border = "1px solid #3C7691";
			 			  
			  if($.browser.msie&&($.browser.version < 9)){
				  div.style.backgroundColor = "rgb(91,192,222)";	  
			  }else{
				  div.style.backgroundColor = "rgba(91,192,222,0.65)";
				  div.style.borderRadius = "4px";
			  }
			  
			  div.style.padding = "4px";
	  		  div.style.fontSize = "13px";
			  
			  // 添加DOM元素到地图中
			  map.getContainer().appendChild(div);
			  // 将DOM元素返回
			  return div;
		}
	
function createIcon(carImg){
    //var icon = new BMap.Icon("http://180.166.124.142:9983/obd_web/mapPic/car.png", new BMap.Size(43,23));
	var icon = null;
	
	if(carImg == "run"){
		icon = new BMap.Icon("../img/car/car_green.png", new BMap.Size(43,23));
	}else if(carImg == "offline"){
		icon = new BMap.Icon("../img/car/car_lightgray.png", new BMap.Size(43,23));
	}else if(carImg == "flameout"){
		icon = new BMap.Icon("../img/car/car_gray.png", new BMap.Size(43,23));
	}else if(carImg == "no"){
		icon = new BMap.Icon("../img/car/car_red.png", new BMap.Size(43,23));
	}
	
	
    return icon;
}
