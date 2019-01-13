<?php
/*
Copyright by Sunplace
CT:2019/1/12
MT:2019/1/13
*/
session_start();
if(isset($_SESSION['name'])&&isset($_SESSION['password']))
{
	require("functions.php");
	if(!ck($_SESSION['name'],md5($_SESSION['password'].'sunplace'))){
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
<title>文件上传</title>
<link rel="stylesheet" type="text/css" href="../assets/webuploader/webuploader.css">
<link rel="stylesheet" href="../assets/materialize/css/materialize.min.css">	
<link href="../assets/materialize/icon/iconfont/material-icons.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-compat-3.0.0-alpha1.js"></script>
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
	.item-pi{position: absolute;top:0;width: 100%; height: 100%;padding: 1em;text-align: center;}
		.item-ir{position: absolute;top:0;right:0;height: 100%;padding: 1em;}
	.drop-tips{width:100%;text-align: center;transform: translateY(-50%);margin: auto;  
	position: absolute;  
	top: 50%;}
	</style>

</head>
	<body>
	<div  id="uploader">
		<div id="thelist"  class="uploader-list">
			<div class="drop-tips">拖入文件到此框上传。</div>
		
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
    server: '../inc/upload.php?s=k',
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
// 当有文件被添加进队列的时候
uploader.on( 'fileQueued', function( file ) {
	$(".drop-tips").hide();
    $("#thelist").append('<div id="'+file.id+'" class="item-w"><div class="item-p cyan lighten-5"></div>	<div class="item-i"><strong style="max-width:10em;display:inline-block;color:#2196F3;" class="truncate">'+file.name+'</strong>&nbsp;<i class="material-icons" style="color:#9e9e9e;">storage</i>	<small style="display:inline-block;color:#9e9e9e;" class="truncate">'+toeasy(file.size)+'</small></div><div class="item-pi">0%	</div>			<div class="item-ir">			<i class="material-icons">pause</i>			<i class="material-icons remove-this">clear</i>	</div>		</div>');
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
        $li.find('.item-pi').html('<span style="color: #db4b4e;">上传中</span>&nbsp;'+Math.floor(percentage * 100)+'%');
        $percent.css( 'width', percentage * 100 + '%' );
	
});
uploader.on( 'uploadSuccess', function( file,response ) {
	$( '#'+file.id ).find('.item-p').fadeOut();
    $( '#'+file.id ).find('.item-pi').html('<span class="green-text text-light-green">已完成</span>');
	$( '#'+file.id ).find('.remove-this').hide();

});

uploader.on( 'uploadError', function( file ) {
    $( '#'+file.id ).find('.item-pi').text('<span class="deep-orange-text text-darken-1">上传出错</span>');
});

uploader.on( 'uploadComplete', function( file ) {
    //$( '#'+file.id ).find('.progress').fadeOut();
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