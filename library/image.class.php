<?php
/********************************************************
Global Class to render images for use on mobisites
Copyright Be-Mobile

Created By   : Darren Hart
Created Date : 10 December 2011

Last Modified Date: 23 January 2012

*********************************************************/


class Image
{
    var $Image;
    var $RenderPath;
    var $Width;
    var $Height;
	
    function __construct()
    {
	$this->RenderPath = 'images/';
    }
	
	function Image($image, $ScreenWidth)
	{
		if(!file_exists(''.IMAGE_FILE_PATH.'/'.$image.''))
		{
		$ImageToRender = '';
		}
		else
		{
		$ImageName=explode(".",$image);
		$FileName = $ImageName[0];
		$Extension = $ImageName[1];
		$Size = getimagesize(''.IMAGE_FILE_PATH.'/'.$image.'', $info);
		$MasterWidth=$Size[0];
		$MasterHeight=$Size[1];

		if($MasterWidth > $ScreenWidth)
		{
			if($MasterWidth > 640)
				$ratio = $ScreenWidth / $MasterWidth;
			else
				$ratio = $ScreenWidth / 640;
		}
		else
		{
			$ratio = $ScreenWidth / 640;
		}	

		$NewWidth = floor($MasterWidth * $ratio);
		$NewHeight = floor($MasterHeight * $ratio);
		$this->Image = ''.IMAGE_FILE_PATH.'/'.$FileName.'_'.$NewWidth.'_'.$NewHeight.'.'.$Extension.'';
		$ImageToRender = '/'.$FileName.'_'.$NewWidth.'_'.$NewHeight.'.'.$Extension.'';
		
		if(!file_exists($this->Image))
		{			
			if (preg_match("/jpg|jpeg/",$Extension)){$src_img=imagecreatefromjpeg(''.IMAGE_FILE_PATH.'/'.$image.'');}
			if (preg_match("/png/",$Extension)){$src_img=imagecreatefrompng(''.IMAGE_FILE_PATH.'/'.$image.'');}
			if (preg_match("/gif/",$Extension)){$src_img=imagecreatefromgif(''.IMAGE_FILE_PATH.'/'.$image.'');}	
		
			$dst_img = ImageCreateTrueColor($NewWidth, $NewHeight);
			imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $NewWidth, $NewHeight, $MasterWidth, $MasterHeight);
			
        if (preg_match("/png/",$Extension))
        {
            imagepng($dst_img, $this->Image);
        } else {
            if (preg_match("/gif/",$Extension))
                imagegif($dst_img, $this->Image);
            else
                if (preg_match("/wbmp/",$Extension))
                    imagewbmp($dst_img, $this->Image);
                else
                    imagejpeg($dst_img, $this->Image);
        }			

			imagedestroy($dst_img);
			imagedestroy($src_img);	
		}
		}
		return ''.$this->RenderPath.''.$ImageToRender.'';
	}
    
    function NewImage($image, $ScreenWidth)
	{
		if(!file_exists(''.IMAGE_FILE_PATH.'/'.$image.''))
		{
            $ImageToRender = '';
		}
		else
		{
            $Size = getimagesize(''.IMAGE_FILE_PATH.'/'.$image.'', $info);
            $MasterWidth=$Size[0];
            $MasterHeight=$Size[1];
            
            if($MasterWidth > $ScreenWidth)
            {
                if($MasterWidth > 640)
                    $ratio = $ScreenWidth / $MasterWidth;
                else
                    $ratio = $ScreenWidth / 640;
            }
            else
            {
                $ratio = $ScreenWidth / 640;
            }	
            
            $Width = floor($MasterWidth * $ratio);
            $Height = floor($MasterHeight * $ratio);
		}
		return 'height="'.$Height.'" width="'.$Width.'"';
	}
    
    function BackgroundImage($image, $ScreenWidth)
	{
		if(!file_exists(''.IMAGE_FILE_PATH.'/'.$image.''))
		{
            $ImageToRender = '';
		}
		else
		{
            $Size = getimagesize(''.IMAGE_FILE_PATH.'/'.$image.'', $info);
            $MasterWidth=$Size[0];
            $MasterHeight=$Size[1];
            
            if($MasterWidth > $ScreenWidth)
            {
                if($MasterWidth > 640)
                    $ratio = $ScreenWidth / $MasterWidth;
                else
                    $ratio = $ScreenWidth / 640;
            }
            else
            {
                $ratio = $ScreenWidth / 640;
            }	
            
            $Width = floor($MasterWidth * $ratio);
            $Height = floor($MasterHeight * $ratio);
		}
		return "height:".$Height."px; width:".$Width."px; background-image:url('/images/".$image."');";
	}
}
