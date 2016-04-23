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
$items = $_POST['items'];
$logo=$_POST['logo'];
$res_img_text=$_POST['res_img_text'];
$client=$_POST['client'];
unset($vert_list);
if(empty($vert_list)){
				$vert=$items['vert'];//yyy++aa==yyy++aa
				$a=explode("==",$vert);
				for($i=0;$i<count($a);$i++){
					$b=explode("++",$a[$i]);	
					$vert_list[]=array('id'=>time().rand(1000,9999),'q'=>$b[0],'a'=>$b[1]);
				}
}

//print_r($items);
//print_r($logo);
//print_r($res_img_text);
//echo "__$client";
}
if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['client-form'])){
	$table1="client_mission";
	$table2="client_mission_wetalk";
	$mission_type="13";
	$vert_list=array();
	$res_list=array();
$flag=$_POST['flag'];
$items = $_POST['items'];
$logo=$_POST['logo'];
$res_img_text=$_POST['res_img_text'];
$client=$_POST['client'];
$vert_list=$_POST['vert_list'];
if(empty($vert_list)){
				$vert=$items['vert'];//yyy++aa==yyy++aa
				$a=explode("==",$vert);
				for($i=0;$i<count($a);$i++){
					$b=explode("++",$a[$i]);	
					$vert_list[]=array('id'=>time().rand(1000,9999),'q'=>$b[0],'a'=>$b[1]);
				}
}
if($client!=0){
	$items_empty=0;
	foreach($items as $item){	
		if($item==""){
			$items_empty=1;
			break;	
		}	
	}
	if($items_empty==0&&!empty($logo)&&!empty($res_img_text)){
		/*res_list*/
			if(empty($res_list)){
					for($i=0;$i<count($res_img_text);$i++){
						if(strstr($res_img_text[$i],"img_admin/".$_SESSION['zdq_admin_s']))
						$res_list[]=array('type'=>'img','res'=>$res_img_text[$i]);
						else
						$res_list[]=array('type'=>'txt','res'=>$res_img_text[$i]);
					}
			}

		/*数据库插入 client_mission,client_mission_wetalk,vertification,resource*/
		  mysql_query("START TRANSACTION");
		  $sql="insert into $table1(client_mission_title,client_mission_intro,client_id,mission_type) values('$items[title]','$items[intro]',$client,'$mission_type')";
		  if(mysql_query($sql)){
			  $sql="select last_insert_id()";
			  $r=mysql_query($sql);
			  $row=mysql_fetch_array($r);
			  $mission_id=$row[0];
			  for($i=0;$i<count($vert_list);$i++){
				  	if($vert_ids=="")
					  $vert_ids=$vert_list[$i]['id'];
					else
					  $vert_ids=$vert_ids.";".$vert_list[$i]['id'];
				}
  
		  $sql="insert into $table2(mission_id,mission_type,repeat_c,interval_i,start_time,end_time,profit,total_profit,logo_big,logo_small,vertification,profit_rest,intro_flow) values($mission_id,'$mission_type','$items[repeat_c]',$items[interval_i],'$items[start_time]','$items[end_time]','$items[profit]','$items[total_profit]','$logo[0]','$logo[1]','$vert_ids','$items[total_profit]','$items[intro_flow]')";
			  if(mysql_query($sql)){
				  	for($i=0;$i<count($vert_list);$i++){
						if($vert_sql=="")
						$vert_sql="('".$vert_list[$i]['id']."','".$vert_list[$i]['q']."','".$vert_list[$i]['a']."')";
						else
						$vert_sql=$vert_sql.",('".$vert_list[$i]['id']."','".$vert_list[$i]['q']."','".$vert_list[$i]['a']."')";
				 }

				  $sql="insert into vertification(vert_id,vertification_question,vertification_answer) values$vert_sql";
				  if(mysql_query($sql)){
					  	for($i=0;$i<count($res_list);$i++){
						if($res_sql==""){
							if($res_list[$i]['type']=="img"){
								$res_sql="($mission_id,'$mission_type','".$res_list[$i]['type']."','".$res_list[$i]['res']."',NULL,'$i')";		
							}
							else{
								$res_sql="($mission_id,'$mission_type','".$res_list[$i]['type']."',NULL,'".$res_list[$i]['res']."','$i')";	
							}
						}
						else
							if($res_list[$i]['type']=="img"){
								$res_sql=$res_sql.",($mission_id,'$mission_type','".$res_list[$i]['type']."','".$res_list[$i]['res']."',NULL,'$i')";		
							}
							else{
								$res_sql=$res_sql.",($mission_id,'$mission_type','".$res_list[$i]['type']."',NULL,'".$res_list[$i]['res']."','$i')";	
							}
						}

					  $sql="insert into resource(mission_id,mission_type,resource_type,resource_url,resource_txt,order_v) values$res_sql";
					  if(mysql_query($sql)){
					  mysql_query("COMMIT");$flag=0;
					  }else $error[]="任务添加失败01！请点击刷新按钮再提交";
				  }else $error[]="任务添加失败02！请点击刷新按钮再提交";
			  }else $error[]="任务添加失败03！请点击刷新按钮再提交";
		  }else $error[]="任务添加失败04！请点击刷新按钮再提交";
		/*数据库插入*/
	}
	else{
		if($items_empty==1){
			$error[]="请将第一步“完善任务信息”填写完整";
		}
		if(empty($logo)){
			$error[]="请在第二步“为任务添加图文”中，上传公众号/商户logo";
		}	
		if(empty($res_img_text)){
			$error[]="请在第二步“为任务添加图文”中，至少上传一个宣传用图片或宣传用文字";
		}	
			
	}	
}
else{
	$error[]="请在第三步“预览并提交”中，选择该任务所属的商户";
}
if($flag!=$_POST['flag']){
		echo "<h2 style='text-align:center;padding-top:40px'>添加成功</h2>";
		echo "<p style='text-align:center'><a href='follow.php'>继续添加</a>或<a href='client_mission_list.php'>查看已添加</a></p>";
		echo "<div style='clear:both'>&nbsp;</div>";
		exit;	
}
//print_r($items);
//print_r($logo);
}
/*if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['upload_res_txt'])){
	if ($_POST['res_txt']!="") {}
}*/
if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['upload_res_img'])){
// Check for an uploaded file:
	if (isset($_FILES['res_img_a'])) {
		
		// Validate the type. Should be JPEG or PNG.
		$allowed = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png','text/plain');
		if (in_array($_FILES['res_img_a']['type'], $allowed)) {
		$upload_res_img_msg=array();
			// Move the file over.
			$dir1='img_admin';
			$dir2='img_admin/'.$_SESSION['zdq_admin_s'];
			$pathinfo = pathinfo($_FILES['res_img_a']['name']);
			$file_dir=$dir2.'/'.time().rand(1000,9999).".".$pathinfo['extension'];
			$file_exit=0;
			if(!is_dir($dir1)){
				if(mkdir($dir1)){
					if(!is_dir($dir2)){
						if(mkdir($dir2)){$file_exit=1;}
					}
				}
			}
			else{
				if(!is_dir($dir2)){
					if(mkdir($dir2)){$file_exit=1;}
				}
				else{$file_exit=1;
				}

			}
			if($file_exit==1){		
					if (move_uploaded_file ($_FILES['res_img_a']['tmp_name'], $file_dir)) {
						$res_img_new=$file_dir;
						$upload_res_img_msg[]="文件上传成功！";
						//echo '<p><em>文件上传成功！</em></p>';
					} // End of move... IF.
			}
			else{
				$upload_res_img_msg[]="服务器端创建文件失败。";
				//echo '<p class="error">服务器端创建文件失败。</p>';
			}
		} else { // Invalid type.
		echo $_FILES['res_img_a']['type'];
			$upload_res_img_msg[]="请选择JPEG或PNG文件上传。";
			//echo '<p class="error">请选择JPEG或PNG文件上传。</p>';
		}

	} // End of isset($_FILES['upload']) IF.
	
	// Check for an error:
	if ($_FILES['res_img_a']['error'] > 0) {
		//echo '<p class="error">由于以下原因，文件无法上传: <strong>';
	
		// Print a message based upon the error.
		switch ($_FILES['res_img_a']['error']) {
			case 1:
				$upload_res_img_msg[]='The file exceeds the upload_max_filesize setting in php.ini.';
				break;
			case 2:
				$upload_res_img_msg[]='The file exceeds the MAX_FILE_SIZE setting in the HTML form.';
				break;
			case 3:
				$upload_res_img_msg[]='The file was only partially uploaded.';
				break;
			case 4:
				$upload_res_img_msg[]='No file was uploaded.';
				break;
			case 6:
				$upload_res_img_msg[]='No temporary folder was available.';
				break;
			case 7:
				$upload_res_img_msg[]='Unable to write to the disk.';
				break;
			case 8:
				$upload_res_img_msg[]='File upload stopped.';
				break;
			default:
				$upload_res_img_msg[]='A system error occurred.';
				break;
		} // End of switch.
		
		//print '</strong></p>';
	
	} // End of error IF.
	
	// Delete the file if it still exists:
	if (file_exists ($_FILES['res_img_a']['tmp_name']) && is_file($_FILES['res_img_a']['tmp_name']) ) {
		unlink ($_FILES['res_img_a']['tmp_name']);
	}
			
} // End of the submitted conditional.
?>
<?php 
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
        <p>完善任务信息</p>
      </li>
      <li>
        <p>为任务添加图文</p>
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
        <p class="nav"><a href="javascript:void(0);" id="applyBtn">下一步</a> </p>
        <!--**************************************form1*完善任务基本信息******************************************-->
        <div class="form-list form-main-list">
          <div class="form-group mission-set">
            <div class="form-item"> <span class="form-label form-label-b">完善任务信息</span> <span class="sub-title">若对填入项有疑问，可在填写后预览，或咨询客服</span> </div>
            <div class="form-item"> <span class="form-label"><span class="star">*</span>任务标题</span>
              <input autocomplete="off" class="form-text" name="items[title]" type="text" value="<?php echo $_POST['items']['title'];?>" placeholder="填写任务标题【此项提交后不可更改】">
            </div>
            <div class="form-item"> <span class="form-label"><span class="star">*</span>任务介绍/商户介绍</span>
              <textarea  class="form-text"  name="items[intro]" style="height:150px;" placeholder="封面中显示，可填入宣传文字【此项提交后不可更改】"><?php echo $_POST['items']['intro']?></textarea>
            </div>
            <div class="form-item"> <span class="form-label"><span class="star">*</span>任务开始时间</span>
              <input class="form-text" type="text" placeholder="填写任务发布时间"  id="example_1" name="items[start_time]" value="<?php if($_POST['items']['start_time']!=NULL) echo $_POST['items']['start_time']; else echo '0000-00-00 00:00:00';?>" readonly="readonly">
            </div>
            <div class="form-item"> <span class="form-label"><span class="star">*</span>任务结束时间</span>
              <input class="form-text" type="text" placeholder="填写任务结束时间"  id="example_2" name="items[end_time]" value="<?php if($_POST['items']['end_time']!=NULL) echo $_POST['items']['end_time']; else echo '0000-00-00 00:00:00';?>" readonly="readonly">
            </div>
            <div class="form-item"> <span class="form-label"><span class="star">*</span>验证问题</span>
              <textarea  class="form-text"  name="items[vert]" style="height:150px; width:380px;" placeholder="【问题与答案“++”分隔，多个问题间“==”分隔，示例如下】点击“我的”频道，该页面第二个栏目显示的是什么？++下载==点击“动态”频道，该页面第二个栏目显示的是什么？++空间"><?php echo $_POST['items']['vert']?></textarea>
            </div>
            <div class="form-item"> <span class="form-label"><span class="star">*</span>任务流程提示</span>
              <textarea  class="form-text"  name="items[intro_flow]" style="height:150px; width:380px;" placeholder="【引导用户完成任务，示例如下】 1. 领取任务； 2. 点击【执行任务】跳转到：http://XXX/app/ 3. 扫描图中二维码下载并安装XXX APP； 4. 下载成功登陆后，寻找答案； 5. 返回任务页面，点击【领取奖励】；"><?php echo $_POST['items']['intro_flow']?></textarea>
            </div>
            <div class="form-item"> <span class="form-label"><span class="star">*</span>是否可重复领取</span>否：
              <input type="radio" name="items[repeat_c]" value="0" checked="checked">
              是:
              <input type="radio" name="items[repeat_c]" value="1" <?php if($_POST['items']['repeat_c']==1) echo "checked='checked'";?>>
            </div>
            <div class="form-item"> <span class="form-label"><span class="star">*</span>重复领取间隔时间（时）</span>
              <input class="form-text" type="text" placeholder="若不可重复，此项可留空" name="items[interval_i]" value="<?php if($_POST['items']['interval_i']!=NULL) echo $_POST['items']['interval_i']; else echo '99999';?>">
            </div>
            <div class="form-item"> <span class="form-label"><span class="star">*</span>完成任务收益（元）</span>
              <input class="form-text" type="text" placeholder="填写用户完成任务，可获得的单次返利" name="items[profit]" value="<?php echo $_POST['items']['profit'];?>">
            </div>
            <div class="form-item"> <span class="form-label"><span class="star">*</span>投入总金额（元）</span>
              <input class="form-text" type="text" placeholder="奖金池耗光后任务将自动停止" name="items[total_profit]" value="<?php echo $_POST['items']['total_profit'];?>">
            </div>
          </div>
        </div>
        <p class="nav"><a href="javascript:void(0);" id="applyBtn1">下一步</a> </p>
      </div>
      <!--**************************************form1*完善任务基本信息******************************************-->
      <div class="step-list">
        <p class="nav"><a href="javascript:void(0);" id="preBtn">上一步</a> <a href="javascript:void(0);" id="submitBtn">下一步</a> </p>
        <!--**************************************form2*为任务添加图文******************************************-->
        <div class="form-list form-main-list" >
          <div class="form-group mission-res-set">
            <div class="form-item"> <span class="form-label form-label-b">为任务添加图文</span> <span class="sub-title">若对填入项有疑问，可在填写后预览，或咨询客服</span> </div>
            <div class="form-item"> <span class="form-label"><span class="star">*</span>LOGO或商标</span>
              <?php
    		
            include("cutdemo/index.php");//client logo
            //resource img
			if(empty($logo)){
				$logo=$_POST['logo'];
			}
			if(!empty($logo)){
				for($i=0;$i<count($logo);$i++)
				echo "<input type='hidden' name='logo[$i]' value='$logo[$i]'>";
			}
    ?>
            </div>
            <div class="form-item"> <span class="form-label"><span class="star">*</span>宣传用文字</span>
              <textarea  class="form-text"  name="res_text_a" style="height:150px;" placeholder="与宣传用图片一起按序号排。"></textarea>
              <p style="padding-left:200px">
                <input type="submit" name="upload_res_txt" value="添加文字" />
              </p>
            </div>
            <div class="form-item"> <span class="form-label"><span class="star">*</span>宣传用图片</span>
              <input type="hidden" name="MAX_FILE_SIZE" value="524288" />
              <p>选择不大于512KB的TXT、JPEG或PNG文件进行上传</p>
              <input type="file" name="res_img_a" />
              <input type="submit" name="upload_res_img" value="添加图片或TXT" />
              <?php
			 	echo "<p class='msg'>";
				if(!empty($upload_res_img_msg)){
             	foreach($upload_res_img_msg as $msg){
						echo "- $msg<br/>";
					}
				}
				echo "</p>";
				$res_img_text=$_POST['res_img_text'];
				if(isset($_POST['upload_res_img'])&&$res_img_new!="") $res_img_text[]=$res_img_new;
				if(isset($_POST['upload_res_txt'])&&$_POST['res_text_a']!="") $res_img_text[]=$_POST['res_text_a'];
				/*if(!empty($res_img_text)){
					for($i=0;$i<count($res_img_text);$i++)
						echo "<input type='hidden' name='res_img_text[$i]' value='$res_img_text[$i]'>";
				}*/
			 ?>
            </div>
          </div>
        </div>
        <fieldset style="width:55%; margin:0 auto;margin-left:200px; margin-bottom:20px; min-height:300px; border-color:#e7e7e7">
          <legend><span style="color: #333333;margin-top: 18px;font-weight: bold;font-size: 14px;">已添加的资源</span></legend>
          <ul>
            <h4 style="color:#F33">LOGO</h4>
            <?php if(!empty($logo)) for($i=0;$i<count($logo);$i++) echo "<li>$logo[$i]</li>";?>             
            <h4 style="color:#F33">宣传内容（图片/文字）</h4>
          </ul>
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
			 if(!empty($res_img_text)) for($i=0;$i<count($res_img_text);$i++) echo "<li id='item_$i' data-module='a'><div>".substr(htmlspecialchars($res_img_text[$i]),0,51)."…"."<input type='hidden' name='res_img_text[]' value='$res_img_text[$i]'></div></li>";
			 ?>
                                    </ul>                    
                              </section>                      
                            </div>

        </fieldset>
        <p class="nav"><a href="javascript:void(0);" id="preBtn1">上一步</a> <a href="javascript:void(0);" id="submitBtn1">下一步</a> </p>
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
            <dt class="float-left"> <img src="<?php if(empty($logo)) echo "img/default.jpeg";else echo $logo[0];?>" alt="logo图片" /> </dt>
            <dd class="float-left">
              <h5> <a href="#" style="font-size:16px;"> <?php echo htmlspecialchars($items['title']);?> </a> <span class="peo">（已有999999人参加）</span> </h5>
              <p> <?php echo htmlspecialchars($items['intro']);?> </p>
              <div class="button">
                <input type="button" value="查看任务详情"/>
                <span class="button_t">完成任务奖励</span> <span class="detail_bg"><?php echo number_format($items['profit'],2);?></span> <span class="score">元</span>
                <input type="button" value="领取任务"/>
              </div>
            </dd>
          </dl>
        </div>
        <div style=" clear:both;"></div>
        <h4 style=" padding-left:155px; padding-top:10px;"><em>任务详情页</em></h4>
        <div class="pre_container detail_top">
          <dl>
            <dt class="float-left">
              <h4> <?php echo htmlspecialchars($items['title']);?></h4>
              <h5><span class="peo">（已有999999人参加）</span> </h5>
              <p> <?php echo htmlspecialchars($items['intro']);?> </p>
              <div class="button">
                <span class="button_t">完成任务奖励</span> <span class="detail_bg"><?php echo number_format($items['profit'],2);?></span> <span class="score">元</span>
                <input type="button" value="领取任务"/>
              </div>
            
            </dt>
            <dd class="float-left">
 			<img src="<?php if(empty($logo)) echo "img/default.jpeg";else echo $logo[0];?>" alt="logo图片"/>             
            </dd>
          </dl>
        </div>
        <div class="pre_container detail_main">
        	<div class="detail_main_container">
            <?php
            	if(!empty($res_img_text)) 
				for($i=0;$i<count($res_img_text);$i++) {
					if(strstr($res_img_text[$i],"img_admin/".$_SESSION['zdq_admin_s']."/"))
					  echo "<img src='$res_img_text[$i]'  width='90%' class='imgtext'/>";
					else
					  echo "<p class='imgtext'>".htmlspecialchars($res_img_text[$i])."</p>";	
				}
			?>
            </div>
        </div>
        <div class="pre_container detail_bottom">
        	<div class="detail_bottom_container">
            <p>
            <b>任务流程提示：</b><br/>
            <?php
             echo htmlspecialchars($items['intro_flow']);
			?>
            </p>
            </div>
        </div>
        <div style=" clear:both;"></div>        
        <h4 style=" padding-left:155px; padding-top:10px;"><em>更多信息</em></h4>
        <div class="pre_container more_info" style="margin-bottom:50px;">
          <dl>
            <dt style="padding-left:50px" class="float-left">任务标题</dt>
            <dd class="float-left"><?php if($items['title']=="") echo "<em style='color:red;'>未设置</em>";else echo htmlspecialchars($items['title']);?>
            </dd>
            <dt style="padding-left:50px" class="float-left">开始时间</dt>
            <dd class="float-left"><?php if($items['start_time']=="") echo "<em style='color:red;'>未设置</em>";else echo htmlspecialchars($items['start_time']);?>
            </dd>
            <dt style="padding-left:50px" class="float-left">结束时间</dt>
            <dd class="float-left"><?php if($items['end_time']=="") echo "<em style='color:red;'>未设置</em>";else echo htmlspecialchars($items['end_time']);?>
            </dd>
            <dt style="padding-left:50px" class="float-left">验证问题</dt>
            <dd class="float-left">
			<?php 
			if($items['vert']=="") echo "<em style='color:red;'>未设置</em>";
			else{
				if(empty($vert_list)){
				  $vert=$items['vert'];//yyy++aa==yyy++aa
				  $vert_list=array();
				  $a=explode("==",$vert);
				  for($i=0;$i<count($a);$i++){
					  $b=explode("++",$a[$i]);	
					  $vert_list[]=array('id'=>time().rand(1000,9999),'q'=>$b[0],'a'=>$b[1]);
				  }

				}
				for($i=0;$i<count($vert_list);$i++)
				echo "<span style='color:red;'> Q: </span>".htmlspecialchars($vert_list[$i]['q'])."&nbsp;<span style='color:red;'>A: </span>".htmlspecialchars($vert_list[$i]['a'])."<br/>";
				 //echo htmlspecialchars($vert_list['q'])." ".htmlspecialchars($vert_list['a']);	
				 for($i=0;$i<count($vert_list);$i++){
					echo "<input type='hidden' name='vert_list[$i][id]' value='".$vert_list[$i]['id']."'/>";
					echo "<input type='hidden' name='vert_list[$i][q]' value='".$vert_list[$i]['q']."'/>";
					echo "<input type='hidden' name='vert_list[$i][a]' value='".$vert_list[$i]['a']."'/>";
				 }
            }
			?>
            </dd>
            <dt style="padding-left:50px"  class="float-left">是否可重复</dt>
            <dd class="float-left"><?php if($items['repeat_c']=="") echo "<em style='color:red;'>未设置</em>";else echo htmlspecialchars($items['repeat_c']);?>
            </dd>
            <dt style="padding-left:50px" class="float-left">重复领取时间间隔</dt>
            <dd class="float-left">（仅对可重复性任务有效）
            <?php if($items['interval_i']=="") echo "<em style='color:red;'>未设置</em>";else echo htmlspecialchars($items['interval_i']);?>
            </dd> 
            <dt style="padding-left:50px" class="float-left">完成后返利</dt>
            <dd class="float-left"><?php if($items['profit']=="") echo "<em style='color:red;'>未设置</em>";else echo htmlspecialchars($items['profit']);?>
            </dd> 
            <dt style="padding-left:50px" class="float-left">投入总金额</dt>
            <dd class="float-left"><?php if($items['total_profit']=="") echo "<em style='color:red;'>未设置</em>";else echo htmlspecialchars($items['total_profit']);?>
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
	if($_POST['client']==$row[client_id])
		echo "<option value='$row[client_id]' selected='selected'>$row[1]&nbsp;&nbsp;$row[2]</option>";
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
			<?php if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['reflash'])) echo "initStep:3"; else echo "initStep:2";?>
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
			var yes=step.goStep(2);

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
			var yes=step.goStep(2);

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
