<?php
if (!isset($_SESSION)) {
  session_start();
}
if($_SESSION['zdq_admin_group']!=1){
	$_SESSION['zdq_admin_s'] = NULL;
	$_SESSION['zdq_admin_group'] = NULL;
	unset($_SESSION['zdq_admin_s']);
	unset($_SESSION['zdq_admin_group']);
	$logoutGoTo = "../index.php?force=home";
    header("Location: $logoutGoTo");
    exit;

	}


?>
<?php
error_reporting(7);
date_default_timezone_set("Asia/Shanghai");
require_once("cutdemo/image.class.php");
$image = $_POST['image'];
$images = new Images("file");

?>

<?php
if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['client-form'])&&$_POST['big-pic']!=""){
		echo '<img src="'.$_POST['big-pic'].'" style="margin:10px;">';
		echo '<img src="'.$_POST['small-pic'].'" style="margin:10px;">';
		echo "<input type='hidden' name='big-pic' value='".$_POST['big-pic']."'/>";
		echo "<input type='hidden' name='small-pic' value='".$_POST['small-pic']."'/>";
		$logo[]=$_POST['big-pic'];
		$logo[]=$_POST['small-pic'];

echo "<br/>";
}
if ($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['cut'])){	
	$image = $_POST['image'];
	$res = $images->thumb($image,false,1);
	if($res == false){
		echo "裁剪失败<br/>";
	}elseif(is_array($res)){
		//$_SESSION['zdq_admin_s']
			$dir1='img_admin';
			$dir2='img_admin/'.$_SESSION['zdq_admin_s'];
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
		  $file=$res['big']; //旧目录
		  $file_sub=substr($file,10);
		  $newFile=$dir2."/".$file_sub; //新目录
		  copy($file,$newFile); //拷贝到新目录
		  unlink($file); //删除旧目录下的文件
		  $big_pic=$newFile;
		  $file=$res['small']; //旧目录
		  $file_sub=substr($file,10);
		  $newFile=$dir2."/".$file_sub; //新目录
		  copy($file,$newFile); //拷贝到新目录
		  unlink($file); //删除旧目录下的文
		  $small_pic=$newFile;			
		echo '<img src="'.$big_pic.'" style="margin:10px;">';
		echo '<img src="'.$small_pic.'" style="margin:10px;">';
		echo "<input type='hidden' name='big-pic' value='$big_pic'/>";
		echo "<input type='hidden' name='small-pic' value='$small_pic'/>";
		$logo[]=$big_pic;
		$logo[]=$small_pic;
		
		//echo "<a href='".$res['big']."' target='_blank'>大图</a>";
		//echo "/";
		//echo "<a href='".$res['small']."' target='_blank'>缩略图</a>";
		echo "裁剪成功<br/>";
		}
	}elseif(is_string($res)){
				//$_SESSION['zdq_admin_s']
			$dir1='img_admin';
			$dir2='img_admin/'.$_SESSION['zdq_admin_s'];
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

		  $file=$res; //旧目录
		  $file_sub=substr($file,10);
		  $newFile=$dir2."/".$file_sub; //新目录
		  copy($file,$newFile); //拷贝到新目录
		  unlink($file); //删除旧目录下的文			
			$pic=$newFile;
		echo '<img src="'.$pic.'">';
		echo "<input type='hidden' name='big-pic' value='$pic'/>";
		echo "<input type='hidden' name='small-pic' value='$pic'/>";
		$logo[]=$pic;
		$logo[]=$pic;

		//echo "<a href='#' target='_blank'>无大图</a>";
		//echo "/";
		//echo "<a href='".$res['small']."' target='_blank'>缩略图</a>";
		echo "裁剪成功<br/>";
		}
	}
?>
<div style="float:left;height:35px;margin:7px 5px 0 0;">
	<input type="submit" value="重新裁剪" name="recut"/>
</div>
<?php
}elseif($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['upload'])){
	
	$path = $images->move_uploaded();
	$image = $path;
	$images->thumb($path,false,0);							//文件比规定的尺寸大则生成缩略图，小则保持原样
	$upload_fail=0;
	if($path == false){
		$upload_fail=1;
		$images->get_errMsg();
	}else{
		echo "上传成功！<br/>";
		/*<a href='".$path."' target='_blank'>查看</a>";*/
	}
}
?>
  <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
  <script src="cutdemo/js/jquery.min.js" type="text/javascript"></script>
  <script src="cutdemo/js/jquery.Jcrop.js" type="text/javascript"></script>
  <link rel="stylesheet" href="cutdemo/css/jquery.Jcrop.css" type="text/css" />
<script type="text/javascript">

    jQuery(function($){

      // Create variables (in this scope) to hold the API and image size
      var jcrop_api, boundx, boundy;
      
      $('#target').Jcrop({
		minSize: [48,48],
		setSelect: [0,0,190,190],
        onChange: updatePreview,
        onSelect: updatePreview,
		onSelect: updateCoords,
        aspectRatio: 1
      },
	function(){
        // Use the API to get the real image size
        var bounds = this.getBounds();
        boundx = bounds[0];
        boundy = bounds[1];
        // Store the API in the jcrop_api variable
        jcrop_api = this;
    });
	function updateCoords(c)
	{
		$('#x').val(c.x);
		$('#y').val(c.y);
		$('#w').val(c.w);
		$('#h').val(c.h);
	};
	function checkCoords()
	{
		if (parseInt($('#w').val())) return true;
		alert('Please select a crop region then press submit.');
		return false;
	};
      function updatePreview(c){
        if (parseInt(c.w) > 0)
        {
          var rx = 48 / c.w;		//小头像预览Div的大小
          var ry = 48 / c.h;

          $('#preview').css({
            width: Math.round(rx * boundx) + 'px',
            height: Math.round(ry * boundy) + 'px',
            marginLeft: '-' + Math.round(rx * c.x) + 'px',
            marginTop: '-' + Math.round(ry * c.y) + 'px'
          });
        }
	    {
          var rx = 199 / c.w;		//大头像预览Div的大小
          var ry = 199 / c.h;
          $('#preview2').css({
            width: Math.round(rx * boundx) + 'px',
            height: Math.round(ry * boundy) + 'px',
            marginLeft: '-' + Math.round(rx * c.x) + 'px',
            marginTop: '-' + Math.round(ry * c.y) + 'px'
          });
        }
      };
    });

  </script>
 <div style="float:left; height:35px;">
		<input type="file" name="file">
        <input type="hidden" id="img" name="image" value="<?php echo $image;?>"/>
		<input type="submit" value="上传" name="upload">
</div>
<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
if($upload_fail==0)	{
	if(isset($_POST['upload'])||isset($_POST['recut'])){
?>	
	<div style="clear:both; margin-left:-80px"><img id="target" src="<?php echo $image;?>" /></div>
	<div style="width:48px;height:48px;margin:10px;overflow:hidden; float:left;"><img  style="float:left;" id="preview" src="<?php echo $image;?>" ></div>
	<div style="width:190px;height:195px;margin:10px;overflow:hidden; float:left;"><img  style="float:left;" id="preview2" src="<?php echo $image;?>" ></div>
<div style="float:left">	
    	<input type="hidden" id="x" name="x" />
		<input type="hidden" id="y" name="y" />
		<input type="hidden" id="w" name="w" />
		<input type="hidden" id="h" name="h" />
		<input type="submit" value="裁剪" name="cut" style=" margin:100px 0 0 5px"/>
</div>
<?php
	}
}
}
?>	
