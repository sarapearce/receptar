(function($) {
	$(document).ready(function() {
		
		var form = $("#templaty-theme-options-form");
        form.find(".templaty-theme-options-color-field").wpColorPicker();
		
		/* Image Upload Fields Handlers */
		var imageSourceField;
		
		form.find(".templaty-upload-button").click(function(e) {
			e.preventDefault();
			
			imageSourceField = $(this).prev("input"); 
			tb_show("","media-upload.php?TB_iframe=true");
		});
		
		form.find(".templaty-remove-button").click(function(e){
			e.preventDefault();
			
			$(this).siblings("img").remove();
			$(this).parent().siblings("input.regular-text").val("");
			$(this).hide();
		});
    
		window.old_tb_remove = window.tb_remove;
		window.tb_remove = function() {
			window.old_tb_remove();
			imageSourceField = null;
		};
 
		window.original_send_to_editor = window.send_to_editor;
		window.send_to_editor = function(html) {
			if (imageSourceField) 
			{
				var url = $("img", html).attr("src");
				imageSourceField.val(url);
				var imagePreview = imageSourceField.siblings(".image-preview");
				imagePreview.find("img").remove(); 
				imagePreview.prepend($("<img/>", { "src": url, "alt": "Image" }));
				imagePreview.find("input.button").show();
					
				tb_remove();
			} 
			else 
			{
				window.original_send_to_editor(html);
			}
		};
		/* Image Upload Fields Handlers */
	});
})(jQuery);