function del_picture(id, id_user)
{
  $.ajax(
    {
      url : "del_picture.php",
      type : "POST",
      data : 'id=' + id + '&id_user=' + id_user,
      success : function(result)
      {
        if (result != 1)
          alert("You're not able to delete this post !");
        else
          location.reload();
      },
    });
  }
