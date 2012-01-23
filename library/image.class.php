<?php
/********************************************************
Class to create an image for use on mobisite
Copyright Be-Mobile

Created By   : Darren Hart
Created Date : 10 December 2011

Last Modified Date: 10 December 2011

*********************************************************/


class Image
{
	var $Image;
	var $FilePath;
	
	function __construct($site)
	{
		$this->FilePath='/home/bemobile/public_html/'.$site.'';
    }
	
	function Image($image, $ScreenWidth)
	{
		if(!file_exists($image))
		{
		$this->Image = '';
		}
		else
		{
		$ImageName=explode(".",$image);
		$FileName = $ImageName[0];
		$Extension = $ImageName[1];
		$Size = getimagesize(''.$this->FilePath.''.$image.'', $info);
		$MasterWidth=$Size[0];
		$MasterHeight=$Size[1];

		if($MasterWidth > $ScreenWidth)
		{
			if($MasterWidth > 500)
				$ratio = $ScreenWidth / $MasterWidth;
			else
				$ratio = $ScreenWidth / 500;
		}
		else
		{
			$ratio = $ScreenWidth / 500;
		}	

		$NewWidth = floor($MasterWidth * $ratio);
		$NewHeight = floor($MasterHeight * $ratio);
		$this->Image = ''.$FileName.'_'.$NewWidth.'_'.$NewHeight.'.'.$Extension.'';
		if(!file_exists(''.$this->FilePath.'/'.$FileName.'_'.$NewWidth.'_'.$NewHeight.'.'.$Extension.''))
		{			
	        if (preg_match("/jpg|jpeg/",$Extension)){$src_img=imagecreatefromjpeg(''.$this->FilePath.''.$image.'');}
			if (preg_match("/png/",$Extension)){$src_img=imagecreatefrompng(''.$this->FilePath.''.$image.'');}
			if (preg_match("/gif/",$Extension)){$src_img=imagecreatefromgif(''.$this->FilePath.''.$image.'');}	
		
			//$src_img=imagecreatefrompng(''.$this->FilePath.''.$image.'');
			$dst_img = ImageCreateTrueColor($NewWidth, $NewHeight);
			$this->Image = ''.$FileName.'_'.$NewWidth.'_'.$NewHeight.'.'.$Extension.'';
			imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $NewWidth, $NewHeight, $MasterWidth, $MasterHeight);
			
        if (preg_match("/png/",$Extension))
        {
            imagepng($dst_img, ''.$this->FilePath.'/'.$this->Image.'');
        } else {
            if (preg_match("/gif/",$Extension))
                imagegif($dst_img, ''.$this->FilePath.'/'.$this->Image.'');
            else
                if (preg_match("/wbmp/",$Extension))
                    imagewbmp($dst_img, ''.$this->FilePath.'/'.$this->Image.'');
                else
                    imagejpeg($dst_img, ''.$this->FilePath.'/'.$this->Image.'');
        }			
			
			//imagepng($dst_img, ''.$this->FilePath.'/'.$this->Image.'');

			imagedestroy($dst_img);
			imagedestroy($src_img);	
		}
		}
		return $this->Image;
	}
}
