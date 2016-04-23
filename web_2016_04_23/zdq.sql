-- phpMyAdmin SQL Dump
-- version 2.11.2.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 04 月 23 日 10:34
-- 服务器版本: 5.0.45
-- PHP 版本: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 数据库: `zdq`
--

-- --------------------------------------------------------

--
-- 表的结构 `about_us`
--

CREATE TABLE `about_us` (
  `alipay` varchar(30) character set utf8 collate utf8_bin default NULL,
  `telephone` varchar(20) default NULL,
  `address` varchar(300) character set utf8 collate utf8_bin default NULL,
  `QQ` varchar(30) default NULL,
  `email` varchar(30) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 导出表中的数据 `about_us`
--

INSERT INTO `about_us` (`alipay`, `telephone`, `address`, `QQ`, `email`) VALUES
('1111111', '1234567890', '中国海洋大学', '987542790', '123123123@qq.com');

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(4) NOT NULL auto_increment,
  `username` varchar(20) NOT NULL,
  `userpass` varchar(40) NOT NULL,
  `first_name` varchar(15) character set utf8 collate utf8_bin default NULL,
  `last_name` varchar(15) character set utf8 collate utf8_bin default NULL,
  `telephone` varchar(20) default NULL,
  `last_logintime` datetime NOT NULL,
  `this_logintime` datetime NOT NULL,
  `fail_times` int(4) NOT NULL default '0' COMMENT '失败次数',
  `admin_type` varchar(2) NOT NULL default '1' COMMENT '暂只留一个类型',
  `reg_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `account` decimal(15,2) NOT NULL default '0.00',
  `id_number` varchar(18) default NULL COMMENT '身份证号',
  PRIMARY KEY  (`admin_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `id_number` (`id_number`),
  UNIQUE KEY `telephone` (`telephone`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- 导出表中的数据 `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `userpass`, `first_name`, `last_name`, `telephone`, `last_logintime`, `this_logintime`, `fail_times`, `admin_type`, `reg_time`, `account`, `id_number`) VALUES
(1, 'lvze', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '泽', '吕', '18354225380', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0', '0000-00-00 00:00:00', 0.00, ''),
(2, 'lvze1', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '明', '王', '123421000', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '1', '0000-00-00 00:00:00', 0.00, '1'),
(3, 'lvze1992', '20eabe5d64b0e216796e834f52d61fd0b70332fc', '小赚', '李', '12345678901', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '1', '0000-00-00 00:00:00', 6000.00, '776766655432134567'),
(4, 'lvze1888', '20eabe5d64b0e216796e834f52d61fd0b70332fc', '', '', '12345678900', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '1', '0000-00-00 00:00:00', 0.00, '5'),
(5, 'wwwwqqqq', '20eabe5d64b0e216796e834f52d61fd0b70332fc', '', '', '23232323232', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '1', '2016-03-12 10:47:38', 0.00, '0'),
(6, 'lvze1111', 'e7868a796996a718c4d5d76a7c4de727e546ccf2', NULL, NULL, '11113223221', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '1', '2016-03-27 12:22:41', 0.00, NULL),
(7, 'lb123456', '9e652b397e85cf577661ecdce13ab7da53992390', NULL, NULL, '23456778765', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '1', '2016-03-27 12:26:13', 0.00, NULL),
(8, 'pl123456', 'd050858356442b544f72242c8447ad435e8d5ffb', NULL, NULL, '67654332123', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '1', '2016-03-27 12:32:47', 0.00, NULL),
(9, 'lvze1113', 'e7868a796996a718c4d5d76a7c4de727e546ccf2', '海', '刘', '11111111111', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '1', '2016-03-27 12:35:56', 0.00, '229835511423425162'),
(10, 'lvze2222', '63684783eb4ce9977515265f8597fefb8a4cc11e', NULL, NULL, '11111111112', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '1', '2016-03-27 12:45:40', 0.00, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `admin_mission`
--

CREATE TABLE `admin_mission` (
  `mission_id` int(4) NOT NULL auto_increment,
  `ad_mission_title` varchar(300) character set utf8 collate utf8_bin NOT NULL,
  `ad_mission_intro` varchar(600) character set utf8 collate utf8_bin NOT NULL,
  `admin_id` int(4) NOT NULL,
  `mission_type` varchar(4) NOT NULL,
  `add_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `order_v` varchar(3) NOT NULL default '0' COMMENT '同类任务，权重大，靠前',
  PRIMARY KEY  (`mission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- 导出表中的数据 `admin_mission`
--

INSERT INTO `admin_mission` (`mission_id`, `ad_mission_title`, `ad_mission_intro`, `admin_id`, `mission_type`, `add_time`, `order_v`) VALUES
(1, '签到领奖励', '每天坚持签到。点小赚会给你包小红包哦', 1, '2', '2016-02-01 20:34:01', '999'),
(2, '新年新气象', '过年点小赚给大家发红包啦', 1, '2', '2016-02-01 20:42:54', '998'),
(3, '无领取间隔任务', '可重复领取，领取间隔时间为0', 1, '2', '2016-02-13 23:11:09', '22'),
(4, '有领取间隔任务', '可重复领取，时间间隔为1H', 1, '2', '2016-02-13 23:13:37', '23'),
(5, '34', '34', 1, '2', '2016-03-15 23:03:08', '4');

-- --------------------------------------------------------

--
-- 表的结构 `admin_mission_beginer`
--

CREATE TABLE `admin_mission_beginer` (
  `ad_mission_beginer_id` int(4) NOT NULL auto_increment,
  `mission_id` int(4) NOT NULL,
  `mission_type` varchar(4) NOT NULL,
  `repeat_c` char(1) NOT NULL default '0' COMMENT '0不可重复1可重复',
  `interval_i` int(4) NOT NULL default '99999',
  `profit` decimal(5,2) NOT NULL COMMENT '一次返利',
  `total_profit` decimal(10,2) NOT NULL COMMENT '返利池总金额',
  `profit_rest` decimal(10,2) NOT NULL COMMENT '返利池余额',
  `state` char(1) NOT NULL default '0' COMMENT '是否可用，1可用，0不可用，2活动维护中',
  `resource_amount` int(4) NOT NULL default '0' COMMENT 'limit查resource表。避免遍历',
  `vertification` varchar(1000) default NULL,
  PRIMARY KEY  (`ad_mission_beginer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `admin_mission_beginer`
--


-- --------------------------------------------------------

--
-- 表的结构 `admin_mission_daily`
--

CREATE TABLE `admin_mission_daily` (
  `ad_mission_daily_id` int(4) NOT NULL auto_increment,
  `mission_id` int(4) NOT NULL,
  `mission_type` varchar(4) NOT NULL,
  `repeat_c` char(1) NOT NULL default '0' COMMENT '0不可重复领取1可重复领取',
  `interval_i` int(4) NOT NULL default '99999',
  `start_time` datetime default NULL,
  `end_time` datetime default NULL,
  `profit` decimal(5,2) NOT NULL,
  `total_profit` decimal(10,2) NOT NULL,
  `profit_rest` decimal(10,2) NOT NULL,
  `state` char(1) NOT NULL default '0' COMMENT '0不可用1可用2任务维护中',
  `resource_amount` int(4) NOT NULL default '0',
  `vertification` varchar(1000) default NULL,
  `join_n` int(4) NOT NULL default '0' COMMENT '多少人参与这个活动，多少人点击领取，重复领取也加1',
  PRIMARY KEY  (`ad_mission_daily_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- 导出表中的数据 `admin_mission_daily`
--

INSERT INTO `admin_mission_daily` (`ad_mission_daily_id`, `mission_id`, `mission_type`, `repeat_c`, `interval_i`, `start_time`, `end_time`, `profit`, `total_profit`, `profit_rest`, `state`, `resource_amount`, `vertification`, `join_n`) VALUES
(1, 1, '2', '1', 23, '2016-03-03 00:00:00', '2016-05-11 00:00:00', 0.20, 10000.00, 83.80, '1', 2, NULL, 1),
(2, 2, '2', '0', 23, '2016-02-03 00:00:00', '2016-02-13 00:00:00', 5.00, 10000.00, 9995.00, '1', 2, NULL, 0),
(3, 3, '2', '1', 0, '2016-06-13 23:10:00', '2016-06-29 00:00:00', 2.00, 20000.00, 19998.00, '1', 1, NULL, 0),
(4, 4, '2', '1', 1, '2016-02-13 23:13:00', '2016-05-29 00:00:00', 2.00, 10000.00, 9996.00, '1', 1, NULL, 0),
(5, 5, '2', '0', 34, '2016-03-01 00:00:00', '2016-02-15 00:00:00', 1.00, 3534535.00, 3534535.00, '0', 0, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `admin_mission_invite`
--

CREATE TABLE `admin_mission_invite` (
  `ad_mission_invite_id` int(4) NOT NULL auto_increment,
  `mission_id` int(4) NOT NULL,
  `mission_type` varchar(4) NOT NULL,
  `repeat_c` char(1) NOT NULL default '0' COMMENT '0不可重复1可重复',
  `interval_i` int(4) NOT NULL default '99999' COMMENT '2次任务时间间隔',
  `profit` decimal(5,2) NOT NULL,
  `total_profit` decimal(10,2) NOT NULL,
  `profit_rest` decimal(10,2) NOT NULL,
  `number_invited` int(4) NOT NULL COMMENT '邀请人数与返利的梯度变化，该人数以下使用该任务',
  `state` char(1) NOT NULL default '0' COMMENT '0不可用1可用2任务维护中',
  `resource_amount` int(4) NOT NULL default '0' COMMENT 'limit 避免遍历',
  `vertification` varchar(1000) default NULL,
  PRIMARY KEY  (`ad_mission_invite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `admin_mission_invite`
--


-- --------------------------------------------------------

--
-- 表的结构 `client`
--

CREATE TABLE `client` (
  `client_id` int(4) NOT NULL auto_increment,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `userpass` varchar(40) NOT NULL COMMENT '密码',
  `first_name` varchar(30) character set utf8 collate utf8_bin NOT NULL COMMENT '名字',
  `last_name` varchar(30) character set utf8 collate utf8_bin NOT NULL COMMENT '姓',
  `company` varchar(60) character set utf8 collate utf8_bin NOT NULL COMMENT '公司',
  `address` varchar(300) character set utf8 collate utf8_bin NOT NULL COMMENT '地址',
  `email` varchar(30) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `alipay` varchar(30) character set utf8 collate utf8_bin NOT NULL COMMENT '支付宝帐号',
  `last_logintime` datetime NOT NULL,
  `this_logintime` datetime NOT NULL,
  `fail_times` int(4) NOT NULL default '0',
  `client_type` varchar(2) NOT NULL default '0',
  `reg_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `admin_id` int(4) default NULL,
  `intro` varchar(300) character set utf8 collate utf8_bin NOT NULL,
  `address_charge` varchar(300) character set utf8 collate utf8_bin NOT NULL,
  `logo_big` varchar(50) NOT NULL,
  `logo_small` varchar(50) NOT NULL,
  PRIMARY KEY  (`client_id`),
  UNIQUE KEY `company` (`company`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- 导出表中的数据 `client`
--

INSERT INTO `client` (`client_id`, `username`, `userpass`, `first_name`, `last_name`, `company`, `address`, `email`, `telephone`, `alipay`, `last_logintime`, `this_logintime`, `fail_times`, `client_type`, `reg_time`, `admin_id`, `intro`, `address_charge`, `logo_big`, `logo_small`) VALUES
(2, 'user2', 'b3daa77b4c04a9551b8781d03191fe098f325e67', '明卅', '刘', '大众传媒有限公司', '上海市塘坊街235号', '7878723223@126.com', '12389314', 'lvsda2324', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0', '0000-00-00 00:00:00', 0, '', '', '', ''),
(3, 'user1', 'b3daa77b4c04a9551b8781d03191fe098f325e67', '刘浩', '曹', '义气发财传媒有限公司', '上海市塘坊街225号', '787872321@126.com', '1238004', 'lvsda232', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0', '0000-00-00 00:00:00', 0, '', '', '', ''),
(4, '', '', '已', '刘', '海大', 'ouc789', 'wqe@173.com', '12233326728', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0', '2016-03-14 00:38:10', NULL, '??????', '??????', './uploads/20160314003650571001.jpeg', './uploads/20160314003650571002.jpeg'),
(5, '', '', '浩', '王', '武大郎烧饼', 'wda122', '213@qq.com', '16543467890', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0', '2016-03-14 01:42:37', NULL, '武大郎烧饼海大', '中国海洋大学', './uploads/20160314012556514601.jpeg', './uploads/20160314012556514602.jpeg'),
(6, '', '', '请问', '企鹅', '请问', '蔷薇蔷薇', '8@qq.com', '17654332890', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0', '2016-03-14 01:50:59', NULL, '我去额前委曲', 'qweqwqweq', './uploads/201603140150369168001.gif', './uploads/201603140150369168002.gif'),
(7, '', '', '色的', '绿', '90', '?/|\\\\\\\\ioin ()*^——_', '187654445422@qq.com', '17654333425', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0', '2016-03-15 00:10:26', 3, '?/|\\\\\\\\ioin ()*^——_', 'adasda?/|\\ioin ()*^——_', './uploads/201603150009583017001.gif', './uploads/201603150009583017002.gif'),
(8, '', '', '>.?/|jo', '>.?/|', '$items[$i]', '<p style=\\\\\\\\啊是大是大打双打\\\\\\啊是大是大打双打\\\\\\啊是大是大打双打\\\\\\啊是大是大打双打\\\\\\啊是大是大打双打\\\\\\啊是大是大打双打\\\\\\啊是大是大打双打\\\\\\啊是大是大打双打', '4@qq.com', '67655555543', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0', '2016-03-15 00:16:44', 3, '>.?/|join insert update new_-=+*)!~', '>.?/|join insert update new_-=+*)!~', './uploads/20160315001608701701.jpeg', './uploads/20160315001608701702.jpeg'),
(9, '', '', '发生的', 'ni 3', 'n你00', '<b>d</b>', 'df@aa.com', '77777777778', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0', '2016-03-15 00:20:51', 3, 'sdfsfsdfsdfsdf', 'sdfsfs;;;;;;;;\\\\|\\''\\''\\"\\"', './uploads/20160315002008323901.jpeg', './uploads/20160315002008323902.jpeg'),
(10, '', '', '一', '刘', '中国海洋大学', 'ouc1999', '898989@qq.com', '17654333456', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0', '2016-03-22 17:33:32', 3, '中国海洋大学', '中国海洋大学崂山校区', 'img_admin/3/20160322173143382201.jpeg', 'img_admin/3/20160322173143382202.jpeg'),
(11, '', '', '龙虾', '小', '北龙口农家菜馆', '北龙口233号', '89898989@qq.com', '78766665432', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0', '2016-03-30 22:14:06', 9, '北龙口农家菜馆，您值得多光顾几次的农家菜馆', '北龙口233号', 'img_admin/9/20160330221330416501.jpeg', 'img_admin/9/20160330221330416502.jpeg'),
(12, '', '', '依依', '杨', '我家牛肉丸', '松岭路239号', '787878787@qq.com', '67666555432', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0', '2016-04-03 20:19:48', 3, '我家牛肉丸。吃出大家味。关注得红包活动进行中', '松岭路239号', 'img_admin/3/20160403201900202801.jpeg', 'img_admin/3/20160403201900202802.jpeg');

-- --------------------------------------------------------

--
-- 表的结构 `client_mission`
--

CREATE TABLE `client_mission` (
  `mission_id` int(4) NOT NULL auto_increment,
  `client_mission_title` varchar(300) character set utf8 collate utf8_bin NOT NULL,
  `client_mission_intro` varchar(600) character set utf8 collate utf8_bin NOT NULL,
  `client_id` int(4) NOT NULL COMMENT '用户id',
  `mission_type` varchar(4) NOT NULL COMMENT '任务类型',
  `add_time` timestamp NOT NULL default CURRENT_TIMESTAMP COMMENT '添加时间',
  `order_v` varchar(3) NOT NULL default '0' COMMENT '同类任务，权重大，靠前',
  PRIMARY KEY  (`mission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- 导出表中的数据 `client_mission`
--

INSERT INTO `client_mission` (`mission_id`, `client_mission_title`, `client_mission_intro`, `client_id`, `mission_type`, `add_time`, `order_v`) VALUES
(2, '中国海洋大学第一食堂', '开业大酬宾，现场可现金支付，现在关注还有红包相送', 7, '13', '2016-03-22 17:05:17', '0'),
(7, '中国海洋大学第二食堂', '开业大酬宾，现场可现金支付，现在关注还有红包相送', 7, '13', '2016-03-22 17:27:35', '0'),
(9, '中国海洋大学第三食堂', '开业大酬宾，现场可现金支付，现在关注还有红包相送', 7, '13', '2016-03-22 17:30:09', '0'),
(10, '北龙口餐馆大酬宾', '北龙口新店面开张，现在关注我们既有机会领取专属红包哦', 10, '13', '2016-03-22 22:52:41', '0'),
(13, '南小区餐馆大酬宾', '南龙口新店面开张，现在关注我们既有机会领取专属红包哦', 10, '13', '2016-03-22 22:58:50', '0'),
(14, '', '', 9, '13', '2016-03-27 23:33:22', '0'),
(15, '就不告诉你这是什么任务', '你猜你猜你猜猜。。关注微信公众号9090找到答案，领取红包', 9, '13', '2016-03-28 00:12:15', '0'),
(16, '北龙口农家菜馆开张啦', '现在关注“北龙口农家菜馆”微信公众号，回答任务问题，即可领取红包哦。', 11, '13', '2016-03-30 22:15:09', '0'),
(17, '我家牛肉丸，关注得红包', '我家牛肉丸是你家门口的牛肉丸店，挑选精致牛肉，为你手工制作，绝对质量保证，绝不用假肉次肉代替', 12, '13', '2016-04-03 20:26:52', '0'),
(18, '测试页面', 'read_mission', 11, '15', '2016-04-21 22:03:19', '0'),
(19, '测试页面2', 'read_mission', 11, '15', '2016-04-21 22:06:11', '0'),
(20, '测试页面3', 'read_mission', 11, '15', '2016-04-23 17:19:01', '0'),
(21, '北龙口 小龙虾菜谱', 'read_mission', 11, '15', '2016-04-23 17:34:13', '0');

-- --------------------------------------------------------

--
-- 表的结构 `client_mission_app`
--

CREATE TABLE `client_mission_app` (
  `client_mission_app_id` int(4) NOT NULL auto_increment,
  `mission_id` int(4) NOT NULL,
  `mission_type` varchar(4) NOT NULL,
  `repeat_c` char(1) NOT NULL default '0' COMMENT '是否可重复领取任务',
  `interval_i` int(4) NOT NULL default '99999' COMMENT '小时。两次任务间的时间间隔',
  `profit` decimal(5,2) NOT NULL,
  `total_profit` decimal(10,2) NOT NULL,
  `profit_rest` decimal(10,2) NOT NULL,
  `vertification` varchar(1000) default NULL COMMENT 'app+client_mission_id',
  `state` char(1) NOT NULL default '0' COMMENT '0不可用1可用2任务维护中',
  `download_url` varchar(1000) character set utf8 collate utf8_bin NOT NULL,
  `app_small_pic` varchar(1000) character set utf8 collate utf8_bin NOT NULL,
  `install_times` int(4) NOT NULL default '0' COMMENT '完成了任务，即安装了app的人数',
  `download_times` int(4) NOT NULL default '0' COMMENT '有下载操作的人',
  `click_times` int(4) NOT NULL default '0' COMMENT '任务被点击的次数',
  `resource_amount` int(4) NOT NULL default '0',
  PRIMARY KEY  (`client_mission_app_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `client_mission_app`
--


-- --------------------------------------------------------

--
-- 表的结构 `client_mission_daily`
--

CREATE TABLE `client_mission_daily` (
  `client_mission_daily_id` int(4) NOT NULL auto_increment COMMENT '用于保证用户的关注或使用app的状态',
  `mission_id` int(4) NOT NULL,
  `mission_type` varchar(4) NOT NULL,
  `repeat_c` char(1) NOT NULL default '0' COMMENT '1可重复 0不可重复 ',
  `interval_i` int(4) NOT NULL default '99999' COMMENT '小时。2次领取任务的时间',
  `interval2` int(4) NOT NULL default '15' COMMENT '秒。几秒后显示红包验证信息',
  `start_time` datetime NOT NULL COMMENT '特殊日期开始',
  `end_time` datetime NOT NULL COMMENT '特殊日期结束',
  `profit` decimal(5,2) NOT NULL,
  `total_profit` decimal(10,2) NOT NULL,
  `profit_rest` decimal(10,2) NOT NULL,
  `vertification` varchar(1000) default NULL COMMENT 'daily+client_mission_id',
  `state` char(1) NOT NULL default '0' COMMENT '0不可用 1可用 2任务维护中',
  `read_time` int(4) NOT NULL default '0' COMMENT '秒。该页面停留时间的总和',
  `done_times` int(4) NOT NULL default '0' COMMENT '完成任务的人数',
  `click_times` int(4) NOT NULL default '0' COMMENT '该任务被点击的次数',
  `resource_amount` int(4) NOT NULL default '0',
  PRIMARY KEY  (`client_mission_daily_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `client_mission_daily`
--


-- --------------------------------------------------------

--
-- 表的结构 `client_mission_read`
--

CREATE TABLE `client_mission_read` (
  `client_mission_read_id` int(4) NOT NULL auto_increment,
  `mission_id` int(4) NOT NULL,
  `mission_type` varchar(4) NOT NULL,
  `profit` decimal(5,2) NOT NULL default '0.00',
  `r_profit` decimal(5,2) NOT NULL default '0.00',
  `profit_limit` decimal(5,2) NOT NULL default '0.00',
  `total_profit` decimal(10,2) NOT NULL default '0.00',
  `profit_rest` decimal(10,2) NOT NULL default '0.00',
  `article_url` varchar(1000) NOT NULL,
  `article_url_id` int(4) NOT NULL,
  `state` char(1) NOT NULL default '0',
  `join_n` int(4) NOT NULL default '0',
  `r_join_n` int(4) NOT NULL default '0' COMMENT '转发后的点击量',
  `pic1` varchar(1000) NOT NULL,
  `pic2` varchar(1000) NOT NULL,
  `pic3` varchar(1000) NOT NULL,
  `pic1_big` varchar(1000) NOT NULL,
  `pic2_big` varchar(1000) NOT NULL,
  `pic3_big` varchar(1000) NOT NULL,
  PRIMARY KEY  (`client_mission_read_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- 导出表中的数据 `client_mission_read`
--

INSERT INTO `client_mission_read` (`client_mission_read_id`, `mission_id`, `mission_type`, `profit`, `r_profit`, `profit_limit`, `total_profit`, `profit_rest`, `article_url`, `article_url_id`, `state`, `join_n`, `r_join_n`, `pic1`, `pic2`, `pic3`, `pic1_big`, `pic2_big`, `pic3_big`) VALUES
(1, 18, '15', 0.05, 0.01, 0.00, 1000.00, 99.95, 'http://www.baidu.com', 73996666, '1', 10, 1, 'img_admin/9/201604212202588012001.gif', '', '', 'img_admin/9/201604212202588012002.gif', '', ''),
(2, 19, '15', 0.05, 0.01, 0.00, 2000.00, 2000.00, 'https://www.sogou.com', 75717751, '3', 0, 0, 'img_admin/9/201604212205234662002.gif', 'img_admin/9/20160421220543533702.jpeg', 'img_admin/9/20160421220554953702.jpeg', 'img_admin/9/201604212205234662001.gif', 'img_admin/9/20160421220543533701.jpeg', 'img_admin/9/20160421220554953701.jpeg'),
(3, 20, '15', 0.05, 0.01, 0.00, 1000.00, 999.95, 'http://www.baidu.com', 31416551, '1', 2, 0, 'img_admin/9/20160423171815515202.jpeg', 'img_admin/9/201604231718303114002.gif', 'img_admin/9/20160423171841466802.jpeg', 'img_admin/9/20160423171815515201.jpeg', 'img_admin/9/201604231718303114001.gif', 'img_admin/9/20160423171841466801.jpeg'),
(4, 21, '15', 0.05, 0.01, 5.00, 200.00, 199.88, 'http://www.baidu.com', 40535164, '1', 3, 2, 'img_admin/9/20160423173359277002.jpeg', '', '', 'img_admin/9/20160423173359277001.jpeg', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `client_mission_tb`
--

CREATE TABLE `client_mission_tb` (
  `client_mission_tb_id` int(4) NOT NULL auto_increment,
  `mission_id` int(4) NOT NULL COMMENT '外键连client_mission',
  `mission_type` varchar(4) NOT NULL COMMENT '任务类型',
  `repeat_c` char(1) NOT NULL default '0' COMMENT '是否可以重复领取',
  `interval_i` int(4) NOT NULL default '99999' COMMENT '重复领取的间隔',
  `profit` decimal(5,2) NOT NULL COMMENT '一次的返利',
  `total_profit` decimal(10,2) NOT NULL COMMENT '总返利',
  `profit_rest` decimal(10,2) NOT NULL COMMENT '返利池余额',
  `vertification` varchar(1000) default NULL COMMENT '验证问题标示tb+clien_mission_id',
  `state` char(1) NOT NULL default '0' COMMENT '0不可用 1可用 2 维护中',
  `read_time` int(4) NOT NULL default '0' COMMENT '页面停留总时间',
  `done_times` int(4) NOT NULL default '0' COMMENT '完成任务的人数',
  `click_times` int(4) NOT NULL default '0' COMMENT '任务被点击的次数',
  `resource_amount` int(4) NOT NULL default '0',
  PRIMARY KEY  (`client_mission_tb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `client_mission_tb`
--


-- --------------------------------------------------------

--
-- 表的结构 `client_mission_wetalk`
--

CREATE TABLE `client_mission_wetalk` (
  `client_mission_wetalk_id` int(4) NOT NULL auto_increment,
  `mission_id` int(4) NOT NULL,
  `mission_type` varchar(4) NOT NULL,
  `repeat_c` char(1) NOT NULL default '0',
  `interval_i` int(4) NOT NULL default '99999',
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `profit` decimal(5,2) NOT NULL,
  `total_profit` decimal(10,2) NOT NULL,
  `profit_rest` decimal(10,2) NOT NULL,
  `vertification` varchar(1400) default NULL COMMENT 'wt+client_mission_id',
  `state` char(1) NOT NULL default '0',
  `join_n` int(4) NOT NULL default '0' COMMENT '领取任务即加1',
  `done_times` int(4) NOT NULL default '0',
  `click_times` int(4) NOT NULL default '0',
  `resource_amount` int(4) NOT NULL default '0',
  `logo_big` varchar(50) NOT NULL,
  `logo_small` varchar(50) NOT NULL,
  `intro_flow` varchar(600) character set utf8 collate utf8_bin NOT NULL,
  PRIMARY KEY  (`client_mission_wetalk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- 导出表中的数据 `client_mission_wetalk`
--

INSERT INTO `client_mission_wetalk` (`client_mission_wetalk_id`, `mission_id`, `mission_type`, `repeat_c`, `interval_i`, `start_time`, `end_time`, `profit`, `total_profit`, `profit_rest`, `vertification`, `state`, `join_n`, `done_times`, `click_times`, `resource_amount`, `logo_big`, `logo_small`, `intro_flow`) VALUES
(1, 2, '13', '0', 99999, '2016-03-31 00:00:00', '2016-04-29 00:00:00', 2.00, 2000.00, 0.00, NULL, '3', 0, 0, 0, 0, 'img_admin/3/20160322164958931801.jpeg', 'img_admin/3/20160322164958931802.jpeg', ''),
(6, 7, '13', '0', 99999, '2016-03-22 00:00:00', '2016-04-29 00:00:00', 2.00, 2000.00, 0.00, '', '0', 0, 0, 0, 0, 'img_admin/3/20160322164958931801.jpeg', 'img_admin/3/20160322164958931802.jpeg', ''),
(8, 9, '13', '0', 99999, '2016-03-22 00:00:00', '2016-03-29 00:00:00', 2.00, 2000.00, 0.00, '14586390047774;14586390043428;14586390045458;14586390047715', '0', 0, 0, 0, 0, 'img_admin/3/20160322164958931801.jpeg', 'img_admin/3/20160322164958931802.jpeg', ''),
(9, 10, '13', '0', 99999, '2016-03-22 22:47:00', '2016-03-29 08:00:00', 1.00, 1000.00, 0.00, '14586583347870;14586583345409;14586583343681', '0', 0, 0, 0, 0, 'img_admin/3/20160322225039736101.jpeg', 'img_admin/3/20160322225039736102.jpeg', ''),
(12, 13, '13', '0', 99999, '2016-04-22 22:47:00', '2016-04-29 08:00:00', 1.50, 1000.00, 0.00, '14586587217670;14586587214989;14586587211811', '3', 0, 0, 0, 0, 'img_admin/3/20160322225807801401.jpeg', 'img_admin/3/20160322225807801402.jpeg', ''),
(13, 14, '13', '0', 99999, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0.00, 0.00, 0.00, '14590928022755', '3', 0, 0, 0, 0, 'img_admin/3/201603272332374020001.gif', 'img_admin/3/201603272332374020002.gif', ''),
(14, 15, '13', '0', 99999, '2016-03-09 00:00:00', '2016-03-27 23:49:00', 2.00, 1000.00, 0.00, '14590951128428;14590951125493', '0', 0, 0, 0, 0, 'img_admin/3/201603280010523153001.gif', 'img_admin/3/201603280010523153002.gif', ''),
(15, 16, '13', '0', 99999, '2016-03-30 22:04:00', '2017-03-30 00:00:00', 1.00, 1000.00, 998.00, '14593472996334;14593472996858;14593472993681;14593472992625', '1', 2, 0, 0, 0, 'img_admin/9/20160330220851992401.jpeg', 'img_admin/9/20160330220851992402.jpeg', '现在关注“北龙口农家菜馆”微信公众号，回答任务问题，即可领取红包哦。'),
(16, 17, '13', '1', 48, '2016-04-03 20:21:00', '2017-04-03 00:00:00', 0.40, 2000.00, 2000.00, '14596863895537;14596863896322;14596863895771', '1', 0, 0, 0, 0, 'img_admin/3/20160403202540463201.jpeg', 'img_admin/3/20160403202540463202.jpeg', '');

-- --------------------------------------------------------

--
-- 表的结构 `mission_type`
--

CREATE TABLE `mission_type` (
  `mission_type` varchar(4) NOT NULL COMMENT '任务类型',
  `mission_title` varchar(30) character set utf8 collate utf8_bin NOT NULL COMMENT '任务类型名',
  `from_table` varchar(30) NOT NULL COMMENT '来自哪个表',
  PRIMARY KEY  (`mission_type`),
  UNIQUE KEY `mission_type` (`mission_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 导出表中的数据 `mission_type`
--

INSERT INTO `mission_type` (`mission_type`, `mission_title`, `from_table`) VALUES
('1', '新手任务', 'admin_mission_beginer'),
('11', 'app任务', 'client_mission_app'),
('12', '淘宝任务', 'client_mission_tb'),
('13', '商户关注推广类', 'client_mission_wetalk'),
('14', '日常任务', 'client_mission_daily'),
('15', '提升文章阅读类', 'client_mission_read'),
('2', '日常任务', 'admin_mission_daily'),
('3', '邀请任务', 'admin_mission_invite');

-- --------------------------------------------------------

--
-- 表的结构 `modules`
--

CREATE TABLE `modules` (
  `module_id` int(4) NOT NULL COMMENT '模块id',
  `module_title` varchar(300) character set utf8 collate utf8_bin NOT NULL COMMENT '模块名称',
  `mission_id` int(4) NOT NULL COMMENT '任务id',
  `mission_type` varchar(4) NOT NULL COMMENT '任务类型',
  `order` int(4) NOT NULL default '0' COMMENT '排序'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 导出表中的数据 `modules`
--


-- --------------------------------------------------------

--
-- 表的结构 `resource`
--

CREATE TABLE `resource` (
  `resource_id` int(4) NOT NULL auto_increment,
  `mission_id` int(4) NOT NULL,
  `mission_type` varchar(4) NOT NULL,
  `resource_type` varchar(30) NOT NULL COMMENT '资源类型txt，img',
  `resource_url` varchar(1000) character set utf8 collate utf8_bin default NULL COMMENT '其它介绍链接',
  `resource_txt` text character set utf8 collate utf8_bin COMMENT '文字介绍',
  `order_v` varchar(3) default '0' COMMENT '再排序',
  `class` varchar(3) default '1' COMMENT '先分类,0为封面资源',
  PRIMARY KEY  (`resource_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- 导出表中的数据 `resource`
--

INSERT INTO `resource` (`resource_id`, `mission_id`, `mission_type`, `resource_type`, `resource_url`, `resource_txt`, `order_v`, `class`) VALUES
(1, 1, '2', 'img', '../../uploads/2/1/unavailable.png', NULL, '10', '7'),
(3, 1, '2', 'img', '../../uploads/2/1/88.txt', NULL, '11', '5'),
(4, 3, '2', 'img', '../../uploads/2/3/1.jpg', NULL, '0', '0'),
(5, 2, '2', 'img', '../../uploads/2/2/1.PNG', NULL, '0', '0'),
(7, 2, '2', 'img', '../../uploads/2/2/14572524683751.jpg', NULL, '0', '1'),
(9, 4, '2', 'img', '../../uploads/2/4/1457254265.jpg', NULL, '15', '1'),
(11, 4, '2', 'img', '../../uploads/2/4/cover1457255059.jpg', NULL, '0', '0'),
(12, 2, '13', 'txt', NULL, 0xe8bf99e698afe4b880e4b8aae7a59ee5a587e79a84e9a490e58e85, '0', '1'),
(13, 2, '13', 'img', 'img_admin/3/14586367076097.JPG', NULL, '1', '1'),
(14, 2, '13', 'txt', NULL, 0xe68891e4bbace59ca8e8bf99e9878ce7ad89e4bda0, '2', '1'),
(15, 2, '13', 'img', 'img_admin/3/14586367248895.JPG', NULL, '3', '1'),
(16, 7, '13', 'txt', NULL, 0xe8bf99e698afe4b880e4b8aae7a59ee5a587e79a84e9a490e58e85, '0', '1'),
(17, 7, '13', 'img', 'img_admin/3/14586367076097.JPG', NULL, '1', '1'),
(18, 7, '13', 'txt', NULL, 0xe68891e4bbace59ca8e8bf99e9878ce7ad89e4bda0, '2', '1'),
(19, 7, '13', 'img', 'img_admin/3/14586367248895.JPG', NULL, '3', '1'),
(20, 9, '13', 'txt', NULL, 0xe8bf99e698afe4b880e4b8aae7a59ee5a587e79a84e9a490e58e85, '0', '1'),
(21, 9, '13', 'img', 'img_admin/3/14586367076097.JPG', NULL, '1', '1'),
(22, 9, '13', 'txt', NULL, 0xe68891e4bbace59ca8e8bf99e9878ce7ad89e4bda0, '2', '1'),
(23, 9, '13', 'img', 'img_admin/3/14586367248895.JPG', NULL, '3', '1'),
(24, 10, '13', 'txt', NULL, 0xe5b08fe5ba97e58fafe689bfe68ea57061727479e38082e6aca2e8bf8ee697a0e8818ae697b6e58589e9a1bee38082e4b88de5ae9ae69c9fe98080e587bae59084e5bc8fe5b08fe6b4bbe58aa8, '0', '1'),
(25, 10, '13', 'img', 'img_admin/3/14586583295873.JPG', NULL, '1', '1'),
(26, 13, '13', 'txt', NULL, 0xe5b08fe5ba97e58fafe689bfe68ea57061727479e38082e6aca2e8bf8ee697a0e8818ae697b6e58589e9a1bee38082e4b88de5ae9ae69c9fe98080e587bae59084e5bc8fe5b08fe6b4bbe58aa8, '0', '1'),
(27, 13, '13', 'img', 'img_admin/3/14586583295873.JPG', NULL, '1', '1'),
(28, 14, '13', 'img', 'img_admin/3/14590926986032.jpg', NULL, '0', '1'),
(29, 14, '13', 'txt', NULL, 0x3930, '1', '1'),
(30, 15, '13', 'txt', NULL, 0x612e68686868, '0', '1'),
(31, 15, '13', 'img', 'img_admin/3/14590951024088.jpg', NULL, '1', '1'),
(32, 15, '13', 'txt', NULL, 0x622e6169797979, '2', '1'),
(33, 16, '13', 'txt', NULL, 0xe5b08fe9be99e899bee5a4a7e9be99e899bee38082e38082e5b0bde59ca8e58c97e9be99e58fa3e5869ce5aeb6e88f9ce9a686, '0', '1'),
(34, 16, '13', 'img', 'img_admin/9/14593469856390.JPG', NULL, '1', '1'),
(35, 16, '13', 'txt', NULL, 0xe69c8de58aa1e591a8e588b0e38082e4bab2e5bfabe782b9e69da5e593a6, '2', '1'),
(36, 16, '13', 'img', 'img_admin/9/14593470538806.JPG', NULL, '3', '1'),
(37, 17, '13', 'txt', NULL, 0xe68891e5aeb6e7899be88289e4b8b8e6aca2e8bf8ee4bda0e38082, '0', '1'),
(38, 17, '13', 'img', 'img_admin/3/14596863817662.JPG', NULL, '1', '1');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `user_id` int(4) NOT NULL auto_increment,
  `username` varchar(20) NOT NULL COMMENT '长20（初始注册信息）',
  `userpass` varchar(40) NOT NULL COMMENT '长20（初始注册信息）',
  `first_name` varchar(30) character set utf8 collate utf8_bin default NULL COMMENT '名',
  `last_name` varchar(30) character set utf8 collate utf8_bin default NULL COMMENT '姓',
  `alipay` varchar(30) character set utf8 collate utf8_bin default NULL COMMENT '支付宝账号',
  `email` varchar(30) default NULL COMMENT '邮箱',
  `QQ` varchar(30) default NULL COMMENT 'QQ',
  `telephone` varchar(20) NOT NULL COMMENT '电话（初始注册信息）',
  `nick_name` varchar(24) character set utf8 collate utf8_bin default NULL COMMENT '昵称',
  `birthday` datetime default NULL,
  `address` varchar(300) character set utf8 collate utf8_bin default NULL COMMENT '地址',
  `location` varchar(300) character set utf8 collate utf8_bin default NULL COMMENT '定位信息',
  `invite_code` varchar(20) NOT NULL COMMENT '邀请码（初始生成）',
  `available_times` varchar(4) NOT NULL default '20' COMMENT '任务可接次数',
  `more_times` varchar(4) NOT NULL default '0' COMMENT '更多次数',
  `used_times` varchar(4) NOT NULL default '0' COMMENT '已用次数',
  `registration_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `last_logintime` datetime NOT NULL,
  `this_logintime` datetime NOT NULL,
  `fail_times` int(4) NOT NULL default '0',
  `number_invited` varchar(4) NOT NULL default '0' COMMENT '邀请的人数',
  `invited` varchar(1) NOT NULL default '0' COMMENT '0未被邀请；1已被邀请',
  `user_type` varchar(2) NOT NULL default '0' COMMENT '用户类型',
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- 导出表中的数据 `user`
--

INSERT INTO `user` (`user_id`, `username`, `userpass`, `first_name`, `last_name`, `alipay`, `email`, `QQ`, `telephone`, `nick_name`, `birthday`, `address`, `location`, `invite_code`, `available_times`, `more_times`, `used_times`, `registration_time`, `last_logintime`, `this_logintime`, `fail_times`, `number_invited`, `invited`, `user_type`) VALUES
(1, '123', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, NULL, NULL, NULL, NULL, '123', '小米', NULL, NULL, NULL, 'BsQu84MBTQOQV9FVWXw0', '1000', '0', '20', '2016-02-03 20:48:30', '2016-02-03 20:48:30', '2016-02-03 20:48:30', 0, '0', '0', '0'),
(2, '234', '0ec09ef9836da03f1add21e3ef607627e687e790', NULL, NULL, NULL, NULL, NULL, '234', '混合', NULL, NULL, NULL, 'vGIkKnUwlH9YXq12aT9F', '20', '0', '1', '2016-02-14 15:36:50', '2016-02-14 15:36:50', '2016-02-14 15:36:50', 0, '0', '0', '0');

-- --------------------------------------------------------

--
-- 表的结构 `user_earning`
--

CREATE TABLE `user_earning` (
  `user_earning_id` int(4) NOT NULL auto_increment,
  `user_mission_id` int(4) NOT NULL,
  `user_id` int(4) NOT NULL,
  `profit` decimal(5,2) default NULL,
  `withdrawal` decimal(5,2) default NULL,
  `withdrawal_to` varchar(30) character set utf8 collate utf8_bin default NULL COMMENT '支付宝（便于支持其他方式）',
  `else_profit` decimal(5,2) default NULL COMMENT '不良行为扣除',
  `update_time` datetime NOT NULL,
  PRIMARY KEY  (`user_earning_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- 导出表中的数据 `user_earning`
--

INSERT INTO `user_earning` (`user_earning_id`, `user_mission_id`, `user_id`, `profit`, `withdrawal`, `withdrawal_to`, `else_profit`, `update_time`) VALUES
(1, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-05 16:44:59'),
(2, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-05 17:03:40'),
(3, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-05 17:25:06'),
(4, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-05 17:25:39'),
(5, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-05 17:26:19'),
(6, 2, 1, 5.00, NULL, NULL, NULL, '2016-02-05 17:27:36'),
(7, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-05 21:38:45'),
(8, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-06 11:24:37'),
(9, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-06 11:30:58'),
(10, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-06 11:42:16'),
(11, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-06 11:51:30'),
(12, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-06 11:53:18'),
(13, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-06 11:57:07'),
(14, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-06 12:03:13'),
(15, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-06 12:34:08'),
(16, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-06 12:40:03'),
(17, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-06 12:49:00'),
(18, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-06 12:51:40'),
(19, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-06 12:52:35'),
(20, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-06 12:56:13'),
(21, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-06 12:56:43'),
(22, 1, 1, 0.20, NULL, NULL, NULL, '2016-02-06 13:04:20'),
(23, 3, 1, 2.00, NULL, NULL, NULL, '2016-02-13 23:15:40'),
(24, 4, 2, 2.00, NULL, NULL, NULL, '2016-02-14 15:38:07'),
(25, 1, 1, 0.20, NULL, NULL, NULL, '2016-03-10 01:04:21'),
(28, 9, 1, 0.05, NULL, NULL, NULL, '2016-04-23 17:26:35'),
(29, 10, 1, 0.05, NULL, NULL, NULL, '2016-04-23 17:31:33'),
(30, 11, 1, 0.05, NULL, NULL, NULL, '2016-04-23 17:35:00'),
(31, 11, 1, 0.05, NULL, NULL, NULL, '2016-04-23 17:35:58'),
(32, 11, 1, 0.01, NULL, NULL, NULL, '2016-04-23 18:24:25'),
(33, 11, 1, 0.01, NULL, NULL, NULL, '2016-04-23 18:25:56');

-- --------------------------------------------------------

--
-- 表的结构 `user_mission`
--

CREATE TABLE `user_mission` (
  `user_mission_id` int(4) NOT NULL auto_increment,
  `user_id` int(4) NOT NULL,
  `mission_id` int(4) NOT NULL,
  `mission_type` varchar(4) NOT NULL,
  `take_time` datetime NOT NULL COMMENT '接受任务时间',
  `hand_time` datetime default NULL COMMENT '提交时间',
  `friend_id` int(4) default NULL COMMENT '被邀请者id',
  `vert_id` char(14) default '0',
  `verfication_answer` varchar(300) character set utf8 collate utf8_bin default NULL COMMENT '验证回答',
  `state` varchar(2) NOT NULL default '0' COMMENT '0进行中1审核中2完成',
  `n` int(4) NOT NULL,
  `r_n` int(4) NOT NULL,
  PRIMARY KEY  (`user_mission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- 导出表中的数据 `user_mission`
--

INSERT INTO `user_mission` (`user_mission_id`, `user_id`, `mission_id`, `mission_type`, `take_time`, `hand_time`, `friend_id`, `vert_id`, `verfication_answer`, `state`, `n`, `r_n`) VALUES
(1, 1, 1, '2', '2016-03-10 01:01:24', '2016-03-10 01:04:21', NULL, '0', NULL, '2', 22, 0),
(2, 1, 2, '2', '2016-02-05 16:42:56', '2016-02-05 17:27:36', NULL, '0', NULL, '2', 1, 0),
(3, 1, 4, '2', '2016-02-28 14:58:49', '2016-02-13 23:15:40', NULL, '0', NULL, '1', 1, 0),
(4, 2, 3, '2', '2016-02-14 15:38:07', '2016-02-14 15:38:07', NULL, '0', NULL, '0', 1, 0),
(6, 1, 16, '13', '2016-04-02 17:02:34', NULL, NULL, '14593472996334', NULL, '1', 0, 0),
(9, 1, 18, '15', '2016-04-23 17:26:35', '2016-04-23 18:22:54', NULL, '0', NULL, '2', 8, 1),
(10, 1, 20, '15', '2016-04-23 17:31:33', '2016-04-23 17:32:33', NULL, '0', NULL, '2', 2, 0),
(11, 1, 21, '15', '2016-04-23 17:35:00', '2016-04-23 17:37:26', NULL, '0', NULL, '2', 3, 2);

-- --------------------------------------------------------

--
-- 表的结构 `vertification`
--

CREATE TABLE `vertification` (
  `vert_id` char(14) NOT NULL,
  `vertification_question` text character set utf8 collate utf8_bin NOT NULL,
  `vertification_answer` varchar(300) character set utf8 collate utf8_bin NOT NULL,
  `type` varchar(10) NOT NULL default 'normal' COMMENT 'check人工审核normal一般random（v_answer为NULL）随机生成',
  UNIQUE KEY `vert_id` (`vert_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 导出表中的数据 `vertification`
--

INSERT INTO `vertification` (`vert_id`, `vertification_question`, `vertification_answer`, `type`) VALUES
('14586367603747', 0xe4bb8ee5898de79a84e4bb8ee5898de58fabe4bb80e4b988, '很久以前', 'normal'),
('14586367607549', 0xe5b08fe78b97e79a84e5a4a9e6958ce698afe4bb80e4b988, '猫', 'normal'),
('14586367608575', 0xe68891e58fabe4bb80e4b988e5908de5ad97, '不知道', 'normal'),
('14586367608692', 0xe9b1bce79a84e88bb1e69687e698afe4bb80e4b988efbc9f, 'fish', 'normal'),
('14586388511765', 0xe4bb8ee5898de79a84e4bb8ee5898de58fabe4bb80e4b988, '很久以前', 'normal'),
('14586388516840', 0xe9b1bce79a84e88bb1e69687e698afe4bb80e4b988efbc9f, 'fish', 'normal'),
('14586388519058', 0xe5b08fe78b97e79a84e5a4a9e6958ce698afe4bb80e4b988, '猫', 'normal'),
('14586388519780', 0xe68891e58fabe4bb80e4b988e5908de5ad97, '不知道', 'normal'),
('14586390043428', 0xe9b1bce79a84e88bb1e69687e698afe4bb80e4b988efbc9f, 'fish', 'normal'),
('14586390045458', 0xe4bb8ee5898de79a84e4bb8ee5898de58fabe4bb80e4b988, '很久以前', 'normal'),
('14586390047715', 0xe68891e58fabe4bb80e4b988e5908de5ad97, '不知道', 'normal'),
('14586390047774', 0xe5b08fe78b97e79a84e5a4a9e6958ce698afe4bb80e4b988, '猫', 'normal'),
('14586583343681', 0xe88f9ce58d95e7acace4ba8ce58886e7b1bbe79a84e7acace4ba8ce9a1b9e698afe4bb80e4b988efbc9f, '啤酒', 'normal'),
('14586583345409', 0xe68891e4bbace9a490e58d95e79a84e7acace4b880e58886e7b1bbe698afe4bb80e4b988efbc9f, '家常小炒', 'normal'),
('14586583347870', 0xe68891e4bbace79a84e5ba97e99da2e698afe4bb80e4b988efbc9f, '北龙口菜馆', 'normal'),
('14586587211811', 0xe88f9ce58d95e7acace4ba8ce58886e7b1bbe79a84e7acace4ba8ce9a1b9e698afe4bb80e4b988efbc9f, '啤酒', 'normal'),
('14586587214989', 0xe68891e4bbace9a490e58d95e79a84e7acace4b880e58886e7b1bbe698afe4bb80e4b988efbc9f, '家常小炒', 'normal'),
('14586587217670', 0xe68891e4bbace79a84e5ba97e99da2e698afe4bb80e4b988efbc9f, '南小区餐馆', 'normal'),
('14590928022755', '', '', 'normal'),
('14590951125493', 0xe585ace4bc97e58fb7e4bda0e78c9ce78c9ce6a08fe79baee7acace4b880e9a1b9e698afe4bb80e4b988efbc9f, '就不告诉你', 'normal'),
('14590951128428', 0xe4bda0e78c9ce78c9ce68891e58fabe4bb80e4b988e5908de5ad97efbc9f, '不知道', 'normal'),
('14593472992625', 0xe58c97e9be99e58fa3e5beaee4bfa1e585ace4bc97e58fb7e7acace4ba8ce9a1b9e698afe4bb80e4b988e591a2efbc9f, '点餐', 'normal'),
('14593472993681', 0xe68891e4bbace79a8477696669e5af86e7a081e698afe4bb80e4b988e591a2efbc9f, 'niyashishui', 'normal'),
('14593472996334', 0xe58c97e9be99e58fa3e9a490e9a686e79a84e88081e69dbfe58fabe4bb80e4b988e591a2efbc9f, '小龙虾', 'normal'),
('14593472996858', 0xe58c97e9be99e58fa3e5beaee4bfa1e585ace4bc97e58fb7e8be93e585a5e2809c776de2809de4bc9ae59b9ee5a48de4bb80e4b988e591a2efbc9f, 'hyz1239', 'normal'),
('14596863895537', 0xe68891e5aeb6e7899be88289e79a84e68e8ce69f9ce58fabe4bb80e4b988efbc9f, '杨依依', 'normal'),
('14596863895771', 0xe585b3e6b3a8e68891e5aeb6e7899be88289e4b8b8e5beaee4bfa1e585ace4bc97e58fb7efbc8ce8be93e585a5e2809ce68891e788b1e68891e5aeb6e7899be88289e4b8b8e2809defbc8ce4bc9ae59b9ee5a48de4bb80e4b988efbc9f, '我家牛肉。健康生活', 'normal'),
('14596863896322', 0xe585b3e6b3a8e68891e5aeb6e7899be88289efbc8ce5beaee4bfa1e585ace4bc97e58fb7e79a84e7acace4b880e9a1b9e698afe4bb80e4b988efbc9f, '牛肉丸', 'normal');
