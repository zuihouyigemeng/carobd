
<?php 
ob_start();
session_start();
$deviceID = isset($_GET['deviceID']) ? $_GET['deviceID'] : '';
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>汽车油耗统计</title>
    <!-- 来自百度CDN -->
    <script src="http://s1.bdstatic.com/r/www/cache/ecom/esl/1-6-10/esl.js"></script>
    <script type="text/javascript" src="../jquery.min.js"></script>
	<script type="text/javascript" src="../jquery.easyui.min.js"></script>
	<script type="text/javascript" src="../timeUtils.js"></script>
	<style>
	table {
      border-spacing: 0px;
       }
	</style>
</head>
<body style="height:300px,width:500px">
    <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
    <div style="height:300px,width:500px"> 
    <div id="main" style="height:400px"></div>
    <div id="butt" >
    	<div id="table"> </div><br>
    	<table style=" float:right">
    	 <tr><td>
	     	 <a href="#" class="easyui-linkbutton" plain="true"  data-options="iconCls:'icon-large-smartart',size:'samall',iconAlign:'top'" onclick="preMonth_dis()">上个月</a>
	         <a href="#" class="easyui-linkbutton" plain="true"  data-options="iconCls:'icon-large-smartart',size:'samall',iconAlign:'top'" onclick="nextMonth_dis()">下个月</a>
	         <a href="#" class="easyui-linkbutton" plain="true"  data-options="iconCls:'icon-large-smartart',size:'samall',iconAlign:'top'" onclick="exportExcel()">导出</a>
    	 </td></tr>
     	</table>
     </div>
    </div>
    
    <script type="text/javascript">
    
     var deviceID='<?php echo $deviceID ?>';
 
     
     function exportExcel(){
     
     //	alert(deviceID);
         var url="../smarty/demo/excel.php?deviceID="+deviceID+"&time="+thisMonthFirstDay.format('yyyy-MM-dd');
       //   alert(url);
          window.open(url,"_blank");
     }
  
     
        var  thisMonthFirstDay=getCurrentMonthFirst();
        
        // 路径配置
         require.config({
                 paths:{ 
                     'echarts' : 'http://echarts.baidu.com/build/echarts',
                     'echarts/chart/line' : 'http://echarts.baidu.com/build/echarts'
                 }
             });
        
        
         getData();
         
         function getCurrentMonthFirst(){
        	  var date=new Date();
        	  date.setDate(1);
        	  return date;
        	 }
         
         function preMonth_dis(){
        
        //	 alert(thisMonthFirstDay.getMonth());
        	 thisMonthFirstDay.setMonth(thisMonthFirstDay.getMonth()-1);
        //	 alert( thisMonthFirstDay);
        	 getData();
        	
         }
         
         function nextMonth_dis(){
         
        	 thisMonthFirstDay.setMonth(thisMonthFirstDay.getMonth()+1);//加一个月
        //	 alert( thisMonthFirstDay);
        	 getData();
        	 
         }
         
     
        
        
        function getData(){
        	  $.post("../../zend_obd/jsonAPI/fuel_consum.php",
            		  {
            		 deviceID:deviceID,time:thisMonthFirstDay.format('yyyy-MM-dd')
            		  },
            		  function(data,status){
            			//  alert("ppp");
            			  var rows=eval(data);
            			  var x_data=rows[0];
            			  var y_data=rows[1];
            			  var lic=rows[2];
                          // 使用
                          require(
                              [
                                  'echarts',
                                  'echarts/chart/line' // 使用柱状图就加载bar模块，按需加载
                              ],
                              function (ec) {
                                  // 基于准备好的dom，初始化echarts图表
                                  var myChart = ec.init(document.getElementById('main')); 
                                  
                                  option = {
                                  	    title : {
                                  	        text: '汽车油耗统计:'+lic,
                                  	        subtext: ''
                                  	    },
                                  	    tooltip : {
                                  	        trigger: 'axis'
                                  	    },
                                //  	    legend: {
                                //  	        data:['每日油耗']
                                //  	    },
                                  	    toolbox: {
                                  	        show : true,
											feature : {
												mark : {show: false},
												dataView : {show: false, readOnly: true},
												magicType : {show: true, type: ['line', 'bar']},
												restore : {show: true},
												saveAsImage : {show: true}
											}
                                  	    },
                                  	    calculable : false,
                                  	    xAxis : [
                                  	        {
                                  	            type : 'category',
                                  	            boundaryGap : false,
                                  	            data : x_data
                                  	        }
                                  	    ],
                                  	    yAxis : [
                                  	        {
                                  	            type : 'value',
                                  	            axisLabel : {
                                  	                formatter: '{value} L'
                                  	            }
                                  	        }
                                  	    ],
                                  	    series : [
                                  	        {
                                  	            name:'当日油耗',
                                  	            type:'line',
                                  	            data:y_data
                                  	        }
                                  	    ]
                                  	};
                          
                                  // 为echarts对象加载数据 
                                  myChart.setOption(option); 
                                   TestSecond(x_data.length,x_data,y_data);
                              }
                          ); 
            			  
            			  
            			  
            			  
            			  
            			  
        	  
            		  });
            		  
            		  
        	
            	
        	
            		 	
                  
        }
        function TestSecond(number,x,y) 
	    { 
	    	
	        var divt=document.getElementById("table"); 
	        var tablet=document.createElement("table");
	         
	        tablet.border=1;   
	        
	        
	           
	        tablet.cellspacing=0;  
	     
			var textRow=4; 
	        var textCell=16; 
	        var num = 0; 
	        
	        if(number == 31)
	        {
	        	var k=1;
	        }
	        else if(number == 30)
	        {
	        	var k=2;
	        }
	        else if(number== 29)
	        {
	        	var k=3;
	        }
	        else if(number == 28)
	        {
	        	var k=4;
	        }
	        
	  
			
	        for(var i=0;i<textRow;i++) 
	        {  
	            var row=tablet.insertRow(num); 
	            
	           
	            if(i == 1 || i==3)
	            {
	            	row.setAttribute("bgcolor","#108be9");
	            	
	            }
	            
	            for(var j=0;j<textCell;j++) 
	            { 
	                var cell=row.insertCell(num); 
	                if (i==0)
	                {
	                	cell.innerText=y[number-1+k-j];
	                	if(cell.innerText == "undefined")
	                	{
	                		cell.innerText = "";
	                	}
	                }
	                if(i == 1)
	                {
	                	cell.innerText=x[number-1+k-j]; 
	                	if(cell.innerText == "undefined")
	                	{
	                		cell.innerText = "";
	                	}
	                }
	                if(i == 2)
	                {
	                	cell.innerText=y[number-1+k-textCell-j]; 
	                	if(cell.innerText == "undefined")
	                	{
	                		cell.innerText = "";
	                	}
	                	
	                }
	                if(i == 3)
	                {
	                	cell.innerText=x[number-1+k-textCell-j]; 
	                	if(cell.innerText == "undefined")
	                	{
	                		cell.innerText = "";
	                	}
	                	
	                }
	                cell.width=170; 
	                cell.height = 20; 
	            } 
	        } 
	        num = num + 1; 
	        
				divt.innerHTML='';
	            
	            divt.appendChild(tablet); 
	            
	            
	            
	        
	            
	    }
       
       
    </script>
</body>
