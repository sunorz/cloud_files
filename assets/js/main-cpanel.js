//Copyright By Sunplace
$(function(){
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
	$(".in-select .collection a").click(function(){
		
	if($(".chip").is(":visible")){
		$(".chip").remove();
	}
	$(".select").after('<div class="chip"><img src="'+$(this).find("img").attr("src")+'" alt="">'+$(this).text()+'<i class="close material-icons">close</i> </div>');
	});
	//tab2
	$(".tab:nth-child(2)").click(function(){
		$.post("../inc/ls.php",{code:"sunplace"},function(result){		
		$("#content2-list").html(result).find("img").each(function(){
		var str = $(this).attr("class");
		$(this).attr('src','../assets/imgs/ft-'+str.substring(str.lastIndexOf("-")+1)+'.svg');

		});
		});
	});
	//tab3
	
	
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
		console.log("ok");
		$("#content2-list").html('<div class="preloader-wrapper active" >   <div class="spinner-layer spinner-blue-only">      <div class="circle-clipper left"><div class="circle"></div>     </div><div class="gap-patch">        <div class="circle"></div>     </div><div class="circle-clipper right"> <div class="circle"></div>    </div>   </div>  </div>载入中...</div>');
	});