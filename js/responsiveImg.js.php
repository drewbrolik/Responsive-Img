<?php /*
Responsive Img jQuery Plugin
Version 1.3
Mar 3rd, 2013

Documentation: http://responsiveimg.com
Repository: https://github.com/drewbrolik/Responsive-Img

Copyright 2012 - 2013 Drew Thomas and Brolik

Dual licensed under the MIT and GPL licenses:
https://github.com/jquery/jquery/blob/master/MIT-LICENSE.txt
http://www.gnu.org/licenses/gpl.txt

This file is part of Responsive Img.

Responsive Img is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Responsive Img is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Responsive Img.  If not, see <http://www.gnu.org/licenses/>.
*/ 

/*
Changelog
3/2/13   Fixed placeholder image bug: plugin will now switch to the original image if it's smaller than the breakpoint when using a placeholder image. Plugin also now fires on window load as well as resize (1.3)

12/22/12 Added a jpeg quality option (1.25)

12/20/12 Added support for pixel ratio, fixed an iOS bug (1.2)

11/26/12 Fixed image size up issue: plugin won't create new images that are larger than the original image (1.1)

10/20/12 Initial plugin (1)
*/ ?>
<?php

function makeImage($file_in,$file_out,$size,$orientation="",$jpegQuality=100) { //- function to make a new image
		
	// make sure it's valid
	list($w, $h, $type) = @getimagesize($file_in);
	if($w < 1) return false;
	
	$src_img = null;
	// find image type and create temp image and variable
	if ($type == IMAGETYPE_JPEG) {
		$src_img = @imagecreatefromjpeg($file_in);
	} else if ($type == IMAGETYPE_GIF) {
		$src_img = @imagecreatefromgif($file_in);
	} else if ($type == IMAGETYPE_PNG) {
		$src_img = @imagecreatefrompng($file_in);
	}
	if(!$src_img) return false;
	
	// choose which side to change the size of: width or height, based on parameter... if neither w or h, then use whichever is longer
	if ($orientation == "w") {
		$new_w = $size;
		$new_h = $h * ($size/$w);
	} else if ($orientation == "h") {
		$new_h = $size;
		$new_w = $w * ($size/$h);
	} else {
		if ($h > $w) {
			$new_h = $size;
			$new_w = $w * ($size/$h);
		} else {
			$new_w = $size;
			$new_h = $h * ($size/$w);
		}
	}
	
	// create temp image
	$tmp_img = imagecreatetruecolor($new_w, $new_h);
	$white = imagecolorallocate($tmp_img, 255, 255, 255);
	imagefill($tmp_img, 0, 0, $white);
	
	// make the new temp image all transparent
	imagecolortransparent($tmp_img, $white); 
	imagealphablending($tmp_img, false);
	imagesavealpha($tmp_img, true);
	
	// put uploaded image onto temp image
	imagecopyresampled($tmp_img, $src_img, 0,0,0,0,$new_w,$new_h,$w,$h);
	
	if ($type == IMAGETYPE_JPEG) {
		imagejpeg($tmp_img, $file_out, $jpegQuality);
	} else if ($type == IMAGETYPE_GIF) {
		imagegif($tmp_img, $file_out);
	} else if ($type == IMAGETYPE_PNG) {
		imagealphablending($tmp_img, false);
		imagesavealpha($tmp_img, true);
		imagepng($tmp_img, $file_out);
	}
	
	imagedestroy($tmp_img);
	return true;
}

if (isset($_REQUEST['makeImage'])) {
	
	$baseURL = $_REQUEST['baseURL'];
	$fileIn = $_REQUEST['fileIn'];
	$fileOut = $_REQUEST['fileOut'];
	$size = $_REQUEST['size'];
	$jpegQuality = $_REQUEST['jpegQuality'];
	
	$imageSize = getimagesize($baseURL.$fileIn); //- get the image's original size to prevent sizing up
	if ($size < $imageSize[0]) {
		makeImage($baseURL.$fileIn,$baseURL.$fileOut,$size,"w",$jpegQuality); //- make the new image!
		echo "1"; //- basically, return true
	} else {
		echo "0 target width is ".$size." and original width is ".$imageSize[0]; //- basically, return false
	}
		
}

?>