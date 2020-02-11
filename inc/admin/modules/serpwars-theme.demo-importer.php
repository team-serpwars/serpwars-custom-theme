<?php
	if ( ! defined('ABSPATH') )  exit;

	class Serpwars_Demo_Importer {
		protected static $instance = null;

		public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    	}


    	 function __construct() {
    	    add_action( 'wp_ajax_serpwars_demo_data'       , array( $this, 'import') );
    	    add_action( 'wp_ajax_nopriv_serpwars_demo_data'       , array( $this, 'import') );
    	    // add_action( 'wp_ajax_auxin_templates_data'  , array( $this, 'templates') );
    	    // add_action( 'wp_ajax_import_step'           , array( $this, 'import_step') );
    	}

    	 public function import() {
    	 	//

    	 	$data = json_decode( $this->parse( 'http://localhost/custom-site/wp-content/uploads/json/sample-data.json', 'insert', 'post' ), true );



        	if ( $data['success'] ) {
	
        	    // $get_options = $_POST['options'];
        	    // foreach ( $get_options as $key => $value ) {
        	    //     $options[ $value['name'] ] = $value['value'];
        	    // }
	
        	    // update_option( 'auxin_demo_options', $options );
	
        	    // update_option( 'auxin_last_imported_demo', array( 'id' => $demo_ID, 'time' => current_time( 'mysql' ), 'status' => $options ) );
	
        	    // flush_rewrite_rules();
				print_r($_POST);
    	 		die();
        	    wp_send_json_success();
        	}


    	 }

    	 public function parse( $url, $action = 'insert', $method = 'get' ) {

        //Get JSON

        if( $method === 'get '){
            $request    = wp_remote_get( $url,
                array(
                    'timeout'     => 30,
                    'user-agent'  => 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0'
                )
            );
        } else {
            // $getLicense = get_site_option( THEME_ID . '_license' );
            $getLicense = empty( $getLicense ) ? get_site_option( AUXELS_PURCHASE_KEY ) : $getLicense;
            $getToken   = 'Bearer ' . base64_encode( $getLicense['token'] );
            $request    = wp_remote_post(
                $url,
                array(
                    // 'body'    => array(
                    //     'audit_token'   => base64_encode( auxin_get_site_key() ),
                    //     'item_slug'     => THEME_ID,
                    //     'item_version'  => THEME_VERSION,
                    //     'authorization' => $getToken
                    // ),
                    // 'headers' => array(
                    //     'Authorization' => $getToken
                    // ),
                    // 'timeout' => 25
                )
            );
        }


        //If the remote request fails, wp_remote_get() will return a WP_Error
        // if( is_wp_error( $request ) || ! current_user_can( 'import' ) ){

        //     // Increase the CURL timeout if required
        //     if( ! empty( $requst['errors']['http_request_failed'][0] ) ){
	       //  	if( false !== strpos( $requst['errors']['http_request_failed'][0], 'cURL error 28') ){
	       //      	set_theme_mod('increasing_curl_timeout_is_required', 15);
	       //      }
        //     }

        //     wp_send_json_error( array( 'message' => $request->get_error_message() ) );
        // }

        //proceed to retrieving the data
        $body       = wp_remote_retrieve_body( $request );
        // Check for error
        // if ( is_wp_error( $body ) || json_decode( $body ) == NULL ) {
        //     wp_send_json_error( array( 'message' => __( 'Retrieve Body Fails', 'auxin-elements' ) ) );
        // }

        if( $action === 'insert' ){
            // Create local json from remote url
            // return $this->insert_file( $url, $body, 'demo.json', 'json' );
        }

        return $body;
    }



	}
?>