jQuery(document).ready(function() {

/* Navigation */

	jQuery('#web2feel ul.sfmenu').superfish({ 
		delay:       500,								// 0.1 second delay on mouseout 
		animation:   { opacity:'show',height:'show'},	// fade-in and slide-down animation 
		dropShadows: true								// disable drop shadows 
	});	

/* Flexslider */

  jQuery('#wideslider').flexslider({
    animation: "fade"
  });
	 
/* Banner claaass */

	jQuery('.squarebanner ul li:nth-child(even)').addClass('rbanner');


	
});