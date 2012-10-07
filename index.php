<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Responsive Img - a jQuery Plugin</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.js"></script>
<script src="js/responsiveImg.js"></script>
<!-- <link type="text/css" rel="stylesheet" href="style.css" /> -->
</head>

<body>

<script>

$(function() {
	
	//$("img").responsiveImg();
	$("img").responsiveImg({"_400":400,"_200":200,"_800":800,"_600":600});
	
	
});

</script>

<h1>Responsive Img</h1>

<p>Specify a filename suffix that gets added to an image based on its container's width</p>
<code>$("img").responsiveImg({"_400":400,"_200":200,"_800":800});</code>

<br /><br />

<div style="width:20%; border:2px dotted rgba(0,0,0,.5);">
	<img src="images/image.png" style="max-width:100%;" />
</div>
<div style="width:80%; border:2px dotted rgba(0,0,0,.5);">
	<img src="images/image.png" style="max-width:100%;" />
</div>

</body>
</html>