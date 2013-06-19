var sendHandle = new Object();
sendHandle.wd_id = 10;
sendHandle.wd_type;
sendHandle.send_data;
sendHandle.send_url = "editor/handle-upload.php";
sendHandle.send_url = 'http://ytl-pc.com/widget/editor/handle-upload.php';

sendHandle.ac_listData = 'listData';
sendHandle.ac_listWidget = 'listWdgt';
sendHandle.ac_saveHtml = 'savehtml';
sendHandle.ac_proDownload = 'download';
sendHandle.ac_proDelete = 'delete';
sendHandle.ac_proNew = 'copy';

//function getValue(varname)
sendHandle.myPost = function(action, id, data, cfunction) {
	$.ajax({
        type: 'POST', 
        url: 'editor/handle-upload.php', 
        crossDomain: true,
        dataType: 'json',
        data: 'action='+action+'&id=' + id + '&data=' + data,
        success: function(json) {
            // and evoke client's function
            cfunction(json);
			alert(json.id);
        } 
    });
	//alert(data);
};

//function getValue(varname)
sendHandle.myGet = function(mjson, cfunction) {
	$.getJSON('editor/handle-gets.php', mjson, function(data) {
		 alert('成功回傳');
		 cfunction(data);
	});
};

sendHandle.getValue = function(varname) 
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