<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>File details</title>
</head>
<link rel="stylesheet" href="../assets/materialize/css/materialize.min.css">	
<link href="../assets/materialize/icon/iconfont/material-icons.css" rel="stylesheet">
<link href="../assets/css/fonts.css" rel="stylesheet">
<script src="../assets/js/jquery-3.1.1.min.js"></script>
<script src="../assets/js/md5.js"></script>
<script src="../assets/materialize/js/materialize.min.js"></script>
	<style>
		.page-title{font-size:2em;}
		img[class^=ftl-]{height: 150px;}		
	</style>
<body>
	<header> 

        <nav class="top-nav  blue lighten-3" style="height: 122px;line-height: 122px;">	
			<div class="nav-wrapper" style="padding-left: 1em;">
				<div class="container">
					<a class="page-title" href="/"><script>var uri=window.location.host;document.write(uri);</script></a>
				</div>
			</div>	
		</nav>

   </header>
<main>
<!--
Code by Sunplace
Website:https://jsunplace.com
Date:18/12/22
Update:19/2/19
-->
<div class="container">
<?php
require("../inc/functions.php");
if(!isset($_GET['fid']))exit("没有这个文件。");
$a=array("g","h","i","j","k","l","m","n","o","p");
$b=array("q","r","s","t","u","v","w","x","y","z");
if($_GET['fid']){
	if(preg_match("/[0-9a-zA-Z]/",$_GET['fid'])){
	$gstr=strtolower($_GET['fid']);
	if(in_array(substr($gstr,2,1),$a)&&in_array(substr($gstr,5,1),$a)){
		$str=substr($gstr,0,2).substr($gstr,3,2).substr($gstr,6);
		pub($str);
	}
	else if(in_array(substr($gstr,2,1),$b)&&in_array(substr($gstr,5,1),$b)){
		$str=substr($gstr,0,2).substr($gstr,3,2).substr($gstr,6);
		pri($str);
	}
	else{
		echo "没有这个文件。";
	}
	}
	else{
   	 echo "没有这个文件。";
	}
}

?>
</div>
	</main>
	<footer><div class="container center-align"><small>Copyright By Sunplace,2018-<script>document.write(new Date().getFullYear('Y'));</script></small></div></footer>
<script>
$(function(){
	var str=$("img").attr("class");
	$("img").attr('src','../assets/imgs/ft-'+str.substring(str.lastIndexOf("-")+1)+'.svg');

});	
</script>
</body>
</html>