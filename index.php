<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Responsive Img - a jQuery Plugin</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.js"></script>
<script src="js/responsiveImg.js"></script>

<link type="text/css" rel="stylesheet" href="style_skeleton.css" />

<script type="text/javascript" src="//use.typekit.net/ybm8hml.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
</head>

<body>

<script>

$(function() {
	
	$("#img1").responsiveImg();
	$("#img2,#img3").responsiveImg({breakpoints:{"_four":400,"_two":200,"_eight":800}});
	$("#img4").responsiveImg({srcAttribute:"data-src"});
	
	$("img").click(function() {
		alert($(this).attr("src"));
	});
	
});

</script>

<style type="text/css">
	
	body	{ font-size:.75em /* 12/16 */; font-family:'jaf-facitweb',sans-serif; font-weight:300; margin:0; padding:0; }
	
	h2		{ font-weight:700; }
	
	.example	{ padding:2% 6%; border-top:1px solid rgba(0,0,0,.2); }
	
	.header		{ padding:2% 6%; background:rgba(200,200,200,.4); border-top:1px solid rgba(0,0,0,.2); }
	.header:first-child	{ border-top:none; }
	
</style>

<div class="header">
	<div class="clearfix">
        <div class="half column">
            <h1>Responsive Img</h1>
            
            <p>Responsive Img swaps out an image's src attribute based on its container's width when the DOM is ready and on resize.</p>
            <p>Using a php file, Responsive Img will create new images on the fly the first time they're needed and then use those images in the future.</p>
            <p>Breakpoint sizes can be set with options, or you can use the default breakpoints.</p>
        </div>
        
        <div class="half column">
            
            <h3>Option 1: No extra HTML or CSS markup</h3>
            <p>For each breakpoint, specify a suffix that gets added to the end of the image's filename, depending on the size of the image's container. (Or just use the default breakpoints.)</p>
            <p>If an image with the new filename already exists on the server, Responsive Img replaces the image's src attribute with the new filename.</p>
            <p style="font-weight:700;">If the image doesn't exist, Responsive Img will create an image at the breakpoint size with the new filename. The image gets saved in the same folder on your server as the original image.</p>
            <p>After the first time an image is created, Responsive Img will use the existing image for all visitors in the future.</p>
            <p>Using this option, images will load faster  when they're viewed in smaller browser windows, but the original, full-size image still loads in the background, preventing events that are bound to page load.</p>
            
            <h3>Option 2: A little bit of HTML markup</h3>
            <p>Without changing the HTML, the original image file always gets loaded (even when Responsive Img swaps in a smaller image, which happens right away).</p>
            <p>To prevent delaying page load events, you'll need to change a little markup.</p>
            <p>Just set the images src attribute to a small image (a loading image or a single pixel image are good options), and then create another attribute (data-src is a good one to use) and use image path and filename for its value. Then you set the srcAttribute option to the new attribute.</p>
            <p>That's it. Responsive images.</p>
        </div>
    </div>
        
</div>

<div class="example clearfix">
	<div class="half column">
    	<h2>Default Options</h2>
    </div>
    <div class="half column">
        <pre><code>$.responsiveImg({
    breakpoints : {
        "_small":360,
        "_medium":780,
        "_large":900
    },
    srcAttribute : "src",
});</code></pre>
    </div>
</div>

<div class="header clearfix">
	<h1>Examples</h1><p style="font-style:italic; margin:0;">Click or tap an image to see its src attribute.</p>
</div>

<div class="example clearfix">
    <div class="half column">
        <h2>No Options</h2>
        <p>If no options are specified, Responsive Img defaults to breakpoints that are roughly device sizes.</p>
        <p>360 pixels (with the suffix "_small")<br />
            780 pixels ("_medium")<br />
            900 pixels ("_large")</p>
        <pre><code>$("#img1").responsiveImg();</code></pre>
    </div>
    <div class="half column">
        <div style="width:50%;">
            <img id="img1" src="images/windowImage.jpg" style="max-width:100%;" />
        </div>
    </div>
</div>

<div class="example clearfix">
    <div class="half column">
    	<h2>Custom Breakpoints</h2>
        <p>Specify custom breakpoints, each with a custom suffix.</p>
        <p>This is useful if you actually need to change the image at certain breakpoints, rather than just resize it. (Remember, you can create the image manually and put it on the server, and Responsive Img will automatically use that instead of creating a new one.)</p>
        <pre><code>$("#img2,#img3").responsiveImg({
    breakpoints:{
        "_four":400,
        "_two":200,
        "_eight":800
    }
});</code></pre>
    </div>
    <div class="half column">
        <img id="img2" src="images/image.png" style="width:49%;" />
        <img id="img3" src="images/image.png" style="max-width:49%;" />
	</div>
</div>

<div class="example clearfix">
    <div class="half column">
        <h2>Placeholder Image</h2>
        <p>For faster loading, especially on mobile phones, you'll need to set the src attribute of each image to a loading icon or a single pixel image (or whatever you want, obviously). Then use another attribute (I recommend <strong>data-src</strong>) to store the original src value.</p>
        <p>Unforutnately, changing the src value, even before the image is loaded, still causes the browser to load the image. The only way to prevent the original image from loading is to change the src value in the original HTML.</p>
        <pre><code>$("#img4").responsiveImg({ srcAttribute:"data-src" });</code></pre>
    </div>
    <div class="half column">
        <img id="img4" src="images/ajax-loader.gif" data-src="images/windowImage.jpg" style="max-width:100%;" />
    </div>
</div>

</body>
</html>