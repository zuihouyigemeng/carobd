<?php //include("session.php"); ?>
<?php
	// url: http://127.0.0.1:8080/obd_web/main/tripListView.php?deviceId=6C500CBD&startTime=2014-07-02%2000:00:00&stopTime=2014-07-24%2023:59:59
	// url: http://192.168.0.163/obd_web_dev/main/tripListView.php?deviceId=6C500CBD&startTime=2014-07-02%2000:00:00&stopTime=2014-07-24%2023:59:59
	//
	$deviceId = $_GET["deviceId"];
	$startTime = $_GET["startTime"];
	$stopTime = $_GET["stopTime"];
	
	
	$optype = isset($_GET['optype']) ? 1 : 0;
	
	
//}catch()

//	echo $deviceId . "<BR>" . $startTime. "<BR>" . $stopTime . "<BR>";

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
<title>历史行程</title>   
<style type="text/css">   
html{height:100%}   
body{height:100%;margin:0px;padding:0px}  
#container{height:100%;width:100%}   
</style>   
<script>
var cursor_grid =null;
var t_template =null;
var m_template =null;
var tripNo=0;
var opType= '<?php echo $optype; ?>';


//$(document).ready(testJson());
//alert(100);

//function testJson(){
////	$.post("../../zend_obd/jsonAPI/getTripList.php?deviceId=6C500CBD&startTime=2014-07-02%2000:00:00&stopTime=2014-07-03%2023:59:59",
////			  {
////				 vins: ""
////			  },
////			  function(data,status){
//////				alert (status);
////				alert(data);
////			  });
////}			  
//
//	$.getJSON("../../zend_obd/jsonAPI/getTripList.php?deviceId=6C500CBD&startTime=2014-07-02%2000:00:00&stopTime=2014-07-03%2023:59:59",
//		 {vins: ""}, 
//		 function(obj){
//				alert(obj);
//				} );
//}	





var totalDistance=0, totalFuel=0, totalTime=0;
var totalAvgFuel,totalAvgSpeed;

$(document).ready( function (){ 
	$.get("../../zend_obd/jsonAPI/getTripList.php", {
			deviceId: 	'<?php echo $deviceId; ?>', //'6C500CBD',
			startTime:	'<?php echo $startTime; ?>', //'2014-07-02 00:00:00',
			stopTime:	'<?php echo $stopTime; ?>', //'2014-07-03 23:59:59'
			optype:opType
		},function(jsonStr,status){	
//			alert(status);
//			alert(jsonStr);
//		}
//	);
//}); 

//prepareTripData

//	var jsonStr = 	"{\"resultCode\":\"200\",\"resultMsg\":\"\",\"data\":[" + 
//			"{\"startLat\":\"0.000000\",\"stopLat\":\"31.217749\",\"startLon\":\"0.000000\",\"stopLon\":\"121.411728\",\"startTime\":\"2014-07-02 17:34:44\",\"stopTime\":\"2014-07-02 17:44:21\",\"startAddress\":\"\",\"stopAddress\":\"\u4e0a\u6d77\u5e02\u957f\u5b81\u533a\u51ef\u65cb\u8def430-\u4e34\",\"trackType\":0,\"trackDistance\":\"2437\",\"trackDistance1\":\"2437\",\"fuel_leve_now\":\"0\",\"fuel_consumption\":\"0.394\"}," + 
//			"{\"startLat\":\"0.000000\",\"stopLat\":\"31.217749\",\"startLon\":\"0.000000\",\"stopLon\":\"121.411728\",\"startTime\":\"2014-07-02 17:34:44\",\"stopTime\":\"2014-07-02 17:44:21\",\"startAddress\":\"\",\"stopAddress\":\"\u4e0a\u6d77\u5e02\u957f\u5b81\u533a\u51ef\u65cb\u8def430-\u4e34\",\"trackType\":0,\"trackDistance\":\"2437\",\"trackDistance1\":\"2437\",\"fuel_leve_now\":\"0\",\"fuel_consumption\":\"0.394\"}," + 
//			"{\"startLat\":\"0.000000\",\"stopLat\":\"31.217749\",\"startLon\":\"0.000000\",\"stopLon\":\"121.411728\",\"startTime\":\"2014-07-02 17:34:44\",\"stopTime\":\"2014-07-02 17:44:21\",\"startAddress\":\"\",\"stopAddress\":\"\u4e0a\u6d77\u5e02\u957f\u5b81\u533a\u51ef\u65cb\u8def430-\u4e34\",\"trackType\":0,\"trackDistance\":\"2437\",\"trackDistance1\":\"2437\",\"fuel_leve_now\":\"0\",\"fuel_consumption\":\"0.394\"}," + 
//			"{\"startLat\":\"31.270953\",\"stopLat\":\"31.263415\",\"startLon\":\"121.489571\",\"stopLon\":\"121.499970\",\"startTime\":\"2014-07-03 22:08:29\",\"stopTime\":\"2014-07-03 22:15:33\",\"startAddress\":\"\u4e0a\u6d77\u5e02\u8679\u53e3\u533a\u66f2\u9633\u8def4\u53f7\",\"stopAddress\":\"\u4e0a\u6d77\u5e02\u8679\u53e3\u533a\u5b89\u56fd\u8def350\u53f72\u5c42\",\"trackType\":0,\"trackDistance\":\"1984\",\"trackDistance1\":\"1984\",\"fuel_leve_now\":\"0\",\"fuel_consumption\":\"17.894\"}" +
//			"]}";
	var i=0;
//	alert(jsonStr);
	//parent.showAlert(jsonStr);
	
	//过滤前面的错误信息
	jsonStr = jsonStr.substr(jsonStr.indexOf("{"));
//	alert(jsonStr);
	
	var jsonObj = eval("(" +jsonStr+ ")");
	
	if (jsonObj.resultCode == "200"){
		//alert (200);
		//alert (jsonObj.data.length );
		//alert(jsonObj.data[0]["startTime"]);
		var trips = jsonObj.data;
//		if (jsonObj.data.length ==0)	{
//			alert ("no data");
//		}else{
			
			var this_t_grid = null;
			var this_m_grid = null;
			var lastStartTime, lastStopTime, parkTimeLength;
			setTemplate();
			for (var trip in jsonObj.data) {
				tripNo++;
				
				if(tripNo>1){
					return ;
				}
				if (cursor_grid != null ){ //第2次及以后的循环
					//calc:  m(n)= t(n+1)-t(n)		//handle parking time
					parkTimeLength = calcParkingTime( lastStartTime,lastStopTime ,jsonObj.data[trip].startTime ,jsonObj.data[trip].stopTime );
                       alert("parkTimeLength"+parkTimeLength);
					this_m_grid = moveToNextSibling();
					
					if (this_m_grid==null)	{
						this_m_grid = createGridInUI("m_grid");
						cursor_grid = this_m_grid;
					} 
					//assign m(n)	--> this_m_grid(n)					
					$(this_m_grid).find("#parkingTime").html(printTimeLength(parkTimeLength));
					
				}else{		//第1个 trip
					var nav=document.getElementById("listOfTrips");  
				//	alert("###############nav:"+nav.innerHTML);
					cursor_grid = nav.firstChild;
					alert("@@@@@@@@@@@@cursor_grid:"+cursor_grid.innerHTML);
					this_m_grid = moveToNextSibling ();
				}
				 
				lastStartTime = jsonObj.data[trip].startTime;
				lastStopTime = jsonObj.data[trip].stopTime;
				
				this_t_grid = moveToNextSibling();	
				alert("--------"+this_t_grid.innerHTML);			
				if (this_t_grid==null)	{
					alert("null!!!!!");
					this_t_grid= createGridInUI("t_grid");
					cursor_grid = this_t_grid;
				}
				//assign t(n)	--> this_t_grid(n)
				alert("this_t_grid:"+this_t_grid);
				initGridInUI(this_t_grid);
		//		alert(jsonObj.data[trip].startTime);
				$(this_t_grid).find("#startTime").html(jsonObj.data[trip].startTime);
		//		alert(jsonObj.data[trip].stopTime);
		     	$(this_t_grid).find("#stopTime").html(jsonObj.data[trip].stopTime);
		//		alert(jsonObj.data[trip].stopTime);
				$(this_t_grid).find("#startAddr").html(printAddr( jsonObj.data[trip].startAddress));
				$(this_t_grid).find("#stopAddr").html(printAddr(jsonObj.data[trip].stopAddress));

			}

		
//		}
	}
	else alert ("error");

	}
	);
}); 

  
function setTemplate(){
	var obj = null;
	var nav=document.getElementById("listOfTrips");
	obj = getNextSibling( nav.firstChild);
	while (obj!=null){
		switch (obj.id){
			case "t1":	t_template= obj;break;
			case "m1":  m_template= obj;break;
			default: break;
		}
		obj = getNextSibling(obj);
	}
	
}

function calcParkingTime( lastStartTime,lastStopTime ,thisStartTime ,thisStopTime ){
	//返回毫秒数 	
	if (lastStopTime <= thisStartTime){ //顺序
		result = (new Date(thisStartTime.replace(/-/ig,'/'))).getTime()-
				(new Date(lastStopTime.replace(/-/ig,'/')).getTime()) ;
	}else { //倒序
		result = (new Date(lastStartTime.replace(/-/ig,'/'))).getTime()-
				(new Date(thisStopTime.replace(/-/ig,'/'))).getTime() ;
		
	}
	return result;
}

function printTimeLength(timeLength){
	var days,hours,mins,secs;
	var ret ="";
	timeLength = Math.round(timeLength/1000);
	days = Math.floor(timeLength/24/3600);
	if (days>0) ret +=  days + "天";
	
	timeLength -= days *24*3600;
	hours = Math.floor(timeLength/3600);
	if (hours>0) ret +=  hours + "小时";
	
	timeLength -= hours * 3600;
	mins = Math.floor (timeLength/60);
	if (mins>0) ret +=  mins + "分";
	
	timeLength -= mins * 60;
	secs = timeLength;
	ret +=  secs + "秒";
	
	return ret;	
}

function calcTimeUsed(dateTime1, dateTime2){
	//	dataTime2 > dateTime1
	//  返回毫秒数	
//	alert ("calcTimeUsed");
//	alert (dateTime1);
//	alert (dataTime1 + "," + dataTime2);
	return (new Date(dateTime2.replace(/-/ig,'/')).getTime()-new Date(dateTime1.replace(/-/ig,'/')).getTime());	
}

function printAddr(address){	//考虑当数据为空的显示内容
	return (address!="")? address:"(地址未获取)";
}

function printDistance(dist){
	// input: unit in "m"; 
	if (isNaN(dist)) return "--";
	if (dist<1000)	return Math.round(dist/1000*100)/100;	//eg. 0.23KM		
	else {
		if (dist<10000 && dist>=1000) return Math.round(dist/1000*10)/10;	//eg. 5.3KM
		else return Math.round(dist/1000);	//eg. 18KM	
	}
}

function createGridInUI(strType){
	//strType =	"m_grid", "t_grid";
	//
	var newObj = null;
	var nav=document.getElementById("listOfTrips");  

	switch(strType){
	case "m_grid":	
		newObj = m_template.cloneNode(true);
		newObj.id = "m" + (tripNo-1).toString(); //(parseInt(cursor_grid.id.substr(1))+1).toString();
		nav.appendChild(newObj);
		//initGridInUI(newObj);
		break;
	case "t_grid":
		newObj = t_template.cloneNode(true);
		//alert ((cursor_grid.id).substr(0,1));
		newObj.id = "t" + (tripNo).toString();
		//initGridInUI(newObj);
		nav.appendChild(newObj);
		break;
	default:
		break;
	}	
	return newObj;
}

function initGridInUI(node){
	if (node==null) return node;
	//alert ("test1:" + ($(node).find("#startAddr").val()));
	//$(node).find("#startTime").html("abcdef");
	//alert ("test2:" + ($(node).find("#startAddr").val()));
	//$(node).find("#stopTime").html("abc");
	$(node).find("#startTime").html("startTime");
	$(node).find("#stopTime").html("stopTim");
	$(node).find("#startAddr").html("startAddr");
	$(node).find("#stopAddr").html("");
	$(node).find("#distance").html("");
	$(node).find("#fuelUsed").html("");
	$(node).find("#timeUsed").html("");
	$(node).find("#avgFuelUsed").html("");
	$(node).find("#avgSpeed").html("");
}

//针对nextSibling去除定位到空的文本节点（元素节点之间的空格和换行符号）
function moveToNextSibling()//n)
{	
	var obj;
	obj = cursor_grid.nextSibling;
	while (obj != null && obj.nodeType!=1)
	  {
	  obj=obj.nextSibling;
	  }
	if (obj!=null) cursor_grid = obj;  
	return obj;
}

function getNextSibling(n)
{	
	var obj;
	//if (n=null)	return null;
	obj = n.nextSibling;
	while (obj != null && obj.nodeType!=1)
	  {
	  obj=obj.nextSibling;
	  }
	return obj;
}

function test(){
	alert ("test1:" + ($("#val_total").find("#startAddr").html()));
	$("#val_total").find("#startAddr").html("abcdef");
	alert ("test2:" + ($("#val_total").find("#startAddr").html()));
	
}

function trip_ondblclick(node){
//	alert ($(node).attr("id"));
//	alert ($(node).find("#startTime").html());
//	alert ($(node).find("#stopTime").html());
//	parent.displayTrackLine();

	parent.getTrackLineData($(node).find("#startTime").html(),$(node).find("#stopTime").html());	
	$("tr[id^='t'").css("background-color","#e0e0ff");
	$(node).css("background-color","green");

} 


</script>    
</head>   
<body>   
<table id="1" alignment="top" width="380px" border="1px" cellspacing="0px"  style="margin:auto;border-collapse:collapse" >
<tbody id="listOfTrips">
                       	<tr id="val_total"   onselectstart="JAVASCRIPT:return false;" style="background-color:#ffffff">
                       		<td>                               
                                 <div class="">
                                    <table>
                                        <tbody><tr>
                                            <td><span>累计油耗：</span></td>
                                            <td align="right"><span id="fuelUsed" name="fuelUsed"   class="valstyle">-</span></td>
                                            <td><span>L</span></td>
                                            <td><span>累计里程：</span></td>
                                            <td align="right"><span  id="distance" name="distance"  class="valstyle">-</span></td>
                                            <td><span>KM</span></td>
                                        </tr>
                                        <tr>
                                            <td><span>平均油耗：</span></td>
                                            <td align="right"><span  id="avgFuelUsed" name="avgFuelUsed" class="valstyle">-</span></td>
                                            <td><span>L/100KM</span></td>
                                            <td><span>平均速度：</span></td>
                                            <td align="right"><span id="avgSpeed" name="avgSpeed"  class="valstyle">-</span></td>
                                            <td><span>KM/H</span></td>
                                        </tr>
                                        
                                    </tbody></table>
                                </div>
                            </td>
                        </tr>                   


                       	<tr id="t1" name="t1" data-options="" style="background-color:#f0f0ff" ondblclick="JAVASCRIPT:trip_ondblclick(this);" onselectstart="JAVASCRIPT:return false;" >
                       		<td>              
                                <div>
                                    <strong style="color:blue;"><span id="startTime" name="startTime"></span> 行程记录</strong>
                                </div>
                                <div class="">
                                    <h3><span id="startTime" name="startTime"  style="color:red;">--:--</span> 从：<span id="startAddr" name="startAddr" >-</span></h3>
                                    <h3><span id="stopTime" name="stopTime"  style="color:red;">--:--</span> 到：<span id="stopAddr" name="stopAddr" >-</span></h3>
                                </div>
                                <div class="">
                                    <table> 
                                        <tbody><tr>
                                            <td><span>行驶里程：</span></td>
                                            <td align="right"><span id="distance" name="distance"   class="valstyle">-</span></td>
                                            <td><span>KM</span></td>
                                            <td><span>行驶油耗：</span></td>
                                            <td align="right"><span id="fuelUsed" name="fuelUsed"   class="valstyle">-</span></td>
                                            <td><span>L</span></td>
                                        </tr>
                                        <tr>
                                            <td><span>行驶耗时：</span></td>
                                            <td align="right"><span id="timeUsed" name="timeUsed"   class="valstyle">--:--</span></td>
                                            <td><span>Hr</span></td>
                                            <td><span>平均油耗：</span></td>
                                            <td align="right"><span id="avgFuelUsed" name="avgFuelUsed"   class="valstyle">-</span></td>
                                            <td><span>L/100KM</span></td>
                                        </tr>
                                        <tr>
                                            <td><span>平均速度：</span></td>
                                            <td align="right"><span id="avgSpeed" name="avgSpeed"   class="valstyle">-</span></td>
                                            <td><span>KM/H</span></td>
                                            <td colspan="3"></td>
                                        </tr>
                                    </tbody></table>
                                </div>
			  
                            </td>
                        </tr>                   
                      	<tr id = "m1" style="background-color:#ffffff"  onselectstart="JAVASCRIPT:return false;" >
                       		<td>                               
                                <div>
                                    <strong style="color:blue;">停留时间&nbsp;&nbsp;&nbsp;  <span id="parkingTime" name="parkingTime" > -天-分-秒</span></strong>
                                </div>
                            </td>
                        </tr>                   

</tbody></table>
<!-- <input type="button" onclick ="JAVASCRIPT: test();" value ="ready"> -->
</body>   
</html>
<?php
?>