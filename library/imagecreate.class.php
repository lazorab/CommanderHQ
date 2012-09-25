<?php
/********************************************************
Global Class to render images for use on mobisites
Copyright Be-Mobile

Created By   : Darren Hart
Created Date : 10 December 2011

Last Modified Date: 23 January 2012

*********************************************************/


class ImageCreate
{
	function __construct($string)
	{
		$length = strlen($string);
		$offset = ceil(160 / $length);

		// create image
		$image = imagecreatetruecolor(640, 115);
        $bg = imagecolorallocate($image, 255, 255, 255);
		$yellow = imagecolorallocate($image, 255, 234, 0);
        
        // Draw a white rectangle
        imagefilledrectangle($image, 0, 0, 640, 115, $bg);

        $font = 'airstrip.ttf';

		imagettftext($image, 24, 0, $offset, 160, $yellow, $font, $string);
        
		// flush image
		imagepng($image, ''.FRAMEWORK_ROOT.'/content/images/53/'.$string.'_header.png');
		imagedestroy($image);
	}
}
