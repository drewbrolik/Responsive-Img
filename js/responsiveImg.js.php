<?php

function makeImage($file_in,$file_out,$size,$orientation="") { //- function to make a new image
		
	// make sure it's valid
	list($w, $h) = @getimagesize($file_in);	
	if($w < 1) return false;
	
	// find image type and create temp image and variable
	if (exif_imagetype($file_in) == IMAGETYPE_JPEG) {
		$src_img = @imagecreatefromjpeg($file_in);
	} else if (exif_imagetype($file_in) == IMAGETYPE_GIF) {
		$src_img = @imagecreatefromgif($file_in);
	} else if (exif_imagetype($file_in) == IMAGETYPE_PNG) {
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
	
	if (exif_imagetype($file_in) == IMAGETYPE_JPEG) {
		imagejpeg($tmp_img, $file_out, 100);
	} else if (exif_imagetype($file_in) == IMAGETYPE_GIF) {
		imagegif($tmp_img, $file_out);
	} else if (exif_imagetype($file_in) == IMAGETYPE_PNG) {
		imagealphablending($tmp_img, false);
		imagesavealpha($tmp_img, true);
		imagepng($tmp_img, $file_out);
	}
	
	imagedestroy($tmp_img);
	return true;
}

if (isset($_REQUEST['makeImage'])) {
	
	makeImage("../".$_REQUEST['fileIn'],"../".$_REQUEST['fileOut'],$_REQUEST['size'],"w"); //- make the new image!
		
}

?>