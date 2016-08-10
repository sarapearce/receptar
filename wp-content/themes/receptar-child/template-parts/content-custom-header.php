<?php
/**
 * Custom Header content
 *
 * Works as fallback when no banner slideshow.
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */
?>

<div class="site-banner-content">

    <?php
    /**
     * Media
     */
    ?>

    <div class="site-banner-media">


        <figure class="site-banner-thumbnail">

            <?php
            $image_url = ( get_header_image() ) ? ( get_header_image() ) : ( receptar_get_stylesheet_directory_uri('images/header.jpg') );

            echo '<img src="' . esc_url($image_url) . '" width="' . esc_attr(get_custom_header()->width) . '" height="' . esc_attr(get_custom_header()->height) . '" alt="" />';
            ?>

        </figure>





        <!--video background-->
        <!--
                <figure class="site-banner-thumbnail">
        
        $video_url = ( receptar_get_stylesheet_directory_uri('videos/bg-vid.mp4') );
        //
        ////i do not think i can set the width/height this way
        //echo '<video id="bg-vid" width=1960 height=700 autoplay loop>
        //  <source src=' . $video_url . ' type="video/mp4">
        //Your browser does not support the video tag.</video>';
        
                </figure>-->

    </div>

    <?php
    /**
     * Custom Header text
     */
    ?>

    <div class="site-banner-header">

        <h1 class="entry-title"><span class="highlight"><?php
                if (
                        get_option('page_on_front') && $custom_title = trim(get_post_meta(get_the_ID(), 'banner_text', true))
                ) {

                    //If there is a front page, display 'banner_text' custom field if set
                    echo $custom_title;
                } else {

                    //Display site description
                    bloginfo('description');
                }
                ?></span></h1>

    </div>

</div>