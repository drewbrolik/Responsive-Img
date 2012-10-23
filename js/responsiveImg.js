/*
Responsive Img jQuery Plugin
Version 1
Oct 20th, 2012

Documentation: http://responsiveimg.com
Repository: https://github.com/drewbrolik/Responsive-Img

Copyright 2012 Drew Thomas

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

(function($) {

	$.fn.responsiveImg = function(additionalOptions) {
		
		var options = { //- set default options
			breakpoints : {
				"_small":360,
				"_medium":780,
				"_large":900
			},
			srcAttribute : "src",
			baseURL:"/",
			pathToPHP:"js",
			createNewImages:true
		}
		options = $.extend(options, additionalOptions ); //- override default options with user-supplied options
		
		var pathToPHP = options.pathToPHP; //- format path to php
		if (pathToPHP.charAt( pathToPHP.length-1 ) !== "/") {
			options["pathToPHP"] = pathToPHP+"/";
		}
		var baseURL = options.baseURL; //- format path from root
		if (baseURL.charAt( baseURL.length-1 ) !== "/") {
			options["baseURL"] = baseURL+"/";
		}
		var baseURL = options.baseURL;
		if (baseURL.charAt( 0 ) !== "/") {
			options["baseURL"] = "/"+baseURL;
		}
		
		$(this).each(function() { //- do it for 'em all
			
			var $this = $(this); //- get this variable for later
						
			var src = $this.attr(options.srcAttribute); //- get the original src attribute so we can always come back to it
			var extension = src.split('.').pop(); //- get the file extension so we can add the suffix before the extension
			
			var breakpoints = options.breakpoints; //- create a new variable for breakpoints object			
			defaultBreakpoint = { "default":1000000 } //- set a "default" breakpoint for anything larger than the largest breakpoint
			breakpoints = $.extend(breakpoints,defaultBreakpoint);
			
			resizeImage($this,breakpoints,src,extension);
						
			$(window).resize(function() {
				resizeImage($this,breakpoints,src,extension);
			});
								
		});
		
		function resizeImage($img,breakpoints,src,extension) {
			
			var $this = $img;
			
			var containerWidth = $this.parent().width(); //- get container width
			
			var cssMaxWidth = $this.css("maxWidth"); //- if we know an image's max width is a percentage, we can use smaller images because we know the maximum size is smaller than the container width
			if (cssMaxWidth.charAt( cssMaxWidth.length-1 ) == "%") {
				containerWidth *= parseInt(cssMaxWidth)*.01;
			} else {		
				var percentageOfContainer = ( 100 * parseFloat($this.css('width')) / containerWidth ); //- account for max-width or width styles
				if (percentageOfContainer > 0 && percentageOfContainer < 100) {
					containerWidth *= percentageOfContainer*.01;
				}
			}
			
			var breakpoint = breakpoints.default; //- set default breakpoint (size when the page loaded)
			if (containerWidth > breakpoint) { breakpoint = $(window).width(); } //- account for sizing the window up
			
			var suffix = ""; //- set up the suffix variable to add to the img src
			
			$.each(breakpoints,function(index,value) { //- loop through until we find the smallest "value" that's larger than the containerWidth
				if (value > containerWidth && value < breakpoint) {
					breakpoint = value;
					suffix = index;
				}
			});
			
			var newSrc = src.replace("."+extension,suffix+"."+extension); //- replace "dot extension" with "suffix dot extension"
			replaceImage($this,src,newSrc,breakpoint);
			
		}
		
		function replaceImage($img,src,newSrc,size) {
					
			var $this = $img;
			
			var img = new Image();
			img.onload = function() { //- image exists
				$this.attr("src",newSrc); //- replace current image with suffixed image
			};
			img.onerror = function() { //- image doesn't exist
				if (options.createNewImages) {
					$.ajax({ //- ajax to a file to create a new image at the size we need
						url:options.pathToPHP+"responsiveImg.js.php",
						data:{ makeImage:1,fileIn:src,fileOut:newSrc,size:size,baseURL:options.baseURL },
						dataType:"html",
						success:function(data) {
							this.src = newSrc; //- see if we get the image or get an error
						},
						error:function() {
							// nothing
						}
					});
				}
			};
			img.src = newSrc; //- see if we get the image or get an error
		}
		
		return this;
	};
	
})(jQuery);