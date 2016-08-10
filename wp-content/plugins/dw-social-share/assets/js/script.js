jQuery(document).ready(function($) {
	function rawurlencode(str) {

	  str = (str + '')
	    .toString();
	  return encodeURIComponent(str)
	    .replace(/!/g, '%21')
	    .replace(/'/g, '%27')
	    .replace(/\(/g, '%28')
	    .
	  replace(/\)/g, '%29')
	    .replace(/\*/g, '%2A');
	}


	var title = rawurlencode( $(document).find('h1.entry-title').text() );
	var url = rawurlencode( window.location.href );
	var image = $('.post-thumbnail img').attr('src');

	$('.dw-social-share .dwss-facebook').on('click', function(event) {
		window.open('http://www.facebook.com/sharer.php?u='+url+'', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600' );
		return false;
	});

	$('.dw-social-share .dwss-twitter').on('click', function(event) {
		window.open('https://twitter.com/share?url='+url+'&text='+title+'','_blank','width=800,height=300' );
		return false;
	});

	$('.dw-social-share .dwss-google-plus').on('click', function(event) {
		window.open('http://plus.google.com/share?url='+url+'','_blank','width=800,height=600');
		return false;
	});

	$('.dw-social-share .dwss-linkedin').on('click', function(event) {
		window.open('https://www.linkedin.com/cws/share?mini=true&url='+url+'','_blank','width=800,height=600');
		return false;
	});	

	$('.dw-social-share .dwss-pinterest').on('click', function(event) {
		window.open('http://pinterest.com/pin/create/button/?url='+url+'&media='+image+'','_blank','width=800,height=600');
		return false;
	});	

	$('.dw-social-share .dwss-print').on('click', function(event) {

		window.print();
		return false;
	});
});
