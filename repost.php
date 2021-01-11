<?php
//$db['host']='localhost';
$db['user']='soptorg';
$db['pass']='soptorg12151';
$db['db']='soptorg';
$conn=@mysqli_connect($db['host'],$db['user'],$db['pass']) or die("Ошибка Базы");
$db=@mysqli_select_db($db['db']) or die("Ошибка Базы");
$thumb=file("/file.txt");
foreach($thumb as $key=>$val)
{
     $ln = explode(";",$val);
     $ln[0] = strip_tags(trim($ln[0]));
     $ln[1] = strip_tags(trim($ln[1]));
     mysqli_query("UPDATE `cms_shop_items` SET `art_no`=$ln[1] WHERE `art_no`=$ln[0]");
}
?>