<?php 
include('head.html'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<link rel="stylesheet" type="text/css" href="css/jquery.step.css">
<link rel="stylesheet" type="text/css" href="css/client_style.css">
<?php
if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['reflash'])){
$error=array();
$profit=$_POST['profit'];
$r_profit=$_POST['r_profit'];
$profit_limit=$_POST['profit_limit'];
$total_profit=$_POST['total_profit'];
$article_url=$_POST['article_url'];
$article_txt=$_POST['article_txt'];
$article_pic=$_POST['article_pic'];
$client=$_POST['client'];
/*unset($vert_list);
if(empty($vert_list)){
				$vert=$items['vert'];//yyy++aa==yyy++aa
				$a=explode("==",$vert);
				for($i=0;$i<count($a);$i++){
					$b=explode("++",$a[$i]);	
					$vert_list[]=array('id'=>time().rand(1000,9999),'q'=>$b[0],'a'=>$b[1]);
				}
}
*/
}
if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['client-form'])){
	$table1="client_mission";
	$table2="client_mission_read";
	$mission_type="15";
$profit=$_POST['profit'];
$r_profit=$_POST['r_profit'];
$profit_limit=$_POST['profit_limit'];
$total_profit=$_POST['total_profit'];
$article_url=$_POST['article_url'];
$article_txt=$_POST['article_txt'];
$article_pic=$_POST['article_pic'];
$flag=$_POST['flag'];
$client=$_POST['client'];
if($client!=0){
	$items_empty=0;
	if($profit=="") $items_empty="请填写-单次点击收益";
	if($r_profit=="") $items_empty="请填写-转发链接单次点击收益";
	if($profit_limit=="") $items_empty="请填写-用户收益上限";
	if($total_profit=="") $items_empty="请填写-投入总金额";
	if($article_url=="") $items_empty="请填写-文章链接";
	if($article_txt=="") $items_empty="请填写-文章摘要";
	if($article_pic=="") $items_empty="请添加-图片展示（1张或3张图片）";
	if(!is_numeric($total_profit)) $error[]="请在“投入总金额”项填入数字，并不要超过余额";
	if($items_empty==0&&empty($error)){
		$article_url_id=substr(time().rand(1000,9999),6);
		/*数据库插入 client_mission,client_mission_wetalk,vertification,resource*/
		  mysql_query("START TRANSACTION");
		  $sql="insert into $table1(client_mission_title,client_mission_intro,client_id,mission_type) values('$article_txt','read_mission',$client,'$mission_type')";
		  if(mysql_query($sql)){
			  $sql="select last_insert_id()";
			  $r=mysql_query($sql);
			  $row=mysql_fetch_array($r);
			  $mission_id=$row[0]; 
			  if(count($article_pic)==2) {$sql=",pic1,pic1_big";$value=",'".$article_pic[1]."','".$article_pic[0]."'";}
			  else if(count($article_pic)==6) {$sql=",pic1,pic2,pic3,pic1_big,pic2_big,pic3_big";$value=",'".$article_pic[1]."','".$article_pic[3]."'".",'".$article_pic[5]."','".$article_pic[0]."'".",'".$article_pic[2]."','".$article_pic[4]."'";}
		  $sql="insert into $table2(mission_id,mission_type,profit,r_profit,profit_limit,total_profit,profit_rest,article_url,article_url_id,state$sql) values($mission_id,'$mission_type','$profit','$r_profit','$profit_limit','$total_profit','$total_profit','$article_url','$article_url_id','0'$value)";
				  if(mysql_query($sql)){
					  mysql_query("COMMIT");$flag=0;
				  }else $error[]="任务添加失败02！请点击刷新按钮再提交";
		  }else $error[]="任务添加失败04！请点击刷新按钮再提交";
		/*数据库插入*/
	}
	else{
		$error[]=$items_empty;			
	}	
}
else{
	$error[]="请在第二步中选择-该任务所属的商户";
}
if($flag!=$_POST['flag']){
		echo "<h2 style='text-align:center;padding-top:40px'>添加成功</h2>";
		echo "<p style='text-align:center'><a href='follow_read.php'>继续添加</a>或<a href='client_mission_list.php'>查看已添加</a></p>";
		echo "<div style='clear:both'>&nbsp;</div>";
		exit;	
}
//print_r($items);
//print_r($logo);
}
if(!empty($error)){
?>
<div class="register-width promotion-tip error"><span class="vertical-middle">
<p style="font-weight: 700;">出现如下错误：</p>
<p>
<?php
	  foreach($error as $msg){
		  echo "• $msg<br/>";
		  }

?>
</p>
<p>请重试</p>
</span></div>
<?php
}
?>
<div class="step-body" id="myStep">
  <div class="step-header" style="width:80%">
    <ul>
      <li>
        <p>完善阅读任务信息</p>
      </li>
      <li>
        <p>预览并提交</p>
      </li>
    </ul>
  </div>
  <form action="" method="post" enctype="multipart/form-data" onSubmit="return checkCoords();">
  <input type="hidden" name="flag" value="1"/>
    <div class="step-content">
      <div class="step-list">
        <p class="nav"> <a href="javascript:void(0);" id="submitBtn">下一步</a> </p>
        <!--**************************************form2*为任务添加图文******************************************-->
        <div class="form-list form-main-list" >
          <div class="form-group mission-res-set">
            <div class="form-item"> <span class="form-label form-label-b">完善阅读任务信息</span> <span class="sub-title">若对填入项有疑问，可在填写后预览，或咨询客服</span> </div>
            <div class="form-item"> <span class="form-label"><span class="star">*</span>文章链接</span>
              <textarea  class="form-text"  name="article_url" style="height:100px; width:300px" placeholder="请填写文章的链接。"><?php echo $_POST['article_url'];?></textarea>
            </div>
            <div class="form-item"> <span class="form-label"><span class="star">*</span>文章摘要</span>
              <textarea  class="form-text"  name="article_txt" style="height:100px; width:300px" placeholder="请填写文章的简要信息。"><?php echo $_POST['article_txt'];?></textarea>
            </div>

            <div class="form-item"> <span class="form-label"><span class="star">*</span>图片展示</span>
            <p>选择JPEG或GIF文件进行上传，添加的图片数量须为1或3。</p>
              <?php
 			$article_pic=$_POST['article_pic'];   		
            include("cutdemo/index.1.5.php");//client logo
            //resource img
    ?>
            </div>
            <?php
            	$profit=0.05;
				$r_profit=0.01;
				$profit_limit=5;
			?>            
            <div class="form-item"> <span class="form-label"><span class="star">*</span>单次点击收益</span>
            <?php echo number_format($profit,2);?>元<input type="hidden" name="profit" value="<?php echo $profit;?>"/>
            </div>
            <div class="form-item"> <span class="form-label"><span class="star">*</span>转发链接单次点击收益</span>
            <?php echo number_format($r_profit,2);?>元<input type="hidden" name="r_profit" value="<?php echo $r_profit;?>"/>
            </div>
            <div class="form-item"> <span class="form-label"><span class="star">*</span>用户收益上限</span>
            <?php echo number_format($profit_limit,2);?>元<input type="hidden" name="profit_limit" value="<?php echo $profit_limit;?>"/>
            </div>   
            <div class="form-item"> <span class="form-label"><span class="star">*</span>投入总金额</span>
            <input type="text" name="total_profit" value="<?php if($_POST['total_profit']!="")echo $_POST['total_profit'];?>"/> 元
            </div>        
          </div>
        </div>
        <fieldset style="width:55%; margin:0 auto;margin-left:200px; margin-bottom:20px; min-height:300px; border-color:#e7e7e7">
          <legend><span style="color: #333333;margin-top: 18px;font-weight: bold;font-size: 14px;">已添加的图片，可拖动排序 <span style="color:red">（添加的图片数量须为1或3）</span></span></legend>
<style type="text/css">
.list_container  ul,.list_container  li { list-style-type:none; color:#262323;}
ul.sTree{ padding:0px; background-color:#151515; }
ul.sTree2 li, ul#sortableListsBase li { padding-left:50px; margin:5px; background-color:#1b6c89; }
li div { padding:7px; background-color:#81c1dc;}
.list_container  li,.list_container  ul,.list_container  div { border-radius: 3px; }
img.descPicture { display:block; width:100%; margin:0 7px 30px 0; float:left; cursor:pointer; /*transition: all 0.5s ease;*/ }
img.descPicture.descPictureClose { width:150px; }
#sTree2 { margin:10px auto; }</style>            
        		    <div class="list_container">
                    <section id="main_content">
						<ul class="sTree2 listsClass" id="sTree2">
             <?php 
			if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['recut'])){
				$n=count($article_pic);
				array_splice($article_pic,$n-2,2);
			}
			if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['cut'])&&!empty($logo)){
				$article_pic[]=$logo[0];
				$article_pic[]=$logo[1];
			}
			if(!empty($article_pic)){
				for($i=0;$i<count($article_pic);$i++){
					echo "<li id='item_$i' data-module='a'><div>".substr(htmlspecialchars($article_pic[$i]),0,51)."…";
					echo "<input type='hidden' name='article_pic[]' value='$article_pic[$i]'>";
					$i++;
					echo "<input type='hidden' name='article_pic[]' value='$article_pic[$i]'>";
					echo "</div></li>";
				}
	
			}
			 ?>
                                    </ul>                    
                              </section>                      
                            </div>

        </fieldset>
        <p class="nav"> <a href="javascript:void(0);" id="submitBtn1">下一步</a> </p>
      </div>
      <!--**************************************form2*为任务添加图文******************************************-->
      <div class="step-list">
        <p class="nav"><a href="javascript:void(0);" id="goBtn">上一步</a></p>
        
        <!--**************************************form3*预览任务******************************************-->
        <style>
	  	.pre_container{
		  padding:10px 10px;
		  width:60%;
		  margin:0 auto 0px 150px;
		  border: solid 1px #ccd6e0;
		  float:left;
		  }
	  	.float-left{
		  float:left;
		  }
		.pre_container dt{
			width:30%;}
		.pre_container dd{
			padding-left:10px;
			width:65%;}
		.pre_container dt img{
			width:80%;
			}
		input[type="button"]{
				border:none;
				color:#FFF;
				background-color:#F33;
				padding:3px 6px;
				font-weight:bold;
				}
		.pre_container dd p{
			padding:0;
			min-height:110px;
			max-height:150px;}	
		.detail_top{
		    width:50%;
			padding-left:30px;
			padding-bottom:10px;
			border-bottom: dashed 1px #bcbcbc;
			margin-bottom:0;
			margin-left:150px;
			}
		.detail_top dt{
			width:55%;
			}
		.detail_top dd{
		width:40%;
		text-align:center;
		}	
		.detail_top dd img{
		width:80%;
		}	
		  .detail_main{
		width:50%;
		padding-left:30px;
		padding-bottom:10px;
		border-bottom: dashed 1px #bcbcbc;
		border-top: none;
		margin-left:150px;

	  }
	  .detail_main_container{
		margin-left: 6%;
		width: 80%;
		background-color:#FCC;/*#FCC*/
		padding: 10px 8px;
		}
		.detail_main_container .imgtext{
			margin:0 auto 0 5%;
		 }
		  .detail_bottom{
		width:50%;
		padding-left:30px;
		border-top: none;
		margin-left:150px;

	  }
		.more_info dt{
			width:25%;
			padding-bottom: 5px;
			}
		.more_info dd{
			width:60%;
			padding-bottom: 5px;
		}
	  </style>
        <h3 style="color:#F33; padding-left:100px;">此页面布局与APP布局有差异，仅供参考。</h3>
        <p class="nav">
          <button type="submit" class="btn btn-large" name="reflash">刷新</button>
        </p>
        <h4 style=" padding-left:155px; padding-top:10px;"><em>任务封面</em></h4>
        <div class="pre_container">
          <dl>
          <?php
          if(count($article_pic)==2){
		  ?>
            <dt class="float-left" style="width:60%;"> <p style="font-size:18px;padding-left: 40px;"><?php echo htmlspecialchars($article_txt);?></p>
            <h5 style="padding-left: 40px;"> <span class="peo"><?php echo $_POST['client_name'];?> （阅读 999999）</span> </h5></dt>
            <dd class="float-left"  style="width:40%; padding-left:0;">
              <p style="min-height:80px"><img src="<?php if(empty($article_pic)) ;else echo $article_pic[0];?>" alt="logo图片"  style="width:80%; "/>  </p>
            </dd>
            <?php
		  }
		  else{	
		  	?>
            <dtstyle="width:100%;"> <p style="font-size:18px;padding-left: 40px;"><?php echo htmlspecialchars($article_txt);?></p>
            <h5 style="padding-left: 40px;"> <span class="peo"><?php echo $_POST['client_name'];?> （阅读 999999）</span> </h5></dt>
            <dd style="width:100%; padding-left:0;">
              <p style="min-height:80px"><img src="<?php echo $article_pic[0];?>" alt="logo图片"  style="width:30%; "/>  <img src="<?php echo $article_pic[2];?>" alt="logo图片"  style="width:30%; "/>  <img src="<?php echo $article_pic[4];?>" alt="logo图片"  style="width:30%; "/>  </p>
            </dd>
            <?php
		  }
			?>
          </dl>
        </div>
        <div style=" clear:both;"></div>        
        <h4 style=" padding-left:155px; padding-top:10px;"><em>更多信息</em></h4>
        <div class="pre_container more_info" style="margin-bottom:50px;">
          <dl>
            <dt style="padding-left:50px" class="float-left">文章链接</dt>
            <dd class="float-left"><?php if($article_url=="") echo "<em style='color:red;'>未设置</em>";else echo htmlspecialchars($article_url);?>
            </dd>
            <dt style="padding-left:50px" class="float-left">文章摘要</dt>
            <dd class="float-left"><?php if($article_txt=="") echo "<em style='color:red;'>未设置</em>";else echo htmlspecialchars($article_txt);?>
            </dd>
            <dt style="padding-left:50px" class="float-left">单次点击收益</dt>
            <dd class="float-left"><?php if($profit=="") echo "<em style='color:red;'>未设置</em>";else echo number_format($profit,2)." 元 ";?>
            </dd>
            <dt style="padding-left:50px"  class="float-left">转发链接单次点击收益</dt>
            <dd class="float-left"><?php if($r_profit=="") echo "<em style='color:red;'>未设置</em>";else echo number_format($r_profit,2)." 元 ";?>
            </dd>
            <dt style="padding-left:50px" class="float-left">用户收益上限</dt>
            <dd class="float-left">
            <?php if($profit_limit=="") echo "<em style='color:red;'>未设置</em>";else echo number_format($profit_limit,2)." 元 ";?>
            （达到收益上限后，该用户无法再从此任务中获得任何收益）
            </dd> 
            <dt style="padding-left:50px" class="float-left">投入总金额</dt>
            <dd class="float-left"><?php if($total_profit=="") echo "<em style='color:red;'>未设置</em>";else echo number_format($total_profit,2)." 元 ";?>
            </dd> 
          </dl>
        </div>

        <div style=" clear:both;"></div>      
<?php
$sql="select client_id,CONCAT(last_name,first_name),company from client where admin_id=".$_SESSION['zdq_admin_s'];
$r=mysql_query($sql);
echo "<p style='text-align:center; margin-bottom:20px'><span style='padding-right:5px; color:red'>*</span><select name='client' style='min-width:200px'>";
echo "<option value='0'>请选择该任务所属的商户</option>";
while($row=@mysql_fetch_array($r)){
	if($_POST['client']==$row[client_id]){
		$client_name=$row[2];
		echo "<option value='$row[client_id]' selected='selected'>$row[1]&nbsp;&nbsp;$row[2]</option>";
	}
	else
		echo "<option value='$row[client_id]'>$row[1]&nbsp;&nbsp;$row[2]</option>";
	}
echo "</select></p>";
?>
        <p class="nav">
          <button type="submit" id="J_BtnInfoForm" name="client-form" class="btn btn-large">确认提交</button>
        </p>
                <h3 style="color:#F33; padding-left:100px; padding-top:50px;">确认提交后，我们将尽快审核，通过后即发布。</h3>

        <p class="nav"><a href="javascript:void(0);" id="goBtn1">上一步</a> </p>
      </div>
    </div>
  </form>
</div>
<div style="clear:both; display:table; content:''; ">&nbsp;</div>
</body>
<script src="js/jquery.step.js"></script>
<script>
	$(function() {

		var step= $("#myStep").step({
			animate:true,
			<?php if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['reflash'])) echo "initStep:2"; else echo "initStep:1";?>
			,
			speed:1000
		});
		
		$("#preBtn").click(function(event) {
			var yes=step.preStep();

		});
		$("#applyBtn").click(function(event) {
			var yes=step.nextStep();

		});
		$("#submitBtn").click(function(event) {
			var yes=step.nextStep();


		});
		$("#goBtn").click(function(event) {
			var yes=step.goStep(1);

		});
		$("#preBtn1").click(function(event) {
			var yes=step.preStep();

		});
		$("#applyBtn1").click(function(event) {
			var yes=step.nextStep();

		});
		$("#submitBtn1").click(function(event) {
			var yes=step.nextStep();


		});
		$("#goBtn1").click(function(event) {
			var yes=step.goStep(1);

		});
		

		
	});
</script>
<link rel="stylesheet" type="text/css" href="js/timepicker/css/jquery-ui.css" />
<script type="text/javascript" src="js/timepicker/js/jquery-ui.js"></script>
<script type="text/javascript" src="js/timepicker/js/jquery-ui-slide.min.js"></script>
<script type="text/javascript" src="js/timepicker/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
$(function(){
	$('#example_1').datetimepicker();
		$('#example_2').datetimepicker();

});
</script>
<script src="js/jquery-git1.min.js"></script>
<script src="js/jquery-sortable-lists.min.js"></script>
<script type="text/javascript">
var jq = $.noConflict(true); 
jq(function()
{
	var options = {
			placeholderCss: {'background-color': '#ff8'},
			hintCss: {'background-color':'#bbf'},
			isAllowed: function(cEl, hint, target)
			{
				if(hint.parents('li').first().data('module') === 'c' && cEl.data('module') !== 'c')
				{
					hint.css('background-color', '#ff9999');
					return false;
				}
				else
				{
					hint.css('background-color', '#99ff99');
					return true;
				}
			},
			opener: {
				 active: true,
				 close: 'images/Remove2.png',
				 open: 'images/Add2.png',
				 openerCss: {
					 'display': 'inline-block',
					 'width': '18px',
					 'height': '18px',
					 'float': 'left',
					 'margin-left': '-35px',
					 'margin-right': '5px',
					 'background-position': 'center center',
					 'background-repeat': 'no-repeat'
				 },
				 openerClass: ''
			}
		},

		sWrapper = jq('#settingsWrapper');

	jq('#sTree2, #sTree').sortableLists(options);

	jq('#toArrBtn').on('click', function(){ console.log(jq('#sTree2').sortableListsToArray()); });
	jq('#toHierBtn').on('click', function() { console.log(jq('#sTree2').sortableListsToHierarchy()); });
	jq('#toStrBtn').on('click', function() { console.log(jq('#sTree2').sortableListsToString()); });
	jq('.descPicture').on('click', function(e) { jq(this).toggleClass('descPictureClose'); });
});
</script>
