<?php

echo '<pre>';
var_dump($_FILES);
echo '</pre>';

if(!$_FILES['simple']['error'])
{

	//�ж���󳤶�
	$maxSize=1000000;
	if($_FILES['simple']['size']>$maxSize){

		exit('�Բ��� �ļ�������󳤶�');
	}

	//ȡ���ļ���չ��

	$name=$_FILES['simple']['name'];
	$str=explode('.',$name);
    $postfix=array_pop($str);
    echo $postfix;
	var_dump($postfix);
	
	//�ж��ļ���չ��
	$postfixAllow=array('jpg','jpeg','gif','bmp','png');	
	if(!in_array($postfix,$postfixAllow)){

		exit('�Բ��� �ļ�����չ��������Ҫ��');	
	}
	
	//�ж�Mimeƥ��
	$mime=$_FILES['simple']['type'];
	$mimeAllow=array('image/jpeg','image/jpeg','image/jpg','image/gif','image/bmp');
	if(!in_array($mime,$mimeAllow)){
	
		exit('�Բ��� �ļ�Mime��ƥ��');	

	}	

	
	$newPath=date('Y').'/'.date('m').'/'.date('d').'/';
	if(!file_exists($newPath)){
		mkdir($newPath,0777,true);
	}

	$newName=uniqid().'.'.$postfix;

	//�ж��ļ��Ƿ���ͨ��POST����
	if(is_uploaded_file($_FILES['simple']['tmp_name'])){

		move_uploaded_file($_FILES['simple']['tmp_name'],$newPath.$newName);
		
		echo '�ϴ��ɹ�';
	
	}else{
		exit('�Բ��� �Ƿ��ļ�����');
	
	}




}
else{

	switch($_FILES['simple']['error']){

		case 1:
		$string='����1';
		break;
		
		case 2:
		$string='����2';
		break;
		
		case 3:
		$string='����3';
		break;
		
		case 4:
		$string='����4';
		break;
		
		case 6:
		$string='����6';
		break;
		
		case 7:
		$string='����7';
		break;
	}

		echo $string;
}







?>
