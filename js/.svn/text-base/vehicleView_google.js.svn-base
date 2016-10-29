var myZoomCtrl1;
var mu= new Map_Utils();
function init() {
	var mapOptions = {
		zoom : 5,
		center : new google.maps.LatLng(35.3349, 103.2319),
		mapTypeId : google.maps.MapTypeId.ROADMAP,
		zoomControl: true,
	    zoomControlOptions: {
	      style: google.maps.ZoomControlStyle.SMALL
	    },
		scaleControl : true
	}
	 map = new google.maps.Map(document.getElementById("container"),
			mapOptions);
	
	// 创建快捷功能控件
	var myZoomCtrl = createZoomControl();
	// 添加到地图当中
	myZoomCtrl.index = 1;
	map.controls[google.maps.ControlPosition.TOP_RIGHT].push(myZoomCtrl);

	 myZoomCtrl1 = createZoomControl1();
	// 添加到地图当中
	myZoomCtrl1.index = 1;
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(myZoomCtrl1);

	// 创建west region switch功能控件
	var myZoomCtrl2 = createZoomControl2();
	// 添加到地图当中
	myZoomCtrl2.index = 1;
	map.controls[google.maps.ControlPosition.LEFT_CENTER].push(myZoomCtrl2);

	timename=setInterval("flesh();",1000); 
}

function createZoomControl() {
	// 创建一个DOM元素
	var div = document.createElement("div");
	div.innerHTML = "<img  style='margin:0;padding:0' id='imgDemo1' width='73' height='55' src='../img/btn_01.png'  title='设防' onmouseover='JavaScript:this.src=\"../img/btn_01_focused.png\"'  onmouseout='JavaScript:this.src=\"../img/btn_01.png\"'  onclick='defence()'  />"
			+ "<img  id='imgDemo2' style='margin:0;padding:0' width='73' height='55' src='../img/btn_02.png'  title='超速阀值设置' onmouseover='JavaScript:this.src=\"../img/btn_02_focused.png\"'  onmouseout='JavaScript:this.src=\"../img/btn_02.png\"'  onclick='vehiCleSetting()'  />"
			+ "<img  id='imgDemo3' style='margin:0;padding:0' width='73' height='55' src='../img/btn_03.png'  title='心跳间隔设置' onmouseover='JavaScript:this.src=\"../img/btn_03_focused.png\"'  onmouseout='JavaScript:this.src=\"../img/btn_03.png\"'  onclick='vehiCleSetting()'  />"
			+ "<img  id='imgDemo3' style='margin:0;padding:0' width='73' height='55'  src='../img/btn_04.png'  title='空转阀值设置' onmouseover='JavaScript:this.src=\"../img/btn_04_focused.png\"'  onmouseout='JavaScript:this.src=\"../img/btn_04.png\"'  onclick='vehiCleSetting()'  />"
			+ "</div>";
	// 设置样式
	div.style.cursor = "pointer";
	div.style.border = "1px solid gray";
	div.style.backgroundColor = "white";
	div.style.padding = "0px";
	div.style.margin = "0px";
	// 将DOM元素返回
	return div;
}

function createZoomControl2() {
	// 创建一个DOM元素
	var div = document.createElement("div");
	div.innerHTML = "<img  id='imgDemo11' src='../img/btn__0002_left_pressed.png'    onclick='westSwitch()'  />"
			+ "</div>";
	// 设置样式
	div.style.cursor = "pointer";
	div.style.border = "1px solid gray";
	div.style.backgroundColor = "white";
	// 将DOM元素返回
	return div;
}

function createZoomControl1() {
	// 创建一个DOM元素
	var div = getSecondTxt();
	// 将DOM元素返回
	return div;
}

function flesh(){
	if(t==0 ){
		var vin=mu.keys();
		if( vin.length >0){
			vin=vin.join(",");
			 $.post("../service/fleshVehicles.php",
			  {
				 vins:vin
			  },
			  function(data,status){
				  var rows=eval(data);
				  checkAll(rows);
			  });	
		}	
		t=60;
	}
map.controls[google.maps.ControlPosition.TOP_LEFT].removeAt(0);
 //添加到地图当中
 myZoomCtrl1 = createZoomControl1();
 myZoomCtrl1.index = 1;
 map.controls[google.maps.ControlPosition.TOP_LEFT].push(myZoomCtrl1);
}

function vehicleClick(rowData){
	lon=rowData.longitude;
	lat=rowData.latitude;
	licenseNumber=rowData.licenseNumber;
	address_num=rowData.address_num;
	time=rowData.time;
	vin=rowData.vin;
	ign=rowData.ign;
	online=rowData.online;
	deviceID=rowData.deviceID;
	heading=rowData.heading;
	curr_vin=vin;
	glob_licenseNumber=licenseNumber;
	glob_deviceID=deviceID;
	curr_deviceID=deviceID;
	queryStatusInfo(deviceID);
	$('#dlgVehicle').dialog('open');
	 if(mu.containsKey(vin)){
		   var markerold=mu.get(vin);
		   markerold.setMap(null);
		   mu.removeByKey(vin);
	   }
	var myLatlng = new google.maps.LatLng(lat,lon);
	var sContent=  createContent(licenseNumber,time,address_num,deviceID,vin,ign,online,heading);
	    map.setZoom(14);
		var image = 'http://180.166.124.142:9983/obd_web/mapPic/car.png';

		var marker = new google.maps.Marker({
		      position: myLatlng,
		      title:licenseNumber,
		      icon:image,
		      map:map
		  });
		mu.put(vin,marker);
	var infowindow=new google.maps.InfoWindow({
		        content: sContent,
		        position:myLatlng
		    });
		    infowindow.open(map);
 google.maps.event.addListener(marker, 'click', function() { 
	           infowindow.open(map);
		      }); 
}


function checkAll(rows){
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
		online=rows[x].online;
		if(mu.containsKey(vin)){
			   var markerold=mu.get(vin);
			   markerold.setMap(null);
			   mu.removeByKey(vin);
		}
		var myLatlng =new google.maps.LatLng(lat,lon);	 	
		var sContent=  createContent(licenseNumber,time,address_num,deviceID,vin,ign,online,heading);
		var image = 'http://180.166.124.142:9983/obd_web/mapPic/car.png';
		var marker = new google.maps.Marker({
					      position: myLatlng,
					      title:licenseNumber,
					      icon:image,
					      map:map
					  });
				mu.put(vin,marker);
				var infowindow=new google.maps.InfoWindow({
			        content: sContent,
			        position:myLatlng
			    });
			  //  infowindow.open(map);
	 google.maps.event.addListener(marker, 'click', function() { 
		           infowindow.open(map);
			      }); 
				
		  })(i);
	}
}

function onUncheckAll (rows){
	for ( var i=0 ; i < rows.length ; ++i ) {
		vin=rows[i].vin;
		var marker=mu.get(vin);
		marker.setMap(null);;
		mu.removeByKey(vin);
	}
}





