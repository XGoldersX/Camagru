function ft_like(id)
{
	$.ajax(
	{
		url : "like.php",
		type : "POST",
		data : 'id=' + id + '&nb_like=' + $("#" + id).val() + '&like=1',
		dataType: "html",
		success : function(html_code, statut)
		{
			$('#' + id + 'l').html(html_code);
		},
		error : function(result, statut, error)
		{
			$('#' + id).html("ERR");
		}
	});
}

function ft_unlike(id)
{
	$.ajax(
	{
		url : "like.php",
		type : "POST",
		data : 'id=' + id + '&nb_unlike=' + $("#" + id).val() + '&unlike=1',
		dataType: "html",
		success : function(html_code, statut)
		{
			$('#' + id).html(html_code);
		},
		error : function(result, statut, error)
		{
			$('#' + id).html("ERR");
		}
	});
}
