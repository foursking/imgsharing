<?php
/*=============================================================================
#     FileName: image.php
#   CreateTime: 2013-03-26 19:04:37 
#       Author: yifeng@leju.com
#   LastChange: 2013-03-26 19:04:37
=============================================================================*/

	class Image 
	{
		protected $path;   //图片所在的路径

        function __construct($path="")
        {
			$this->path=$path;
        }

		function thumb($name , $width , $height , $prefix = "th_" , $flag = true)
		{
			$imageInfo = $this->getImageInfo($name);                                     //获取图片信息
			$srcImage  = $this->getImageRes($name, $imageInfo);                          //获取图片资源         
			$size      = $this->getNewSize($name , $width , $height , $imageInfo);       //获取新图片尺寸
			$newImage  = $this->kidOfImage($srcImage , $size , $imageInfo);              //获取新的图片资源
            if ($flag) 
             {
		      	return $this->createNewImage($newImage , $prefix.$name , $imageInfo);            //返回新生成的缩略图的名称，以"th_"为前缀
             }
		}
		
		// 获取图片的信息
		private function getImageInfo($name) 
		{
			$this->path=rtrim($this->path,"/")."/";
			$data	= getimagesize($this->path.$name);
			$imageInfo["width"]	= $data[0];
			$imageInfo["height"]    = $data[1];
			$imageInfo["type"]	= $data[2];

			return $imageInfo;		
		}

		// 创建图像资源 
		private function getImageRes($name, $imageInfo)
		{
			$this->path=rtrim($this->path,"/")."/";
			$srcPic=$this->path.$name;
			
			switch ($imageInfo["type"]) 
			{
				case 1:	//gif
					$image = imagecreatefromgif($srcPic);
					break;
				case 2:	//jpg
					$image = imagecreatefromjpeg($srcPic);
					break;
				case 3:	//png
					$image = imagecreatefrompng($srcPic);
					break;
				default:
					return false;
					break;
			}
			return $image;
		}
		
		//返回等比例缩放的图片宽度和高度，如果原图比缩放后的还小保持不变
		private function getNewSize($name, $width, $height,$imageInfo){	
			$size["width"]=$imageInfo["width"];          //将原图片的宽度给数组中的$size["width"]
			$size["height"]=$imageInfo["height"];        //将原图片的高度给数组中的$size["height"]
			
			if($width < $imageInfo["width"])
			{
				$size["width"]=$width;             //缩放的宽度如果比原图小才重新设置宽度
			}

			if($height < $imageInfo["height"])
			{
				$size["height"]=$height;            //缩放的高度如果比原图小才重新设置高度
			}

            if($imageInfo["width"]*$size["width"] > $imageInfo["height"] * $size["height"])
            {
				$size["height"]=round($imageInfo["height"]*$size["width"]/$imageInfo["width"]);
            }
            else
            {
				$size["width"]=round($imageInfo["width"]*$size["height"]/$imageInfo["height"]);
			}

			return $size;
		}	



        private function createNewImage($newimage, $newName, $imageInfo)
        {
			$this->path=rtrim($this->path,"/")."/";
			switch ($imageInfo["type"]) 
			{
		   		case 1:	//gif
					$result=imageGIF($newimage, $this->path.$newName);
					break;
				case 2:	//jpg
					$result=imageJPEG($newimage,$this->path.$newName);  
					break;
				case 3:	//png
					$result=imagePng($newimage, $this->path.$newName);  
					break;
			}
			imagedestroy($newimage);
			return $newName;
		}

		private function copyImage($groundimage, $waterimage, $pos, $waterInfo)
		{
			imagecopy($groundimage, $waterimage, $pos["posX"], $pos["posY"], 0, 0, $waterInfo["width"],$waterInfo["height"]);
			imagedestroy($waterimage);
			return $groundimage;
		}

        private function kidOfImage($srcimage,$size, $imageInfo)
        {
			$newimage = imagecreatetruecolor($size["width"], $size["height"]);		
			$otsc = imagecolortransparent($srcimage); //将某个颜色定义为透明色
            if( $otsc >= 0 && $otsc < imagecolorstotal($srcimage)) 
            {  //取得一幅图像的调色板中颜色的数目
		  		 $transparentcolor = imagecolorsforindex( $srcimage, $otsc ); //取得某索引的颜色
		 		 $newtransparentcolor = imagecolorallocate($newimage,$transparentcolor['red'],$transparentcolor['green'],$transparentcolor['blue']);
		  		 imagefill( $newimage, 0, 0, $newtransparentcolor );
		  		 imagecolortransparent( $newimage, $newtransparentcolor );
            }

			imagecopyresized( $newimage, $srcimage, 0, 0, 0, 0, $size["width"], $size["height"], $imageInfo["width"], $imageInfo["height"] );
			imagedestroy($srcimage);
			return $newimage;
		}

	}
