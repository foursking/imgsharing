<?php

include "fileupload.php";

$fileupload = new FileUpload();
$res = $fileupload->uploadImage("simple");
echo $fileupload->getErrorMsg();

var_dump($res);

echo dirname(dirname(__FILE__));
?>
