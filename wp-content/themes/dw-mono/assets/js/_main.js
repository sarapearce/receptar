(function($) {
	"use strict";
	// $(".dropdown").hover( function() {
	// 	$(this).toggleClass('open');
	// });

	$('.carousel').carousel({
		interval: 5000
	}).on('slide.bs.carousel', function(e) {
		var nextH = $(e.relatedTarget).outerHeight();
		$(this).find('.active.item').parent().animate({ height: nextH }, 500);
	});

	$('.smooth-scroll').click(function() {
    if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') && location.hostname === this.hostname) {

      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });

})(jQuery);
