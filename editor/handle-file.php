<?php
//phpinfo();
/*
 *檔案處理
*/
class HandleFile{
	//widget的id,type,目的檔案名稱，來源檔案名稱
	var $id, $type, $dFileName, $sFileName;
	var $aType;
	
	public function HandleFile(){
		
	}
	
	public function testData(){
		$post_data = array("json"=>"testback","id"=>0);
		return json_encode($post_data);
	}
	
	public function file_move_img($id, $sFileName, $dFileName) {
		$url_source = "../classes/Jupload/server/php/files/".$sFileName;
		$url_target = "../widgets/$id.wdgt/".$dFileName;
		
		if(!file_exists($url_source)){
			return false;
		}
		if(!rename($url_source, $url_target)){
			return false;
		}
	
		$myFile = "/classes/Jupload/server/php/files/thumbnail/" . $file_name;
		if (file_exists($myFile)) {
			unlink($myFile);
		} else {
			return false;
		}
	}
	public function file_copy_sample($id, $type){
		$url_source = "../widgets/".$this->aType[$type];
		$url_target = "../widgets/".$id.".wdgt";
		
		$this->copy_dir($url_source, $url_target);
      
        return $this->copy_dir($url_source, $url_target);
	}
	public function project_delete($id){
		$url = "../widgets/".$id.".wdgt";
		return $this->deleteDirectory($url);
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
	public function file_save_html($id, $fileString){
		$url = "../widgets/".$id.".wdgt/index.html";
		$dest =  fopen($url, 'w');
		//return stream_copy_to_stream($fileString, $dest);
		return file_put_contents($url, $fileString);
	}
	public function file_save_plist($id){
		
	}
	public function file_read_plist($id){
	}
	//資料夾處理
	public function copy_dir($from_dir,$to_dir){  
        if(!is_dir($from_dir)){  
            return false ;  
        }
        
        //echo "<br>From:",$from_dir,' --- To:',$to_dir;  
        $from_files = scandir($from_dir);  

        if(!file_exists($to_dir)){  
            mkdir($to_dir); // @mkdir($to_dir) << 跟這樣差異在哪!?     
        }  
        if( ! empty($from_files)){  
            foreach ($from_files as $file){  
                if($file == '.' || $file == '..' ){  
                    continue;  
                }  
                  
                if(is_dir($from_dir.'/'.$file)){
                    $this->copy_dir($from_dir.'/'.$file,$to_dir.'/'.$file);  
                }else{
                    copy($from_dir.'/'.$file,$to_dir.'/'.$file);  
                }  
            }  
        }
        return true ;
    }
	public function deleteDirectory($dir) {  
	if (!file_exists($dir)) return true;  
	if (!is_dir($dir) || is_link($dir)) return unlink($dir);  
		foreach (scandir($dir) as $item) {  
			if ($item == '.' || $item == '..') continue;  
			if (!$this->deleteDirectory($dir . "/" . $item)) {  
				chmod($dir . "/" . $item, 0777);  
				if (!$this->deleteDirectory($dir . "/" . $item)) return false;  
			};  
		}  
		return rmdir($dir);  
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