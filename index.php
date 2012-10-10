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
	$("#img2,#img3").responsiveImg({breakpoints:{"_400":400,"_200":200,"_800":800}});
	$("#img4").responsiveImg({srcAttribute:"data-src"});
	
	$("img").click(function() {
		alert($(this).attr("src"));
	});
	
});

</script>

<style type="text/css">

	strong	{ background:#FFECC1; }

</style>

<h1>Responsive Img</h1>

<p>Responsive Img lets you specify breakpoints where an img tag should load a different souce file, based on the tag's container width.</p>
<p>For each breakpoint, you choose a suffix to be added to the end of the image's filename. If an image with the new filename already exists, Responsive Img replaces the img tag's source attribute with the new filename.</p>
<p style="font-weight:bold;">If the image doesn't exist, Responsive Img will create that image with the new filename and put in the same folder as the original image. Once created, Responsive Img can just replace the img tag's source for all visitors in the future.</p>
<p>Up to this point, there <strong>is no need to change any html markup.</strong> You can make any existing website have responsive images with one include and one line of code.</p>
<p>But there's one drawback. The original image file will always get loaded (even though Responsive Img swaps in a smaller image right away). To prevent this, we do need to change a little markup. Just set the img tag's source attribute to a loading image or a single pixel image, set another attribute (like data-src) as the image filename, and specify "srcAttribute":"data-src" when you call the plugin.</p>
<p>That's it. Responsive images.</p>

<p style="font-style:italic;">Click an image to see its src attribute.</p>

<h2>Default</h2>
<p>If no options are specified, Responsive Img defaults to breakpoints at 360 pixels (with the suffix "_small"), 780 pixels ("_medium") and 900 pixels ("_large").</p>
<p><code>$("#img1").responsiveImg();</code></p>
<div style="width:50%;">
	<img id="img1" src="images/windowImage.jpg" style="max-width:100%;" />
</div>

<h2>Custom Breakpoints</h2>
<p>Specify custom breakpoints, each with a custom suffix.</p>
<p>This is useful if you actually need to change the image at certain breakpoints, rather than just resize it. (Remember, you can create the image manually and put it on the server, and Responsive Img will automatically use that instead of creating a new one.)</p>
<p><code>$("#img2,#img3").responsiveImg({
	breakpoints:{
    	"_400":400,
        "_200":200,
        "_800":800
    }
});</code></p>
<div style="width:50%; float:left;"><img id="img2" src="images/image.png" style="max-width:98%;" /></div>
<div style="width:50%; float:left;"><img id="img3" src="images/image.png" style="max-width:98%;" /></div>

<h2>The Placeholder Image</h2>
<p>For faster loading, especially on mobile phones, you'll need to set the src attribute of each image to a loading icon or a single pixel image (or whatever you want, obviously). Then use another attribute (I recommend <strong>data-src</strong>) to store the original src value.</p>
<p>Unforutnately, changing the src value, even before the image is loaded, still causes the browser to load the image. The only way to prevent the original image from loading is to change the src value in the original HTML.</p>
<p><code>$("#img4").responsiveImg({
    srcAttribute:"data-src"
});</code></p>
<div>
	<img id="img4" src="images/ajax-loader.gif" data-src="images/windowImage.jpg" style="max-width:100%;" />
</div>

</body>
</html>