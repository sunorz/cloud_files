<?php
/*
Copyright by Sunplace
CT:2018/12/25
MT:2019/5/23
*/
session_start();
if(isset($_SESSION['name'])&&isset($_SESSION['password'])){
	$n=$_SESSION['name'];
	$p=md5($_SESSION['password'].'CONFUSED_STRING');
	require('../inc/functions.php');
	if(!ck($n,$p))
	{
		die('failed');
	}
}
else{
	die('failed');
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CPanel</title>
</head>
<link rel="stylesheet" href="../assets/materialize/css/materialize.min.css">	
<link href="../assets/materialize/icon/iconfont/material-icons.css" rel="stylesheet">
<link href="../assets/css/fonts.css" rel="stylesheet">
<script src="../assets/js/jquery-3.1.1.min.js"></script>
<script src="../assets/js/md5.js"></script>
<script src="../assets/materialize/js/materialize.min.js"></script>
	<style>
		.page-title{font-size:2em;}
		nav{box-shadow:0 0 0 0 #fff;}
		.tabs .tab a:hover,.tabs .tab a:active,.tabs .tab a:visited,.tabs .tab .active{color: #0d47a1 !important;background-color: #fafafa  !important;}
		.tabs .indicator{background: #0d47a1 !important;}
		.tabs .tab a{color: #0d47a1 !important;-webkit-transition: color .28s ease, background-color .28s ease;
    transition: color .28s ease, background-color .28s ease;}		
		img[class^='ft-'],.collection img,.in-select img{height: 1em; font-size:1em !important;margin-right: 0.5em;color:#1a237e; }
		.in-select a{display:block;padding:0.5em;}
		.in-select a:hover{background:#ccc;}
		.open{color:#0d47a1;}
		.more{color:#0d47a1;cursor:pointer;}
		.open:hover,.more:hover{color: #f44336;}
		.tabs .tab{background: #fff;}
		.preloader-wrapper{width: 1em;height: 1em;margin-right: 0.5em;}
		.in-select{height:200px;overflow-y: scroll;display:none;float: right;border:#CCC 1px solid;}
		.chip>img{border-radius:0;}
		.tips{vertical-align: middle;display:inline-block;color:#cccccc;margin-bottom:0.5em;margin-left:0.5em;cursor:pointer;}
		.tips-content{border: 1px solid #e7e7eb;color:#9A9A9A;padding:12px;word-break:break-all;text-indent:24px;display: none;font-size:12px;}
		.truncate{display:inline-block;vertical-align:middle;max-width:70%;}
		.bt{background:#d7ecf5;}
		.card{box-shadow: none;background:#f6f6f6;color:#000;}
		.del{color:#EB9C23;}
		.slideup{background:#f1f3f4;color:#babcbe;}
		.switch label input[type=checkbox]:checked+.lever:after{background-color:#29b6f6;}
		.switch label input[type=checkbox]:checked+.lever{background-color:#b3e5fc;}
		.delall{vertical-align: middle;margin-right:0.35em;}
		.filename{width:80% !important;}
		.slta:hover,.swts:hover,.delall:hover{color:#f44336;cursor:pointer;}
	</style>
<body>
<header> 
        <nav class="top-nav  blue lighten-3" style="height: 60px;line-height: 60px;">	
			<div class="nav-wrapper" style="padding-left: 1em;">
				<div class="container">
					<a class="page-title">CPANEL</a>					
				</div>
			</div>				 
		</nav>
   </header>
<main>
	<div class="container">
	  <ul class="tabs">
        <li class="tab"><a href="#">公开列表</a></li>
        <li class="tab"><a href="#">私密列表</a></li>
        <li class="tab"><a href="#">文件上传</a></li>
      </ul>
<!--公开列表-->
<div id="content1"><h4>公开列表</h4><a class="btn right select waves-effect waves-light blue"><i class=" material-icons left">filter_list</i>筛选</a>
			<div style="clear: both;"></div>
			<div class="in-select">
	<a href="#" onclick="ls('apk')"><img  src="../assets/imgs/ft-apk.svg">APK</a>
	<a href="#" onclick="ls('zip')"><img  src="../assets/imgs/ft-zip.svg">压缩文件</a>
	<a href="#" onclick="ls('img')"><img  src="../assets/imgs/ft-img.svg">图片</a>
	<a href="#" onclick="ls('video')"><img  src="../assets/imgs/ft-video.svg">视频</a>
	<a href="#" onclick="ls('doc')"><img  src="../assets/imgs/ft-doc.svg">Word文档</a>
	<a href="#" onclick="ls('ppt')"><img  src="../assets/imgs/ft-ppt.svg">PowerPoint文档</a>
	<a href="#" onclick="ls('xls')"><img  src="../assets/imgs/ft-xls.svg">Excel文档</a>
	<a href="#" onclick="ls('pdf')"><img  src="../assets/imgs/ft-pdf.svg">PDF文档</a>
	<a href="#" onclick="ls('txt')"><img  src="../assets/imgs/ft-txt.svg">文本文档</a>
	<a href="#" onclick="ls('unknow')"><img  src="../assets/imgs/ft-unknown.svg">其他文件</a>
</div>
<div class="clearfix"></div>	
<div id="content1-list"><!--List here.--></div></div>
<!--私密列表-->
<div id="content2" style="display: none;"><h4>私密列表</h4>
<div id="content2-list"><!--List here.--></div></div>
<!--文件上传-->
<div id="content3" style="display: none;"><h4 style="display:inline-block;">文件上传</h4><i class="material-icons tips" title="点击查看帮助">help</i>
<div class="tips-content">不支持上传文件名为空和后缀为<i class="red-text">exe,msi,php,html,htm,js,css,json,config,htacess,sh,asp,aspx,cs,ashx,bat,cmd</i>的文件。文件大小不能超过<i class="red-text">200MB</i>。</div>
	<div id="content3-list"><iframe id="mainiframe" frameborder="0" scrolling="no" src="../inc/fileupload.php"  onload="setIframeHeight(this)" width="100%"></iframe></div>
		</div>
	</div>
</main>
	<footer><div class="container center-align"><small>Copyright By Sunplace,2018-<script>document.write(new Date().getFullYear('Y'));</script></small></div></footer>
	<div class="fixed-action-btn">
          <a class="btn-floating btn red waves-effect waves-light" onclick="logout()">
            <i class="material-icons">exit_to_app</i>
          </a>         
        </div>
	<script src="../assets/js/main-cpanel.js"></script>
</body>
</html>