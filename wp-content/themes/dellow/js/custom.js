jQuery(document).ready(function() {
	//Set up the Slider 
	
	

/*
	jQuery('.menu-icon').toggle(
				function () {
					jQuery('.default-nav-wrapper').show();
				},
				
				function () {
					jQuery('.default-nav-wrapper').hide();
				});
*/

	
	jQuery('#main-menu').sidr({
		onOpen: function() { 
			jQuery('#main-menu i').removeClass('icon-list').addClass('icon-indent-left');
			 },
		onClose: function() { jQuery('#main-menu i').removeClass('icon-indent-left').addClass('icon-list') },
	});
	
	/* jQuery('.default-nav-wrapper').show(); */
	
	
	jQuery("time.entry-date").timeago();	
	
	jQuery(".featured-thumb").hoverIntent(function() {
		jQuery('.img-meta',this).slideDown(600,'easeOutBounce'); 
		jQuery('.img-meta-link',this).css('margin-right','50px');
		jQuery('.img-meta-link',this).animate({'margin-right':'0px'},500);
	},
		function() {
		jQuery('.img-meta-link',this).animate({'margin-right':'50px'},500);
		//jQuery('.img-meta-link').css('margin-right','50px');
		jQuery('.img-meta',this).fadeOut('fast');
		//jQuery('.img-meta-link').stop(true,false);	
	});	

   	jQuery('a.meta-link-img').nivoLightbox();
	
/*
	jQuery('.main-navigation ul.menu').mobileMenu({
		switchWidth: 768
	});
*/
	
	/*jQuery('.menu-toggle').toggle(function() {
		jQuery('.td_mobile_menu_wrap').fadeIn();
	},
	function() {
		jQuery('.td_mobile_menu_wrap').hide();
	});*/
		
	jQuery(window).bind('scroll', function(e) {
		hefct();
	});		
	
	jQuery(function() {
 
    // grab the initial top offset of the navigation 
    var sticky_navigation_offset_top = jQuery('#top-bar').offset().top;
     
    // our function that decides weather the navigation bar should have "fixed" css position or not.
    var sticky_navigation = function(){
        var scroll_top = jQuery(window).scrollTop(); // our current vertical position from the top
         
        // if we've scrolled more than the navigation, change its position to fixed to stick to top,
        // otherwise change it back to relative
        if (scroll_top > sticky_navigation_offset_top) { 
            jQuery('#top-bar').css({ 'position': 'fixed', 'top':0, 'width':'100%' });
            jQuery("body.admin-bar #top-bar").css({ 'position': 'fixed', 'top':28, 'width':'100%' });
        } else {
            jQuery('#top-bar').css({ 'position': 'relative' }); 
            jQuery('body.admin-bar #top-bar').css({ 'position': 'relative','top':0 }); 
        }
        if (jQuery(window).width() < 960 ) {
	         jQuery('#top-bar').css({ 'position': 'relative' }); 
        }     
    };
     
    // run our function on load
    sticky_navigation();
     

// and run it again every time you scroll
    jQuery(window).scroll(function() {
         sticky_navigation();
    });
 

    });

}); //endready

  	
    	
function hefct() {
	var scrollPosition = jQuery(window).scrollTop();
	jQuery('#parallax-bg').css('top', (0 - (scrollPosition * .2)) + 'px');
}	