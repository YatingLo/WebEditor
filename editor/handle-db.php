<?php
 //phpinfo();
include_once("mysql.inc.php");

class HandleDB{
	
	var $tbType = "wd_widget_type";
	var $tbWidget = "wd_widgets";
	var $tbData = "wd_widget_data";
	
	var $testData = '{"name":"你好", "score": 25}';
	
	public function HandleDB(){
	}
		
	public function sql_select($tableName) {
		//echo "<table>";
		//$tableName = "wd_widgets";
		$sql = "SELECT * FROM ".$tableName;
		$result = mysql_query($sql);
		
		return $result;
		/*
		while($row =  mysql_fetch_array($result)){
			echo "<tr><td>{$row[0]} </td><td> $row[2] </td></tr>";
		}
			echo "<table>";
		return $result;
		*/
	}
	public function sql_select_databyid($wdid){
		$sql = "SELECT * FROM wd_widget_data ";
		$sql = $sql."WHERE wd_id ='"+$wdid+"'";
		$result = mysql_query($sql);
		return $result;
	}
	
	/*新增之後回傳auto產生的id值
	*種類、部件、部件資料
	*/
	public function sql_insert_type($name, $type) {
			$sql = "INSERT INTO wd_widget_type (id ,name) VALUES (NULL, '".$type."')";
			if(@mysql_query($sql)){
				return mysql_insert_id();
			} else {
				return false;
			}
	}
	public function sql_insert_widget($name, $type) {
			$taiwan =  mktime(date('H')+14, date('i'), date('s'), date('m'), date('d'), date('Y'));
			$time = date("Y-m-d H:i:s", $taiwan);
			$sql = "INSERT INTO wd_widgets (name, type_id, date) ";
			$sql = $sql."VALUES ('".$name."',".$type.",'".$time."')";
			if(@mysql_query($sql)){
				return mysql_insert_id();
			} else {
				return false;
			}
	}
	public function sql_insert_data($id, $data) {
			//時區設定
			$taiwan =  mktime(date('H')+14, date('i'), date('s'), date('m'), date('d'), date('Y'));
			$time = date("Y-m-d H:i:s", $taiwan);
			$sql = "INSERT INTO wd_widget_data (wd_id,data,date) ";
			$sql = $sql."VALUES (".$id.",'".$data."','".$time."')";
			if(@mysql_query($sql)){
				return mysql_insert_id();
			} else {
				return false;
			}
	}
	/*新增之後回傳auto產生的id值
	*部件、部件資料
	*/
	public function sql_delete_widget($id){
		$sql = "DELETE FROM wd_widgets WHERE id = $id";
		$result = mysql_query($sql);
		return $result;
	}
	//刪除資訊
	public function sql_delete_data($id){
		$sql = "DELETE FROM wd_widget_data WHERE id = $id";
		$result = mysql_query($sql) or die(mysql_error());
		return $result;
	}
	
	//修改名稱
	public function sql_update_widget($id, $name){
		$sql = "INSERT INTO wd_widgets (wd_id,data,date) ";
		$sql = $sql."VALUES (".$id.",'".$data."','".$time."')";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function show_table($result){
		echo "<table>";
		while($row =  mysql_fetch_array($result)){
			$table = "<tr>";
			for($i = 0; $i < count($row); $i+=1){
				$table = $table."<td>{$row[".$i."]} </td>";
			}
			$table = $table."</tr>";
			echo $table;
		}
		echo "</table>";
	}
	//sql obejct to json
	public function mysql2json($result){
	     while($row=mysql_fetch_assoc($result)){
			$output[]=$row;
		 }
	     return(json_encode($output));
	}
}
?>