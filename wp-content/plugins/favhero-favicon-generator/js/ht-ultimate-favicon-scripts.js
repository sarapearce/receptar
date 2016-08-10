// Uploading files
var file_frame;

jQuery(document).ready(function($){

  $('#ht-select-favicon, .replace-generated').live('click', function( event ){

    event.preventDefault();

    var target =  $( this ).attr('data-id');

    // If the media frame already exists, reopen it.
    if ( file_frame ) {
      // Open frame
      file_frame.open();
      return;
    } else {
      // Set the wp.media post id so the uploader grabs the ID we want when initialised
    }

    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: $( this ).data( 'uploader_title' ),
      button: {
        text: $( this ).data( 'uploader_button_text' ),
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });

    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      // We set multiple to false so only get one image from the uploader
      attachment = file_frame.state().get('selection').first().toJSON();

      // Do something with attachment.id and/or attachment.url here
      if( attachment.id ){
        console.log("att->"+target);
        if(target==undefined || target==""){
          $( '#attachment_id' ).val( attachment.id );
        } else {
          $( '#override_id_'+target ).val( attachment.id );
        }
        
      }

      //trigger form submit
      $( '#submit' ).trigger('click');
       
      
    });

    // Finally, open the modal
    file_frame.open();
  });


  

  $('#ht-clear-favicon, .restore-generated').live('click', function( event ){

      var target =  $( this ).attr('data-id');

      if(target==undefined || target==""){
        //clear id
        $( '#attachment_id' ).val( '' );
      } else {
        $( '#override_id_'+target ).val( '' );
      }

      //trigger form submit
      $( '#submit' ).trigger('click');
    });
  
});