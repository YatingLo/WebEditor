var Editor = new Object();
Editor.widgetId = 6;

var oldLoad = window.onload || function() {
};
window.onload = function() {
	oldLoad();
	$('#tabs').tabs();
	$('#saveHtml').click(saveDocument);

	$('#contentL').load("./widgets/" + Editor.widgetId + "/index.html",
			function() {

				// 隱藏不被編輯的內容
				$('#quiz_result').hide();
				$('#contentL button').hide();
				$(this).find('#widget_id').hide();
				// 內容排序
				$(this).find('ol').sortable({
					revert : true
				// 移動動畫
				});

				// 外觀設定
				setLook();
				// 刪除設定
				setRemove();
				// 物件不能選擇
				$("ul, li, h3").disableSelection();

				// 加入元件
				$('.quiz_sample li, .quiz_sample h3').draggable({
					connectToSortable : "#quiz_content ol",
					helper : "clone",
					revert : "invalid",
					stop : function() {
						setLook();
						setRemove();
					}
				});
			});
	
	/*
	 * 範本內容變更
	 */
	//標題
	$('#title_string').change(function(){
		$('#tabs-4 h3').html($(this).val());
	});
	
	//填空
	$('#blank_string').change(function(){
		$('#tabs-3 .quiz_string').html($(this).val());
	});
	$('#blank_answer').change(function(){
		var str = $('#blank_edit form').serialize();
		//alert(str);
		str = decodeURIComponent(str, true);
		$('#tabs-3 .quiz_ans').html(str);
	});
	$('#blank_comment').change(function(){
		$('#tabs-3 .quiz_comment').html($(this).val());
	});
	
	//單選
	$('#single_string').change(function(){
		$('#tabs-2 .quiz_string').html($(this).val());
	});
	$('#single_choice').change(function(){
		var str = $(this).val().split(',');
		var option = "";
		var option2 = "";
		//產生選擇器
		//$('#multi_edit').append("<form>答案 "+str[1]+"</form>"+str.length);
		for(var i=0; i<str.length; ++i){
			if(str[i] != ""){
				option += '<input type="radio" name="answer" value="'
					+str[i] + '">'+str[i];
				option2 += '<option>'+str[i];
			}
		}
		//alert(option);
		$('#tabs-2 .choice').html(option);
		$('#quiz_single2 .answer').html(option2);
		
		$('#single_edit form input').change(function(){
			var str = $('#single_edit form').serialize();
			str = decodeURIComponent(str, true);
			$('#tabs-2 .quiz_ans').html(str);
		});
	});
	$('#single_comment').change(function(){
		$('#tabs-2 .quiz_comment').html($(this).val());
	});
	
	//多選
	$('#multi_string').change(function(){
		$('#tabs-1 .quiz_string').html($(this).val());
	});
	$('#multi_answer').change(function(){
		var str = $(this).val().split(',');
		var option = "";
		//產生選擇器
		//$('#multi_edit').append("<form>答案 "+str[1]+"</form>"+str.length);
		for(var i=0; i<str.length; ++i){
			if(str[i] != ""){
				option += '<input type="checkbox" name="answer" value="'
					+str[i] + '">'+str[i];
			}
		}

		$('#tabs-1 .choice').html(option);
		
		$('#multi_edit form input').change(function(){
			var str = $('#multi_edit form').serialize();
			str = decodeURIComponent(str, true);
			$('#tabs-1 .quiz_ans').html(str);
		});
	});
	$('#multi_comment').change(function(){
		$('#tabs-1 .quiz_comment').text($(this).val());
	});
	
};

var saveDocument = function() {
	//alert($('#contentL').text());

	$('#contentSave').text($('#contentL').html());
	
};


var setLook = function() {
	// 外觀設置
	$('#quiz_content li, #quiz_content h3').css('border', '1px gray dashed');
	$("ul, li, h3").disableSelection();
};

var setRemove = function() {
	// 雙擊刪除
	$('#quiz_content li, #quiz_content h3').dblclick(function() {
		$(this).remove();
	});
};
