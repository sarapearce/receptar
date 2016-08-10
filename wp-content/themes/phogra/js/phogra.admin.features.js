jQuery(document).ready(function($){
    window.ExtendMediaUploader("#post-images-row", "image_link", true);
    $("#post-type-image-list").sortable();

    var albumMetaBox = $("#album_meta_box");
    var postdivrich = $("#postdivrich");
    var pageTemplate = $("#page_template");

    SetMetaBoxes();
    $(window).load(function(){
        SetMetaBoxes();
    });
    pageTemplate.change(function(){
        SetMetaBoxes();
    });

    function SetMetaBoxes()
    {
        if ( pageTemplate.val() == "template-home.php" || pageTemplate.val() == "template-album.php" )
        {
            albumMetaBox.show();
            postdivrich.hide();
        }
        else
        {
            albumMetaBox.hide();
            postdivrich.show();
        }
    }
});