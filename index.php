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
	
	$("#img1").responsiveImg();
	$("#img2").responsiveImg({breakpoints:{"_400":400,"_200":200,"_800":800,"_600":600}});
	$("#img3").responsiveImg({breakpoints:{"_400":400,"_200":200,"_800":800,"_600":600},srcAttribute:"data-src"});
	
	$("img").click(function() {
		alert($(this).attr("src"));
	});
	
});

</script>

<h1>Responsive Img</h1>

<p>Specify a filename suffix that gets added to an image based on its container's width</p>

<p><em>Click an image to see its src attribute.</em></p>

<h2>Default</h2>
<p>Right now it defaults to 360 (_mobile),780 (_tablet) and 900 (_desktop) but soon it will be more correct mobile, tablet, desktop sizes.</p>
<code>$("#img1").responsiveImg();</code>
<div style="width:50%; border:2px dotted rgba(0,0,0,.5);">
	<img id="img1" src="images/image.png" style="max-width:100%;" />
</div>

<h2>Custom Breakpoints</h2>
<p>Specify sizes at which images should change, and have a custom suffix appended to image filenames for each breakpoint.</p>
<code>$("#img2").responsiveImg({breakpoints:{"_400":400,"_200":200,"_800":800,"_600":600}});</code>
<div style="width:40%; border:2px dotted rgba(0,0,0,.5);">
	<img id="img2" src="images/image.png" style="max-width:100%;" />
</div>

<h2>Use a Placeholder Image</h2>
<p>For faster loading, especially on mobile phones, you'll need to set the src attribute of all images to a loading icon or a small white pixel (or whatever you want, obviously). Then use another attribute (I recommend data-src to specify the path to the image file).</p>
<p>Unforutnately, the only way to prevent loading an src attribute is in the HTML. Even if we change it before the image loads, the original image still loads.</p>
<code>$("#img3").responsiveImg({breakpoints:{"_400":400,"_200":200,"_800":800,"_600":600},"srcAttribute":"data-src"});</code>
<div style="width:80%; border:2px dotted rgba(0,0,0,.5);">
	<img id="img3" src="images/ajax-loader.gif" data-src="images/image.png" style="max-width:100%;" />
</div>

</body>
</html>