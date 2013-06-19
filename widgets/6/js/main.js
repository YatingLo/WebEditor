/**
 * @author yatinglo
 */
//問題物件
var Quiz = function() {
	this.int_score = 0;
	this.int_perScore = 0;
	this.int_totalScore = 100;
	this.url_send = "http://localhost/test/upload/upload_widget_data.php";
};

//html完成時運行
var oldLoad = window.onload || function() {
};
window.onload = function() {
	$('#quiz_restart').click(fun_restart);
	$('#quiz_check').click(fun_checkAns);
	$('#quiz_sendResult').click(fun_sendResult);
	$('#quiz_result').hide();
	$('div.quiz_ans').hide();
	$('#widget_id').hide();
};
//去除字串中的空白
function trim(s) {
	return s.replace(/^\s*|\s*$/g, "")
}
//計算答題結果
var fun_checkAns = function() {
	// $("li div.quiz_string").html('我的問題');

	$('#quiz_content').hide();
	$('#quiz_result').show(500);

	var str_ans = "";
	var int_score = 0;
	var int_perScore = 100;
	var int_totalScore = 100;

	var ans = "";
	var gans = "";

	var int_numQuiz = 0;
	int_numQuiz = $('form').length;

	int_perScore = int_totalScore / int_numQuiz;

	$('form').each(function() {
		/*
		 * str_ans += "<br/>"+$(this).serialize(); str_ans +=
		 * $(this).find('div.quiz_ans').html();
		 */
		ans = $(this).serialize();
		ans = decodeURIComponent(ans, true);
		ans = trim(ans);
		// str_ans = str_ans.toString();
		gans = $(this).find('div.quiz_ans').text();
		gans = trim(gans);

		str_ans += "<br/>" + ans;
		str_ans += "***" + gans;

		if (gans == ans) {
			str_ans += "相同" + ans.length + "***" + gans.match(ans).length;
			int_score += int_perScore;
		} else {
			str_ans += "不同";
		}
	});
	// alert(ans);
	// str_ans = decodeURIComponent(str_ans, true);
	$('#quiz_result div').html(
			str_ans + "<br/>分數:<span id='quiz_score'>" + int_score + '</span>');
};
//再一次
var fun_restart = function() {
	$('#quiz_result').hide(500, function() {
		$('#quiz_content').show(500);
	});
};

var result = new Object();
result.score = 'score';
result.testName = 'name';
//上傳結果
var fun_sendResult = function() {
	result.score = $('#quiz_score').html();
	result.testName = $('#quiz_testName').val();

	var int_widgetId = $('#widget_id').html();

	var json_send = new Object();
	json_send.id = int_widgetId;
	json_send.data = JSON.stringify(result);
	//跨域上傳問題
	var request = createCORSRequest("get", "http://ytl-pc.com/widget/upload/upload_widget_data.php");
	if (request){
	    request.onload = function(){
	        alert(request.responseText);
	    };
	    request.send();
	}
	alert('結果:' + json_send.data + 'id:' + int_widgetId);
};

function createCORSRequest(method, url){
    var xhr = new XMLHttpRequest();
    if ("withCredentials" in xhr){
        xhr.open(method, url, true);
    } else if (typeof XDomainRequest != "undefined"){
        xhr = new XDomainRequest();
        xhr.open(method, url);
    } else {
        xhr = null;
    }
    return xhr;
}

var fun_loadJson = function() {
	$.get('Info.plist', function(data) {
		$('#readtest').text(data);
		alert('Load was performed.');
	});
};