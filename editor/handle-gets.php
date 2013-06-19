<?php

/**
 * Examples for how to use CFPropertyList
 * Read an XML PropertyList
 * @package plist
 * @subpackage plist.examples
 */

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
if (isset($_GET['mode']) && $_GET['mode'] === "down") {
	
	$carPart = new HandleFile;
	$resLink = $carPart-> project_download($iId);
	
	
	//$post_data = array("json"=>"$sName, $dName, $iId","id"=>1);
	$post_data = array("json"=>"$resLink","id"=>"$iId");
	echo json_encode($post_data);
	//echo $carPart->testData();
	exit();
}//get end

/*
 *圖片上
 *sfile，dfile
*/
if (isset($_GET['mode']) && $_GET['mode'] === "move") {
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

class Car{
	var $testData = "";
	
	public function testData(){
		$post_data = array("json"=>"testback","id"=>0);
		return json_encode($post_data);
	}
	
	public function project_download($id){
		//echo "download：";
		$url = "../widgets/".$id.".wdgt";
		$zipName = "../widgets/".$id.".zip";
		$zip = new ZipArchive();
		if ($zip->open($zipName, ZipArchive::CREATE) === TRUE) {
			$from_files = scandir($url);
			$this->add2zip($zip, $url);
			$zip->close();
			//echo 'ok';
			return '<a href="'.$zipName.'">下載</a>';
		} else {
			//echo 'failed';
			return false;
		}
	}
	
	//檔案加入壓縮檔中
	public function add2zip($zip,$url) {
		$from_files = scandir($url);  

        if( ! empty($from_files)){  
			foreach ($from_files as $file){  
				if($file == '.' || $file == '..' ){  
					continue;  
				}  
				if(is_dir($url.'/'.$file)){
					$this->add2zip($zip, $url.'/'.$file);
				}else{
					$zip->addFile($url.'/'.$file);  
				}  
			}  
		}
        return $zip ;
	}
}

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