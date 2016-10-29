<?php
#header('Content-type: text/html; charset=UTF8');

$url = "http://".$_SERVER['REMOTE_HOST']; //当前用户主机名 
//$_SERVER['REQUEST_URI'] //URL


//Code By Safe
function customError($errno, $errstr, $errfile, $errline){ 
  echo "alert('Error number: [".$errno."],error on line ".$errline." in ".$errfile."');location='javascript:history.go(-1)';";
  die();
}

set_error_handler("customError",E_ERROR);

$getfilter="'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";

/*$postfilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";*/

$postfilter="'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";

/*$cookiefilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";*/

$cookiefilter="'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";

function StopAttack($StrFiltKey,$StrFiltValue,$ArrFiltReq){
	 if(is_array($StrFiltValue)){
		 $StrFiltValue=implode($StrFiltValue);
	 }  
	 if(preg_match("/".$ArrFiltReq."/is",$StrFiltValue)==1){   
		header("Location: ".$url."/obd_web_1.0.6_csl/filter/operationError.php");
		exit();
	 }      
}  

foreach($_GET as $key=>$value){ 
  StopAttack($key,$value,$getfilter);
}

foreach($_POST as $key=>$value){ 
  StopAttack($key,$value,$postfilter);
}

foreach($_COOKIE as $key=>$value){ 
  StopAttack($key,$value,$cookiefilter);
}

?>