<?php

class FileUpload 
{	
    private $allowType   = array('jpg','gif','png'); 
    private $maxSize     = 1000000;  
    private $originName  = '';   	     
    private $tmpFileName = '';       
    private $fileType    = ''; 	     
    private $fileSize    = '';            
    private $newFileName = ''; 	      
    private $errorMess   = '';       
    private $errorNum    = 0;        


    /**
     * 调用该方法上传文件
     * @param	string	$fileFile	上传文件的表单名称 例如：<input type="file" name="myfile"> 参数则为myfile
     * @return	bool			 如果上传成功返回数true 
     */

    function uploadImage($fileField) 
    {
        $return   = true; //定义return flag
        $name     = $_FILES[$fileField]['name'];       //文件名
        $tmpName  = $_FILES[$fileField]['tmp_name'];   //临时文件名
        $size     = $_FILES[$fileField]['size'];       //文件大小
        $error    = $_FILES[$fileField]['error'];      //error

        if($this->setFiles($name , $tmpName , $size , $error)) 
        {
            if($this->checkFileSize() && $this->checkFileType())       //检查文件大小 和文件属性
            {	
                $this->setNewFileName();       //设置新文件名
                if($this->moveUploadFile())    //上传文件 
                { 
                    return true;
                }
                else
                {
                    $return = false;
                }
            }
            else
            {
                $return = false;
            }
        }
        else
        {
            $return = false;	
        }

        if(!$return)
        {
            $this->errorMess = $this->getError();
        }
        return $return;
    }

    /** 
     * 获取上传后的文件名称
     * @param	void	 没有参数
     * @return	string 	上传后，新文件的名称
     */
    public function getFileName()
    {
        return $this->newFileName;
    }

    /**
     * 上传失败后，调用该方法则返回，上传出错信息
     * @param	void	 没有参数
     * @return	string 	 返回上传文件出错的信息提示
     */

    public function getErrorMsg()
    {
        return $this->errorMess;
    }

    //设置上传出错信息
    private function getError() 
    {
        //$str = "上传文件<font color='red'>{$this->originName}</font>时出错 : ";
        switch ($this->errorNum) 
        {
        case 4 :
            $str .= "No Files Uploaded"; 
            break;
        case 3 :
            $str .= "Part of Files Uploads";
            break;
        case 2 :
            $str .= "Upload file size exceeds the the MAX_FILE_SIZE option value specified in the HTML form"; 
            break;
        case 1 :
            $str .= "上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值";
            break;
        case -1:
            $str .= "未允许类型";
            break;
        case -2:
            $str .= "文件过大,上传的文件不能超过{$this->maxSize}个字节";
            break;
        case -3:
            $str .= "上传失败"; 
            break;
        case -4:
            $str .= "建立存放上传文件目录失败，请重新指定上传目录";
            break;
        case -5:
            $str .= "必须指定上传文件的路径"; 
            break;
        default: 
            $str .= "未知错误";
        }
        return $str.'<br>';
    }


    //设置和$_FILES有关的内容
    private function setFiles($name = "", $tmpName = '' , $size = 0 , $error = 0) 
    {
        $this->setProtery('errorNum', $error);
        if($error)
        {
            return false;
        }
        $this->setProtery('originName', $name);                                    //赋值originName
        $this->setProtery('tmpFileName',$tmpName);                                 //赋值tmpFileName
        $fileArr = explode(".", $name); 
        $this->setProtery('fileType', strtolower($fileArr[count($fileArr)-1]));    //文件类型
        $this->setProtery('fileSize', $size);                                      //赋值文件大小
        return true;
    }

    //为单个成员属性设置值
    private function setProtery($key, $val) 
    {
        $this->$key = $val;
    }

    //设置上传后的文件名称
    private function setNewFileName() 
    {
        $this->setProtery('newFileName', $this->originName);
    }

    //检查上传的文件是否是合法的类型
    private function checkFileType() 
    {
        echo $this->fileType;
        if (in_array(strtolower($this->fileType), $this->allowType)) 
        {
            return true;
        }else 
        {
            $this->setProtery('errorNum', -1);
            return false;
        }
    }
    //检查上传的文件是否是允许的大小
    private function checkFileSize() 
    {
        if ($this->fileSize > $this->maxSize) 
        {
            $this->setProtery('errorNum', -2);
            return false;
        }
        else
        {
            return true;
        }
    }

    //检查是否有存放上传文件的目录
    private function checkFilePath() 
    {
        if(empty($this->path))
        {
            $this->setProtery('errorNum', -5);
            return false;
        }
        if (!file_exists($this->path) || !is_writable($this->path)) 
        {
            if (!@mkdir($this->path, 0755)) 
            {
                $this->setProtery('errorNum', -4);
                return false;
            }
        }

        return true;
    }

    //将文件放置在指定位置
    private function moveUploadFile() 
    {
        if(!$this->errorNum) 
        {
            $path = dirname(dirname(__FILE__)) . '/'; 
            $path .= $this->newFileName;
            if (@move_uploaded_file($this->tmpFileName, $path)) 
            {
                return true;
            }
            else
            {
                $this->setProtery('errorNum', -3);
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}
