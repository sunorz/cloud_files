<?php
/*
Copyright by Sunplace
CT:2019/1/12
MT:2019/3/24
*/
session_start();
if(isset($_SESSION['name'])&&isset($_SESSION['password']))
{
	require("functions.php");
	if(!ck($_SESSION['name'],md5($_SESSION['password'].'CONFUSED_STRING'))){
		die("failed");
	}
}
else
{
	die("failed");
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload</title>
<link rel="stylesheet" type="text/css" href="../assets/webuploader/webuploader.css">
<link rel="stylesheet" href="../assets/materialize/css/materialize.min.css">	
<link href="../assets/materialize/icon/iconfont/material-icons.css" rel="stylesheet">
<link href="../assets/css/fonts.css" rel="stylesheet">
<script src="../assets/js/jquery-1.10.2.min.js"></script>
<script src="../assets/js/jquery.cookie.js"></script>
<script src='../assets/webuploader/webuploader.js'></script>
<script src="../assets/materialize/js/materialize.min.js"></script>
<style>.uploader-list{
	    color: #ccc;
    border: 2px dashed #ddd;
    padding: 15px;
    margin: 15px 0 0;min-height:150px;width: 100%;position: relative;
	}
	.item-w{
		position: relative;height: 50px;color:#000;margin-top: 0.5em;
	}
	.item-p{
		position: absolute;left:0;top:0;width:0%;height: 100%;
	}
	.item-i{
		position: absolute;height: 100%;padding: 1em;top: 0;left: 0;
	}
	.item-pi{position: absolute;top:0;width: 100%; height: 100%;padding: 1em 5em 1em 1em;text-align: right;}
		.item-ir{position: absolute;top:0;right:0;height: 100%;padding: 1em;}
	.drop-tips{width:100%;text-align: center;transform: translateY(-50%);margin: auto;  
	position: absolute;  
	top: 50%;}
	@media screen and (max-width:600px){
.item-pi {
   display:none;
  }
}
img{ height:2em;vertical-align: middle;margin-right:0.5em;}
	</style>

</head>
	<body>
    <p>
      <label>
        <input class="with-gap" name="group1" type="radio" id="pub" checked />
        <span for="pub">公开</span>
      </label>
      <label>
        <input class="with-gap" name="group1" id="pri" type="radio"  />
        <span for="pri">私密</span>
      </label>
    </p>   
  	<div  id="uploader">
		<div id="thelist"  class="uploader-list">
			<div class="drop-tips"><img src="../assets/imgs/cloud-backup-up-arrow.svg"><span>拖入文件到此框上传。</span></div>
		
		</div>	
		<div id="picker">选择文件</div>
		<a id="ctlBtn" class="waves-effect waves-light btn blue"><i class="material-icons left">file_upload</i>上传</a>
		
			</div>	
<script>
var state = 'pending';
var uploader = WebUploader.create({
    // swf文件路径
    swf: '../assets/webuploader/Uploader.swf',
    // 文件接收服务端。
    server: '../inc/upload.php',
    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: {id:'#picker',innerHTML:'<a style="z-index:-999" class="btn-floating btn-large waves-effect waves-light blue lighten-2"><i class="material-icons">add</i></a>'},
			dnd:'#thelist',
			disableGlobalDnd:true,
			duplicate:true,
			
	chunked: true,           //开启分片上传
    	chunkSize: 1024*1024*2,  //每一片的大小
    	chunkRetry: 100,         // 如果遇到网络错误,重新上传次数
    		threads: 3,              //上传并发数。允许同时最大上传进程数。
    		resize: false,

});
uploader.on( 'all', function(type) {	
	$('#thelist').on('click', '.pause-this:visible', function () {
		var id = $(this).parents(".item-w").attr("id");//拿到id
		if($(this).text()=='pause'){			    
				$(this).text('play_arrow');
			    uploader.stop(id);
		}
		else
		{
				$(this).text('pause');
			    uploader.upload(id);
		}
				
	});
});

// 当有文件被添加进队列的时候
uploader.on( 'fileQueued', function( file ) {
	var filename = file.name;
	var filext = filename.substring(filename.lastIndexOf(".")+1,filename.length);
	var forbidden = "exe,msi,php,html,htm,js,css,json,config,htacess,sh,asp,aspx,cs,ashx,bat,cmd";
	var arr = forbidden.split(',');		
	$(".drop-tips").hide();
	/*包含非法后缀或文件名为：
	  ..jpg,.jpg,.name.jpg*/
	if($.inArray(filext,arr)>-1||filename.indexOf(".")==0){
    $("#thelist").append('<div id="'+file.id+'" class="item-w"><div class="item-i"><strong style="max-width:10em;display:inline-block;color:#ef5350;" class="truncate">'+file.name+'</strong></div><div class="item-ir"><small>非法文件名或被禁止的后缀。</small></div>		</div>');
		uploader.removeFile(file);
		}
		else
	{
    $("#thelist").append('<div id="'+file.id+'" class="item-w"><div class="item-p cyan lighten-5"></div>	<div class="item-i"><strong style="max-width:10em;display:inline-block;color:#2196F3;" class="truncate">'+file.name+'</strong>&nbsp;<small style="display:inline-block;color:#9e9e9e;" class="truncate">'+toeasy(file.size)+'</small></div><div class="item-pi">0%	</div>			<div class="item-ir">			<i class="material-icons pause-this" style="display:none;">pause</i>			<i class="material-icons remove-this">clear</i>	</div>		</div>');
	}
			//删除上传的文件
		$('#thelist').on('click', '.remove-this', function () {
			if ($(this).parents('.item-w').attr('id') == file.id) {
			uploader.removeFile(file);
			$(this).parents('.item-w').remove();
			}
			if($(".item-w").length==0)
				{
					$(".drop-tips").show();
				}
				
		});


	 
});

// 文件上传过程中创建进度条实时显示。
uploader.on( 'uploadProgress', function( file, percentage ) {
    var $li = $( '#'+file.id ),
        $percent = $li.find('.item-p');
	    $( '#'+file.id+" .item-ir").find(".pause-this").show();
        $li.find('.item-pi').html(Math.floor(percentage * 100)+'%');
        $percent.css( 'width', percentage * 100 + '%' );
		//暂停上传

});
	
uploader.on( 'uploadSuccess', function( file,response ) {
	$( '#'+file.id ).find('.item-p').fadeOut();
    $( '#'+file.id ).find('strong').css('color','#689f38');
	$( '#'+file.id ).find('.item-pi').css('padding','0');
	$( '#'+file.id ).find('.remove-this').hide();

});

uploader.on( 'uploadError', function( file ) {
   $( '#'+file.id ).find('strong').css('color','#BD2D30');
});

uploader.on( 'uploadComplete', function( file ) {
    $( '#'+file.id ).find(".pause-this").hide();
});
var ty="pub";
$(function(){
		 $('input[type=radio][name=group1]').change(function() {
			$('.item-w').remove();
        if (this.id == 'pri') {
        $.cookie('type', 'pri');
        }
        else if (this.id == 'pub') {
        $.cookie('type', 'pub');
        }
    });
});

$("#ctlBtn").on( 'click', function() {


	if ( state === 'uploading' ) {
		
		uploader.stop();
		
	} else {

				 uploader.upload();

		
	}
});
function toeasy(bytes) {
    if (bytes === 0) return '0 B';
    var k = 1000, // or 1024
        sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
        i = Math.floor(Math.log(bytes) / Math.log(k));
 
   return (bytes / Math.pow(k, i)).toPrecision(3) + ' ' + sizes[i];
}

</script>
		</body>
	<html>