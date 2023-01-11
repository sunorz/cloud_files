<!--Copyright by Sunplace
CT:2018/12/16
MT:2019/5/30
-->
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CloudStorage</title>
</head>
<link rel="stylesheet" href="assets/materialize/css/materialize.min.css">	
<link href="assets/materialize/icon/iconfont/material-icons.css" rel="stylesheet">
<link href="assets/css/fonts.css" rel="stylesheet">
<script src="assets/js/jquery-3.1.1.min.js"></script>
<script src="assets/js/md5.js"></script>
<script src="assets/materialize/js/materialize.min.js"></script>
<style>		
.page-title{font-size:2em;}
.circle{height:150px;width:150px;border:#fff 3px solid;}
.avatar{margin: auto; background-color:#000;height:150px;width:150px;border-radius:50%;position:absolute;top: 50%;transform: translateY(-50%) translateX(-50%);left:50%;border:#fff 3px solid;background-position:center center;background-repeat: no-repeat;cursor:pointer;}
</style>
<body>
	<header> 

        <nav class="top-nav  blue lighten-3" style="height: 122px;line-height: 122px;">	
			<div class="nav-wrapper" style="padding-left: 1em;">
				<div class="container">
					<a class="page-title" href="/"><script>var uri=window.location.host;document.write(uri);</script></a>
				</div>
			</div>	
		</nav>

   </header>
<main>
	<div class="container">
		<div class="row">
		<div class="col s12 m10 l6 offset-l3 offset-m1 z-depth-2" style="margin-top: 2em;padding: 0;color: #0d47a1;">

<?php 
	session_start();
	if(isset($_SESSION['name'])&&isset($_SESSION['password'])){
	$n=$_SESSION['name'];
	$p=$_SESSION['password'];
	require('inc/functions.php');
	if(ck($n,md5($p.'CONFUSED_STRING'))){
		?>
        <div class="col s12 blue lighten-5" style="position: relative;height:190px;">
		 <?php
		$flag=0;
		if(!is_file("assets/imgs/avatars/".$n.".jpg")){
			$flag=1;
		}
		
		if($flag==0){
			$size  = getimagesize("assets/imgs/avatars/".$n.".jpg"); 
			$width = $size[0];
			$height = $size[1];
			if(max($width,$height)>=150){
				?>
				<div class="avatar" title="进入后台" style="background-size:contain;background-image:url('assets/imgs/avatars/<?php echo $n;?>.jpg');"></div>
				<?php
			}
			else{
				?>
				<div class="avatar" title="进入后台" style="background-image:url('assets/imgs/avatars/<?php echo $n;?>.jpg');"></div>
				<?php
			}
							
		}
		else
		{
		echo '<p class="center-align"><img class="circle" src="assets/imgs/avatars/default.jpg"></p>';
		}
		
		
		
		?>
          <a onClick="logout()" class="btn-floating waves-effect waves-light red" style="position: absolute;bottom: -20px;right:10px;"><i class="material-icons">exit_to_app</i></a> 
      </div>
			 <div class="col s12 login">
          <p><i class="material-icons">account_circle</i><?php echo $n;?>&nbsp;&nbsp;<span class="blue-grey-text text-lighten-3">已登录。</span></p></div>
	   <?php
	}
	}
			else{
?>  			<div class="col s12 blue lighten-5">
              <h3>用户登陆</h3>
              <p>Login</p>
				<div class="divider"></div>
			</div>	
        <div class="col s12 login">
          <div class="row">
				<form>
					<div class="input-field col s12" style="margin-top: 2em;">
          				<input id="username" type="text" class="validate" autocomplete="off" required="required">
          				<label for="username"><i class="material-icons">assignment_ind</i>&nbsp;账户<span class="errmsg"></span></label>
        			</div>
					<div style="clear: both;"></div>
					<div class="input-field col s12">
          				<input id="password" type="password" class="validate" autocomplete="off" required="required">
          				<label for="password"><i class="material-icons">vpn_key</i>&nbsp;密码<span class="errmsg"></span></label>
        			</div>
					 <center><button class="btn waves-effect waves-light blue">登陆
    <i class="material-icons right">send</i>
  </button></center>
					</form>
			  <?php }?>
			  <div style="clear: both;"></div>
            </div> 
</div>
        </div>
      </div>
	</div>
</main>
	<footer><div class="container center-align"><i class="material-icons tiny">hotel</i>&nbsp;<small><a href="changelogs.html">Changelogs</a>&nbsp;Copyright By Sunplace,2018-<script>document.write(new Date().getFullYear('Y'));</script></small></div></footer>
	<script src="assets/js/main-index.js"></script>
</body>
</html>