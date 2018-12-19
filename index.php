<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DOWNLOAD</title>
<link rel="shortcut icon" href="favicon.ico" /> 
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/fa/css/font-awesome.min.css">
<style>
/*自定义样式*/
ul,li{list-style-type:none;margin:0;padding:0;}
img[class^="ft-"]{height:1em;outline:none;margin-right:0.5em;}
a,img{display:inline-block;vertical-align:middle;}
footer{padding:1em;color:#CCCCCC;cursor:default;}
nav li{vertical-align:middle;cursor:pointer;width:150px;padding:0.2em;}
nav li:hover{background:#CCC;display:inline-block;}
nav li img{height:1em;vertical-align:middle;margin-right:0.5em;}
nav ul{overflow-y: scroll;max-height: 150px;display:none;border:solid #ccc 1px;background:#fff;}
.in-select{display:inline-block;position:absolute;top:0;}
.select{display:inline-block;margin-right:1em;cursor:pointer;}
nav{position:relative;}
</style>
<script src="assets/js/jquery-3.1.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</head>
<body>
<!--
Code by Sunplace
Website:https://jsunplace.com
Date:18/12/16
Update:18/12/19
-->
<div class="container">
<h1>Cloud Files</h1>
<blockquote>
<p>List of files on this site :</p>
</blockquote>
<nav>
<div class="select"><i class="fa fa-file"></i></div>
<div  class="in-select">
<ul>
<li><img src="assets/imgs/ft-apk.svg">APK</li>
<li><img src="assets/imgs/ft-zip.svg">压缩文件</li>
<li><img src="assets/imgs/ft-img.svg">图片</li>
<li><img src="assets/imgs/ft-video.svg">视频</li>
<li><img src="assets/imgs/ft-doc.svg">Word文档</li>
<li><img src="assets/imgs/ft-ppt.svg">PowerPoint文档</li>
<li><img src="assets/imgs/ft-xls.svg">Excel文档</li>
<li><img src="assets/imgs/ft-pdf.svg">PDF</li>
<li><img src="assets/imgs/ft-txt.svg">文本文档</li>
<li><img src="assets/imgs/ft-unknown.svg">其他文档</li>
</ul>
</div>
</nav>
<div class="content">
<?php 
require_once('inc/functions.php');
my_dir('src');
?>
</div>
<footer>&copy;&nbsp;Sunplace,2018</div>
</footer>
<script>
$(".content img").each(function(index,ele){
var str = $(this).attr("class");
$(this).attr('src','assets/imgs/ft-'+str.substring(str.lastIndexOf("-")+1)+'.svg');	
       });
$(".select").click(function(){
	$("nav").find("ul").toggle();
});
</script>
</body>
</html>