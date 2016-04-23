<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
if($_SESSION['zdq_admin_group']!=1){
	$_SESSION['zdq_admin_s'] = NULL;
	$_SESSION['zdq_admin_group'] = NULL;
	unset($_SESSION['zdq_admin_s']);
	unset($_SESSION['zdq_admin_group']);
	$logoutGoTo = "index.php?force=home";
    header("Location: $logoutGoTo");
    exit;

	}
// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['zdq_admin_s'] = NULL;
  $_SESSION['zdq_admin_group'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['zdq_admin_s']);
  unset($_SESSION['zdq_admin_group']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>赚点钱-管理平台</title>
<style type="text/css">
<!--
body {
    font-family: "Helvetica Neue", "Luxi Sans", "DejaVu Sans", Tahoma, "Hiragino Sans GB", STHeiti, "Microsoft YaHei";
	background-color: #4E5869;
	margin: 0;
	padding: 0;
	color: #000;
}

/* ~~ 元素/标签选择器 ~~ */
ul, ol, dl { /* 由于浏览器之间的差异，最佳做法是在列表中将填充和边距都设置为零。为了保持一致，您可以在此处指定需要的数值，也可以在列表所包含的列表项（LI、DT 和 DD）中指定需要的数值。请注意，除非编写一个更为具体的选择器，否则您在此处进行的设置将会层叠到 .nav 列表。 */
	padding: 0;
	margin: 0;
}
h1, h2, h3, h4, h5, h6, p {
	margin-top: 0;	 /* 删除上边距可以解决边距会超出其包含的 div 的问题。剩余的下边距可以使 div 与后面的任何元素保持一定距离。 */
	padding-right: 15px;
	padding-left: 15px; /* 向 div 内的元素侧边（而不是 div 自身）添加填充可避免使用任何方框模型数学。此外，也可将具有侧边填充的嵌套 div 用作替代方法。 */
}
a img { /* 此选择器将删除某些浏览器中显示在图像周围的默认蓝色边框（当该图像包含在链接中时） */
	border: none;
}

/* ~~ 站点链接的样式必须保持此顺序，包括用于创建悬停效果的选择器组在内。 ~~ */
a:link {
	color:#414958;
	text-decoration: underline; /* 除非将链接设置成极为独特的外观样式，否则最好提供下划线，以便可从视觉上快速识别 */
}
a:visited {
	color: #4E5869;
	text-decoration: underline;
}
a:hover, a:active, a:focus { /* 此组选择器将为键盘导航者提供与鼠标使用者相同的悬停体验。 */
	text-decoration: none;
}

/* ~~ 此容器包含所有其它 div，并依百分比设定其宽度 ~~ */
.container {
	width: 90%;
	max-width: 1260px;/* 可能需要最大宽度，以防止此布局在大型显示器上过宽。这将使行长度更便于阅读。IE6 不遵循此声明。 */
	min-width: 780px;/* 可能需要最小宽度，以防止此布局过窄。这将使侧面列中的行长度更便于阅读。IE6 不遵循此声明。 */
	background-color: #FFF;
	margin: 0 auto; /* 侧边的自动值与宽度结合使用，可以将布局居中对齐。如果将 .container 宽度设置为 100%，则不需要此设置。 */
}

/* ~~ 标题未指定宽度。它将扩展到布局的完整宽度。标题包含一个图像占位符，该占位符应替换为您自己的链接徽标 ~~ */
.header {
	background-color: #2b96bc;
}
#header_contain{
	width:84%; 
	float:right;
	margin-top:-70px;
}
#header_contain a{
color: #FFF;
padding-right: 10px;
float: right;
text-decoration: none;
font-size: 15px;
	}
/* ~~ 以下是此布局的列。 ~~ 

1) 填充只会放置于 div 的顶部和/或底部。此 div 中的元素侧边会有填充。这样，您可以避免使用任何“方框模型数学”。请注意，如果向 div 自身添加任何侧边填充或边框，这些侧边填充或边框将与您定义的宽度相加，得出 *总计* 宽度。您也可以选择删除 div 中的元素的填充，并在该元素中另外放置一个没有任何宽度但具有设计所需填充的 div。

2) 由于这些列均为浮动列，因此未对其指定边距。如果必须添加边距，请避免在浮动方向一侧放置边距（例如：div 中的右边距设置为向右浮动）。在很多情况下，都可以改用填充。对于必须打破此规则的 div，应向该 div 的规则中添加“display:inline”声明，以控制某些版本的 Internet Explorer 会使边距翻倍的错误。

3) 由于可以在一个文档中多次使用类（并且一个元素可以应用多个类），因此已向这些列分配类名，而不是 ID。例如，必要时可堆叠两个侧栏 div。您可以根据个人偏好将这些名称轻松地改为 ID，前提是仅对每个文档使用一次。

4) 如果您更喜欢在右侧（而不是左侧）进行导航，只需使这些列向相反方向浮动（全部向右，而非全部向左），它们将按相反顺序显示。您无需在 HTML 源文件中移动 div。

*/
.sidebar1 {
	float: left;
	width: 16%;
	padding-bottom: 20px;
	background-color: #293038;
	color:#FFF;
	font-size: 12px;
	background-image:url(img/sidebarbg.png);
	background-repeat:no-repeat;
	background-position:0 320px;
	overflow:hidden;
}
.content {
	padding: 10px 0;
	width: 84%;
	float: left;
}

/* ~~ 此分组的选择器为 .content 区域中的列表提供了空间 ~~ */
.content ul, .content ol { 
	padding: 0 15px 15px 40px; /* 此填充反映上述标题和段落规则中的右填充。填充放置于下方可用于间隔列表中其它元素，置于左侧可用于创建缩进。您可以根据需要进行调整。 */
}

/* ~~ 导航列表样式（如果选择使用预先创建的 Spry 等弹出菜单，则可以删除此样式） ~~ */
ul.nav {
	list-style: none; /* 这将删除列表标记 */
	border-top: 1px solid #666; /* 这将为链接创建上边框 – 使用下边框将所有其它项放置在 LI 中 */
	margin-bottom: 15px; /* 这将在下面内容的导航之间创建间距 */
}
ul.nav li {
	border-bottom: 1px solid #666; /* 这将创建按钮间隔 */
}
ul.nav a, ul.nav a:visited { /* 对这些选择器进行分组可确保链接即使在访问之后也能保持其按钮外观 */
	padding: 5px 5px 5px 15px;
	display: block; /* 这将为链接赋予块属性，使其填满包含它的整个 LI。这样，整个区域都可以响应鼠标单击操作。 */
	text-decoration: none;
	background-color: #8090AB;
	color: #000;
}
ul.nav a:hover, ul.nav a:active, ul.nav a:focus { /* 这将更改鼠标和键盘导航的背景和文本颜色 */
	background-color: #6F7D94;
	color: #FFF;
}

/* ~~ 脚注 ~~ */
.footer {
padding: 20px 0 10px 0;
background-color: #1d6981;
position: relative;
clear: both;
color: #999;
font-size: 14px; 
}

/* ~~ 其它浮动/清除类 ~~ */
.fltrt {  /* 此类可用于在页面中使元素向右浮动。浮动元素必须位于其在页面上的相邻元素之前。 */
	float: right;
	margin-left: 8px;
}
.fltlft { /* 此类可用于在页面中使元素向左浮动。浮动元素必须位于其在页面上的相邻元素之前。 */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* 如果从 #container 中删除或移出了 #footer，则可以将此类放置在 <br /> 或空 div 中，作为 #container 内最后一个浮动 div 之后的最终元素 */
	clear:both;
	height:0;
	font-size: 1px;
	line-height: 0px;
}
-->
.AccordionPanelContent p{
margin: 0;
padding: 5px;
padding-left: 40px;
color: #ffffff;
	}
.AccordionPanelContent p:hover{
margin: 0;
padding: 5px;
padding-left: 40px;
color: #ffffff;
cursor:pointer;
background-color: #37424f;
	}	
.AccordionPanelContentFocus{
background-color:#0099cb;
	}		
</style>
<link href="js/SpryAccordion.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 7]>
<style>
.content { margin-right: -1px; } /* 此 1px 负边距可以放置在此布局中的任何列中，且具有相同的校正效果。 */
ul.nav a { zoom: 1; }  /* 缩放属性将为 IE 提供其需要的 hasLayout 触发器，用于校正链接之间的额外空白 */
</style>
<![endif]-->
<script src="js/SpryAccordion.js" type="text/javascript"></script>
</head>

<body>
<div class="container">
  <div class="header"><a href="#"><img src="img/logo.png" alt="赚点钱LOGO" name="Insert_logo" width="16%" id="Insert_logo" style="background-color: #1d6981; display:block;" /></a>
<?php
require_once('../../../mysql_connect.php'); 
$admin_id= $_SESSION['zdq_admin_s'];
$sql="select CONCAT('**',first_name) from admin where admin_id=$admin_id limit 1";
$r=mysql_query($sql);
$row=@mysql_fetch_array($r);
?>
   <div id="header_contain"><a href="<?php echo $logoutAction ?>">退出</a><a href="#">Hi,<?php echo $row[0];?></a></div>
  <!-- end .header --></div>
  <div class="sidebar1" id="sidebar2">
      <div id="Accordion1" class="Accordion" tabindex="0">
        <div class="AccordionPanel">
          <div class="AccordionPanelTab" style=" border-top:1px solid transparent">商户</div>
           <div class="AccordionPanelContent"><p onclick="javascript:ahref('client.php',event)" id="p1">添加商户</p><p onclick="javascript:ahref('client_list.php',event)"  id="p2">商户列表</p></div>
        </div>
        <div class="AccordionPanel">
          <div class="AccordionPanelTab">发布任务</div>
          <div class="AccordionPanelContent"><p onclick="javascript:ahref('follow.php',event)"  id="p3">商户关注推广</p><p onclick="javascript:ahref('follow_read.php',event)"  id="p4">提升文章阅读</p></div>
        </div>
        <div class="AccordionPanel">
          <div class="AccordionPanelTab">任务中心</div>
          <div class="AccordionPanelContent"><p  id="p5">任务反馈信息</p><p  id="p6">提升任务关注度</p><p  id="p7">审核中</p><p  onclick="javascript:ahref('client_mission_list.php',event)"   id="p07">任务列表</p></div>
        </div>
        <div class="AccordionPanel">
          <div class="AccordionPanelTab">充值续费</div>
          <div class="AccordionPanelContent"><p onclick="javascript:ahref('account.php',event)"  id="p8">查看资金情况</p><p onclick="javascript:ahref('error.html',event)"  id="p9">充值</p></div>
        </div>
        <div class="AccordionPanel">
          <div class="AccordionPanelTab">账户管理</div>
          <div class="AccordionPanelContent"><p onclick="javascript:ahref('user.php',event)"  id="p10">个人信息</p></div>
        </div>
      </div>
    <p style="padding-top:100px;">☎ 欢迎来到赚点钱-管理平台，若有疑问可咨询QQ：8765551<!-- 关于我们的介绍 --></p>
    <div style="top: 565px;position: relative; background-color:#0fa6d7;width:100%; height:100%;"></div>
  <!-- end .sidebar1 -->
  </div>
  <div class="content">
	<iframe src="client.php" height="500px" width="100%" style="border:hidden" id="phpernote" onload="javascript:dyniframesize('phpernote');" scrolling="no"></iframe>
    <!-- end .content --></div>
  <div class="footer">
    <p>Copyright © 2016 Zhuandianqian. All rights reserved.</p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
<script type="text/javascript">
var Accordion1 = new Spry.Widget.Accordion("Accordion1");
</script>
<script>
setInterval("dyniframesize('phpernote')",1000);
function dyniframesize(down){
	var Sys={};
	var ua=navigator.userAgent.toLowerCase();
	var s;
	(s=ua.match(/msie ([\d.]+)/))?Sys.ie=s[1]:
	(s=ua.match(/firefox\/([\d.]+)/))?Sys.firefox=s[1]:
	(s=ua.match(/chrome\/([\d.]+)/))?Sys.chrome=s[1]:
	(s=ua.match(/opera.([\d.]+)/))?Sys.opera=s[1]:
	(s=ua.match(/version\/([\d.]+).*safari/))?Sys.safari=s[1]:0;
	var pTar=null;
	var slide=null;
	if (document.getElementById){
		pTar=document.getElementById(down);
	}else{
		eval('pTar='+down+';');
	}
	pTar.style.display="block";
	
	if (Sys.ie){
		if(Sys.ie=='9.0'){
			pTar.height=pTar.contentWindow.document.body.offsetHeight+15+"px";
			//pTar.width=pTar.contentWindow.document.body.scrollWidth+"px";
		}else if(Sys.ie=='8.0'){
			pTar.height=pTar.Document.body.offsetHeight+15+"px";
			//pTar.width=pTar.Document.body.scrollWidth+"px";
		}else{
			pTar.height=pTar.Document.body.scrollHeight+25+"px";
			//pTar.width=pTar.Document.body.scrollWidth+"px";
		}
	}
	if (Sys.firefox){
		pTar.height=pTar.contentDocument.body.offsetHeight+15+"px";
		//pTar.width=pTar.contentDocument.body.scrollWidth+"px";
	}
	if (Sys.chrome){
		pTar.height=pTar.contentDocument.body.offsetHeight;
		//pTar.width=pTar.contentDocument.body.scrollWidth;
	}
	if (Sys.opera){
		pTar.height=pTar.contentDocument.body.offsetHeight;
		//pTar.width=pTar.contentDocument.body.scrollWidth;
	}
	if (Sys.safari){						        	
		if(pTar.contentDocument.body.offsetHeight <= '186'){
			pTar.height=pTar.contentDocument.body.offsetHeight+10;
		}else{
			pTar.height=pTar.contentDocument.body.offsetHeight;
		}
		//pTar.width=pTar.contentDocument.body.scrollWidth;
	}
	var side=document.getElementById("sidebar2");
	if(pTar.height.indexOf("px") <= 0 ){
		pTar.height=pTar.height+"px";
	}
	side.style.height=pTar.height;
	side.style.minHeight="550px";

}


function ahref(url,e){
	var i=document.getElementById('phpernote');
	i.src=url;
	var e = window.event || e;
    var o = e.srcElement || e.target;
	addClass(o.id,"AccordionPanelContentFocus");
	}
function addClass(element,value) {
	var a=document.getElementsByClassName("AccordionPanelContent");
	for(var i=0;i<a.length;i++){
		var b=a[i].getElementsByTagName("p");
		for(var j=0;j<b.length;j++){
		  b[j].className="";
		}
	}
	var on=document.getElementById(element);
	on.className=value;
}
</script>
</body>
</html>
