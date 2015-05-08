jQuery(document).ready(function () {
	var slideshowData = jQuery(".cycle-slideshow").data();
	
	jQuery(".cycle-slideshow").cycle({
		'slides': slideshowData.cycleSlides,
		'timeout': slideshowData.cycleTimeout,
		'fx': slideshowData.cycleFx,
		'auto-height': slideshowData.cycleAutoHeight,
		'random': slideshowData.cycleRandom
	});
});