<?php
/* Template Name:Resource Template 1*/
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

$items = get_field('resource_files');
?>

<section class="section-full-width  simple-listing resource-section p1">
    <div class="container">
        <div class="row">
            <?php foreach($items as $item){ ?>        
            <div class="col col-100 p4 pb1_2 border-3">
                <div class="col-wrap">
                    <div class="widget-wrap">
                        <div class="widget-text">
                            <div class="widget-container">
                                <h3 class="heading-title">
                                    <?php echo $item['title'];?>
                                </h3>
                            </div>
                        </div>
                        <div class="widget-text">
                            <div class="widget-container">
                                <div class="listing-content">
                                    <p><?php echo $item['description'];?></p>  
                                </div>                                                              
                            </div>
                        </div>
                        <?php echo $item['filepath'];?>
                    </div>
                </div>
            </div>    
            <?php } ?>
        </div>
    </div>
</section>
<?php

get_footer();
