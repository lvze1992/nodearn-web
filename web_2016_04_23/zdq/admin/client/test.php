<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<?php
			$dir1='img_admin';
			$dir2='img_admin/2/4';
			$file_exit=0;
				if(!is_dir($dir2)){
					if(mkdir($dir2)){$file_exit=1;}
				}
				else{$file_exit=1;
				}

?>
<body>
</body>
</html>