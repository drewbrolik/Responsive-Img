(function($) {

	$.fn.responsiveImg = function(breakpoints,additionalOptions) {
		
		$(this).each(function() { //- do it for 'em all
			
			var options = { //- set default options
				srcAttribute : "src",
				createNewImages : true
			}
			options = $.extend(options, additionalOptions ); //- override default options with user-supplied options
			
			var $this = $(this); //- get this variable for later
			
			var src = $this.attr(options.srcAttribute); //- get the original src attribute so we can always come back to it
			var extension = src.split('.').pop(); //- get the file extension so we can add the suffix before the extension
			
			//$this.attr("src",""); //- remove image src so it doesn't load (this might get fired after it loads, not sure yet)
			
			//defaultBreakpoint = {"default":$this.parent().width()} //- add a "default" breakpoint at the original size (no suffix)
			defaultBreakpoint = { "default":1000000 } //- set a "default" breakpoint for anything larger than the largest breakpoint
			breakpoints = $.extend(breakpoints,defaultBreakpoint);
			
			resizeImage($this,breakpoints,src,extension);
						
			$(window).resize(function() {
				resizeImage($this,breakpoints,src,extension);
			});
									
		});
		
		return this;
	};
	
	function resizeImage($this,breakpoints,src,extension) {
		
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
		replaceImage($this,newSrc);
		
	}
	
	function replaceImage($this,src) {
		var img = new Image();
		img.onload = function() { //- image exists
			$this.attr("src",src); //- replace current image with suffixed image
		};
		img.onerror = function() { //- image doesn't exist
			// create image here
		};
		img.src = src; //- see if we get the image or get an error
	}
	
})(jQuery);