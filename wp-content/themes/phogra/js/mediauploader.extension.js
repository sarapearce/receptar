window.ExtendMediaUploader = function(holderId, name, isList, callback)
{
	var file_frame;
	var holder = jQuery(holderId);
	var imageList = holder.find(".image-list");
	
	holder.find(".add-more").click(function(e){
		e.preventDefault();
				
	    if (file_frame) 
	    {
			file_frame.open();
			return;
	    }
 
		file_frame = wp.media.frames.file_frame = wp.media({
			title: jQuery( this ).data( "uploader_title" ),
			button: { text: jQuery( this ).data( "uploader_button_text" ) },
			multiple: false
		});
 
		file_frame.on( "select", function() {
			attachment = file_frame.state().get("selection").first().toJSON();
				
			if (isList)
			{
				var imageItem = jQuery("<div/>", { "class": "formfield" });
				imageList.append(
					imageItem	.append(jQuery("<img/>", { "src": attachment.sizes.thumbnail.url, "width": "100", "height": "100" }))
								.append(jQuery("<input/>", { "class": "text image-file file-id", "type": "hidden", "name": name + "[]", "value": attachment.id }))
								.append(jQuery("<a/>", { "class": "remove", "href": "#", "text": imageList.attr("data-remove-text") }))
  				);
  				
  				if (typeof callback != "undefined")
  				{
  					callback(imageItem);
  				}
			}
			else
			{
				imageList.empty().append(
					jQuery("<div/>", { "class": "formfield" })
						.append(jQuery("<img/>", { "src": attachment.sizes.thumbnail.url, "width": "100", "height": "100" }))
						.append(jQuery("<a/>", { "class": "remove", "href": "#", "text": imageList.attr("data-remove-text") }))
	  				);
				holder.find(".image_link").val(attachment.id);
			}
		});
 
		file_frame.open();
	});
			
	imageList.delegate(".remove", "click", function(e){
		e.preventDefault();
		if (confirm(imageList.attr("data-confirm-text")))
		{
			if (isList)
			{
				jQuery(this).parent().remove();
			}
			else
			{
				holder.find(".image_link").val("");
				jQuery(this).parent().remove();
			}
		}
	});
}