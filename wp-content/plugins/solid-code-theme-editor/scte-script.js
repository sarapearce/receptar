jQuery(document).ready(function(){
	jQuery('.scte_inside_right ul ul').each(function(itm){
		if(jQuery(this).hasClass('scte_show')){
			jQuery(this).parent('li').prepend('<a class="scte_nav" id="scte_a_' + itm + '" href="JavaScript:scte_expand(' + itm + ');">-</a> ');
		}else{
			jQuery(this).parent('li').prepend('<a class="scte_nav" id="scte_a_' + itm + '" href="JavaScript:scte_expand(' + itm + ');">+</a> ');	
		}
	});
	
	//form fous on new file name
	jQuery('#newfilename').focus(function(){
		if(jQuery(this).val()=='Enter file name') jQuery(this).val('');
	});
	jQuery('#newfilename').blur(function(){
		if(jQuery(this).val()=='') jQuery(this).val('Enter file name');
	});
});

function scte_expand(itm){
	var htm = jQuery('#scte_a_' + itm).html();
	if(htm=='+'){
		jQuery('.scte_inside_right ul ul:eq(' + itm + ')').slideDown();
		jQuery('#scte_a_' + itm).html('-');
	}else{
		jQuery('.scte_inside_right ul ul:eq(' + itm + ')').slideUp();
		jQuery('#scte_a_' + itm).html('+');
	}
}

function SCTE_delFile(urltheme,file){
	if(confirm('Are you sure you want to delete ' + file + '?')){
		window.location = 'themes.php?page=scte-theme-editor&theme='+ urltheme +'&delfile=1&file=' + file;
	}
}