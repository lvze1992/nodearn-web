![](http://121.42.169.148/img/logo_a.jpg)
nodearn - background management
=========================

将整个文件夹放置网站任意目录，导入zdq.sql即可正常运行。
* wamp(windows+apache+mysql+php)

[Home Page](http://121.42.169.148/admin/client/) | [宣传主页](http://121.42.169.148/) 

#### 此项目非私人项目，故转载，使用请告知。lvzeyst@aliyun.com

v0.4.2 (2016/04/23 22:00 +00:00) 完成阅读推广任务
------------

* 请将web中的zdq.sql替换旧的数据库。
* 发现并修改了mission.php中的错误。
* sys/read_mission.php为刷阅读推广任务列表，阅读任务图片只可能为1张或3张，请判断并选择布局。
* sys/read_mission_click.php为点击阅读链接后的跳转文件，每个咨询均有链接1和链接2（非初始链接），链接1用于app中；链接2用于转发后。
* sys/client_mission.php为刷任务列表文件。
* sys/client_mission_detail.php为刷任务详情信息文件。
* sys/mission_state.php为任务按钮或文字初始状态。
* sys/mission.php为任务按钮触发后的状态。
* sys/mission_vert.php为问题回答验证文件。
* sys/sys_mission.php为刷系统任务列表。
* client/index.php为商户管理界面。
* client_check/index.php为商户关注推广任务审核页面（发布的任务需先审核才会显示）。


v0.4.1 (2016/04/04 12:00 +00:00) 完成系统任务&商户关注推广任务
------------

* sys/client_mission.php为刷任务列表文件。
* sys/client_mission_detail.php为刷任务详情信息文件。
* sys/mission_state.php为任务按钮或文字初始状态。
* sys/mission.php为任务按钮触发后的状态。
* sys/mission_vert.php为问题回答验证文件。
* sys/sys_mission.php为刷系统任务列表。
* client/index.php为商户管理界面。
* client_check/index.php为商户关注推广任务审核页面（发布的任务需先审核才会显示）。

