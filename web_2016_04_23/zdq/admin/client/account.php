<?php 
include('head.html'); 
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/account_style.css" type="text/css" rel="stylesheet"/>

<?php
$id=$_SESSION['zdq_admin_s'];
if($_GET['account']!=""){
$charge=$_GET['account'];
$sql="update admin set account=account+$charge where admin_id=$id limit 1";
if(mysql_query($sql)){
	echo "<em>- 成功充值<b>$charge</b>元！</em>";
	}
else{
	echo "<em>- 充值失败！</em>";
	
	}
}

$sql="select account from admin where admin_id=$id";
$r=mysql_query($sql);
$row=mysql_fetch_array($r);
$account=$row[0];
?>
<div class="col-sm-12 account-block">
  <div class="account-home-cash"><span class="account-home-left-title"><span class="text-size-16">现金余额<!--现金余额--></span> <span>:</span></span> <span class="text-size-18">￥<?php echo number_format($account,2);?></span> <span class="text-muted">（ 欠费： <span class="text-warning">￥0.00</span> <a class=""  href="#" >查看详情</a> ）</span> <span><a class="btn btn-primary" href="account.php?account=1000">充值</a><a href="#">提现</a><span class="text-explode">|</span> <a href="#">提现记录</a> <span class="text-explode">|</span> <a href="#">退款</a> <span class="text-explode">|</span> <a href="#" >收支详情</a> <span class="text-explode">|</span> <a href="#">我有兑换码</a></span></div>
  <!-- ngIf: vm.tag.postFinancialSettle -->
  <div class="account-home-threshold">
    <div style="margin-left:1px;margin-right:1px;padding-top: 10px;padding-bottom: 20px;border-bottom-width: 1px;  border-bottom-style: dashed;border-bottom-color: rgb(188, 188, 188);padding-left: 10px;"><span class="account-home-left-title">现金余额预警：</span>
<?php
if($account>0){
?>  
    <span style=" color:green; font-weight:500">正常</span>
<?php
}
else{
?>  
    <span style=" color:red; font-weight:600">请及时充值！</span>
<?php

}
?>    
      <div>
        <div>
          <div style=" -webkit-transition-property: background-position, border-spacing; -webkit-transition-duration: 0.2s, 0.2s; "></div>
        </div>
      </div>
      <span class="text-muted" >（ 预警阈值为￥0.00 <a class="ng-binding">修改</a> ）</span></div>
  </div>
</div>
<style>
.account-home-sum-item {
border-left: solid 1px #ccd6e0;
border-bottom: solid 1px #ccd6e0;
border-right: solid 1px #ccd6e0;
border-top-width: 0;
padding: 20px 20px;
height: 80px;
}
.col-sm-3 {
width: 24%;
box-sizing: border-box;
}
.account-home-sum-item .item-title {
font-size: 18px;
line-height: 18px;
}
.account-home-sum-item .item-title .sub {
font-size: 13px;
}
.account-home-sum-item .item-content {
font-size: 13px;
line-height: 13px;
margin-top: 7px;
}
.margin-left-2 {
margin-left: 16px !important;
}
.account-home-sum-item.no-left-border {
border-left: none;
}
.account-home-sum-item.no-border {
border-left: none;
border-right: none;
}
.account-home-sum-item {
border-left: solid 1px #ccd6e0;
border-bottom: solid 1px #ccd6e0;
border-right: solid 1px #ccd6e0;
border-top-width: 0;
padding: 20px 20px;
height: 80px;
}
</style>
<div class="col-sm-3 account-home-sum-item">
  <div class="item-title">1 <span class="sub">张</span></div>
  <div class="item-content">可用代金券 <a class="margin-left-2" href="#" >代金券管理</a></div>
</div>
<div class="col-sm-3 account-home-sum-item no-left-border">
  <div class="item-title">0 <span class="sub">张</span></div>
  <div class="item-content">可用体验券 <a class="margin-left-2" target="_blank"  href="#">体验券管理</a></div>
</div>
<div class="col-sm-3 account-home-sum-item no-border">
  <div class="item-title">￥74.45</div>
  <div class="item-content">可索取发票总额 <span class="icon-help-2 text-muted"></span> <a class="margin-left-2" target="_blank" href="#">索取发票</a></div>
</div>
<div class="col-sm-3 account-home-sum-item">
  <div class="item-title">0 <span class="sub">个</span></div>
  <div class="item-content">待付款账单 <a class="margin-left-2" href="#">立即付款</a></div>
</div>
<div style=" clear:both"></div>
<div style="display:table; content:"";">&nbsp;</div>
