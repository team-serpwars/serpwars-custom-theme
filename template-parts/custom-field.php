<?php
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php
while ( have_posts() ) : the_post();
$args['photo'] = get_field('page_banner_background_image');
	?>
<style>
    
</style>
<section class="section-full-width page-banner" style="background-image: url(<?php echo $args['photo']; ?>);">
    <div class="background-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-100">
                <div class="col-wrap">                
                <div class="widget-wrap">
                    <div class="widget-heading">
                        <div class="widget-container">
                            <h1 class="heading-title">WE BUY FIRE DAMAGED HOUSES</h1>
                        </div>
                    </div>
                    <div class="widget-heading excerpt">
                        <div class="widget-container">
                            <h2 class="heading-title">We Buy Fire Damaged Houses Pays Cash for Fire Damaged Property Across the USA. Ready to Sell Your Fire Damaged Home? Get Started Below.</h2>
                        </div>
                    </div>
                    <div class="widget-button">
                        <div class="widget-container">
                            <div class="button-wrapper">
                                <a href="#" class="button lg">Get My Cash Offer</a>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<main <?php post_class( 'site-main' ); ?> role="main">
	<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
		<header class="page-header">
			<?php //the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
	<?php endif; ?>
	<div class="page-content">
		<?php the_content(); ?>
		<div class="post-tags">
			<?php the_tags( '<span class="tag-links">' . __( 'Tagged ', 'hello-elementor' ), null, '</span>' ); ?>
		</div>
		<?php wp_link_pages(); ?>
	</div>

	<?php comments_template(); ?>
</main>

	<?php
endwhile;
