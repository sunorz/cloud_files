<?php
if(!isset($_GET['key'])||$_GET['key']!="value"){//简单省事的免密码操作
	die("???");
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DOWNLOAD</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/fa/css/font-awesome.min.css">
<link rel="stylesheet" href="../assets/css/main.css">
<script src="../assets/js/jquery-3.1.1.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
</head>
<body>
<!--
Code by Sunplace
Website:https://jsunplace.com
Date:18/12/25
Update:18/12/30
-->
<div class="container">
<h1>获取链接</h1>
<p class="res"></p>
</div>
<script src="../assets/js/main.js"></script>
	<script>
	$(function(){
		
		$.post("ls.php",{sha1:null,key:"value"},function(result){	//防止直接请求	
		$(".res").html(result).find("img").each(function(){
		var str = $(this).attr("class");
		$(this).attr('src','../assets/imgs/ft-'+str.substring(str.lastIndexOf("-")+1)+'.svg');

		});
		});
	})

	</script>
</body>
</html>