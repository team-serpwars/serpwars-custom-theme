<?php
/**
 * The site's entry point.
 *
 * Loads the relevant template part,
 * the loop is executed (when needed) by the relevant template part.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$is_elementor_theme_exist = function_exists( 'elementor_theme_do_location' );
while ( have_posts() ) : the_post();
get_template_part( 'template-parts/custom-field-parts/page-heading-banner' );
?>
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

<!-- <main <?php post_class( 'site-main' ); ?> role="main"></main> -->

	<?php
endwhile;
get_footer();
