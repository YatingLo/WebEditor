<?php

/**
 * Examples for how to use CFPropertyList
 * Read an XML PropertyList
 * @package plist
 * @subpackage plist.examples
 */
namespace CFPropertyList;

// just in case...
error_reporting(E_ALL);
ini_set('display_errors', 'on');

/**
 * Require CFPropertyList
 */
require_once (__DIR__ . '~/../classes/CFPropertyList/CFPropertyList.php');
require_once("mysql.inc.php");
include("handle-db.php");
include("handle-file.php");

if(isset($_GET['mode']))
	$iMode = $_GET['mode'];
if(isset($_GET['wdid']))
	$iId = $_GET['wdid'];
if(isset($_GET['data']))
	$sData = $_GET['data'];
 
$int_widgetId = 4;
$aResult = array("data" => "預設", "id" => "$int_widgetId");
$path_widget = "../widgets/$int_widgetId.wdgt/Info.plist";

/*
 *下載zip
*sfile，dfile
*/
if (isset($_GET['mode']) && $_GET['mode'] === "test") {
	
	
	
	//$post_data = array("json"=>"$sName, $dName, $iId","id"=>1);
	$post_data = array("json"=>"test","id"=>0);
	echo json_encode($post_data);
	exit();
}//get end

/*
 *圖片上
 *sfile，dfile
*/
else if (isset($_GET['mode']) && $_GET['mode'] === "move") {
	$sName = '';
	$dName = '';
	if(isset($_GET['sfile']))
		$sName = $_GET['sfile'];
	if(isset($_GET['dfile']))
		$dName = $_GET['dfile'];
	
	$url_s = "../classes/Jupload/server/php/files/" . $sName;
	$url_d = "../widgets/".$iId.".wdgt/". $dName;
	rename($url_s, $url_d);
	
	$myFile = "../classes/Jupload/server/php/files/thumbnail/" . $sName;
	if (file_exists($myFile)) {
		unlink($myFile);
	}
	//$post_data = array("json"=>"$sName, $dName, $iId","id"=>1);
	$post_data = array("json"=>"$sName, $dName, $url_d","id"=>$iId);
	echo json_encode($post_data);
	exit();
}//get end



?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Plist files</title>

		<!---DOCTYPE import --->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>

	</head>

	<body>

	</body>
</html>