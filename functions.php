<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '2.2.0' );
require_once get_template_directory().'/inc/theme-customizer.php';

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_load_textdomain', [ true ], '2.0', 'hello_elementor_load_textdomain' );
		if ( apply_filters( 'hello_elementor_load_textdomain', $hook_result ) ) {
			load_theme_textdomain( 'hello-elementor', get_template_directory() . '/languages' );
		}

		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_register_menus', [ true ], '2.0', 'hello_elementor_register_menus' );
		if ( apply_filters( 'hello_elementor_register_menus', $hook_result ) ) {
			register_nav_menus( array( 'menu-1' => __( 'Primary', 'hello-elementor' ) ) );
		}

		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_add_theme_support', [ true ], '2.0', 'hello_elementor_add_theme_support' );
		if ( apply_filters( 'hello_elementor_add_theme_support', $hook_result ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				array(
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
				)
			);
			add_theme_support(
				'custom-logo',
				array(
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				)
			);

			/*
			 * Editor Style.
			 */
			add_editor_style( 'editor-style.css' );

			/*
			 * WooCommerce.
			 */
			$hook_result = apply_filters_deprecated( 'elementor_hello_theme_add_woocommerce_support', [ true ], '2.0', 'hello_elementor_add_woocommerce_support' );
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', $hook_result ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		$enqueue_basic_style = apply_filters_deprecated( 'elementor_hello_theme_enqueue_style', [ true ], '2.0', 'hello_elementor_enqueue_style' );
		$min_suffix          = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( apply_filters( 'hello_elementor_enqueue_style', $enqueue_basic_style ) ) {
			wp_enqueue_style( 'serpwars-custom-theme-vendor', "//kit-pro.fontawesome.com/releases/latest/css/pro.min.css" , array(),"5.13.0", 'all');
			wp_enqueue_style('hello-page-main-style',get_template_directory_uri() . '/assets/theme-css/main.css',[],microtime());
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
			//
		
		
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style( 'serpwars-custom-theme-vendor',"//kit-pro.fontawesome.com/releases/latest/css/pro.min.css" , array(),"5.13.0", 'all');
			wp_enqueue_style('hello-page-main-style',get_template_directory_uri() . '/assets/theme-css/main.css',[],microtime());
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
			wp_enqueue_style('hello-page-banner-style',get_template_directory_uri() . '/assets/theme-css/page-banner.css',[],microtime());
			wp_enqueue_style('hello-page-blurbs',get_template_directory_uri() . '/assets/theme-css/blurbs.css',[],microtime());
			wp_enqueue_style('hello-page-how-it-works-steps',get_template_directory_uri() . '/assets/theme-css/how-it-works-steps.css',[],microtime());
			wp_enqueue_style('hello-page-why-choose-us',get_template_directory_uri() . '/assets/theme-css/why-choose-us-listings.css',[],microtime());
			wp_enqueue_style('hello-page-what-we-do',get_template_directory_uri() . '/assets/theme-css/what-we-do.css',[],microtime());
			wp_enqueue_style('hello-page-gallery',get_template_directory_uri() . '/assets/theme-css/gallery.css',[],microtime());
			wp_enqueue_style('hello-page-heading-banner',get_template_directory_uri() . '/assets/theme-css/page-heading-banner.css',[],microtime());
			wp_enqueue_style('hello-blurb-image',get_template_directory_uri() . '/assets/theme-css/blurb-image.css',[],microtime());
			wp_enqueue_style('hello-simple-listing',get_template_directory_uri() . '/assets/theme-css/simple-listing.css',[],microtime());
			wp_enqueue_style('hello-resources',get_template_directory_uri() . '/assets/theme-css/resources.css',[],microtime());
			wp_enqueue_style('hello-testimonial',get_template_directory_uri() . '/assets/theme-css/testimonial.css',[],microtime());
			wp_enqueue_style('hello-image-grids',get_template_directory_uri() . '/assets/theme-css/image-grids.css',[],microtime());
			wp_enqueue_style('hello-contact-us',get_template_directory_uri() . '/assets/theme-css/contact-us.css',[],microtime());
		
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_register_elementor_locations', [ true ], '2.0', 'hello_elementor_register_elementor_locations' );
		if ( apply_filters( 'hello_elementor_register_elementor_locations', $hook_result ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( is_admin() ) {
	require get_template_directory() . '/includes/admin-functions.php';
}

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check hide title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = \Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

/**
 * Wrapper function to deal with backwards compatibility.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		} else {
			do_action( 'wp_body_open' );
		}
	}
}


if ( ! class_exists( 'WP_Importer' ) ) {
	defined( 'WP_LOAD_IMPORTERS' ) || define( 'WP_LOAD_IMPORTERS', true );
	require ABSPATH . '/wp-admin/includes/class-wp-importer.php';
}
// locate_template( get_template_directory() . '/inc/modules/lib/class-tgm-plugin-activation.php' , true, true );
require_once get_template_directory() . '/inc/modules/lib/class-tgm-plugin-activation.php';
if ( ! function_exists( 'load_tgm_plugin_activation' ) ) {
        /**
         * Ensure only one instance of the class is ever invoked.
         *
         * @since 2.5.0
         */
        function load_tgm_plugin_activation() {
            $GLOBALS['tgmpa'] = TGM_Plugin_Activation::get_instance();
        }
    }

	if ( ! class_exists( 'TGM_Plugin_Activation' ) || ! isset( $GLOBALS['tgmpa'] ) ) {
			die( 'Failed to find TGM' );
	}



require_once get_template_directory() . '/inc/class-theme-custom.php';

function SW_Theme_Custom() {
	// phpc:ignore WordPress.NamingConventions.ValidFunctionName.
	return SW_Theme_Custom::get_instance();


}


function pageBanner($args = NULL) {
  
	if (!$args['title']) {
	  $args['title'] = get_the_title();
	}
  
	if (!$args['subtitle']) {
	  $args['subtitle'] = get_field('page_banner_subtitle');
	}
  
	if (!$args['photo']) {
	  if (get_field('page_banner_background_image')) {
		$args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
	  } else {
		$args['photo'] = get_theme_file_uri('/images/ocean.jpg');
	  }
	}
  
	?>
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
<?php }
function set_two_columns($loaded){
	$items = array();
    $max_items = ceil(count($loaded)/2);
    $current_index = 0;

    for($i=0;$i<$max_items;$i+=1){
        $items[$i] = array();
    }
    for($i=0;$i<count($loaded);$i+=1){
        if(count($items[$current_index]) == 2){
            $current_index+=1;
        }
        array_push($items[$current_index],$loaded[$i]);
	}
	return $items ;
}
function set_items_per_row($loaded,$per_row=4){
	$items = array();
    $max_items = ceil(count($loaded)/$per_row);
    $current_index = 0;

    for($i=0;$i<$max_items;$i+=1){
        $items[$i] = array();
	}
	
	
    for($i=0;$i<count($loaded);$i+=1){
        if(count($items[$current_index]) == $per_row){
            $current_index+=1;
        }
        array_push($items[$current_index],$loaded[$i]);
	}
	return $items ;
}
 SW_Theme_Custom();

 require_once get_template_directory().'/includes/acf.php';