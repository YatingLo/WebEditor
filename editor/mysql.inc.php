<?php
//phpinfo();

//mysql_connect("box779.bluehost.com", "ytlpccom_widget", "102201245")
$dbServer = "localhost";
$dbName = "ytlpccom_widget";
$dbUser = "ytlpccom_widget";
$dbPass = "102201245";
//@mysql_query("SELECT name, id FROM wd_widget_type")

header('Content-Type: text/html; charset=utf-8');
if(!@mysql_connect($dbServer, $dbUser, $dbPass)) {
	//die("無法連線資料庫");
	//echo "無法連線資料庫";
} else {
	mysql_query("SET NAMES utf8");
	if(!@mysql_select_db($dbName)) {
		//die("不能存取");
		//echo "不能存取";
	}
}
?>