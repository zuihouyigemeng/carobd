
function createZoomControl1() {
	  var div = document.createElement("div");
	  div.innerHTML ="还有"+t+"秒刷新";
	  div.style.cursor = "pointer";
	  div.style.border = "1px solid gray";
	  div.style.backgroundColor = "red";
	  return div;
}


function createZoomControl(txt) {
	var div = document.createElement("div");
	div.style.background = "red";
	div.innerHTML = txt + "</div>";
	div.style.cursor = "pointer";
	div.style.border = "1px solid gray";
	div.style.backgroundColor = "white";
	return div;
}

function bindDiv(deviceID, longitude, latitude, address_num, time, speed,
		engineRPM, batt_level, fuel_level_now, ign, licenseNumber, heading) {
	var map;
	var myLatlng = new google.maps.LatLng(latitude, longitude);
	//if (!mu.containsKey(deviceID)) {
		var mapOptions = {
			zoom : 14,
			center : myLatlng,
			mapTypeId : google.maps.MapTypeId.ROADMAP,
			zoomControl : true,
			zoomControlOptions : {
				style : google.maps.ZoomControlStyle.SMALL
			},
			scaleControl : true
		}
		map = new google.maps.Map(document.getElementById("container_"
				+ deviceID), mapOptions);
/*		mu.put(deviceID, map);
	} else {
		map = mu.get(deviceID);
	}*/

	var sContent = "<div style='width:200px'><h4 style='margin:0 0 5px 0;padding:0.2em 0'>"
			+ licenseNumber
			+ "</h4>"
			+ "<hr/>"
			+ "定位时间："
			+ time
			+ "</br>"
			+ "位置：" + address_num + "</div>";

	var image = 'http://180.166.124.142:9983/obd_web/mapPic/car.png';
	var marker = new google.maps.Marker({
		position : myLatlng,
		title : licenseNumber,
		icon : image,
		map : map
	});
	var infowindow = new google.maps.InfoWindow({
		content : sContent,
		position : myLatlng
	});
	
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map);
	});

	var s = "";
	if (ign == 1) {
		s = "运行";
	} else {
		s = "熄火";
	}
	var tmp = "车牌号：" + licenseNumber + "&nbsp;引擎状态：" + s;
	tmp += "</br>引擎转速：" + engineRPM + "RPM" + "&nbsp;速度：" + speed + "KM/H";
	tmp += "</br>剩余油量：" + fuel_level_now + "%" + "&nbsp;电压：" + batt_level + "V";
	
	if(map.controls[google.maps.ControlPosition.TOP_RIGHT].length>0){
		map.controls[google.maps.ControlPosition.TOP_RIGHT].pop();
	}
	
	var myZoomCtrl = createZoomControl(tmp);
//	alert(myZoomCtrl);
	// 添加到地图当中
	myZoomCtrl.index = 1;
	map.controls[google.maps.ControlPosition.TOP_RIGHT].push(myZoomCtrl);
}


function flesh(){
	//alert("into flesh!");
	if(t==0){
		t=10;
		getLocations(deviceIDs);
	}
	for ( var i=0 ; i < mu.size() ; ++i ) {
		var map =mu.element(i).value;
		if(map.controls[google.maps.ControlPosition.TOP_LEFT].length>0){
			map.controls[google.maps.ControlPosition.TOP_LEFT].pop();
		}
		
		var myZoomCtrl = createZoomControl1();
		// 添加到地图当中
		myZoomCtrl.index = 1;
		map.controls[google.maps.ControlPosition.TOP_LEFT].push(myZoomCtrl);
}
		t=t-1;
}


	
