<?php
$type=$_GET['type'];
$id=$_GET['id'];

?>
<form enctype="multipart/form-data" action="<?php echo "add_admin_daily.php?type=$type&id=$id";?>" method="post">

	<input type="hidden" name="MAX_FILE_SIZE" value="524288" />
	
	<fieldset><legend>【详情页】选择不大于512KB的TXT、JPEG或PNG文件进行上传:</legend>
	
	<p><b>File:</b> <input type="file" name="upload" /></p>
		<div align="center"><input type="submit" name="add-resource" value="添加资源图片或TXT" /></div>

	</fieldset>

</form>
<form enctype="multipart/form-data" action="<?php echo "add_admin_daily.php?type=$type&id=$id";?>" method="post">

	<input type="hidden" name="MAX_FILE_SIZE" value="524288" />
	
	<fieldset><legend>【封面】选择不大于512KB的JPEG文件进行上传:</legend>
	<iframe src="cut/demo2/index.php?type=<?php echo $type;?>&id=<?php echo $id;?>" width="100%" style="border:hidden" id="phpernote" onload="javascript:dyniframesize('phpernote');" scrolling="no"></iframe>
	</fieldset>

</form>
<div id="resource-list">
<ul>
<?php # Script 11.6 - images.php
/*// This script lists the images in the uploads directory.
// This version now shows each image's file size and uploaded date and time.

// Set the default timezone:
date_default_timezone_set ('America/New_York');

$dir = '../../uploads/'.$type.'/'.$id; // Define the directory to view.

if(@$files = scandir($dir)){ // Read all the images into an array.
	$m=0;

// Display each image caption as a link to the JavaScript function:
foreach ($files as $image) {

	if (substr($image, 0, 1) != '.') { // Ignore anything starting with a period.
		// Get the image's size in pixels:
		$image_size = getimagesize ("$dir/$image");
		if($image_size[0]==""){
		$image_size=array("500","500");
		}
		// Calculate the image's size in kilobytes:
		$file_size = round ( (filesize ("$dir/$image")) / 1024) . "kb";
		
		// Determine the image's upload date and time:
		$image_date = date("F d, Y H:i:s", filemtime("$dir/$image"));
		
		// Make the image's name URL-safe:
		$image_name = urlencode($image);
		// Print the information:
		echo "<li><a href=\"javascript:create_window('$image_name',$image_size[0],$image_size[1],'$type',$id)\">$image</a> $file_size ($image_date)";
		require('../../mysql_connect.php');
	    $file="../../uploads/$type/$id/$image_name";
		$sql="select class,order_v from resource where resource_url='$file'";
		$r=mysql_query($sql);
		$row=mysql_fetch_array($r);
		?>

		<select onchange="changeROC(this.name,<?php echo $m;?>,<?php echo $type;?>,<?php echo $id;?>)" name="class_<?php echo $image_name;?>" id="class_<?php echo $image_name;?>">
		<?php
		for($i=1;$i<11;$i++){
			if($i==$row[0])
				echo "<option value='$i' selected='selected'>$i</option>";
			else
				echo "<option value='$i'>$i</option>";			
		}
		?>
		</select> >> 
		<select onchange="changeROC(this.name,<?php echo $m;?>,<?php echo $type;?>,<?php echo $id;?>)" name="order_<?php echo $image_name;?>" id="order_<?php echo $image_name;?>">
		<?php
		for($i=0;$i<20;$i++){
			if($i==$row[1])
				echo "<option value='$i' selected='selected'>$i</option>";
			else
				echo "<option value='$i'>$i</option>";			
		}

		?>
		</select>
		<span id="span_<?php echo $m;?>"></span> 
		<?php
		echo "<a href='javascript:changeROC(\"$image_name\",$m,$type,$id,1)'><img src='icon/delete.png'/></a></li>\n";
		$m=$m+1;
	} // End of the IF.
    
} // End of the foreach loop.
}//End of the if dir exist
else{
echo "<em>该任务没有资源文件！</em>";
}
*/
require('../../mysql_connect.php');
$m=0;
$sql="select class,order_v,resource_url,resource_id from resource where mission_type='$type' and mission_id=$id order by class,order_v DESC";
$r=mysql_query($sql);
if(@mysql_num_rows($r)!=0){
	while($row=mysql_fetch_array($r)){
	$image_name = substr(urlencode($row[2]),18);
	$image=substr($row[2],18);
	echo "<li><a href=\"javascript:create_window('$image',500,800,'$type',$id)\"  style='display:inline-block;width:150px;height:25px;'>$image</a>";

?>

<select onchange="changeROC(this.name,<?php echo $m;?>,<?php echo $type;?>,<?php echo $id;?>)" name="class_<?php echo $row[3];?>" id="class_<?php echo $row[3];?>">		<?php
		for($i=0;$i<11;$i++){
			if($i==$row[0])
				echo "<option value='$i' selected='selected'>$i</option>";
			else
				echo "<option value='$i'>$i</option>";			
		}
		?>
		</select> >> 
		<select onchange="changeROC(this.name,<?php echo $m;?>,<?php echo $type;?>,<?php echo $id;?>)" name="order_<?php echo $row[3];?>" id="order_<?php echo $row[3];?>">
		<?php
		for($i=0;$i<20;$i++){
			if($i==$row[1])
				echo "<option value='$i' selected='selected'>$i</option>";
			else
				echo "<option value='$i'>$i</option>";			
		}

		?>
		</select>
		<span id="span_<?php echo $m;?>"></span> 
		<?php
		echo "<a href='javascript:changeROC($row[3],$m,$type,$id,1)'><img src='icon/delete.png'/></a></li>\n";

	$m=$m+1;		
	}
}
else{
echo "<em>该任务没有资源文件！</em>";
}

?>
</ul>
</div>