<?php

echo '<pre>';
var_dump($_FILES);
echo '</pre>';

if(!$_FILES['simple']['error'])
{

	//判断最大长度
	$maxSize=1000000;
	if($_FILES['simple']['size']>$maxSize){

		exit('对不起 文件超过最大长度');
	}

	//取得文件扩展名

	$name=$_FILES['simple']['name'];
	$str=explode('.',$name);
    $postfix=array_pop($str);
    echo $postfix;
	var_dump($postfix);
	
	//判断文件扩展名
	$postfixAllow=array('jpg','jpeg','gif','bmp','png');	
	if(!in_array($postfix,$postfixAllow)){

		exit('对不起 文件的扩展名不符合要求');	
	}
	
	//判断Mime匹配
	$mime=$_FILES['simple']['type'];
	$mimeAllow=array('image/jpeg','image/jpeg','image/jpg','image/gif','image/bmp');
	if(!in_array($mime,$mimeAllow)){
	
		exit('对不起 文件Mime不匹配');	

	}	

	
	$newPath=date('Y').'/'.date('m').'/'.date('d').'/';
	if(!file_exists($newPath)){
		mkdir($newPath,0777,true);
	}

	$newName=uniqid().'.'.$postfix;

	//判断文件是否是通过POST传递
	if(is_uploaded_file($_FILES['simple']['tmp_name'])){

		move_uploaded_file($_FILES['simple']['tmp_name'],$newPath.$newName);
		
		echo '上传成功';
	
	}else{
		exit('对不起 非法文件传递');
	
	}




}
else{

	switch($_FILES['simple']['error']){

		case 1:
		$string='错误1';
		break;
		
		case 2:
		$string='错误2';
		break;
		
		case 3:
		$string='错误3';
		break;
		
		case 4:
		$string='错误4';
		break;
		
		case 6:
		$string='错误6';
		break;
		
		case 7:
		$string='错误7';
		break;
	}

		echo $string;
}







?>
