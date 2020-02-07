<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
 
    session_start();
    header('Content-type: image/jpeg');
	
	$font_size = 20;
	
	$img_width = 100;
	$img_height = 40;
	
	$image = imagecreate($img_width,$img_height);
	imagecolorallocate($image, 255, 255, 255);
	
	$text_color = imagecolorallocate($image, 0, 0, 0);
	
	for($x=1; $x<=30; $x++) 
	{
		$x1 = rand(1,100);
		$y1 = rand(1,100);
		$x2 = rand(1,100);
		$y2 = rand(1,100);
		
		imageline($image, $x1, $y1, $x2, $x2, $text_color);
	}
	
	imagettftext($image, $font_size, 0, 15, 30, $text_color, 'arial.ttf', $_SESSION['captcha_numero']);
	imagejpeg($image);

?>