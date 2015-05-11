jQuery(document).ready(function () {
	var slideshowData = jQuery(".cycle-slideshow").data();	
	
	var cycleSlides = "> div.testimonial_slide";
	var cycleTimeout = "4000";
	var cycleFx = "fade";	
	var cycleAutoHeight = "container";
	var cycleRandom = "false";
	
	if (typeof slideshowData != "undefined"){
		if (typeof slideshowData.cycleSlides != 'undefined') {
			var cycleSlides = slideshowData.cycleSlides;
		} 
		if (typeof slideshowData.cycleTimeout != 'undefined') {
			var cycleTimeout = slideshowData.cycleTimeout;
		}
		if (typeof slideshowData.cycleFx != 'undefined') {
			var cycleFx = slideshowData.cycleFx;
		}
		if (typeof slideshowData.slideshowData != 'undefined') {
			var cycleAutoHeight = slideshowData.cycleAutoHeight;
		}
		if (typeof slideshowData.cycleRandom != 'undefined') {
			var cycleRandom = slideshowData.cycleRandom;
		}
	}
	
	jQuery(".cycle-slideshow").cycle({
		'slides': cycleSlides,
		'timeout': cycleTimeout,
		'fx': cycleFx,
		'auto-height': cycleAutoHeight,
		'random': cycleRandom
	});
});