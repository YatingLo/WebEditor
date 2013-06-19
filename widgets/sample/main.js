var oldLoad = window.onload || function () {};

window.onload = function (){
	oldLoad();

	var scene={};
  $.getJSON('test.json', function(data) { 
    scene=data;
    $('body').append(scene.StudentName);
    
  }); 
  
  
  

};