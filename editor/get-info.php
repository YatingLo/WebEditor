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

/**
 * setting
 * widgetId從資料庫中取出
 */
$int_widgetId = 4;
//$int_widgetId = "sample";
$path_widget = "../widgets/$int_widgetId/Info.plist";

function file_move_img($id, $sFileName, $dFileName) {
		$url_source = "../classes/Jupload/server/php/files/" . $file_name;
		$url_target = "../widgets/$int_widgetId/Default.png";
		rename($url_source, $url_target);
	
		$myFile = "../classes/Jupload/server/php/files/thumbnail/" . $file_name;
		if (file_exists($myFile)) {
			unlink($myFile);
		}
	}

/*
 *移動檔案
 */
if (isset($_GET['mode']) && $_GET['mode'] === "move") {

    $file_name = $_GET['file'];
	$int_widgetId = $_GET['id'];
	
    $url_source = "../classes/Jupload/server/php/files/" . $file_name;
    $url_target = "../widgets/$int_widgetId.wdgt/Default.png";
    rename($url_source, $url_target);

    $myFile = "../classes/Jupload/server/php/files/thumbnail/" . $file_name;
    if (file_exists($myFile)) {
        unlink($myFile);
    }

	//file_move_img(4, $file_name, "Default.png");

    $post_data = array("json"=>"$file_name","id"=>"$int_widgetId");
    echo json_encode($post_data);
	
	

    exit();
}//get end

/*
 *測試
*/
if (isset($_GET['mode']) && $_GET['mode'] === "test") {

	$post_data = array("json"=>'adsf',"id"=>1);
	echo json_encode($post_data);
	exit();
}//get end



/*
 *存plist檔案
 */
if (isset($_GET['mode']) && $_GET['mode'] === "save") {
    $post_data = $_GET['data'];
	$int_widgetId = $_GET['wdid'];
    /*
     $post_data = '
     {
     "orderID": 12345,
     "shopperName": "John Smith",
     "shopperEmail": "johnsmith@example.com",
     "contents": "asdfadsf",
     "orderCompleted": true
     }
     ';*/
    $post_data = json_decode($post_data);
    //string to object
    $post_data = get_object_vars($post_data);
    //object to array

    savePlist($post_data, "../widgets/$int_widgetId.wdgt/Info.plist");
    $post_data = array("data" => "saved");
    //echo json_encode($post_data);
    exit();
}//get end
/*
 *讀plist檔案，傳送設定資料
 */
if (isset($_GET['mode']) && $_GET['mode'] === "read") {
	//$wdid = $_GET['wdid'];
	$int_widgetId = $_GET['wdid'];
	//echo "../widgets/$int_widgetId.wdgt/Info.plist";
    if (file_exists("../widgets/$int_widgetId.wdgt/Info.plist")) {
        //讀檔後轉成json
        $value = readPlist("../widgets/$int_widgetId.wdgt/Info.plist");
        $value = $value -> toArray();
        //echo json_encode($value); //object to string

        $value = json_encode($value);
        $post_data = array("json" => "$value", "id" => "$int_widgetId");
		//echo "存在";
        echo json_encode($post_data);
		
        exit();
    } else {
        if (!file_exists("../widgets/$int_widgetId.wdgt")) {
            mkdir("../widgets/$int_widgetId.wdgt", 0755, TRUE);
        }
        // save data
        $plist = readPlist("../widgets/sample/Info.plist");
        $plist_path = dirname(dirname(__FILE__));
        $plist_path = $plist_path . "/widgets/$int_widgetId.wdgt/Info.plist";
        $plist -> saveXML($plist_path);

        //讀檔後轉成jsont
        $value = readPlist($path_widget);
        $value = $value -> toArray();
        //echo json_encode($value);

        $value = json_encode($value);
        $post_data = array("json" => "$value", "id" => "$int_widgetId");
		
		//echo "不存在";
        echo json_encode($post_data);

        exit();
    }
}//get end

/*
 *存plist檔案
 */
function savePlist($value, $path) {//$value:array
    try {
        $plist = new CFPropertyList();
        $td = new CFTypeDetector();
        $guessedStructure = $td -> toCFType($value);
        $plist -> add($guessedStructure);
        $plist -> saveXML($path);
    } catch( PListException $e ) {
        echo 'Normal detection: ', $e -> getMessage(), "\n";
    }
}

/*
 *讀plist檔案
 */
function readPlist($path) {
    $plist = new CFPropertyList($path, CFPropertyList::FORMAT_XML);
    return $plist;
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
