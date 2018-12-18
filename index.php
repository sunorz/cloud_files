<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DOWNLOAD</title>
<link rel="shortcut icon" href="favicon.ico" /> 
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<style>
/*自定义样式*/
ul,li{list-style-type:none;margin:0;padding:0;}
img[class^="ft-"]{height:1em;outline:none;margin-right:0.5em;}
a,img{display:inline-block;vertical-align:middle;}
footer{padding:1em;color:#CCCCCC;cursor:default;}
</style>
<script src="assets/js/jquery-3.1.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</head>
<body>
<!--
Code by Sunplace
Website:https://jsunplace.com
Date:18/12/16
Update:18/12/17
-->
<div class="container">
<h1>Cloud Files</h1>
<blockquote>
<p>List of files on this site :</p>
</blockquote>
<?php 
require_once('inc/functions.php');
for ($x = ord('A'); $x <= ord('Z'); $x++){
  my_dir('src',chr($x));
}
my_dir('src','#');
?>
<footer>&copy;&nbsp;Sunplace,2018</div>
</footer>
<script>
$("img").each(function(index,ele){
var str = $(this).attr("class");
$(this).attr('src','assets/imgs/ft-'+str.substring(str.lastIndexOf("-")+1)+'.svg');	
       });
</script>
</body>
</html>