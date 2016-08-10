<?php /* Template Name: Homepage */ ?>
<?php get_header(); ?>
<?php $images = get_post_meta(get_queried_object_id(), 'gallery_links', true); ?>
<?php if ($images !== false && $images != ''): ?>
    <?php $images = explode(";", $images); ?>
    <?php if (count($images) > 0): ?>

        <section id="slider">
            <ul class="before-init">
                <?php foreach($images as $imageId): ?>
                    <?php $image = wp_get_attachment_image_src($imageId, "full"); ?>
                    <?php if ($image): ?>
                        <li>
                            <img src="<?php echo $image[0]; ?>" alt="Image" />
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>

            <div id="image-loader">
                <div id="image-loader-progress"></div>
            </div>

            <a href="#" class="slider-prev"></a>
            <a href="#" class="slider-next"></a>
        </section>

    <?php endif; ?>
<?php endif; ?>

<?php get_footer(); ?>