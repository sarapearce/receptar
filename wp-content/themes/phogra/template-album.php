<?php /* Template Name: Album */ ?>
<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
    <section id="slider">
        <ul class="before-init">
            <?php $images = get_post_meta(get_the_ID(), 'gallery_links', true); ?>
            <?php $images = explode(";", $images); ?>
            <?php foreach($images as $image): ?>
                <?php $image = wp_get_attachment_image_src($image, 'full'); ?>
                <?php if ($image): ?>
                    <li>
                        <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" />
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>

        <div id="image-loader">
            <div id="image-loader-progress"></div>
        </div>

        <a href="#" class="slider-prev"></a>
        <a href="#" class="slider-next"></a>
        <a href="#" class="slider-back"></a>
    </section>
<?php endwhile; ?>

<?php get_footer(); ?>
