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
get_template_part( 'template-parts/custom-field-parts/page-heading-banner' );
get_template_part( 'template-parts/custom-field-parts/blurb-image-right' );
get_template_part( 'template-parts/custom-field-parts/simple-listing' );

// get_template_part( 'template-parts/custom-field-parts/what-we-do' ); // on hold requires select dropdown to select from all posts  pages and post types
// get_template_part( 'template-parts/custom-field-parts/blurb-grids' ); // on hold requires select dropdown to select from all posts  pages and post types
//get_template_part( 'template-parts/custom-field-parts/2-step-form' ); // on hold requires select dropdown to select from all posts  pages and post types
																		// do settings API to set social media and other contact details
//get_template_part( 'template-parts/custom-field-parts/footer' ); // on hold requires select dropdown to select from all posts  pages and post types
																	// make use of widgets and widget areas
																	/*
																	Services
About Us
Contact Us 	//Shortcode For Google map
FAQ 		// Accordion
Resources // on hold requires select dropdown to select from all posts  pages and post types // contact form 7
																	
Blog // Pagination is broken
Special Promotions // Not found
Reviews //
Pricing // not found
Locations
																	*/
// get_template_part( 'template-parts/custom-field-parts/gallery' );
// get_template_part( 'template-parts/custom-field-parts/testimonial' );

	?>


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
