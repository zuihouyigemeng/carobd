
// 2014-08, by rb
(function(){

function Point(latitude,longitude){
	this.lat = latitude;
	this.lng = longitude;
}

function initMap(mapEngine,htmlNodeID){
	//alert("initMap!");
	var mapObj;
	switch (mapEngine){
		case 'google':	
			var mapOptions = {          
				center: new google.maps.LatLng(35.3349,103.2319),        
				zoom: 5,          
				mapTypeId: google.maps.MapTypeId.ROADMAP        
			};        
			mapObj = new google.maps.Map(document.getElementById("container"),mapOptions);			
			break;

		case 'baidu':	
		default:
			mapObj = new BMap.Map("container");
			mapObj.addControl(new BMap.NavigationControl());  
			mapObj.addControl(new BMap.ScaleControl());    
			mapObj.addControl(new BMap.MapTypeControl({mapTypes: [BMAP_NORMAL_MAP,BMAP_HYBRID_MAP]}));    
			var pt = new BMap.Point(103.2319, 35.3349);
			mapObj.centerAndZoom(pt, 5);
			break;
	}
	return mapObj;
}	

function isValidGps(lat,lng){
	return ((lat>+1e-5 && lat<=90.0)|| (lat<-1e-5 && lat >=-90.0)) && ((lng>+1e-5 && lng<=180.0)|| (lng<-1e-5 && lng >=-180.0));
}

function displayPolyline(mapEngine,mapObj,points){
	switch (mapEngine){
	case "google":
		return _displayPolyline_google_(mapObj,points);
		break;
	case "baidu":
		return _displayPolyline_baidu_(mapObj,points);
		break;
	}
}

function clearPolyline (mapEngine,mapObj,trackLine){
	switch (mapEngine){
	case "google":
		_clearPolyline_google_(mapObj,trackLine);
		break;
	case "baidu":
		_clearPolyline_baidu_(mapObj,trackLine);
		break;
	default:
		break;
	}
}

function clearIcons(mapEngine,mapObj,iconArray){
	switch (mapEngine){
	case "google":
		_clearIcons_google_(mapObj,iconArray);
		break;
	case "baidu":
		_clearIcons_baidu_(mapObj,iconArray);
		break;
	default:
		break;
	}
}

function displayTrackPointAtOffset(mapEngine,mapObj,lat,lon,iconUrl,height,width,anchorY,anchorX,rotation,data){
	//(不管纠偏)	
	//console.log("displayTrackPointAtOffset:" + lon + "," + lat + ". icon:" + iconUrl + ".Height:" + height + ",width:" + width + ".Rotation:" + rotation);
	//console.log(typeof data == "object");
	var marker;
	var anchorY = arguments[7] ? arguments[7] : height/2;	
	var anchorX = arguments[8] ? arguments[8] : width /2;			
 	var rotation = arguments[9] ? arguments[9] : 0;
	
	var point = new BMap.Point(lon, lat);
	
	var offset;
	offset = new BMap.Size(anchorX,anchorY); 
	var myIcon = new BMap.Icon(iconUrl,new BMap.Size(width,height),{anchor: offset});
	marker = new BMap.Marker(point,{icon:myIcon});
	
	if (rotation !=0) marker.setRotation(rotation);
	
	mapObj.addOverlay(marker);				
	mapObj.setCenter(point);
	
	if(typeof data == "object"){
		var infoWindow = new BMap.InfoWindow("<div>"+
					"<span style='color:blue;font-size:16px;display:block;'>车牌:"+
					data.deviceID+"</span>"+"<span style='display:block;line-height:24px;font-size:14px;'>位置: "+
					data.address_num+"</span><span style='display:block;font-size:14px;'>时间: "+
					data.gpsStamp+"</span></div>");  // 创建信息窗口对象
		marker.openInfoWindow(infoWindow);
	}

	//alert (pt.lng + "," + pt.lat);
	return marker;	
}

function displayTrackPointByIcon(mapEngine,mapObj,lat,lon,iconUrl,height,width,anchorPoint,rotation){
	//alert("displayTrackPointByIcon");  //reserved, unused.
	// anchorPoint: 
	//		"bottom_right" 右下角
	//		
 	var anchorPoint = arguments[7] ? arguments[7] : "center";	
	var rotation = arguments[8] ? arguments[8] : 0;
	
	var point = new BMap.Point(lon, lat);
	var offset;
	
	switch (anchorPoint){
		case "bottom_right": 
			offset = new BMap.Size(width,height); break;
		case "center":
		default:	
			offset = new BMap.Size(width/2,height/2); break;			
	}
	var myIcon = new BMap.Icon(iconUrl,new BMap.Size(height,width),{anchor: offset});
	var marker = new BMap.Marker(point,{icon:myIcon});
	marker.setRotation(rotation);
	mapObj.addOverlay(marker);
	
	return marker;	//	返回句柄	
}

function removeTrackPoint(mapEngine,mapObj,lastPoint){
	//lastPoint: Type -- overlay
	mapObj && mapObj.removeOverlay(lastPoint);
}

//baidu API
function _displayPolyline_baidu_(mapObj,points){
	var trackLine;
	var pointsOnMap = new Array();
	var maxX,maxY,minX,minY;
	for (var pointNo in points){
		pointsOnMap[pointNo] = new BMap.Point(points[pointNo].lng, points[pointNo].lat);	
		if (pointNo==0){
			maxX = points[pointNo].lng;
			minX = points[pointNo].lng;
			maxY = points[pointNo].lat;
			minY = points[pointNo].lat;					
		}else{
			maxX = (maxX>=points[pointNo].lng)?maxX:points[pointNo].lng;
			minX = (minX<=points[pointNo].lng)?minX:points[pointNo].lng;
			maxY = (maxY>=points[pointNo].lat)?maxY:points[pointNo].lat;
			minY = (minY<=points[pointNo].lat)?minY:points[pointNo].lat;
		}
		//pointNo++;
	}
	trackLine = new BMap.Polyline(pointsOnMap,{strokeColor:"green", strokeWeight:6, stokeOpacity:0.5}	);		
	mapObj && mapObj.addOverlay(trackLine);
	var MBRpoints = new Array();
	MBRpoints[0]=new BMap.Point(maxX,maxY);
	MBRpoints[1]=new BMap.Point(minX,minY);	
	var viewPort = mapObj.getViewport(MBRpoints);
	mapObj.centerAndZoom(viewPort.center, viewPort.zoom);//new BMap.Point(centX,centY), viewPort.zoom);
	return trackLine;
} 

function _clearPolyline_baidu_ (mapObj,trackLine){
	mapObj && mapObj.removeOverlay(trackLine);
}

function _clearIcons_baidu_(mapObj,iconArray){
	for (var index in iconArray){
		mapObj.removeOverlay(iconArray[index]);	
	}	
	iconArray = new Array();
	return;
}

//google API
function _displayPolyline_google_(mapObj,points){
//	  var flightPlanCoordinates = [
//	                               new google.maps.LatLng(31.20918, 121.58211),
//	                               new google.maps.LatLng(31.23918, 121.58211),
//	                               new google.maps.LatLng(31.23918, 121.55211),
//	                               new google.maps.LatLng(31.20918, 121.55211)
//	                             ];
	var flightPlanCoordinates = new Array();
	var maxX,minY,minX,minY;
	for (var pointNo in points){
		flightPlanCoordinates[pointNo]= new google.maps.LatLng(points[pointNo].lat, points[pointNo].lng );
		if (pointNo==0){
			maxX = points[pointNo].lng;
			minX = points[pointNo].lng;
			maxY = points[pointNo].lat;
			minY = points[pointNo].lat;					
		}else{
			maxX = (maxX>=points[pointNo].lng)?maxX:points[pointNo].lng;
			minX = (minX<=points[pointNo].lng)?minX:points[pointNo].lng;
			maxY = (maxY>=points[pointNo].lat)?maxY:points[pointNo].lat;
			minY = (minY<=points[pointNo].lat)?minY:points[pointNo].lat;
		}
	}
	var flightPath = new google.maps.Polyline({
	                               path: flightPlanCoordinates,
	                               geodesic: true,
	                               strokeColor: '#00FF00',
	                               strokeOpacity: 0.5,
	                               strokeWeight: 6
	                             });
	
	flightPath.setMap(mapObj); 
	mapObj.setCenter(new google.maps.LatLng((maxY+minY)/2,(maxX+minX)/2)); //new google.maps.LatLng(35.3349,103.2319));
	mapObj.setZoom(12); 
	return flightPath;
	                            
}
function _clearPolyline_google_ (mapObj,trackLine){
	trackLine && trackLine.setMap(null);
	return;
}

function _clearIcons_google_(mapObj,iconArray){
	return;
}

window.anydata = window.anydata || {};
anydata.mapapi = {};
anydata.mapapi.history = {};

anydata.mapapi.history.point = Point;
anydata.mapapi.history.initMap = initMap; 
anydata.mapapi.history.displayPolyline = displayPolyline; 
anydata.mapapi.history.clearPolyline = clearPolyline; 
anydata.mapapi.history.clearIcons = clearIcons;
anydata.mapapi.history.displayTrackPoint = displayTrackPointAtOffset;
anydata.mapapi.history.removeTrackPoint = removeTrackPoint;

})();
