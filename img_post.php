<?php
require("config/database.php");


// // // // // // // // // // // // // //
//                                     //
// A function who keeps the Alpha      //
// canal on the imagecopymerge funtion.//
//                                     //
// // // // // // // // // // // // // //

function imagecopymerge_alpha($destination, $source, $destinationH, $destinationW, $sourceX, $sourceY, $sourceW, $sourceH, $fill)
{
	$proper = imagecreatetruecolor($sourceW, $sourceH);
	imagecopy($proper, $destination, 0, 0, $destinationH, $destinationW, $sourceW, $sourceH);
	imagecopy($proper, $source, 0, 0, 0, 0, $sourceW, $sourceH);
	imagecopymerge($destination, $proper, $destinationH, $destinationW, 0, 0, $sourceW, $sourceH, $fill);
}

// // // // // // // // // // // // // //
//                                     //
// Get the iamge uploaded by the user  //
// to replace the camera flux.         //
//                                     //
// // // // // // // // // // // // // //

$up = 0;
$dir = 'resources/';

if (isset($_FILES['upload']['name']))
	$data = $_FILES['upload']['name'];
else
	$data = "nodata";

$file = basename($data);
$ext_1 = array('.png', '.gif', '.jpg', '.jpeg');
$ext_2 = strrchr($data, '.');

if(!in_array($ext_2, $ext_1)) {
	$error = 'Please use an image file dude !';
}

if(!isset($error))
{
	$file = strtr($file,
	'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
	'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
	$file = preg_replace('/([^.a-z0-9]+)/i', '-', $file);
	if(move_uploaded_file($_FILES['upload']['tmp_name'], $dir . "upload.png")) {
		$up = 1;
	}

}


// // // // // // // // // // // // // //
//                                     //
// Stock the different images needed   //
// for the fusion.                     //
//                                     //
// // // // // // // // // // // // // //

if (isset($_POST['hidden_data'])) {
	$img = $_POST['hidden_data'];
}
else {
	$img = "nodata";
}

$img = str_replace('data:image/png;base64,', '', $img);

$filter = $_POST['hidden_filter'];

$imageData = base64_decode($img);

if ($up === 1)
{
	$destination = imagecreatefrompng("resources/upload.png");
}
else
{
	$destination = imagecreatefromstring($imageData);
}
$source = imagecreatefrompng($filter);

//  // // // // // // // // // // //  //
//                                    //
//  Get dimensions of pictures files. //
//                                    //
//  // // // // // // // // // // //  //

$destinationW = imagesx($destination);
$destinationH = imagesy($destination);
$sourceW      = imagesx($source);
$sourceH      = imagesy($source);



// // // // // // // // // // // // // //
//                                     //
// Put the filter on the photo taken   //
// and save the picture on the server. //
//                                     //
// // // // // // // // // // // // // //

imagecopymerge_alpha($destination, $source, $destinationH / 2.5, 0, 0, 0, $sourceW, $sourceH, 100);
imagepng($destination, "resources/fusion.png");


// // // // // // // // // // // // // //
//                                     //
// Upload the picture on the database  //
// in base64.                          //
//                                     //
// // // // // // // // // // // // // //

$sql_upload = "INSERT INTO web_pictures (id_user, img_encode, user_mail, creation_date)
VALUES (:id_user, :img_encode, :user_mail, :creation_date)";

$test = $_SESSION['auth']['id'];
$PDO->query("INSERT INTO log_request_wr (request) VALUES ('$test')");

$params = array(
	'id_user' => $_SESSION['auth']['id'],
	'img_encode' => base64_encode(file_get_contents("resources/fusion.png")),
	'user_mail' => $_SESSION['auth']['email'],
	'creation_date' => gmdate("y-m-d")

);
$ret = $PDO->prepare($sql_upload, $params);
header('Location:camagru.php');
?>
