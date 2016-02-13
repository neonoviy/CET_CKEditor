CKEDITOR.plugins.add( 'CETTypograf',
{
	init : function( editor )
	{
		// Add the link and unlink buttons.
		editor.ui.addButton( 'CETTypograf',
			{
				label : 'CETTypograf',
				icon : this.path + 'images/CETTypograf.gif',
				command : 'CETTypograf'
			} );
		editor.addCommand('CETTypograf', {exec:CETTypografProcess});
	}
} );

var CETTypografProcess = function (e) {
if(e.config.Typograf != 'Muravev'){
	var path = e.config.TypografPath+"plugins/CETTypograf/Lebedev/typo.php";
	console.log(e.config.Typograf+" Типограф Лебедева "+path);
}else{
	var path = e.config.TypografPath+"plugins/CETTypograf/Muravev/typo.php";
	console.log(e.config.Typograf+" Типограф Муравьева: "+path);
	}
	var selection = e.getSelection();
	if (CKEDITOR.env.ie) {
	  selection.unlock(true);
	  selection = selection.getNative().createRange().text;
	} else {
	  selection = selection.getNative();
	}
	if (selection != '') {
		var selectionHTML = getSelectionHTML(selection);
		//console.log(selectionHTML);
		sendData(path, selectionHTML, function(results){
			//onsole.log(results);
			e.insertHtml(results);
		});
	}else{
		var data = e.getData();
		if (data != '') {
			sendData(path, data, function(results){
				//console.log(results);
				e.setData(results);
			});
			
		}
	}
}


function sendData(url, data, callback) {
	var xhr = new XMLHttpRequest()
	xhr.onreadystatechange = function() {
		if (xhr.readyState==4) {
			if (xhr.status==200) {
				callback(xhr.responseText)  
			} else {
				callback(xhr.statusText)
			}
		}			
	}
	xhr.open("POST", url, true); 
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	xhr.send("text="+encodeURIComponent(data))
}

function getSelectionHTML(selection)
{
   var range = (document.all ? selection.createRange() : selection.getRangeAt(selection.rangeCount - 1).cloneRange());

   if (document.all)
   {
      return range.htmlText;
   }
   else
   {
      var clonedSelection = range.cloneContents();
      var div = document.createElement('div');
      div.appendChild(clonedSelection);
      return div.innerHTML;
   }
}