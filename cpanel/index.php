<?php
/*
Copyright by Sunplace
CT:2018/12/25
MT:2019/1/13
*/
session_start();
if(isset($_SESSION['name'])&&isset($_SESSION['password'])){
	$n=$_SESSION['name'];
	$p=md5($_SESSION['password'].'54h7845');
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
		img[class^='ft-'],.collection img{height: 1em; font-size:1em !important;margin-right: 0.5em;color:#1a237e; }
		.open{color:#0d47a1;}
		.open:hover{color: #f44336;}
		.tabs .tab{background: #fff;}
		.preloader-wrapper{width: 1em;height: 1em;margin-right: 0.5em;}
		.in-select .collection{display: inline-block;height:200px;overflow-y: scroll; }
		.in-select{display:none;float: right;}
		.chip>img{border-radius:0;}
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
<div class="collection">
	<a href="#" onclick="ls('apk')" class="collection-item"><img  src="../assets/imgs/ft-apk.svg">APK</a>
	<a href="#" onclick="ls('zip')" class="collection-item"><img  src="../assets/imgs/ft-zip.svg">压缩文件</a>
	<a href="#" onclick="ls('img')" class="collection-item"><img  src="../assets/imgs/ft-img.svg">图片</a>
	<a href="#" onclick="ls('video')" class="collection-item"><img  src="../assets/imgs/ft-video.svg">视频</a>
	<a href="#" onclick="ls('doc')" class="collection-item"><img  src="../assets/imgs/ft-doc.svg">Word文档</a>
	<a href="#" onclick="ls('ppt')" class="collection-item"><img  src="../assets/imgs/ft-ppt.svg">PowerPoint文档</a>
	<a href="#" onclick="ls('xls')" class="collection-item"><img  src="../assets/imgs/ft-xls.svg">Excel文档</a>
	<a href="#" onclick="ls('pdf')" class="collection-item"><img  src="../assets/imgs/ft-pdf.svg">PDF文档</a>
	<a href="#" onclick="ls('txt')" class="collection-item"><img  src="../assets/imgs/ft-txt.svg">文本文档</a>
	<a href="#" onclick="ls('unknow')" class="collection-item"><img  src="../assets/imgs/ft-unknown.svg">其他文件</a>
</div>
</div>
			
<div id="content1-list"><!--List here.--></div></div>
<!--私密列表-->
<div id="content2" style="display: none;"><h4>私密列表</h4>
<div id="content2-list"><!--List here.--></div></div>
<!--文件上传-->
<div id="content3" style="display: none;"><h4>文件上传</h4>
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