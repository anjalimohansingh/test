<?php
      include_once("common/includes/constants.php");
      include_once("common/includes/constants.php"); 
      include_once("common/includes/functions.php");
      include_once("common/includes/common.php"); 
      include_once("common/includes/admin_session.php");
      include_once("common/includes/english_admin.php");

$vencode=$_REQUEST['vencode'];
$venname=addslashes($_REQUEST['venname']);
$qc_rq=addslashes($_REQUEST['qc_rq']);

$page=$_REQUEST['page'];
$mod=$_REQUEST['mod'];

if($mod=="edt")
{
   $sql="select Vendor_Code from vendormaster where Vendor_Name='{$venname}' and Vendor_Code!='$vencode' and Vendor_Del!=1 ";
   $ret=mysql_query($sql);
if (mysql_num_rows($ret))
{
   header("location:index.php?act=vendor&errmsg=Vendor Name Alredy Exist&page=$page");
   exit;
}
else
{
    $sql="update vendormaster set Vendor_Name='{$venname}',Qc_Req='{$qc_rq}' where Vendor_Id='$vencode'";
    $ret=mysql_query($sql);
    header("location:index.php?act=vendor&msg=Vendor Modified&page=$page");
    exit;
}
}
if($mod=="add") 
{
    $sql="select Vendor_Code from vendormaster where Vendor_Name='".$venname."' and Vendor_Del!=1 ";
    $ret=mysql_query($sql);
if (mysql_num_rows($ret))
{
    header('location:index.php?act=vendor&errmsg=Vendor Alredy Exist');
    exit;
}
else
{
    $sql="insert into    `vendormaster`(`Vendor_Name`,Qc_Req) values ('{$venname}','{$qc_rq}')";
    $ret=mysql_query($sql) or die($sql."Error in Query ".mysql_error());
if($ret==1)
{
    header('location:index.php?act=vendor&msg=Vendor Added');
    exit;
}
}
}

?> 