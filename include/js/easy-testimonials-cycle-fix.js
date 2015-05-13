jQuery(document).ready(function () {
	var slideshowData = jQuery(".cycle-slideshow").data();	
	
	var cycleSlides = "> div.testimonial_slide";
	var cycleTimeout = "4000";
	var cycleFx = "fade";	
	var cycleAutoHeight = "container";
	var cycleRandom = "false";
	
	if (null != slideshowData && typeof slideshowData != "undefined"){
		if (null != slideshowData.cycleSlides && typeof slideshowData.cycleSlides != 'undefined') {
			cycleSlides = slideshowData.cycleSlides;
		} 
		if (null != slideshowData.cycleTimeout && typeof slideshowData.cycleTimeout != 'undefined') {
			cycleTimeout = slideshowData.cycleTimeout;
		}
		if (null != slideshowData.cycleFx && typeof slideshowData.cycleFx != 'undefined') {
			cycleFx = slideshowData.cycleFx;
		}
		if (null != slideshowData.slideshowData && typeof slideshowData.slideshowData != 'undefined') {
			cycleAutoHeight = slideshowData.cycleAutoHeight;
		}
		if (null != slideshowData.cycleRandom && typeof slideshowData.cycleRandom != 'undefined') {
			cycleRandom = slideshowData.cycleRandom;
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