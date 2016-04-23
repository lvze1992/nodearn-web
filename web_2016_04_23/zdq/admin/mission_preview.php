<style>
div#preview_div_bg{
background-image:url(img/bg.png);
top:0px;
left:0px;
width:100%;
height:100%;
z-index:2;
position:fixed;
margin:0 auto;
}  
div#preview_div{
width: 100%;
z-index: 3;
position:absolute;
top: 15px;
}  
div#preview_div_container{
background-color:#FFFFFF;
width:730px;
margin:0 auto;
margin-bottom: 30px;
}
div#close_div{
background-image:url(img/close.png);
height:25px;
width:25px;
float:right;
}
</style>
<div id="preview_div_bg"></div>
<div id="preview_div">
	<div id="preview_div_container"><div id="close_div" onclick="Del_Pre()" style="cursor:pointer"></div>
	<?php
		require('../../mysql_connect.php');
		$type='2';
		$id=4;
		$sql="select resource_url from resource where mission_type='$type' and mission_id=$id and class='0' order by order_v DESC";

	?>	
<?php
include("pre.php");
?>	
	
	</div>
</div>
