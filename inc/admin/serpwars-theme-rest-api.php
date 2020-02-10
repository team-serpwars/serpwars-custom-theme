<?php
	require_once("modules/serpwars-theme.exporter.php");
	require_once("modules/serpwars-theme.import-ui.php");
	
	class Serpwars_Theme_Plugin extends TGM_Plugin_Activation{
		static $instance;
		public static function get_instance() {
        	if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {
            	self::$instance = new self();
        	}
        	return self::$instance;
    	}
    	public function ajax(){
        $plugin = sanitize_text_field( $_REQUEST['plugin'] );
       //$_GET['plugin'] = 'contact-form-7';
        // print_r( ! current_user_can( 'install_plugins' ));
        // $_GET['plugin'] = $plugin;
        // if ( ! current_user_can( 'install_plugins' ) ) {            die( 'access_denied' );        }

			die();
        }
        
	}
	class Serpwars_Theme_Rest_API  extends TGM_Plugin_Activation{
		static $instance;
		public static function get_instance() {
        	if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {
            	self::$instance = new self();
        	}
        	return self::$instance;
    	}
		public function __construct() {
			add_action( 'wp_ajax_serpwars_setup_plugins_test'	, array(  $this, 'ajax_plugins' ) );
			add_action( 'wp_ajax_nopriv_serpwars_setup_plugins_test'	, array(  $this, 'ajax_plugins' ) );

			//Some plugin stuff
			add_action( 'wp_ajax_cs_install_plugin', array( Serpwars_Theme_Plugin::get_instance(), 'ajax' ));
			add_action( 'wp_ajax_nopriv_cs_install_plugin', array( Serpwars_Theme_Plugin::get_instance(), 'ajax' ));

			// Import Content
			// add_action( 'wp_ajax_cs_import__check', array( $this, 'ajax_import__check' ) ); //Useless

			add_action( 'wp_ajax_cs_import_content', array( $this, 'ajax_import_content' ) );
			add_action( 'wp_ajax_nopriv_cs_import_content', array( $this, 'ajax_import_content' ) );

			add_action( 'wp_ajax_cs_download_files', array( $this, 'ajax_download_files' ) );
			add_action( 'wp_ajax_nopriv_cs_download_files', array( $this, 'ajax_download_files' ) );
		}

		function ajax_import_content(){

        	// $this->user_can();

        	$import_ui = new Serpwars_Theme_WXR_Import_UI();
        	$import_ui->import();

        	// die( 'content_imported' );
    	}

    	function ajax_download_files(){
    		$this->user_can();


    		$slug = isset( $_REQUEST['site_slug'] ) ?  sanitize_text_field( wp_unslash( $_REQUEST['site_slug'] ) ) : '';
        	$builder = isset( $_REQUEST['builder'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['builder'] ) ) : '';
        	$placeholder_only = apply_filters( 'serpwars_import_placeholder_only', true );

    		update_option( 'serpwars_import_placeholder_only', $placeholder_only );

        	$resources = isset( $_REQUEST['resources'] ) ? wp_unslash( $_REQUEST['resources'] ) : array();

    		 $resources = wp_parse_args( $resources, array(
            'xml_url' => '',
            'xml_placeholder_url' => '',
            'json_url' => '',

            'elementor_xml_url' => '',
            'elementor_xml_placeholder_url' => '',
            'elementor_json_url' => '',

            'beaver_builder_xml_url' => '',
            'beaver_builder_xml_placeholder_url' => '',
            'beaver_builder_json_url' => '',
        	) );

    		 foreach( $resources as $k => $v ) {
        		if ( $v == 'false' ) {
		        	$resources[ $k ] = false;
	        	}
        	}

        	if ( $placeholder_only && $resources['elementor_xml_placeholder_url'] ) {
			        $suffix_name = '-elementor-placeholder';
			        $xml_url = sanitize_text_field( wp_unslash( $resources['elementor_xml_placeholder_url'] ) );
		        } else {
			        $suffix_name = '-elementor';
			        $xml_url = sanitize_text_field( wp_unslash( $resources['elementor_xml_url'] ) );
		        }

                $json_url = sanitize_text_field( wp_unslash( $resources['elementor_json_url'] ) );

            if ( ! $xml_url &&  $placeholder_only && $resources['xml_placeholder_url'] ) {
		    $xml_url = sanitize_text_field( wp_unslash( $resources['xml_placeholder_url'] ) );
		    $suffix_name = '-no-builder-placeholder';
	    }

        if ( ! $xml_url ) {
            $xml_url = sanitize_text_field( wp_unslash( $resources['xml_url'] ) );
        }
        if ( ! $json_url ) {
            $json_url = sanitize_text_field( wp_unslash( $resources['json_url'] ) );
        }

        $return = array(
            'xml_id' => 0,
            'json_id' => 0,
            'summary' => array(),
            'texts' => array(),
            '_recommend_plugins' => array()
        );

         if ( ! $slug ) {
            return $return;
        }
        $xml_file_name =  basename( $xml_url );
        $json_file_name = basename( $json_url );

        $xml_file_exists = get_page_by_path( str_replace( '.', '-', $xml_file_name ), OBJECT, 'attachment' );
        $json_file_exists = get_page_by_path( str_replace( '.', '-', $json_file_name ), OBJECT, 'attachment' );
        if ( $xml_file_exists ) {
            $return['xml_id'] = $xml_file_exists->ID;
        } else {
            $return['xml_id'] = Customify_Sites_Ajax::download_file( $xml_url, $xml_file_name );
        }

        if ( $json_file_exists ) {
            $return['json_id'] = $json_file_exists->ID;
        } else {
            $return['json_id'] = Customify_Sites_Ajax::download_file( $json_url, $json_file_name );
        }

        $import_ui = new Customify_Sites_WXR_Import_UI();
        $return['summary'] = $import_ui->get_data_for_attachment( $return['xml_id'] );

        $return['summary'] = ( array ) $return['summary'];
        if ( ! is_array( $return['summary'] ) ) {
            $return['summary'] = array();
        }

        $return['summary']  = wp_parse_args( $return['summary'], array(
            'post_count' => 0,
            'media_count' => 0,
            'user_count' => 0,
            'term_count' => 0,
            'comment_count' => 0,
            'users' => 0,
        ) );

        if ( isset( $return['summary']['users'] ) ) {
            $return['summary']['user_count'] = count( $return['summary']['users'] );
        }

        $return['texts']['post_count'] = sprintf( _n( '%d post (including CPT)', '%d posts (including CPTs)', $return['summary']['post_count'], 'customify-sites' ), $return['summary']['post_count'] );
        $return['texts']['media_count'] = sprintf( _n( '%d media item', '%d media items', $return['summary']['media_count'], 'customify-sites' ), $return['summary']['media_count'] );
        $return['texts']['user_count'] = sprintf( _n( '%d user', '%d users', $return['summary']['user_count'], 'customify-sites' ), $return['summary']['user_count'] );
        $return['texts']['term_count'] = sprintf( _n( '%d term', '%d terms', $return['summary']['term_count'], 'customify-sites' ), $return['summary']['term_count'] );
        $return['texts']['comment_count'] = sprintf( _n( '%d comment', '%d comments', $return['summary']['comment_count'], 'customify-sites' ), $return['summary']['comment_count'] );

        if ( $return['json_id'] ) {
            $options = $this->get_config_options( $return['json_id'] );
            if ( isset( $options['_recommend_plugins'] ) ) {
                $return['_recommend_plugins'] = $options['_recommend_plugins'] ;
            }
        }

    		 print_r($return);
        // wp_send_json( $return );

        



    		die();
    	}
    	function user_can(){
    		// debug mode
    		return true;

        	if ( ! current_user_can( 'manage_options' ) ) {
            	die( 'access_denied' );
        	}
    	}




		public function ajax_plugins(){
        	// print_r($_REQUEST);
			echo "Installing Plugins";
			die();
		}

	
        // ob_start();
        // $action = sanitize_text_field( $_REQUEST['action'] );
        // $did_action = '';
        // $this->do_register_plugin( $plugin );
        // if ( $action == 'cs_install_plugin' ) {
        //     $did_action = 'installed';
        //     $_GET['tgmpa-install'] = 'install-plugin';
        //     // set nonce for install plugin
        //     $nonce = wp_create_nonce( 'tgmpa-install' );
        //     $_GET['tgmpa-nonce'] = $nonce;
        //     $_REQUEST['tgmpa-nonce'] = $nonce;
        //     $this->do_plugin_install();
        // } else if( $action == 'cs_active_plugin' ){
        //     // set nonce for active plugin
        //     $did_action = 'activated';
        //     $nonce = wp_create_nonce('tgmpa-activate');
        //     $_GET['tgmpa-nonce'] = $nonce;
        //     $_REQUEST['tgmpa-nonce'] = $nonce;
        //     $_GET['tgmpa-activate'] = 'activate-plugin';
        //     $this->do_plugin_install();
        // }

        // $msg = ob_get_clean();
        // ob_end_clean();
        // die( $plugin.'_'.$did_action );

    	
	};

	new Serpwars_Theme_Rest_API();

?>