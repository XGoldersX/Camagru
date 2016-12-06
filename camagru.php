<?PHP
require("config/database.php");

if (!isset($_SESSION['auth']['username']))
	header('Location:auth.php');

require("header.php");
require("comment/Comment.class.php");
?>

<!DOCTYPE html>
<HTML lang="en" >
	<BODY>
		<BUTTON onclick="document.location.href='auth.php?logout'" style="display:block;margin-left:auto;" class="button_b">Logout</BUTTON>
		<!--This is the main block of the page with the video flux.-->
		<DIV class="main" style="display:inline-block;position:relative"><BR><BR/>
			<!--This is the upload feature for the user.-->
			<DIV style="display:block;margin-left:auto;margin-right:auto;" align="center">
				<FORM  method="post"          action="img_post.php" enctype="multipart/form-data">
					<INPUT name="upload"        type="file"           id="find_file"/>
					<INPUT name="hidden_filter" type="hidden"     		id='hidden_filter2'/>
					<INPUT name="submit"        type="submit"					id="upload" value="Start Upload"/>
				</FORM>
			</DIV>
			<!--This is the video return for the user from camera flux.-->
			<BUTTON  id="startbutton">Start</BUTTON>
			<VIDEO  id="video"></VIDEO>
			<CANVAS id="live" style="max-width:100%;max-height:100%;" class="" ></CANVAS><BR>
				<FORM    name="form1"         method="post"      action="#"        accept-charset="utf-8" >
					<INPUT name="hidden_filter" id='hidden_filter' type="hidden"/>
					<INPUT name="hidden_data"   id='hidden_data'   type="hidden"/>
				</FORM>
				<CANVAS  id="canvas"></CANVAS>
			</DIV>
			<!--This is the gallery block where pictures taken by users are stocked and
			where the social features are placed. (like, comment, delete)-->
			<DIV class="gallery" style="display:block;margin-left:auto;margin-right:auto;" align="center">
				<SCRIPT type="text/javascript" src="js/comment.js"/></SCRIPT>
				<?PHP
				$req = $PDO->query("SELECT * FROM web_pictures ORDER BY id DESC");
				// Get back all web_picture in web_pictures table
				// and displya like and unlike button
				?>
				<BR>
					<?PHP while ($img = $req->fetch(PDO::FETCH_ASSOC))
					{
						$comments = array();
						$result = $PDO->query(
						"SELECT comments.id, comments.body, comments.creation_date
						FROM comments
						WHERE id_web_picture = " . $img['id'] . "
						ORDER BY id ASC");

						// This is comment preparation for user display.

						while($row = $result->fetch(PDO::FETCH_ASSOC))
						$comments[] = new Comment($row);
						echo '<IMG  class="displayed" src="data:image/png;base64,' . $img['img_encode'] . '" />';?>
						<SCRIPT src="js/infinite_scroll.js"></SCRIPT>
						<DIV class="grid">
							<SPAN   id="status"></SPAN><BR>
								<BUTTON class="button_like"    id="like"   onClick="ft_like('<?PHP echo $img['id'];?>')"    value="<?PHP echo $img['id'];?>">
									<SPAN id="<?PHP echo $img['id'];?>l"><?php echo $img['nb_like'];?></SPAN>
								</BUTTON>
								<BUTTON class="button_unlike"  id="unlike" onClick="ft_unlike('<?PHP echo $img['id'];?>')"  value="<?PHP echo $img['id'];?>">
									<SPAN id="<?PHP echo $img['id'];?>"><?PHP echo $img['nb_unlike'];?></SPAN>
								</BUTTON>
								<SCRIPT type="text/javascript" src="js/like.js"></SCRIPT>
							</DIV>
							<BUTTON   class="button_trash"   id="trash"  onclick="del_picture('<?PHP echo $img['id']?>', '<?PHP echo $img['id_user']?>')"></BUTTON><BR><BR>
								<!--This is the commentary section, with the rendering and the sealing-date
								from the body filled.-->
								<DIV id="com<?php echo $img['id'];?>">
									<?php
									foreach($comments as $c)
									echo $c->date();
									?>
								</DIV>
								<DIV        id="addCommentContainer">
									<BUTTON   id="comment" class="button_b" onClick="add_comment('<?PHP echo $img['id']; ?>', '<?PHP echo date('d M Y H:i');?>')">Comment</BUTTON>
									<TEXTAREA id="body<?PHP echo $img['id'];?>" name="body" maxlenght="600"></TEXTAREA><BR>
									</DIV>
									<?PHP
								}?>
								<IMG id="photo">
								</DIV>
								<!--
								This is the filter part where you can choose a filter to put on the image
								source, from the camera flux or even the uploaded file.
							-->
							<DIV class="filter">
								<SCRIPT src="js/camera.js"></SCRIPT>
								<?PHP /* Display all filters in a div. */
								$dirname = "resources/filter/";
								$images = glob($dirname."*.png");
								foreach($images as $image)
								{?>
									<SPAN id="<?PHP echo $image;?>" onClick="ft_filter('<?PHP echo $image;?>')"><IMG src="<?PHP echo $image;?>"/></SPAN> <?PHP
								}?>
							</DIV>
							<!--
							This is the footer part whith some bulshit text.
						-->
						<DIV class="footer"><BR>UrMoM Company -  © 2016 </DIV>
							<!--
							Here are scripts includes needed for the good use of the javascpript
							utilisation.
						-->
						<SCRIPT type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></SCRIPT>
						<SCRIPT type="text/javascript" src="js/del_picture.js"></SCRIPT>
						<!-- <SCRIPT type="text/javascript" src="js/infinite_scroll.js"></SCRIPT> -->
					</BODY>
				</HTML>

<SCRIPT>

var hidden = 0;
function action()
{
	if(hidden == 0)
	{
		document.getElementById('upload').style.visibility = 'hidden';
		document.getElementById('startbutton').style.visibility = 'hidden';
		hidden = 1;
	}
	else
	{
		document.getElementById('upload').style.visibility = 'visible';
		document.getElementById('startbutton').style.visibility = 'visible';
	}
}

function ft_filter(img_name)
{
		var img = document.getElementById("resources/filter/1-lol.png");
		img.className = "";
		var img = document.getElementById("resources/filter/2-pepe.png");
		img.className = "";
		var img = document.getElementById("resources/filter/dodge.png");
		img.className = "";
		var img = document.getElementById("resources/filter/kanye.png");
		img.className = "";
		var img = document.getElementById("resources/filter/kim.png");
		img.className = "";
		var img = document.getElementById("resources/filter/spartan.png");
		img.className = "";
		action();

		var live = document.getElementById("live");
		if (img_name == "resources/filter/1-lol.png")
		live.className = "lol";
		else if (img_name == "resources/filter/2-pepe.png")
		live.className = "pepe";
		else if (img_name == "resources/filter/dodge.png")
		live.className = "dodge";
		else if (img_name == "resources/filter/kanye.png")
		live.className = "kanye";
		else if (img_name == "resources/filter/kim.png")
		live.className = "kim";
		else if (img_name == "resources/filter/spartan.png")
		live.className = "spartan";

		var img  = document.getElementById(img_name);
		img.classList.add("filter_click");

		document.getElementById("hidden_filter").value  = img_name;
		document.getElementById("hidden_filter2").value = img_name;
}
action();

</SCRIPT>
