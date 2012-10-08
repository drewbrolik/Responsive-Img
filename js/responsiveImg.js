(function($) {

	$.fn.responsiveImg = function(additionalOptions) {
		
		var options = { //- set default options
			breakpoints : {
				"_200":200,
				"_400":400,
				"_600":600,
				"_800":800
			},
			srcAttribute : "src",
			createNewImages : true
		}
		options = $.extend(options, additionalOptions ); //- override default options with user-supplied options
		
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
					
			var breakpoint = breakpoints.default; //- set default breakpoint (where we started)
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
				//- destroy img here?
			};
			img.onerror = function() { //- image doesn't exist
				if (options.createNewImages) {
					$.ajax({ //- ajax to a file to create a new image at the size we need
						url:"js/responsiveImg.js.php",
						data:{ makeImage:1,fileIn:src,fileOut:newSrc,size:size },
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