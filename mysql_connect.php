<!DOCTYPE html>
<html>
<body>
<div align="center">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php
	//資料庫設定
	//資料庫位置
	$db_server = "dbhome.cs.nctu.edu.tw";
	//資料庫名稱
	$db_name = "chiaan0516021_cs_2";
	//資料庫管理者帳號
	$db_user = "chiaan0516021_cs";
	//資料庫管理者密碼
	$db_passwd = "****"; //打碼
	//對資料庫連線
	$dbConnection = mysqli_connect($db_server,$db_user,$db_passwd);
	if(!$dbConnection)
			die("無法對資料庫連線");

	//資料庫連線採UTF8
	#mysqli_query("SET NAMES utf8");

	//選擇資料庫
	$db_select = mysqli_select_db($dbConnection, $db_name);
	if(!$db_select)
        die("無法使用資料庫");
?>
</div>
</body>
</html>
