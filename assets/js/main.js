//Copyright By Sunplace
$(function(){
	$.post("../inc/functions.php",{filter:null},function(result){
		$(".content").html(result).find("img").each(function(){
		var str = $(this).attr("class");
		$(this).attr('src','../assets/imgs/ft-'+str.substring(str.lastIndexOf("-")+1)+'.svg');

		});
	});

});


$(".select").click(function(){
	$("nav").find("ul").toggle();
});
function ls(ft){
	$.post("../inc/functions.php",{filter:ft},function(result){
		$(".content").html(result).find("img").each(function(){
		var str = $(this).attr("class");
		$(this).attr('src','../assets/imgs/ft-'+str.substring(str.lastIndexOf("-")+1)+'.svg');

		});
	});
$(".select").trigger("click");

}