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
	function __Construct()
        {
            
        }
        
	function Image($MasterImage)
	{
            if(!file_exists(''.IMAGE_FILE_PATH.'/'.LAYOUT_WIDTH.'/'.$MasterImage.''))
            {
		$ImageToRender = '';
            }
            else
            {
		$ImageName=explode(".",$MasterImage);
		$FileName = $ImageName[0];
		$Extension = $ImageName[1];
		$Size = getimagesize(''.IMAGE_FILE_PATH.'/'.LAYOUT_WIDTH.'/'.$MasterImage.'', $info);
		$MasterWidth=$Size[0];
		$MasterHeight=$Size[1];

		if(LAYOUT_WIDTH > SCREENWIDTH)
		{
                    $ratio = SCREENWIDTH / LAYOUT_WIDTH;
		}
		else if(SCREENWIDTH > LAYOUT_WIDTH)
		{
                    $ratio = LAYOUT_WIDTH / SCREENWIDTH;
		}
                else
                    $ratio = 1;	

		$NewWidth = floor($MasterWidth * $ratio);
		$NewHeight = floor($MasterHeight * $ratio);
		$Image = ''.IMAGE_FILE_PATH.'/'.LAYOUT_WIDTH.'/'.$FileName.'_'.$NewWidth.'_'.$NewHeight.'.'.$Extension.'';
		$ImageToRender = ''.$FileName.'_'.$NewWidth.'_'.$NewHeight.'.'.$Extension.'';
		
		if(!file_exists($Image))
		{			
			if (preg_match("/jpg|jpeg/",$Extension)){$src_img=imagecreatefromjpeg(''.IMAGE_FILE_PATH.'/'.LAYOUT_WIDTH.'/'.$MasterImage.'');}
			if (preg_match("/png/",$Extension)){$src_img=imagecreatefrompng(''.IMAGE_FILE_PATH.'/'.LAYOUT_WIDTH.'/'.$MasterImage.'');}
			if (preg_match("/gif/",$Extension)){$src_img=imagecreatefromgif(''.IMAGE_FILE_PATH.'/'.LAYOUT_WIDTH.'/'.$MasterImage.'');}	
		
			$dst_img = ImageCreateTrueColor($NewWidth, $NewHeight);
			imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $NewWidth, $NewHeight, $MasterWidth, $MasterHeight);
			
        if (preg_match("/png/",$Extension))
        {
            imagepng($dst_img, $Image);
        } else {
            if (preg_match("/gif/",$Extension))
                imagegif($dst_img, $Image);
            else
                if (preg_match("/wbmp/",$Extension))
                    imagewbmp($dst_img, $Image);
                else
                    imagejpeg($dst_img, $Image);
        }			

			imagedestroy($dst_img);
			imagedestroy($src_img);	
		}
		}
		return $ImageToRender;
	}
    
    function NewImage($MasterImage)
	{
            $Height = 0;
            $Width = 0;
            if(file_exists(''.IMAGE_FILE_PATH.'/'.LAYOUT_WIDTH.'/'.$MasterImage.''))
            {
		$Size = getimagesize(''.IMAGE_FILE_PATH.'/'.LAYOUT_WIDTH.'/'.$MasterImage.'', $info);
		$MasterWidth=$Size[0];
		$MasterHeight=$Size[1];

		if(LAYOUT_WIDTH > SCREENWIDTH)
		{
                    $ratio = SCREENWIDTH / LAYOUT_WIDTH;
		}
		else if(SCREENWIDTH > LAYOUT_WIDTH)
		{
                    $ratio = LAYOUT_WIDTH / SCREENWIDTH;
		}
                else
                    $ratio = 1;
            $Width = floor($MasterWidth * $ratio);
            $Height = floor($MasterHeight * $ratio);
                
		}
		return 'height="'.$Height.'" width="'.$Width.'"';
	}
        
     function ImageSandwich($MiddleImage, $LeftImage, $RightImage)
	{
		$Size = getimagesize(''.IMAGE_FILE_PATH.'/'.LAYOUT_WIDTH.'/'.$LeftImage.'', $info);
		$LeftWidth=floor($Size[0]);
		$LeftHeight=floor($Size[1]);
                
  		$Size = getimagesize(''.IMAGE_FILE_PATH.'/'.LAYOUT_WIDTH.'/'.$RightImage.'', $info);
		$RightWidth=floor($Size[0]);
		$RightHeight=floor($Size[1]);  
                
                $Size = getimagesize(''.IMAGE_FILE_PATH.'/'.LAYOUT_WIDTH.'/'.$MiddleImage.'', $info);
		
		$MiddleHeight=floor($Size[1]);

		if(LAYOUT_WIDTH > SCREENWIDTH)
		{
                    $ratio = SCREENWIDTH / LAYOUT_WIDTH;
		}
		else if(SCREENWIDTH > LAYOUT_WIDTH)
		{
                    $ratio = LAYOUT_WIDTH / SCREENWIDTH;
		}
                else
                    $ratio = 1;
                
            $LeftWidth = floor($LeftWidth * $ratio);
            $LeftHeight = floor($LeftHeight * $ratio);
            $RightWidth = floor($RightWidth * $ratio);
            $RightHeight = floor($RightHeight * $ratio);
            $MiddleWidth= SCREENWIDTH - $LeftWidth - $RightWidth;
            $MiddleHeight = floor($MiddleHeight * $ratio);           
		
            return 'height="'.$MiddleHeight.'" width="'.$MiddleWidth.'"';
	}       
    
    function BackgroundImage($MasterImage,$Height,$Width)
	{
            if(file_exists(''.IMAGE_FILE_PATH.'/'.LAYOUT_WIDTH.'/'.$MasterImage.''))
            {
		$Size = getimagesize(''.IMAGE_FILE_PATH.'/'.LAYOUT_WIDTH.'/'.$MasterImage.'', $info);
		$MasterWidth=$Size[0];
		$MasterHeight=$Size[1];

		if(LAYOUT_WIDTH > SCREENWIDTH)
		{
                    $ratio = SCREENWIDTH / LAYOUT_WIDTH;
		}
		else if(SCREENWIDTH > LAYOUT_WIDTH)
		{
                    $ratio = LAYOUT_WIDTH / SCREENWIDTH;
		}
                else
                    $ratio = 1;
                
            if($Height > 0){
                $NewHeight = floor($Height * $ratio);
            }else{
                $NewHeight = floor($MasterHeight * $ratio);
            }
            
             if($Width > 0){
                $NewWidth = floor($Width * $ratio);
            }else{
                $NewWidth = floor($MasterWidth * $ratio);
            }           
		}
		return "height:".$NewHeight."px; width:".$NewWidth."px; background-image:url('".IMAGE_FILE_PATH."/".LAYOUT_WIDTH."/".$MasterImage."');";
	}
}
