/*
 * plist 變數值
 * 根據plist值顯示表單，表單編輯後儲存成plist file
 */

var json_value = new Object();
var int_WidgetId = 11;
var str_imgPath = "./widgets/sample/Default.png";
var str_bundle = "com.apple.widget.";


getValue = function(varname) 
{
  var url = window.location.href;
  var qparts = url.split("?");
  if (qparts.length == 0){return "";}
  var query = qparts[1];
  var vars = query.split("&amp;");
  var value = "";
  for (i=0; i<vars.length; i++)
  {
	var parts = vars[i].split("=");
	if (parts[0] == varname)
	{
	  value = parts[1];
	  break;
	}
  }
  value = unescape(value);
  value.replace(/\+/g," ");
  return value;
};

var func_setForm = function(height, name, label, img) {
	(height == 768) ? $('#radio_Layout_1').attr('checked', true) : $(
			'#radio_Layout_0').attr('checked', true);
	$('#text_Name').val(name);
	$('#text_Label').val(label);
	if (img === "default") {
		$(':input#text_Icon').attr('value', img);
	}
	
};
/*
 * 儲存編輯結果
 */
var savePlist = function() {
	var layout = $('[name="Layout"]:checked').val();
	if (layout == 'vertical') {
		json_value.Height = 1024;
		json_value.Width = 768;
		// $('body').append(json_value.Height);
	} else {
		json_value.Height = 768;
		json_value.Width = 1024;
		// $('body').append(json_value.Height);
	}

	var name = $('[name="Name"]:input').val();
	var label = $('[name="Label"]:input').val();
	var indent = json_value.CFBundleIdentifier;

	// 用原本的label替換辨識標籤
	indent = indent.replace(json_value.CFBundleName, label);
	json_value.CFBundleIdentifier = indent;
	json_value.CFBundleDisplayName = name;
	json_value.CFBundleName = label;

	/*
	$('body').append("<br />name:" + name);
	$('body').append("<br />label:" + label);
	$('body').append("<br />indentifier:" + json_value.CFBundleIdentifier);
	*/

	// json處理，加入mode
	// json_value.mode = 'save';
	// alert(JSON.stringify(json_value));

	var json_send = new Object();
	json_send.mode = 'save';
	json_send.wdid = int_WidgetId;
	json_send.data = JSON.stringify(json_value);
	// alert(json_send.data);

	$.getJSON('editor/get-info.php', json_send, function(data) {
		// alert(data.data);
		// alert('success');
		// int_Height = data.Height;
		// func_setForm(data.Height,data.CFBundleDisplayName,data.CFBundleName,"default");
	});
};


var oldLoad = window.onload || function() {
};
window.onload = function() {
	oldLoad();

	//alert(getValue('ID'));
	if(getValue('ID') != ""){
		int_WidgetId = getValue('id');
	}
	/*
	 * input限制 lable只能英文字母 name不限定 <input
	 * onkeyup="value=value.replace(/[\W]/g,'') "
	 * onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"
	 * id="Text1" name="Text1">
	 */
	$('input[name="Label"]').inputLetter();
	
	//$('img').attr('src',str_imgPath);

	// $('input[name!="Label"]').inputLetterSpace();


	/*
	 * 用ajax接收從php檔案輸出的json物件 // 根據html和php的想對位置
	 */
	$.getJSON('editor/get-info.php', {
		mode : 'read',
		wdid : int_WidgetId
	}, function(data) {
		 
		$('body').append(data.json);
		json_value = JSON.parse(data.json);
		//int_WidgetId = data.id;
		alert(json_value.CFBundleDisplayName);
		func_setForm(json_value.Height, json_value.CFBundleDisplayName,
				json_value.CFBundleName, "default");
					
		var path = "./widgets/"+int_WidgetId+".wdgt/Default.png";
		$('img').attr('src',path);
	});
	
	
	
	/*jslint unparam: true */
	/*global window, $ */
	/*https://github.com/blueimp/jQuery-File-Upload*/
	$(function() {'use strict';
		// Change this to the location of your server-side upload handler:
		var url = (window.location.hostname === 'blueimp.github.com' || window.location.hostname === 'blueimp.github.io') ? '//jquery-file-upload.appspot.com/' : 'classes/Jupload/server/php/';
		$('#fileupload').fileupload({
			url : url,
			dataType : 'json',
			done : function(e, data) {
				$.each(data.result.files, function(index, file) {
					//$('<p/>').text(file.name).appendTo('#files');
					//var path_img = "../classes/Jupload/server/php/files/" + file.name;
					//alert(file.name);

					var json_send = new Object();
					json_send.mode = 'test';
					json_send.data = file.name;

					//alert(JSON.stringify(json_send));

					$.getJSON('editor/get-info.php', {
						mode : 'move',
						file : file.name,
						id   : int_WidgetId
					}, function(data) {
						alert(data.id);
						//alert(url);
						var int_widgetId = data.id;
						var path = "./widgets/"+int_WidgetId+".wdgt/Default.png";
						$('#icon').attr('src',path);
					});
				});
			}
		});

	});
};
