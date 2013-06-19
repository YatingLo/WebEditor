<title>檔案處理</title>
<?php
//include_once("mysql.inc.php");
include("handle-db.php");
include("handle-file.php");

header('Access-Control-Allow-Origin: *');

if (version_compare(phpversion(), '5.3.0', '>=')  == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
  error_reporting(E_ALL & ~E_NOTICE); 

// accept POST params
$sAction = $_POST['action'];
$iId = (int)$_POST['id'];
$sData = (string)$_POST['data'];

// perform calculation
switch ($sAction) {
    case 'send': //測驗成績上傳
        //$data_send = array("name"=>$sPname,"score"=>$iPscore);
		//$data_send = json_encode($data_send);
		$dbHandle = new HandleDB();
		if($id = $dbHandle->sql_insert_data($iId,$sData))
        break;
	case 'move'://上傳圖片時呼叫，但黨名根據傳來的字串直，以id.wdgt為基準"sfile""dfile"
		/*
		$fileName = json_decode($sData);
		$fileName = get_object_vars($fileName);
		$fileHandle->file_move_img($iId, $fileName['sfile'],$fileName['dfile']);
		*/
		$res = array("id"=>1, "data"=>"test");
		//header('Content-type: application/json');
		echo json_encode($res);
	 	break;
	case 'delete'://刪除部件
		$fileHandle->file_delete($iId);
		$dbHandle = new HandleDB();
		$dbHandle->sql_delete_widget($iId);
		break;
	case 'copy'://新增部件
		$fileHandle->file_copy_sample(10,1);
		break;
	case 'download'://下載部件
		echo $fileHandle->project_download($iId, $sData);
	
		break;
	case 'savehtml'://存html
		
		if($fileHandle->file_save_html($iId,$sData));
		break;
	case 'saveplist'://存plist
		break;
	case 'readplist'://讀plist, back json
		break;
	case 'listData'://取資料列表
		
		header('Content-type: application/json');
		echo json_encode($aResult);
		break;
	case 'listWdgt'://取部件列表
		
		header('Content-type: application/json');
		echo json_encode($aResult);
		break;

}

/*測試*/

//$fileHandle = new HandleFile();
$dbHandle = new HandleDB;

/*
$sData = json_encode(array('sfile'=>'apple_ex.png', 'dfile'=>"dfile"));
$fileName = json_decode($sData);
$fileName = get_object_vars($fileName);
if(is_array($fileName)){
	echo 'yes';
}else {
	echo 'no';
}
echo is_array($fileName);
//echo var_dump($fileName);
echo $fileName["sfile"];
$fileHandle->file_move_img($iId, $fileName["sfile"],$fileName["dfile"]);
		
$res = array("id"=>$iId, "data"=>$sData);
header('Content-type: application/json');
echo json_encode($res);


//$fileHandle->file_copy_sample(10,1);
//$fileHandle->file_delete(10);
//$fileHandle->file_move_img(4,"apple_ex.png","Default.png");
//echo $fileHandle->project_download(10);

/*
$string = '<meta charset="utf-8"> <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame Remove this if you use the .htaccess --> <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> <!---DOCTYPE import ---> <script type="text/javascript" src="js/main.js"></script> <script type="text/javascript" src="js/jquery-1.9.1.js"></script> <link href="main.css" rel="stylesheet" type="text/css"> <!-- head end--> <div style="display: none;" id="widget_id">4</div> <div id="quiz_content"> <ol class="ui-sortable"> <h3 style="display: block; border: 1px dashed gray;" class="ui-draggable">標題</h3> </ol> <button style="display: none;" id="quiz_check"> 完成 </button> </div> <div style="display: none;" id="quiz_result"> <div></div> <p> 輸入名稱 <input id="quiz_testName" type="text"> </p> <button style="display: none;" id="quiz_sendResult"> 結果上傳 </button> <button style="display: none;" id="quiz_restart"> 再一次 </button> </div> <!-- body end-->';
if($fileHandle->file_save_html(10,$string))
echo "save success";
*/

echo "<br />test";

?>