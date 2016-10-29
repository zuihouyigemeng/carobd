<?php //include("session.php"); ?>
<?php 

//	url: http://127.0.0.1:8080/obd_web/main/historyView.php?deviceId=6C4C76C1&licenseNumber=GL8(CBD)
//	url: http://192.168.0.163/obd_web/main/historyView.php?deviceId=6C4C76C1&licenseNumber=GL8(CBD)

	$deviceId = $_GET["deviceId"];
	$licenseNumber = $_GET["licenseNumber"];
	
	//echo "licenseNumber:" . $licenseNumber . "<BR>"; 	
	
	function url4RequestTrips($deviceId, $condition){
		switch ($condition){
			case "last3hr":
						$startTime =  date('Y-m-d H:i:s',time() - 60*60*3);
						$stopTime = date('Y-m-d H:i:s');
						break;
			case "last6hr":
						$startTime =  date('Y-m-d H:i:s',time() - 60*60*6);
						$stopTime = date('Y-m-d H:i:s');
						break;			
			case "last12hr":
						$startTime =  date('Y-m-d H:i:s',time() - 60*60*12);
						$stopTime = date('Y-m-d H:i:s');
						break;			
			case "today":
			default:	
						$startTime = date('Y-m-d') . "%2000:00:00";
						$stopTime = date('Y-m-d') . "%2023:59:59";
		}
		return 	"./tripListView.php?deviceId=" . $deviceId . "&startTime=" . $startTime . "&stopTime=" . $stopTime;	
	}	
						 			
?>
<!DOCTYPE html   
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"   
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>   
<head>   
<meta name="viewport" content="initial-scale=1.0, user-scalable=yes" />   
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />   
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="../themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="../themes/icon.css">
	<link rel="stylesheet" type="text/css" href="../demo.css">
	<script type="text/javascript" src="../jquery.min.js"></script>
	<script type="text/javascript" src="../jquery.easyui.min.js"></script>
	<script type="text/javascript" src="../locale/easyui-lang-zh_CN.js"></script> 
    <SCRIPT type="text/javascript" src="../jquery.layout.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../jquery.layout.extend.js"></SCRIPT>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=oCbw1Qz8ayXfZKlgDHKyfsWG"></script>  
	<script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script>  
<!--	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAKKcnYLgJKhO6-yOav7Qzn-1EFBn814Lg&sensor=FALSE"></script>
--> 
    <script type="text/javascript" src="../timeUtils.js"></script>
    <script type="text/javascript" src="../js/history.js"></script>

<title>历史行程</title>   
<style type="text/css">   
html{height:100%}   
body{height:100%;margin:0px;padding:0px}  
#container{height:100%;width:100%}   
</style>   
	<script>
		function showAlert( obj){
			alert (obj);
		}
		
		function isValidGps(lat,lng){
			return ((lat>+1e-5 && lat<=90.0)|| (lat<-1e-5 && lat >=-90.0)) && ((lng>+1e-5 && lng<=180.0)|| (lng<-1e-5 && lng >=-180.0));
		}
	</script>  
	
</head>   

<body class="easyui-layout"  id="cc" >   
<!-- 数据窗口 -->
<div data-options="region:'south',split:false" style="height:150px;width:100%">
	<table id="dg" class="easyui-datagrid"  style="height:148px;width:1560px"
						data-options="rownumbers:true,singleSelect:true,selectOnCheck:false,checkOnSelect:false">
					<thead>
						<tr>
						
			                <th data-options="field:'gpsDate',width:200">日期</th>
							<th data-options="field:'gpsTime',width:200">时间</th>
							<th data-options="field:'longitude',width:200">经度</th>
							<th data-options="field:'latitude',width:200">纬度</th>
							<th data-options="field:'address_num',width:500,align:'right'">地址</th>
							<th data-options="field:'heading',width:100">方向</th>
							<th data-options="field:'code',width:100">事件类型</th>
						
						</tr>
					</thead>
				</table>	   
</div>
<div data-options="region:'center',iconCls:'icon-ok'" id="conterid" >

  
<div style="margin:20px 0 10px 0; position:absolute; z-index:10;  visibility:hidden">
		<a id="Test1" href="#" class="easyui-linkbutton" onclick="JAVASCRIPT:onTest1();">Test1</a>  
		<a id="Test2" href="#" class="easyui-linkbutton" onclick="javascript:">Test2</a>   
</div>

<!-- 历史行程列表 -->
<div id="histWin" class="easyui-window" title="历史行程" data-options="minimizable:false,maximizable:false,resizable:false" 
style="width:450px;height:600px;top:45px;left:80px; padding:0px;z-index:3 ;" >
	<div id="tabRecentTrips" class="easyui-tabs" style="margin-top:0px;width:436px;height:547px;padding:0px">
		<div title="本月" style="padding:10px">
			<div style="">
				<table><tr><td>					
				<!--	<input id="searchDate" class="easyui-datetimebox" required style="width:200px"/>  	-->	
				</td><td>
				<!--	<input type="button"  style="width:150px" value="按日期查询" onclick="JAVASCRIPT:alert("ok");searchByDate();"/> -->
				</td></tr>
				</table>
			</div>	
			<div id="div_triplist1" style = "height:450px">
				<iframe src="<?php 
						//本月：1号到今天半夜
						echo "./tripListView.php?deviceId=";
						echo $deviceId; 
						echo "&";
						echo "startTime=" . date("Y"). "-" . date("m") . "-01" ;
						// starttime: 本月1日
						echo "&stopTime=";
						// stoptime: now
						echo date("Y-m-d") . "%2023:59:59";				
				
				?>" id="triplist1" name="triplist1" frameBorder=0 scrolling=yes width="100%" height="100%" ></iframe>
			</div>	
		</div>
		<div title="本周" style="padding:10px">
			<div style="">
				<table><tr><td>					
				<!--	<input class="easyui-datetimebox" required style="width:200px"/>  	  -->	
				</td><td>
				<!--	<input type=”button"  style="width:150px" value="按日期查询" />  -->
				</td></tr>
				</table>
			</div>	
			<div id="div_triplist2" style = "height:450px">
				<iframe src="<?php 

						//本周：周一到今天半夜
						$dayNumInWeek = (idate("w")>0?idate("w"):7)-1;	//周一为 一周第一天
						$Monday = date('Y-m-d',time() - $dayNumInWeek*24*60*60) . "%2000:00:00";
						$stopTime = date('Y-m-d') . "%2023:59:59";
						echo "./tripListView.php?deviceId=" . $deviceId . "&startTime=" . $Monday . "&stopTime=" . $stopTime;				

				?>" id="triplist2" name="triplist2" frameBorder=0 scrolling=yes width="100%" height="100%" ></iframe>
			</div>	
		</div>
		<div title="当天" style="padding:10px">
			<div style="">
				<table><tr><td>					
				<!--	<input class="easyui-datetimebox" required style="width:200px"/>  	 -->	
				</td><td>
				<!--	<input type="button"  style="width:150px" value="按日期查询" />  -->
				</td></tr>
				</table>
			</div>	
			<div id="div_triplist3" style = "height:450px">
				<iframe id="tripOfTodayFrm" src="<?php 
						
						//今天：凌晨到半夜
						$startTime = date('Y-m-d') . "%2000:00:00";
						$stopTime = date('Y-m-d') . "%2023:59:59";
						echo "./tripListView.php?deviceId=" . $deviceId . "&startTime=" . $startTime . "&stopTime=" . $stopTime;				

				?>" id="triplist3" name="triplist3" frameBorder=0 scrolling=yes width="100%" height="100%" ></iframe>
			</div>	
		</div>
		<div title="最近10笔(倒序)" style="padding:10px">
			<div style="">
				<table><tr><td>					
					<!-- <input class="easyui-datetimebox" required style="width:200px"/>  		 -->
				</td><td>
				<!--	<input type="button"  style="width:150px" value="按日期查询" />  -->
				</td></tr>
				</table>
			</div>	
			<div id="div_triplist4" style = "height:450px">
				<iframe  id="triplist4" name="triplist4" frameBorder=0 
				
				src="<?php 		
						echo "./tripListView.php?deviceId=" . $deviceId . "&optype=lastTen";
				?>" 
				scrolling=yes width="100%" height="100%" ></iframe>
			</div>	
		</div>
				
	</div>
	<!--	tab带下拉菜单-->
	<div id="tabByHours">
		<div>最近3小时</div>
		<div>最近6小时</div>
		<div>最近12小时</div>
		<div>当天</div>
	</div>
	<script>
		$(function(){	//tab  上面嵌入菜单
			var p = $('#tabRecentTrips').tabs().tabs('tabs')[2];
			var mb = p.panel('options').tab.find('a.tabs-inner');
			mb.menubutton({
				menu:'#tabByHours'
			}).click(function(){
				$('#tabRecentTrips').tabs('select',2);
			});
			$('#tabByHours').menu({    
			    onClick:function(item){    
			    	alert (item.text);
			    	switch (item.text){
			    	case '最近3小时':	$('#tripOfTodayFrm').attr("src","<?php echo url4RequestTrips($deviceId,"last3hr");?>");	//./tripListView.php?deviceId=6C500CBD&startTime=2014-07-02%2013:30:30&stopTime=2014-07-03%2016:30:30");
			    						break;
			    	case '最近6小时':	$('#tripOfTodayFrm').attr("src","<?php echo url4RequestTrips($deviceId,"last6hr");?>");	//./tripListView.php?deviceId=6C500CBD&startTime=2014-07-02%2010:30:30&stopTime=2014-07-03%2016:30:30");	
			    						break;
			    	case '最近12小时':	$('#tripOfTodayFrm').attr("src","<?php echo url4RequestTrips($deviceId,"last12hr");?>");	//./tripListView.php?deviceId=6C500CBD&startTime=2014-07-02%2004:30:30&stopTime=2014-07-03%2016:30:30");
			    						break;
			    	case '当天':			
			    	default:			//今天：凌晨到半夜
			    						$('#tripOfTodayFrm').attr("src","<?php echo url4RequestTrips($deviceId,"today");?>");
			    						break;
			    	};
			    	$('#tabRecentTrips').tabs("select",2);				    	
			 }}); 
			 
			 $('#tabRecentTrips').tabs("select",3);
			 
		});
		
		function searchByDate()	{
			var selectedDate = $("#searchDate").value();
			alert (selectedDate);
			$("#triplist1").attr("src","./tripListView.php?deviceId=6C500CBD&date="+selectedDate);
		}
	</script>

</div>

<!-- 行程播放控制面板 -->
<script>
		//alert("002");
</script>    
<div id = "playbackWin" style="position:absolute;z-index:2 ;">
	<table>
	<tbody>
	<tr ><td valign ="top">
<!--	<div id="playbackWin1" class="easyui-panel" style="width:25px;height:120px;padding:0px; " onclick="javascript:playPanelOnOff()"> 
			<br>关<br>闭<br>
		</div> -->
		<div id="playbackWin1" class="easyui-panel" style="width:25px;height:120px;padding:0px" onclick="javascript:playPanelOnOff()"> 
			<div id="playbackWin1_1" style="width:100%; height:100%;background:url('../mapPic/history/btn_pbp_close.png'); background-repeat:no-repeat" >
			</div>
		</div>


	</td>
	<td>
		<div id="playbackWin2" class="easyui-panel" style="height:160px; width:225px;padding:5px; background:#f0f0f0 ">
			<table border="0" cellspacing="0" cellpadding="1"><tbody>
				<tr><td>
					<table>
						<tbody><tr>
				    		<td width="70px">
				           		<select id ="searchType" class="easyui-combobox" name="state" style="width:80px;">
									<option value="VehNum">车牌号</option>
									<option value="ESN">ESN</option>	
								</select>
							</td><td width="70px">
								<input id="licenseNumber" class="easyui-validatebox textbox" style="width:100%" data-options="required:true,validType:'length[3,10]'" value='<?php echo urldecode($licenseNumber); ?>'>							    
							</td>
							<td><a href="#" class="easyui-linkbutton"     onclick="doSearch()">查询</a></td>
						</tr></tbody>
					</table>             
				</td></tr>
				<tr><td>  		                             
					<table border="0" cellspacing="0" cellpadding="1"><tbody>
						<tr>
	                           <td width="75"><span>时间范围</span></td>
	                           <td width="" align="">
	                           		<select id ="recent" class="easyui-combobox" name="state" style="">
										<option value="last3hr">最近3小时</option>
										<option value="last6hr">最近6小时</option>
										<option value="last12hr">最近12小时</option>
										<option value="today">最近24小时</option>					
									</select>
								</td>
	                    </tr>
	                    <tr>
	                           <td><span>开始时间</span></td>
	                           <td align="right"><input id ="beginTimeV" class="easyui-datetimebox"  style=""/></td>
	                    </tr>
	                    <tr>
	                           <td><span>结束时间</span></td>
	                           <td align="right"><input id ="endTimeV" class="easyui-datetimebox"  style=""/></td>
	            		</tr></tbody>
	           		 </table>
            </td></tr>
            <tr><td>
				<table border="0" cellspacing="0" cellpadding="1" width="100%" align="center"><tbody>
						<tr >
						<td align="center"><a id="playbackHistory" href="#" class="easyui-linkbutton" style="width:60px" onclick="javascript:playbackHistory();">播放</a></td>
						<td align="center"><a href="stopPlayback" class="easyui-linkbutton" style="width:60px" onclick="javascript:stopPlayback()">停止</a></td>
						<td align="center"><a href="" class="easyui-linkbutton" style="width:60px; visibility:hidden" >打开选项</a></td>
						</tr>     
				</tbody>
				</table>       
            </td></tr>
<!--        <tr><td align="center">
				<div id="optionPanel" class="easyui-panel" style="width:210px;height:120px;padding:10px;">	
					<table border="0" cellspacing="0" cellpadding="1"><tbody>
						<tr>
	                           <td width="75"><span>播放频率</span></td>
	                           <td width="" align="" colspan = 2>
	                           		<select class="easyui-combobox" name="state" style="">
										<option value="speed1">急速</option>
										<option value="speed2">较快</option>
										<option value="speed3" Selected>中等</option>
										<option value="speed4">较慢</option>			
										<option value="speed5">慢速</option>			
									</select>
								</td>
	                    </tr>
	                    <tr>
	                           <td><span>屏蔽高速</span></td>
	                           <td width="" align="">
	                           		<select class="easyui-combobox" name="state" style="">
										<option value="speed-none">不屏蔽</option>
										<option value="speed-0">0KM/H速度</option>
										<option value="speed-10">10KM/H以内</option>
										<option value="speed-20">20KM/H以内</option>			
										<option value="speed-60">60KM/H以内</option>			
										<option value="speed-80">80KM/H以内</option>
										<option value="speed">人工输入</option>			
									</select>
								</td>
	            		</tr>
	                    </tr>
	                           <td><input type="checkbox" value="">气泡</td>
	                           <td><input type="checkbox" value="">显示轨迹点</td>	                    
	                    <tr>
	                    </tr>
	                           <td><input type="checkbox" value="">车辆居中</td>
	                           <td><input type="checkbox" value="">超速颜色区分</td>	                    
	                    <tr>
	            		</tbody>
	           		 </table>
				</div>
           </td></tr>
-->	
	         </tbody></table>            
		</div>
	</td>	 
	</tr>
	</tbody></table>
</div>
	<script>
		//left: $(funtion()={alert(\"abc\");}
		//alert("abc");
		dockToRight();
		var playPanelStatus = 1;	//1: on; 0: off
		// function playPanelOnOff (){
			// if (playPanelStatus ==1){
				// $('#playbackWin2').panel('close');
				// playPanelStatus = 0;
			// }else{
				// $('#playbackWin2').panel('open');
				// playPanelStatus = 1;				
			// }
			// dockToRight();
		// };
		function playPanelOnOff (){
			if (playPanelStatus ==1){
				document.getElementById("playbackWin1_1").style.background= "url('/obd_web/mapPic/history/btn_pbp_open.png')" ;
				$('#playbackWin1_1').css({"background-repeat":"no-repeat"});
				$('#playbackWin2').panel('close');
				playPanelStatus = 0;
			}else{
				document.getElementById("playbackWin1_1").style.background= "url('/obd_web/mapPic/history/btn_pbp_close.png')" ;
				$('#playbackWin1_1').css({"background-repeat":"no-repeat"});
				$('#playbackWin2').panel('open');
				playPanelStatus = 1;				
			}
			dockToRight();
		};


		function dockToRight(){
			var posToLeft = $(window).width() - $('#playbackWin').width();
			$('#playbackWin').offset({left:posToLeft,top:100});
			//$('#playbackWin1').panel('move',{ left:400,top:400});
		};
	</script>
	<script>		
		var optionPanelstatus = 1;		//1: on; 0: off
		function optionPanelOnOff(){			
			if (optionPanelstatus ==1){
				$('#optionPanel').panel('close');
				optionPanelstatus = 0;
			}else{
				$('#optionPanel').panel('open');
				optionPanelstatus = 1;	
			}
		}
	</script>		


<!-- 地图 -->	
<!-- <div id="mapView" width="100%" >-->
<table  width="100%" ><tbody>
	<tr><td height="20px" >
		<div id="mapTool" >
			地图选择：<select id="mapEngine" onchange='mapEngine_onChange(this.value)'>
						<option value='baidu' checked>百度地图</option>
						<option value='google'>谷歌地图</option>
					 </select>		
		</div>
	</td></tr>
	<tr><td>
		<div id="container" style="position:absolute; z-index:1"></div>
	</td></tr>
</tbody></table>
<!--</div>  -->

  
<script type="text/javascript">  
function doSearch(){
	var  textValue= $('#licenseNumber').val();
	var searchType=$('#searchType').combobox('getValue');
//	alert(searchType);
	
	var recent=$('#recent').combobox('getValue');;
//	alert(recent);
	
	var startTime=$('#beginTimeV').datetimebox('getValue');
	//alert(startTime);
	
	var stopTime=$('#endTimeV').datetimebox('getValue');
	//alert($stopTime);
	
	if(startTime != null && startTime !=''){
		if(stopTime ==null || stopTime==''){
			alert("请输入结束时间！");
			return;
		}
	}
	
	if(stopTime != null && stopTime !=''){
		if(startTime ==null || startTime==''){
			alert("请输入开始时间！");
			return;
		}
	}
	
	if((startTime == null || startTime =='') &&(stopTime ==null || stopTime=='') ){
			if(recent== "last3hr"){
					var now =new Date();
				    now.setHours(now.getHours()-3);
				    startTime=now.format('yyyy-MM-dd hh:mm:ss');
	                stopTime=new Date().format('yyyy-MM-dd hh:mm:ss');
					
			}
			else if(recent== "last6hr"){
				 var now =new Date();
				    now.setHours(now.getHours()-6);
				    startTime=now.format('yyyy-MM-dd hh:mm:ss');
	                stopTime=new Date().format('yyyy-MM-dd hh:mm:ss');
			}
			else if(recent== "last12hr"){
				    var now =new Date();
				    now.setHours(now.getHours()-12);
				    startTime=now.format('yyyy-MM-dd hh:mm:ss');
	                stopTime=new Date().format('yyyy-MM-dd hh:mm:ss');
			}
			
			else if(recent== "today"){
				    var now =new Date();
				    now.setHours(now.getHours()-24);
				    startTime=now.format('yyyy-MM-dd hh:mm:ss');
	                stopTime=new Date().format('yyyy-MM-dd hh:mm:ss');
			}
					
	}
	
	//   alert("optype:"+searchType);
	//   alert("opvalue:"+textValue);
	 $.post("../service/deviceInfo.php",
			  {
				 optype:searchType,
				 opvalue:textValue
				 
			  },
			  function(data,status){
			 // 	alert(data.length);
				  var rows=eval(data);
				  if(rows.length==0){
				  	alert("没有数据！");
				  }
				  else{
				  	glob_deviceID=rows[0].deviceID;
				  //	 alert(_deviceID);
				  	getTrackLineData(startTime,stopTime);
				  	 
				  }
			
				
			  });
	
   
	
	
}



// 百度地图API功能
//var sContent =
//"<h4 style='margin:0 0 5px 0;padding:0.2em 0'>15800892321【在线】</h4>" + 
//"定位：GPS（南）"+"时间：2014-06-22 10:22:05</br>"
//+"位置：上海市浦东新区松涛路489号-a</br>"
//+"<img  id='imgDemo1' src='../mapPic/trace.jpg' width='39' height='38' title='跟踪'  onclick='trace()'  /> "
//+"&nbsp;&nbsp;&nbsp;"
//+"<img  id='imgDemo2' src='../mapPic/playback.jpg' width='39' height='38' title='回放'  onclick='playback()'  /> "
//+"&nbsp;&nbsp;&nbsp;"
//+"<img  id='imgDemo3' src='../mapPic/alerts.jpg' width='39' height='38' title='告警'  onclick='alerts()'  /> "
//+"&nbsp;&nbsp;&nbsp;"
//+"<img  id='imgDemo4' src='../mapPic/infor.jpg' width='39' height='38' title='档案'  onclick='info()'  /> "
//+"&nbsp;&nbsp;&nbsp;"
//+"<img  id='imgDemo5' src='../mapPic/setting.jpg' width='39' height='38' title='设置'  onclick='setting()'  /> "
//+"&nbsp;&nbsp;&nbsp;"
//+"<img  id='imgDemo5' src='../mapPic/more.jpg' width='39' height='38' title='更多'  onclick='more()'  /> "
//+"</div>";

var map;

$(function(){
	map = anydata.mapapi.history.initMap(curMapEngine,"container");

//var point = new BMap.Point(121.582123, 31.209193);
//var marker = new BMap.Marker(point);
//var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
//map.centerAndZoom(point, 15);
//map.addOverlay(marker);
//marker.addEventListener("click", function(){          
//   this.openInfoWindow(infoWindow);
//   //图片加载完毕重绘infowindow
//   document.getElementById('imgDemo').onload = function (){
//       infoWindow.redraw();   //防止在网速较慢，图片未加载时，生成的信息框高度比图片的总高度小，导致图片部分被隐藏
//   }
//});

})

var curMapEngine = "baidu";
function mapEngine_onChange(newEngine){
	if (newEngine == curMapEngine) return;
	curMapEngine = newEngine;
	map = anydata.mapapi.history.initMap(curMapEngine,"container");
}


//历史行程
var trackLine;
var trackData = null;
var deviceId;
var startTime;
var stopTime;
//playback_fakeData();
//var recordIndex=0;
var eventIcons = new Array();

function clearTrackLine(){
	anydata.mapapi.history.clearPolyline(curMapEngine,map,trackLine);
	
	anydata.mapapi.history.clearIcons(curMapEngine,map,eventIcons);
//	for (var index in eventIcons){
//		map.removeOverlay(eventIcons[index]);	
//	}	
}

//  add by zjf begin
var  glob_deviceID = "<?php echo $deviceId; ?>";	
//add by zjf end

//'2014-07-02 17:34:44',
//'2014-07-02 17:44:21'
function getTrackLineData(start_time,stop_time){
		$.get("../../zend_obd/jsonAPI/getTripDetail.php", {
			deviceId: 	glob_deviceID,
			startTime:	start_time, 
			stopTime:	stop_time	
		},function(jsonStr,status){	
			//alert (jsonStr);
			//alert (status);
			if (status=="success") {		
				//过滤前面的错误信息
				jsonStr = jsonStr.substr(jsonStr.indexOf("{"));
				trackData = eval("(" +jsonStr+ ")");	
				//if (trackData.resultCode == "200"){
				if (trackData.total > 0){
					displayTrackLine();	//地图显示轨迹					
				}
				else trackData = null;
			}
		});
		getHistory(glob_deviceID,start_time,stop_time);	//数据窗口加载数据
}
 

//画轨迹
function displayTrackLine(){
	clearTrackLine();
	//alert("displayTrackLine");
	// 轨迹线
	if (trackData== null) return;
	var points = new Array();
	var i=0; //非0的有效gps信息计数
	var centX =0.0, centY=0.0, maxX=0.0,maxY=0.0,minX=0.0,minY=0.0;
	for (var trip in trackData.rows) {		
		lat = parseFloat(trackData.rows[trip].baidu_latitude) ;
		lon = parseFloat(trackData.rows[trip].baidu_longitude);
		if ( isNaN(lat) || isNaN(lon)) continue;

		if ( isValidGps(lat,lon)){			
			points[i]= new anydata.mapapi.history.point(lat,lon);			
			i++;
		}			
	}
	if(i>0){
		centX /=i; 
		centY /=i;
	}	
				
	//画线
	trackLine = anydata.mapapi.history.displayPolyline(curMapEngine,map,points);

	displayTrackLine_events();
		
}

function displayTrackLine_events(){
	//不处理纠偏问题
	
	//对事件轨迹点画图
	var iconUrl;
	var iconH =68;
	var iconW = 51;
	var offsetY = 64;
	var offsetX = 47;
	
	var lastLat,lastLon;	//上	一个有效gps
	var hasStopIcon = false;
	
	var  i=0;
	for (var tripindex in trackData.rows) {		
		lat = parseFloat(trackData.rows[tripindex].baidu_latitude) ;
		lon = parseFloat(trackData.rows[tripindex].baidu_longitude);
		if ( isNaN(lat) || isNaN(lon)) continue;
		
		if ( !isValidGps(lat, lon) )	continue;	
		
		switch (trackData.rows[tripindex].code){
			case "3015":
				iconUrl = "../mapPic/history/ev-36.png";
				break;
			case "3016":
				iconUrl = "../mapPic/history/ev-30.png";
				hasStopIcon = true;
				break;
			case "3004":
				//if (i==0)	iconUrl = "../mapPic/history/ev-36.png"; 	//第一个有效gps,强制加上起点图标
			default:
				iconUrl = "";
				break;
		};			
		
		if (i==0) {
			iconUrl = "../mapPic/history/ev-36.png"; //第一个有效gps,强制加上起点图标
		}
		
		if (iconUrl != "") {
			var markerOfPoint = anydata.mapapi.history.displayTrackPoint(curMapEngine,map,lat,lon,iconUrl,iconH,iconW,offsetY,offsetX);				
			var index = eventIcons.length;
			eventIcons[index]= markerOfPoint;
		}
		
		lastLat = lat;
		lastLon = lon;		
		i++;
	}	
	
	if (!hasStopIcon){	//最后一个有效gps,如果没有则强制加上终点图标
		var markerOfPoint = anydata.mapapi.history.displayTrackPoint(curMapEngine,map,lastLat,lastLon,"../mapPic/history/ev-30.png",iconH,iconW,offsetY,offsetX);
		var index = eventIcons.length;
		eventIcons[index]= markerOfPoint;		
	}
}

//播放历史轨迹 playback for trip info
var playbackStatus =0;	//0: stop; 1:playing; 2:Pause
var playInterval = 250;	//播放间隔
var playProgress = 0; 
var lastPoint =null;	
//var markerOfPoint;		//地图播放点

function playbackHistory(){
//播放\暂停
	if (playbackStatus==0){
		
		playbackStatus=1;
		//clearTrackLine();
		$('#playbackHistory').html("暂停");
		//alert(playbackStatus);		
		window.setTimeout(showOnePoint, 10);
	}
	else{
		if (playbackStatus ==1){
			playbackStatus = 2;	//pause
			$('#playbackHistory').html("播放");
			//alert(playbackStatus);
		}
		else{
			playbackStatus =1; //continue;
			$('#playbackHistory').html("暂停");		
			//alert(playbackStatus);	
		}
	} 	
	
}

function stopPlayback(){
//停止播放
	playbackStatus=0;
	playProgress = 0;
	
	$('#playbackHistory').html("播放");
	$('#Test1').html(playProgress.toString());	
	
}

function showOnePoint() {
	if (playbackStatus == 2) {  //暂停则Idle
		window.setTimeout(showOnePoint, playInterval);
		return;
	} 
	if (playbackStatus == 0) return;
	
	var curLat,curLng;	
	$('#Test1').html(playProgress.toString());	
	if (trackData && trackData.total >0){
		anydata.mapapi.history.removeTrackPoint(curMapEngine, map,lastPoint);
		do {
			curHeading = parseFloat( trackData.rows[playProgress].heading) + 90.0;  
			curLat = trackData.rows[playProgress].baidu_latitude;
			curLng = trackData.rows[playProgress++].baidu_longitude;					
		}while (!isValidGps(curLat,curLng) && playProgress < trackData.total);	
		
		if (playProgress < trackData.total) {
			//displayTrackPoint (curLat,curLng);	
			lastPoint = anydata.mapapi.history.displayTrackPoint(curMapEngine, map, curLat, curLng,"/obd_web/mapPic/car.png",21,43,10.5,21.5,curHeading);	//画点
			showNextPoint();
		}else {
			playbackStatus=0;
			playProgress=0;
			$('#playbackHistory').html("播放");
		}
	}
}

function showNextPoint(){
	if (playbackStatus == 2) {  //暂停则Idle
		window.setTimeout(showOnePoint, playInterval);
		return;
	} 
	if (playbackStatus == 0) return;
	
	//lastPoint = markerOfPoint;
	if (playProgress < trackData.total){
		//如果未结束,启动下个点的处理
		window.setTimeout(showOnePoint, playInterval);	
	}
}

function removeTrackPoint(lastPoint){
	//lastPoint: Type -- overlay
	map.removeOverlay(lastPoint);
}

function displayTrackPoint(lat,lon){
	//alert("displayTrackPoint");
	var point = new BMap.Point(lon, lat);
	var marker = new BMap.Marker(point);
	map.addOverlay(marker); //	保存句柄
	markerOfPoint = marker;
	//return marker;	//	返回句柄
	
}


var westStatus=1;
		function  westSwitch(){
			if(westStatus==1){
				$('#cc').layout('hidden','south');
				westStatus=0;
			}
			else{
				$('#cc').layout('show','south');
				westStatus=1;
			}
			
		}
 
////定义一个控件类,即function
//function ZoomControl2(){
//  // 默认停靠位置和偏移量
//  this.defaultAnchor = BMAP_ANCHOR_BOTTOM_LEFT;
//  this.defaultOffset = new BMap.Size(600, 0);
//}
//
////通过JavaScript的prototype属性继承于BMap.Control
//ZoomControl2.prototype = new BMap.Control();
//
//// 自定义控件必须实现自己的initialize方法,并且将控件的DOM元素返回
//// 在本方法中创建个div元素作为控件的容器,并将其添加到地图容器中
//ZoomControl2.prototype.initialize = function(map){
//  // 创建一个DOM元素
//  var div = document.createElement("div");
//  div.innerHTML ="<a href='#'><img  id='imgDemo1' src='../mapPic/west.jpg'    onclick='westSwitch()'  /></a> "
//  +"</div>";
//  // 设置样式
//  div.style.cursor = "pointer";
//  div.style.border = "1px solid gray";
//  div.style.backgroundColor = "white";
//  // 添加DOM元素到地图中
//  map.getContainer().appendChild(div);
//  // 将DOM元素返回
//  return div;
//}
//// 创建控件
//var myZoomCtrl2 = new ZoomControl2();
//// 添加到地图当中
//
//map.addControl(myZoomCtrl2);

//$(document).ready( function (){
//	$('#licenseNumber').attr("value", "<?php echo $licenseNumber;?>" );
//});

//	alert ("ready");

//getHistory('6C500CBD','2014-07-20 10:34:44','2014-07-20 17:34:44');
//getHistory('6C4C76C1','2014-07-01%2005:30:33','2014-07-02%2007:26:08');

function getHistory(deviceId,startTime,stopTime){
//	alert("deviceID:"+deviceId);
     var url1='../../zend_obd/jsonAPI/getTripDetail.php?startTime='+startTime+'&'+'stopTime='+stopTime+'&deviceId='+deviceId;
 //     alert(url1);	
     $('#dg').datagrid({   
		 url:url1
				 }
	);  
}



</script>  
</div> 
</body>   
</html>
<?php
?>