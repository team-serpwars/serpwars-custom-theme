<?php
	add_action( 'tgmpa_register', 'serpwars_theme_register_recommended_plugins' );
	/*'elementor',
			'custom-post-type-ui',
			'advanced-custom-fields',
			'font-awesome',
			'dynamicconditions',*/
			
	function serpwars_theme_register_recommended_plugins(){
		$plugins = array(
        	array(
            	'name'      => __('Elementor', 'serpwars'),
            	'slug'      => 'elementor',
            	'categories'=> array('serpwars', 'essential')
        	),
        	array(
            	'name'      => __('Custom Post Type', 'serpwars'),
            	'slug'      => 'custom-post-type-ui',
            	'required'  => false,
        	),
        	array(
            	'name'      => __('Advance Custom Fields', 'serpwars'),
            	'slug'      => 'advanced-custom-fields',
            	'categories'=> array('serpwars', 'essential')
        	),
        	array(
            	'name'      => __('Font Awesome', 'serpwars'),
            	'slug'      => 'font-awesome',
            	'required'  => false,
            	'categories'=> array('serpwars', 'essential')
        	),
        	array(
            	'name'      => __('Dynamic Conditions', 'serpwars'),
            	'slug'      => 'dynamicconditions',
            	'required'  => false,
            	'categories'=> array('serpwars', 'essential')
        	),
    	);
    	
    	$config = array(
        	'id'           => 'phlox',            // Unique ID for hashing notices for multiple instances of TGMPA.
        	'default_path' => get_template_directory() . "/auxin-content/embeds/plugins/",                      // Default absolute path to bundled plugins.
        	'menu'         => 'tgmpa-install-plugins', // Menu slug.
        	'has_notices'  => false,                   // Show admin notices or not.
        	'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        	'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        	'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        	'message'      => '',                      // Message to output right before the plugins table.
	
        	'strings'      => array(
        	    'page_title'                      => __( 'Install Recommended Plugins', 'phlox' ),
        	    'menu_title'                      => __( 'Install Plugins', 'phlox' )
        	)
    	);


		tgmpa( $plugins, $config );
	}


?>