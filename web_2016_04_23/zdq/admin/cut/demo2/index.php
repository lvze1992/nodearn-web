<?php
$type=$_GET['type'];
$id=$_GET['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
        <link href="css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />
        <style>
            .error {
                font-size: 18px;
                font-weight: bold;
                color: red;
                margin:10px 0
            }
            label{width:60px;display: inline-block}
            .info li{margin:10px 0}
            
        </style>
    </head>
    <body>
        <div class="container">
            <div class="demo">
                <form id="upload_form" enctype="multipart/form-data" method="post" action="upload.php?type=<?php echo $type;?>&id=<?php echo $id;?>" onsubmit="return checkForm()">
                    <!-- hidden crop params -->
                    <input type="hidden" id="x1" name="x1"autocomplete="off" />
                    <input type="hidden" id="y1" name="y1" autocomplete="off"/>
                    <input type="hidden" id="x2" name="x2"autocomplete="off" />
                    <input type="hidden" id="y2" name="y2"autocomplete="off" />


                    <input type="file" name="image_file" id="image_file" onchange="fileSelectHandler()" />

                    <div class="error">注意：请上传指定大小的图片：300*60像素。不满足要求的图片会被自动剪切。</div>
                    <div class="step2">
						<!--

                        <img id="preview" />
                            <div class="info">
                            <ul>
                                <li><label>文件大小</label> <input type="text" id="filesize" name="filesize" class="input" autocomplete="off" /></li>
                                <li><label>类型</label> <input type="text" id="filetype" name="filetype" class="input"autocomplete="off"/></li>
                                <li><label>图像尺寸</label> <input type="text" id="filedim" name="filedim" class="input"autocomplete="off"/></li>
                                <li><label>宽度</label> <input type="text" id="w" name="w" class="input"autocomplete="off"/></li>
                                <li><label>高度</label> <input type="text" id="h" name="h" class="input"autocomplete="off"/></li>
                            </ul>
                        </div>
						-->
						 <input  type="hidden" id="w" name="w" class="input"autocomplete="off" value="300px"/>
						  <input type="hidden" id="h" name="h" class="input"autocomplete="off" value="60px"/>
                        <div style="width:100%; text-align:center"><input type="submit" value="添加封面图片" class="btn"/></div>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript" src="../../js/jquery.min.js"></script> 
        <script src="js/jquery.Jcrop.min.js"></script>
        <script src="js/script.js"></script>
    </body>
</html>
