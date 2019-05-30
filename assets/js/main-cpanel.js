//Copyright By Sunplace
var countdown=15;
var t;
$(function(){
	$("body").on("click",".delall",function(){
		console.log($(".chk:checked").length);
	});
	$("body").on("click","#chk_1",function(){
		$(".card").remove();
		$('.chk').prop('checked',$(this).is(':checked')?true:false);
		if($(".chk:checked").length==0||$(".chk:checked").length==$(".chk").length){
			$("#chk_2").attr("disabled","disabled");
		}
		else{
			$("#chk_2").removeAttr("disabled");
		}
	});
	$("body").on("click","#chk_2",function(){
		$(".card").remove();
		$('.chk').each(function(){
				$(this).prop('checked',$(this).is(':checked')?false:true);
			 });
	});
	$("body").on("change",".chk",function(){
		if($(".chk:checked").length==0||$(".chk:checked").length==$(".chk").length){
$("#chk_2").attr("disabled","disabled");
}
else{
	$("#chk_2").removeAttr("disabled");
}
		
	});
	$("body").on("click",".undo",function(){
		//撤回的操作
		clearTimeout(t);
		countdown=15;
		$(this).attr("class","del waves-effect waves-red btn-flat right");
        $(this).html('<i class="material-icons left">clear</i>删除');
	});
	$("body").on("click",".save",function(){
		var fnews = $(this).parents(".collection-item").find(".filename").val();
		if(fnews == "" || $.trim(fnews).length == 0){
			fnews = $(this).parents(".collection-item").find(".truncate").text();
		}
		$.post("../inc/options.php",{fname:$(this).parents(".collection-item").find(".truncate").text(),fnew:fnews,fopt:"s"},function(){M.toast({html: '已更新'});
		init();
		});
	});
	$("body").on("click",".del",function(){
	var obj = $(this);
    settime(obj);		
	});
	$("body").on("click",".slideup",function(){
	$(this).parents(".card").slideUp();
	$(this).parents("li").find(".more").show();
	$(this).parents(".card").remove();
	});
	$("body").on("click",".more",function(){
		if(countdown==15){
		$(".card").fadeOut();
		$(".more").show();
		$(this).parents("li").append('<div class="card"><div class="card-content" style="font-size:14px;"><input class="filename"  placeholder="不修改文件名请留空" type="text" length="50" maxlength="50" autocomplete="off"><span class="blue-grey-text text-lighten-2"><i>'+get_file_ext($(this).parents(".collection-item").find(".truncate").text())+'</i></span><div class="clearfix"></div><a class="save waves-effect waves-green btn-flat green-text"><i class="material-icons left">spellcheck</i>保存</a><a class="del waves-effect waves-red btn-flat right"><i class="material-icons left">clear</i>删除</a></div><a class="slideup waves-effect bt btn-flat center-align" style="display:block;"><i class="material-icons">publish</i></a></div>');
		$(this).fadeOut();
		}
	});
	$(".tips").click(function(){
		$(".tips-content").slideToggle();
	});
	 $('ul.tabs').tabs();
	//初始
	init();
    $(".tab").click(function(){
		$(this).css("background","#fff");
	});
			$(".tab").click(function(){
				var index = $(this).index()+1;
				$("div[id^=content]").not("div[id$=list]").hide();
				if($("div[id=content"+index+"]").is(":hidden")){
					$("div[id=content"+index+"]").show();
				}
				
			});
	//tab1
	$(".select").click(function(){
		$(".in-select").toggle();
	});
	$(".in-select").click(function(){
		$(this).hide();
	});
	$(".in-select a").click(function(){
		
	if($(".chip").is(":visible")){
		$(".chip").remove();
	}
	$(".select").after('<div class="chip"><img src="'+$(this).find("img").attr("src")+'" alt="">'+$(this).text()+'<i class="close material-icons">close</i> </div>');
	});
	//tab2
	$(".tab:eq(2)").click(function(){
		$.post("../inc/ls.php",{key:"six"},function(result){		
		$("#content2-list").html(result).find("img").each(function(){
		var str = $(this).attr("class");
		$(this).attr('src','../assets/imgs/ft-'+str.substring(str.lastIndexOf("-")+1)+'.svg');

		});
		});
	});	
});
	$("body").on('click','.close',function(){
		init();		
	});
function init(){
			$("#content1-list").html('<div class="preloader-wrapper active" >   <div class="spinner-layer spinner-blue-only">      <div class="circle-clipper left"><div class="circle"></div>     </div><div class="gap-patch">        <div class="circle"></div>     </div><div class="circle-clipper right"> <div class="circle"></div>    </div>   </div>  </div>载入中...</div>');
			
$.post("../inc/ll.php",{filter:null},function(result){
		$("#content1-list").html(result).find("img").each(function(){
		var str = $(this).attr("class");
		$(this).attr('src','../assets/imgs/ft-'+str.substring(str.lastIndexOf("-")+1)+'.svg');

		});
	});

}
function ls(ft){
			$("#content1-list").html('<div class="preloader-wrapper active" >   <div class="spinner-layer spinner-blue-only">      <div class="circle-clipper left"><div class="circle"></div>     </div><div class="gap-patch">        <div class="circle"></div>     </div><div class="circle-clipper right"> <div class="circle"></div>    </div>   </div>  </div>载入中...</div>');
	$.post("../inc/ll.php",{filter:ft},function(result){
	
		$("#content1-list").html(result).find("img").each(function(){
				var str = $(this).attr("class");
		$(this).attr('src','../assets/imgs/ft-'+str.substring(str.lastIndexOf("-")+1)+'.svg');

		});
	});

}
function logout(){
	$.post('../inc/action.php',{action:"logout"},function(result){
		if(result=='success'){
			alert("已注销。");
			window.location.href="/";
		}
	});
}
  function setIframeHeight(){
        var ifm= document.getElementById("mainiframe");
        ifm.height=document.documentElement.clientHeight-56;
    }
    window.onresize=function(){ setIframeHeight();}
    $(function(){setIframeHeight();});
	$(".tab:eq(1)").click(function(){
		$("#content2-list").html('<div class="preloader-wrapper active" >   <div class="spinner-layer spinner-blue-only">      <div class="circle-clipper left"><div class="circle"></div>     </div><div class="gap-patch">        <div class="circle"></div>     </div><div class="circle-clipper right"> <div class="circle"></div>    </div>   </div>  </div>载入中...</div>');
	});
function settime(obj) { //倒计时
    if (countdown == 0) { 
		var ul = obj.parents("ul");
		var li =  obj.parents("li");
		var fn = li.find(".truncate").text();
        setTimeout(function(){li.remove();},2000);
		if(ul.find("li").length==2){
			setTimeout(function(){ul.remove();},2000);
		}
		$.post(
			"../inc/options.php",
			{fname:obj.parents(".collection-item").find(".truncate").text(),fopt:"d"},
			function(result){
				$(".card").html(result);
				M.toast({html: fn+'已删除！'});});
        countdown = 15; 		
        return;
    } else { 
		obj.attr("class","undo waves-effect waves-light btn-flat right");
        obj.html('<i class="material-icons left">undo</i>撤回(' + countdown + ')');
        countdown--; 
    } 
	if(countdown<=15){
t=setTimeout(function() { 
    settime(obj) }
    ,1000) }
}
function get_file_ext(filename){
//获取后缀名
var arr = filename.split('.');
	if(arr.length>=2){
    var last = arr[arr.length-1];
	var last_bf = arr[arr.length-2];
	if ('.'+last_bf+'.'+last=='.tar.gz'){
		return '.tar.gz';
	}
	else{
		return '.'+last;
	}
	}
return 0;
}