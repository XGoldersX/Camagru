function add_comment(id_img, heure)
{
	$.ajax(
	{
			url : "comment.php",
			type : "POST",
			data : 'body=' + $("#body" + id_img).val() + '&id_web_picture=' + id_img,
			dataType: "html",
			success : function(html_code)
			{
				var all = document.createElement("DIV");
				var date = document.createElement("DIV");
				var com = document.createElement("P");
				var body = document.createTextNode(html_code);
				var time_stamp = document.createTextNode(heure);
				com.appendChild(body);
				date.appendChild(time_stamp);
				date.className += "date";
				all.appendChild(date);
				all.appendChild(com);
				all.className += "comment";
				document.getElementById("com" + id_img).appendChild(all);
			},
	});
}
