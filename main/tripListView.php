<?php //include("session.php"); ?>
<?php
	$deviceId = $_GET["deviceId"];
	$startTime = $_GET["startTime"];
	$stopTime = $_GET["stopTime"];	
	$optype = isset($_GET['optype']) ? 1 : 0;

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

::-webkit-scrollbar/*整体部分*/
{
	width: 12px;
	height:12px;
}

::-webkit-scrollbar-track/*滑动轨道*/
{
	-webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.1);
	border-radius: 5px;
	background: rgba(0,0,0,0.1);
}

::-webkit-scrollbar-thumb/*滑块*/
{
	border-radius: 5px;
	-webkit-box-shadow: inset 0 0 5px rgba(0,0,0,.3);
	background: rgba(0,0,0,.3);
}

::-webkit-scrollbar-thumb:hover/*滑块效果*/
{
	border-radius: 5px;
	-webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.5);
	background: rgba(0,0,0,.5);
}

  
</style>   
<script>
var cursor_grid =null;
var t_template =null;
var m_template =null;
var tripNo=0;
var opType= '<?php echo $optype; ?>';

var totalDistance=0, totalFuel=0, totalTime=0;
var totalAvgFuel,totalAvgSpeed;

$(document).ready( function (){ 
	
	$.get("../../zend_obd/jsonAPI/getTripList.php", {
			deviceId: 	'<?php echo $deviceId; ?>', //'6C500CBD',
			startTime:	'<?php echo $startTime; ?>', //'2014-07-02 00:00:00',
			stopTime:	'<?php echo $stopTime; ?>', //'2014-07-03 23:59:59'
			optype:opType
		},function(jsonStr,status){		
			var i=0;
		
			//过滤前面的错误信息
			jsonStr = jsonStr.substr(jsonStr.indexOf("{"));
		
			var jsonObj = eval("(" +jsonStr+ ")");
			
			if (jsonObj.resultCode == "200"){
		
				var trips = jsonObj.data;			
				var this_t_grid = null;
				var this_m_grid = null;
				var lastStartTime, lastStopTime, parkTimeLength;
				setTemplate();
				for (var trip in jsonObj.data) {
					tripNo++;
					//alert (i++);
					if (cursor_grid != null ){ //第2次及以后的循环
						//calc:  m(n)= t(n+1)-t(n)		//handle parking time
						parkTimeLength = calcParkingTime( lastStartTime,lastStopTime ,jsonObj.data[trip].startTime ,jsonObj.data[trip].stopTime );
		
						this_m_grid = moveToNextSibling();
						
						if (this_m_grid==null)	{
							this_m_grid = createGridInUI("m_grid");
							cursor_grid = this_m_grid;
						} 
						//assign m(n)	--> this_m_grid(n)					
						$(this_m_grid).find("#parkingTime").html(printTimeLength(parkTimeLength));
						
					}else{		//第1个 trip
						var nav=document.getElementById("listOfTrips");  
						
						//cursor_grid = nav.firstChild;	//firstChild兼容性有问题
						cursor_grid = $(nav).children(0).get(0);
						this_m_grid = cursor_grid;//moveToNextSibling ();
					}
					 
					lastStartTime = jsonObj.data[trip].startTime;
					lastStopTime = jsonObj.data[trip].stopTime;
					
					this_t_grid = moveToNextSibling();				
					if (this_t_grid==null)	{
						this_t_grid= createGridInUI("t_grid");
						cursor_grid = this_t_grid;
					}
					
					//赋值 t(n)	--> this_t_grid(n)
					initGridInUI(this_t_grid);
					$(this_t_grid).find("#startTime").html(jsonObj.data[trip].startTime);
					$(this_t_grid).find("#stopTime").html(jsonObj.data[trip].stopTime);
					$(this_t_grid).find("#startAddr").html(printAddr( jsonObj.data[trip].startAddress));
					$(this_t_grid).find("#stopAddr").html(printAddr(jsonObj.data[trip].stopAddress));
		
					var tripDistance = !isNaN(jsonObj.data[trip].trackDistance)?jsonObj.data[trip].trackDistance:jsonObj.data[trip].trackDistance1;
					$(this_t_grid).find("#distance").html(printDistance(tripDistance));
		
					var tripFuelUsed = jsonObj.data[trip].fuel_consumption; 
					$(this_t_grid).find("#fuelUsed").html(!isNaN(tripFuelUsed)?(Math.round(tripFuelUsed*100)/100):"--");
		
					var timeUsed = calcTimeUsed(jsonObj.data[trip].startTime, jsonObj.data[trip].stopTime); //毫秒
					//alert(timeUsed);
					$(this_t_grid).find("#timeUsed").html(formatSeconds(Math.round(timeUsed/1000)));
		
					var tripAvgFuel = (tripDistance!=0)? (tripFuelUsed*(1e+5)/tripDistance ):0;		 //jsonObj.data[trip].fuel_consumption * (1e+5)  / jsonObj.data[trip].trackDistance 
					
					if(Math.round(tripDistance/1000 /(timeUsed/1000/3600) * 10)/10 <= 5.0){
						var useFuel = !isNaN(tripFuelUsed)?(Math.round(tripFuelUsed*100)/100):"--";
						var useTime = Math.round(timeUsed/1000/3600*100)/100;//小时
						//console.log(useFuel+"--"+useTime+"--"+Math.round(useFuel/useTime*100)/100);
						if(useFuel != "--"){
							$(this_t_grid).find("#avgFuelUsed")
								.html(useTime == 0 ? "--&nbsp;L/H": Math.round(useFuel/useTime*100)/100 + "&nbsp;L/H");	
						}else{
							$(this_t_grid).find("#avgFuelUsed")
								.html("--&nbsp;L/H");	
						}
						
					}else{
						$(this_t_grid).find("#avgFuelUsed").html(!isNaN(tripAvgFuel) ? (Math.round(tripAvgFuel  * 10)/10 ) + "&nbsp;L\/100KM": "--&nbsp;L\/100KM" );	
					}
					
					//if (tripNo<12) alert (tripAvgFuel);
					
		
					$(this_t_grid).find("#avgSpeed").html(Math.round(tripDistance/1000 /(timeUsed/1000/3600) * 10)/10);

					//statistic
					totalTime += !isNaN(timeUsed) ? timeUsed:0;
					totalDistance += !isNaN(tripDistance) ? parseInt(tripDistance) :0;
					totalFuel += !isNaN(tripFuelUsed)? parseFloat(tripFuelUsed):0;

				}
							
				$("#val_total").find("#distance").html(printDistance(totalDistance));
				$("#val_total").find("#fuelUsed").html(!isNaN(totalFuel)?(Math.round(totalFuel*100)/100):"--");
				
				$("#val_total").find("#avgSpeed").html((totalTime!=0)?  Math.round(totalDistance/1000 /(totalTime/1000/3600) * 10)/10 : "--"   );
				
				totalAvgFuel = (totalDistance!=0)? (totalFuel*(1e+5)/totalDistance ):0;
				$("#val_total").find("#avgFuelUsed").html( !isNaN(totalAvgFuel) ? (Math.round(totalAvgFuel  * 10)/10 ): "--");		
						
				if (tripNo <=1){
					var m1=document.getElementById("m1");
					m1.parentNode.removeChild(m1);
				}
				if (tripNo ==0){
					var t1=document.getElementById("t1");
					t1.parentNode.removeChild(t1);
				}
				cursor_grid =null;
				t_template =null;
				m_template =null;
				tripNo=0;
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
	return (new Date(dateTime2.replace(/-/ig,'/')).getTime()-new Date(dateTime1.replace(/-/ig,'/')).getTime());	
}

function printAddr(address){	//考虑当数据为空的显示内容
	return (address!="")? address:"(地址未获取)";
}

function printDistance(dist){
	if (isNaN(dist)) return "--";
	return Math.round(dist/1000*100)/100;
}

function createGridInUI(strType){
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
	$(node).find("#startTime").html("");
	$(node).find("#stopTime").html("");
	$(node).find("#startAddr").html("");
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
	parent.getTrackLineData($(node).find("#startTime").html(),$(node).find("#stopTime").html());	
	$("tr[id^='t']").css("background-color","#e0e0ff");
	$(node).css("background-color","green");
} 

function formatSeconds(value) { 
	var theTime = parseInt(value);// 秒 
	var theTime1 = 0;// 分 
	var theTime2 = 0;// 小时 
	// alert(theTime); 
	if(theTime > 60) { 
		theTime1 = parseInt(theTime/60); 
		theTime = parseInt(theTime%60);
		if(theTime1 > 60) { 
			theTime2 = parseInt(theTime1/60); 
			theTime1 = parseInt(theTime1%60); 
		} 
	} 
	var result = ""+parseInt(theTime)+"秒"; 
	if(theTime1 > 0) { 
		result = ""+parseInt(theTime1)+"分"+result; 
	} 
	if(theTime2 > 0) { 
		result = ""+parseInt(theTime2)+"时"+result; 
	} 
	return result; 
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
                                            <td><span></span></td>
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
                                            <td><span></span></td>
                                            <td><span>平均油耗：</span></td>
                                            <td align="right"><span id="avgFuelUsed" name="avgFuelUsed"   class="valstyle">-</span></td>
                                            <td><span></span></td>
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
</body>   
</html>
<?php
?>