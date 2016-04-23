<?php
header("Content-type: text/html; charset=utf-8");
$maxSize = 1024 * 1024; //1M 设置附件上传大小
$allowExts = array("gif", "jpg", "jpeg", "png"); // 设置附件上传类型
$type=$_GET['type'];
$id=$_GET['id'];
$file_save = "upload/";
$file_save_small = "../../../../uploads/$type/$id/";
include_once("UploadFile.class.php");
$upload = new UploadFile(); // 实例化上传类
$upload->maxSize = $maxSize;
$upload->allowExts = $allowExts;
$upload->savePath = $file_save; // 设置附件
$upload->saveRule = time() . sprintf('%04s', mt_rand(0, 1000));
if (!$upload->upload()) {// 上传错误提示错误信息
    $errormsg = $upload->getErrorMsg();
    $arr = array(
        'error' => $errormsg, //返回错误
    );
    //echo json_encode($arr);
	echo "上传失败，请上传jpg格式的图片，并注意图片大小";
	echo "<p align='center' style='width:100%; '><input type='button' value='返回' onclick='history.go(-1)'/></p>";
    exit;
} else {// 上传成功 获取上传文件信息
    $info = $upload->getUploadFileInfo();
    $imgurl = $info[0]['savename'];//删除该路径

    $x = $_POST['x1'];
    $y = $_POST['y1'];
    $x2 = $_POST['x2'];
    $y2 = $_POST['y2'];
    $w = $_POST['w'];
    $h = $_POST['h'];
    include_once("jcrop_image.class.php");
    //$file_save = $file_save_small;
	//判断$file_save_small是否存在
	$dir1="../../../../uploads/$type/";
	$dir2=$file_save_small;
	if(!is_dir($dir1)){
	if(mkdir($dir1)){
		if(!is_dir($dir2)){
			mkdir($dir2);
		}
	}
}
else{
	if(!is_dir($dir2)){
		mkdir($dir2);
	}
}

    $pic_name = $file_save . $imgurl;
    $crop = new jcrop_image($file_save_small, $pic_name, $x, $y, $w, $h, $w, $h);
    $file = $crop->crop();
	if(unlinkFile($pic_name)){
						//insert into sql
						require('../../../../mysql_connect.php');
						$file_dir=substr($file,6);
						$sql="select from_table from mission_type where mission_type='$type'";
						$r=mysql_query($sql);
						$row=mysql_fetch_array($r);
						$table=$row[0];
						mysql_query("START TRANSACTION");
						$sql="insert into resource(mission_id,mission_type,resource_type,resource_url,class) values($id,'$type','img','$file_dir','0')";
						if(mysql_query($sql)){
							$sql="update $table set resource_amount=resource_amount+1 where mission_type='$type' and mission_id=$id limit 1";
							if(mysql_query($sql)){
								mysql_query("COMMIT");
							}
						}
	
    echo "缩略图（刷新后才会在资源列表中显示）：<p><img src='" . $file . "'/></p>";
    echo "<p align='center' style='width:100%; '><input type='button' value='返回' onclick='history.go(-1)'/></p>";
	}
}




  /**
     * 删除文件
     *
     * @param string $aimUrl
     * @return boolean
     */
    function unlinkFile($aimUrl) {
        if (file_exists($aimUrl)) {
            unlink($aimUrl);
            return true;
        } else {
            return false;
        }
    }

?>
