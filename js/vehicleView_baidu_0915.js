mu= new Map_Utils();
function vehicleClick(rowData){
	//alert("click!");
	lon=rowData.longitude;
	lat=rowData.latitude;
	licenseNumber=rowData.licenseNumber;
	address_num=rowData.address_num;
	time=rowData.time;
	vin=rowData.vin;
	ign=rowData.ign;
	deviceID=rowData.deviceID;
	heading=rowData.heading;
	curr_vin=vin;
	glob_licenseNumber=licenseNumber;
	glob_deviceID=deviceID;
	curr_deviceID=deviceID;
	queryStatusInfo(deviceID);
	$('#dlgVehicle').dialog('open');
	var point = new BMap.Point(lon, lat);
	
//	 BMap.Convertor.translate(gpsPoint,0,function(point){
		//  alert("translateCallback");
		 //   alert(vin);
		  //  alert("mu size:"+mu.size())
		   if(mu.containsKey(vin)){
			  // alert("remove old!");
			   var markerold=mu.get(vin);
				map.removeOverlay(markerold);
				mu.removeByKey(vin);
		   }
		  map.centerAndZoom(point, 15);
		  //  alert("deviceID:"+deviceID);
		 
		// 	alert(sContent);
		  //var point1 = new BMap.Point(lon, lat);
		  //map.centerAndZoom(point1, 10);
		var sContent=  createContent(licenseNumber,time,address_num,deviceID,vin,ign,heading);
		alert(sContent);
		  var iconImg = createIcon();
		  var marker = new BMap.Marker(point,{icon:iconImg});
		  marker.setRotation(heading);
		  marker.setRotation(90);
		  var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
		  marker.addEventListener("click", function(){
		   this.openInfoWindow(infoWindow);
		   //图片加载完毕重绘infowindow
		   document.getElementById('imgDemo').onload = function (){
		       infoWindow.redraw();   //防止在网速较慢，图片未加载时，生成的信息框高度比图片的总高度小，导致图片部分被隐藏
		   }
		  });		
		  map.addOverlay(marker);
		  mu.put(vin,marker);
		  marker.openInfoWindow(infoWindow);
	//	  	});
	 
}

//定义一个控件类,即function
function ZoomControl(){
  // 默认停靠位置和偏移量
  this.defaultAnchor = BMAP_ANCHOR_TOP_RIGHT;
  this.defaultOffset = new BMap.Size(150, 10);
}

//通过JavaScript的prototype属性继承于BMap.Control
ZoomControl.prototype = new BMap.Control();

// 自定义控件必须实现自己的initialize方法,并且将控件的DOM元素返回
// 在本方法中创建个div元素作为控件的容器,并将其添加到地图容器中
ZoomControl.prototype.initialize = function(map){
  // 创建一个DOM元素
  var div = document.createElement("div");
  div.innerHTML ="<img  style='margin:0;padding:0' id='imgDemo1' width='73' height='55' src='../img/btn_01.png'  title='设防' onmouseover='JavaScript:this.src=\"../img/btn_01_focused.png\"'  onmouseout='JavaScript:this.src=\"../img/btn_01.png\"'  onclick='defence()'  />"
  +"<img  id='imgDemo2' style='margin:0;padding:0' width='73' height='55' src='../img/btn_02.png'  title='超速阀值设置' onmouseover='JavaScript:this.src=\"../img/btn_02_focused.png\"'  onmouseout='JavaScript:this.src=\"../img/btn_02.png\"'  onclick='vehiCleSetting()'  />"
  +"<img  id='imgDemo3' style='margin:0;padding:0' width='73' height='55' src='../img/btn_03.png'  title='心跳间隔设置' onmouseover='JavaScript:this.src=\"../img/btn_03_focused.png\"'  onmouseout='JavaScript:this.src=\"../img/btn_03.png\"'  onclick='vehiCleSetting()'  />"
  +"<img  id='imgDemo3' style='margin:0;padding:0' width='73' height='55'  src='../img/btn_04.png'  title='空转阀值设置' onmouseover='JavaScript:this.src=\"../img/btn_04_focused.png\"'  onmouseout='JavaScript:this.src=\"../img/btn_04.png\"'  onclick='vehiCleSetting()'  />"
  +"</div>";
  // 设置样式
  div.style.cursor = "pointer";
  div.style.border = "1px solid gray";
  div.style.backgroundColor = "white";
  div.style.padding = "0px";
  div.style.margin = "0px";
  // 添加DOM元素到地图中
  map.getContainer().appendChild(div);
  // 将DOM元素返回
  return div;
}


function ZoomControl1(){
	  // 默认停靠位置和偏移量
	  this.defaultAnchor = BMAP_ANCHOR_TOP_LEFT;
	  this.defaultOffset = new BMap.Size(80, 10);
	}
//通过JavaScript的prototype属性继承于BMap.Control
ZoomControl1.prototype = new BMap.Control();

//自定义控件必须实现自己的initialize方法,并且将控件的DOM元素返回
// 在本方法中创建个div元素作为控件的容器,并将其添加到地图容器中
ZoomControl1.prototype.initialize = function(map){
	 // 创建一个DOM元素
	  var div = getSecondTxt();
	  
	  // 添加DOM元素到地图中
	  map.getContainer().appendChild(div);
	  // 将DOM元素返回
	  return div;
}

function ZoomControl2(){
	  // 默认停靠位置和偏移量
	  this.defaultAnchor = BMAP_ANCHOR_TOP_LEFT;
	  this.defaultOffset = new BMap.Size(0, 200);
	}
	//通过JavaScript的prototype属性继承于BMap.Control
	ZoomControl2.prototype = new BMap.Control();
	// 自定义控件必须实现自己的initialize方法,并且将控件的DOM元素返回
	// 在本方法中创建个div元素作为控件的容器,并将其添加到地图容器中
	ZoomControl2.prototype.initialize = function(map){
	  // 创建一个DOM元素
	  var div = document.createElement("div");
	  div.innerHTML ="<img  id='imgDemo11' src='../img/btn__0002_left_pressed.png'    onclick='westSwitch()'  />"
	  +"</div>";
	  // 设置样式
	  div.style.cursor = "pointer";
	  div.style.border = "1px solid gray";
	  div.style.backgroundColor = "white";
	  // 添加DOM元素到地图中
	  map.getContainer().appendChild(div);
	  // 将DOM元素返回
	  return div;
	}
	

	var myZoomCtrl1;
	
function init(){
	 map = new BMap.Map("container");
	map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
	map.addControl(new BMap.MapTypeControl({mapTypes: [BMAP_NORMAL_MAP,BMAP_HYBRID_MAP]}));     //2D图，卫星图
	map.addControl(new BMap.ScaleControl());    
	map.addControl(new BMap.OverviewMapControl());    
	//map.setCurrentCity("上海");
	var point = new BMap.Point(103.2319, 35.3349);
	map.centerAndZoom(point, 5);

	// 创建控件
	var myZoomCtrl = new ZoomControl();
	// 添加到地图当中

	map.addControl(myZoomCtrl);


	// 创建控件
	 myZoomCtrl1 = new ZoomControl1();
	// 添加到地图当中

	map.addControl(myZoomCtrl1);
	
	// 创建控件
	var myZoomCtrl2 = new ZoomControl2();
	// 添加到地图当中

	map.addControl(myZoomCtrl2);
	timename=setInterval("flesh();",1000); 

}


function flesh(){
	if(t==0 ){
		//updat maker
		var vin=mu.keys();
		if( vin.length >0){
			
			vin=vin.join(",");
	//		alert("vin:"+vin);
			
			 $.post("../service/fleshVehicles.php",
			  {
				 vins:vin
			  },
			  function(data,status){
				  var rows=eval(data);
			//	  alert(rows[0].deviceID);
			//	  map.clearOverlays(); 
			//	  mu.clear();
				  checkAll(rows);
			  });

			
		}
		
		t=60;
	}
	map.removeControl(myZoomCtrl1);
	ZoomControl1.prototype.initialize = function(map){
		 // 创建一个DOM元素
		  var div = getSecondTxt();
		  // 添加DOM元素到地图中
		  map.getContainer().appendChild(div);
		  // 将DOM元素返回
		  return div;
	}
	// 创建控件
	 myZoomCtrl1 = new ZoomControl1();
	// 添加到地图当中
	map.addControl(myZoomCtrl1);
}

function onUncheckAll (rows){
	
	for ( var i=0 ; i < rows.length ; ++i ) {
		vin=rows[i].vin;
		
		var marker=mu.get(vin);
	//	alert("mu size:"+mu.size());
	//	alert("vin:"+vin +"marker:"+marker);
		map.removeOverlay(marker);
		mu.removeByKey(vin);
	}
}


function checkAll(rows){
//	alert("into checkAll!");
	for ( var i=0 ; i < rows.length ; ++i ) {
	(function (x) {
		lon=rows[x].longitude,
		lat=rows[x].latitude,
		licenseNumber=rows[x].licenseNumber,
		address_num=rows[x].address_num,
		time=rows[x].time;
		heading=rows[x].heading;
		var vin=rows[x].vin;
		deviceID=rows[x].deviceID;
		ign=rows[x].ign;
		if(mu.containsKey(vin)){
			//   alert("remove old!");
			   var markerold=mu.get(vin);
				map.removeOverlay(markerold);
				mu.removeByKey(vin);
		}
		var point = new BMap.Point(lon, lat);
		
//		 BMap.Convertor.translate(gpsPoint,0,function (point){
			 	
				var sContent=  createContent(licenseNumber,time,address_num,deviceID,vin,ign,heading);
			    var iconImg = createIcon();
				var marker = new BMap.Marker(point,{icon:iconImg});
				 marker.setRotation(heading);
				 marker.setRotation(90);
				var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
				marker.addEventListener("click", function(){   
				   this.openInfoWindow(infoWindow);
				});
				map.addOverlay(marker);
				mu.put(vin,marker);

//			});
		  })(i);


	}
	
}

function createIcon(){
    var icon = new BMap.Icon("http://180.166.124.142:9983/obd_web/mapPic/car.png", new BMap.Size(43,23));
    return icon;
}

