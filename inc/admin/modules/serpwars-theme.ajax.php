<?php
class Serpwars_Theme_Ajax {
	protected $mapping = array();
	public $placeholder_id = 0;
	public $placeholder_post = false;
	public $placeholder_url = '';

	 function __construct()
    {
        // Install Plugin
        // add_action( 'wp_ajax_cs_install_plugin', array( Customify_Sites_Plugin::get_instance(), 'ajax' ) );
        // // Active Plugin
        // add_action( 'wp_ajax_cs_active_plugin', array( Customify_Sites_Plugin::get_instance(), 'ajax' ) );

        // add_filter( 'upload_mimes', array( $this, 'add_mime_type_xml_json' ) );

        // // Import Content
        // add_action( 'wp_ajax_cs_import__check', array( $this, 'ajax_import__check' ) );
        add_action( 'wp_ajax_nopriv_cs_import_content', array( $this, 'ajax_import_content' ) );
        // add_action( 'wp_ajax_cs_import_options', array( $this, 'ajax_import_options' ) );

        // Download files
        add_action( 'wp_ajax_cs_download_files', array( $this, 'ajax_download_files' ) );
		add_action( 'wp_ajax_nopriv_cs_download_files', array( $this, 'ajax_download_files_test' ) );

        // add_action( 'wp_ajax_cs_export', array( $this, 'ajax_export' ) );
    }

       	function user_can(){
    		// debug mode
    		return true;

        	if ( ! current_user_can( 'manage_options' ) ) {
            	die( 'access_denied' );
        	}
    	}

    	function ajax_import_content(){

        	// $this->user_can();

        	$import_ui = new Serpwars_Theme_WXR_Import_UI();

        	// print_r($import_ui );
        	$import_ui->import();

        	die( 'content_imported' );
    	}

    	//ajax_import__check
    	// action=cs_import_options&id=6&xml_id=5
    	//action: elementor_reset_library
    	// elementor_clear_cache

    function ajax_download_files_test(){
    	wp_send_json(json_decode('{"xml_id":5,"json_id":6,"summary":{"post_count":40,"media_count":2,"user_count":2,"term_count":10,"comment_count":4,"users":[{"data":{"ID":"1","user_login":"wpengine","user_email":"bitbucket@wpengine.com","display_name":"wpengine","first_name":"","last_name":""},"meta":[]},{"data":{"ID":"2","user_login":"customifysites","user_email":"no-reply@customifysites.com","display_name":"customifysites","first_name":"","last_name":""},"meta":[]}],"home":"https:\/\/customifysites.com\/consulting","siteurl":"http:\/\/customifysites.com\/","title":"Consulting","generator":"https:\/\/wordpress.org\/?v=4.9.8","version":"1.2"},"texts":{"post_count":"40 posts (including CPTs)","media_count":"2 media items","user_count":"2 users","term_count":"10 terms","comment_count":"4 comments"},"_recommend_plugins":{"breadcrumb-navxt":"Breadcrumb NavXT","custom-sidebars":"Custom Sidebars","elementor":"Elementor","wpforms-lite":"WPForms Lite"}}'));
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


        // if ( $xml_file_exists ) {
        //     $return['xml_id'] = $xml_file_exists->ID;
        // } else {
        //     $return['xml_id'] = Serpwars_Theme_Ajax::download_file( $xml_url, $xml_file_name );
        // }

        print_r($xml_url);
        // if ( $json_file_exists ) {
        //     $return['json_id'] = $json_file_exists->ID;
        // } else {
        //     $return['json_id'] = Customify_Sites_Ajax::download_file( $json_url, $json_file_name );
        // }

        // $import_ui = new Customify_Sites_WXR_Import_UI();
        // $return['summary'] = $import_ui->get_data_for_attachment( $return['xml_id'] );

        // $return['summary'] = ( array ) $return['summary'];
        // if ( ! is_array( $return['summary'] ) ) {
        //     $return['summary'] = array();
        // }

        // $return['summary']  = wp_parse_args( $return['summary'], array(
        //     'post_count' => 0,
        //     'media_count' => 0,
        //     'user_count' => 0,
        //     'term_count' => 0,
        //     'comment_count' => 0,
        //     'users' => 0,
        // ) );

        // if ( isset( $return['summary']['users'] ) ) {
        //     $return['summary']['user_count'] = count( $return['summary']['users'] );
        // }

        // $return['texts']['post_count'] = sprintf( _n( '%d post (including CPT)', '%d posts (including CPTs)', $return['summary']['post_count'], 'customify-sites' ), $return['summary']['post_count'] );
        // $return['texts']['media_count'] = sprintf( _n( '%d media item', '%d media items', $return['summary']['media_count'], 'customify-sites' ), $return['summary']['media_count'] );
        // $return['texts']['user_count'] = sprintf( _n( '%d user', '%d users', $return['summary']['user_count'], 'customify-sites' ), $return['summary']['user_count'] );
        // $return['texts']['term_count'] = sprintf( _n( '%d term', '%d terms', $return['summary']['term_count'], 'customify-sites' ), $return['summary']['term_count'] );
        // $return['texts']['comment_count'] = sprintf( _n( '%d comment', '%d comments', $return['summary']['comment_count'], 'customify-sites' ), $return['summary']['comment_count'] );

        // if ( $return['json_id'] ) {
        //     $options = $this->get_config_options( $return['json_id'] );
        //     if ( isset( $options['_recommend_plugins'] ) ) {
        //         $return['_recommend_plugins'] = $options['_recommend_plugins'] ;
        //     }
        // }

    		
        // wp_send_json( $return );





    		die();
    	}


}

new Serpwars_Theme_Ajax();
?>