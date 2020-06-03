<?php
/* Template Name:FAQ Template 1*/
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
get_template_part( 'template-parts/custom-field-parts/page-heading-banner' );
get_template_part( 'template-parts/custom-field-parts/faq-accordion' );

get_footer();
