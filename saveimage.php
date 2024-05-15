<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization");

require_once 'database/con_db.php';


$filename =  time() . '.jpg';
$filepath = 'static/facialReg_captured/';
if(!is_dir($filepath))
	mkdir($filepath);
if(isset($_FILES['webcam'])){	
	move_uploaded_file($_FILES['webcam']['tmp_name'], $filepath.$filename);
	$sql="Insert into camera(camera_upload) values('$filename')";
	$result=mysqli_query($con,$sql);
	echo $filepath.$filename;
}
?>
