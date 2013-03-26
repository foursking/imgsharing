<?php

include "fileupload.php";
include "image.php";

$fileupload = new FileUpload();
$res = $fileupload->uploadImage("simple");
echo $fileupload->getErrorMsg();
$path = dirname(dirname(__FILE__)) . '/Uploads/images/';


$image = new Image($path);

$newName = $image->thumb("ceshi.jpg" , 100 , 100);

echo $newName;
var_dump($res);

?>
