/* CT:2019/1/9
   MT:2019/1/9
   Sunplace */ 
		var reg = /^(\d|[a-zA-Z])+$/;
		$(function(){
		$("#username").bind('input propertychange', function() {	
		var uname = $(this).val();
		if($.trim(uname)===''){
			$(this).addClass("invalid");
			$(this).parent(".input-field").find(".errmsg").text('没有填写。');
			return;
		}
			else{
				if(reg.test(uname)){
					$(this).removeClass("invalid");
					$(this).parent(".input-field").find(".errmsg").text('');					
				}
				else
					{
						$(this).addClass("invalid");
						$(this).parent(".input-field").find(".errmsg").text('格式错误。');
						return;
					}
			}
	});
			$("#password").bind('input propertychange', function() {	
		var pwd = $(this).val();
		if(pwd===''){
			$(this).addClass("invalid");
			$(this).parent(".input-field").find(".errmsg").text('没有填写。');
			return;
		}
			else{
				if(reg.test(pwd)){
					$(this).removeClass("invalid");
					$(this).parent(".input-field").find(".errmsg").text('');					
				}
				else
					{
						$(this).addClass("invalid");
						$(this).parent(".input-field").find(".errmsg").text('格式错误。');
						return;
					}
			}
	});
			
			
		});

	$(".btn").click(function(even){
		even.preventDefault();
		var name = $.trim($("#username").val());
		var pp = $.md5($("#password").val());
		if(name!="" && $("#password").val()!="" && $('.errmsg').text()===''){
		   //console.log("uname="+$.trim($("#username").val())+",password="+$("#password").val());
		$(".login").html('<div class="valign-wrapper" style="height:128px;"><div class="valign center" style="width:100%;"><div class="preloader-wrapper active small"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div>      </div><div class="gap-patch">  <div class="circle"></div>   </div><div class="circle-clipper right">        <div class="circle"></div>    </div>    </div>  </div><p>登录中...</p></div></div>');

			$.post('../inc/action.php',{username:name,password:pp},function(result){
				if(result!='success')
					{
						$(".login").html('<div class="valign-wrapper" style="height:128px;"><div class="valign center" style="width:100%;"><p class="red-text text-lighten-1">登录失败</p><button onclick="javascript:window.location.href=\'/\';" class="btn waves-effect waves-light red" style="border:none;">重新登录<i class="material-icons right">send</i>  </button></div></div>');
					}
				else{
					window.location.href='../cpanel/';
				}
			});
		   }
	});
function logout(){
	$.post('../inc/action.php',{logout:"yes"},function(result){
		if(result=='logout'){
			alert("已注销。");
			window.location.href="/";
		}
	});
}