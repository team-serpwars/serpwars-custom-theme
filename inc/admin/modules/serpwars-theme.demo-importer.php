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

            add_action( 'wp_ajax_serpwars_import_step'           , array( $this, 'import_step') );
            add_action( 'wp_ajax_nopriv_serpwars_import_step'           , array( $this, 'import_step') );

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
	
        	    // update_option( 'serpwars_demo_options', $options );
	
        	    // update_option( 'serpwars_last_imported_demo', array( 'id' => $demo_ID, 'time' => current_time( 'mysql' ), 'status' => $options ) );
	
        	    // flush_rewrite_rules();
    	 		die();
        	    wp_send_json_success();
        	}


    	 }

        public function import_step() {
            $data    = $this->get_demo_data();

            if( ! is_array( $data ) ){
                wp_send_json_error( array( 'message' => __( 'Error in getting data!', 'serpwars' ) ) );
            }

            if(isset($data['elementor_templates'])){
                // $this->import_elementor_data($data['elementor_templates']);
            }
            if(isset($data['cptui'])){
                // $cptdata = get_option( 'cptui_post_types', false );
                // $cptdata = ($cptdata) ? $cptdata : array();
                // foreach ($data['cptui'] as $i=>$item) {
                //      $cptdata[$item['name']] = $item;
                // }
                // update_option('cptui_post_types',$cptdata,true);
                // echo "CPT UI Options Imported";
            }

            if(isset($data['acf'])){
                $ids = array();
                foreach($data['acf'] as $acf){
                    $post = acf_get_field_group_post( $acf['key'] );
                    if( $post ) {
                        $field_group['ID'] = $post->ID;
                    }
                    $acf = acf_import_field_group( $acf );
                    $ids[] = $acf['ID'];
                    $total = count($ids);
                    $text = sprintf( _n( 'Imported 1 field group', 'Imported %s field groups', $total, 'acf' ), $total );   

                    // $args = array(
                    //     'post_title'    => wp_strip_all_tags( $acf['post_title'] ),
                    //     'post_excerpt'    => $acf['post_excerpt'] ,
                    //     'post_status'   => 'publish',
                    //     'post_type'     => 'acf-field-group',
                    //     'post_content'  => serialize($acf['post_content'])
                    // );

                    // $args = wp_slash( $args );
                    // $post_id = wp_insert_post( $args );
                    // print_r(acf_update_field_group($acf['post_content']));
                    // print_r(acf_update_field_group($acf));
                }
            }



            $options = get_option( 'serpwars_demo_options', false );
            $options = ($options) ? $options : array();


            // return $this->import_options( $data['options'] );


            die();
        }

            public function import_elementor_data( array $templates ) {               
                foreach($templates as $template){
                    

                    $this->import_elementor_post($template);

                    // print_r($template);
                }
            }

            public function import_elementor_post($template){
                $page_template = $template["type"];
                $template_title = $template["title"];

                extract($template);

                $sanitize_key    = sanitize_key(  $page_template  );

                $args = array(
                    'post_title'    => wp_strip_all_tags( $title ),
                    'post_status'   => 'publish',
                    'post_type'     => 'elementor_library'
                );

                $post_id = wp_insert_post( $args );


                //  if( ! is_wp_error( $post_id ) ){
                // $json_content = json_decode( $data , true );
                // update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
                // update_post_meta( $post_id, '_elementor_data', $json_content['content'] );
                // update_post_meta( $post_id, '_elementor_version', '0.4' );

                //     if( ! empty( $page_template ) ){
                //         update_post_meta( $post_id, '_wp_page_template', $page_template );
                //     }

                //     if( $post_type === 'elementor_library' ) {
                //         update_post_meta( $post_id, '_elementor_template_type', $page_template );
                //     }               

                // }else{
                //     //there was an error in the post insertion,
                //     $data = false;
                // }
                $data = serpwars_get_transient( $sanitize_key ) ;
                print_r($post_id);
            }

            public function import_options( array $options ) {
        // $auxin_custom_images   = $this->get_options_by_type( 'image' );
        extract( $options );

        // foreach ( $theme_options as $serpwars_key => $serpwars_value ) {
        //     if ( in_array( $serpwars_key, $auxin_custom_images ) && ! empty( $serpwars_value ) ) {
        //         // This line is for changing the old attachment ID with new one.
        //         $serpwars_value    = $this->get_attachment_id( 'auxin_import_id', $serpwars_value );
        //     }
        //     // Update exclusive auxin options
        //     print_r(maybe_unserialize( $serpwars_value ) );
        //     // auxin_update_option( $serpwars_key , maybe_unserialize( $serpwars_value ) );
        // }

        // foreach ( $site_options as $site_key => $site_value ) {
        //     // If option value is empty, continue...
        //     if ( empty( $site_value ) ) continue;
        //     // Else change some values :)
        //     if( $site_key === 'page_on_front' || $site_key === 'page_for_posts' ) {
        //         $site_value = $this->get_meta_post_id( 'auxin_import_post', $site_value );
        //     }
        //     // Finally update options :)
        //     update_option( $site_key, $site_value );
        // }

        // foreach ( $theme_mods as $theme_mods_key => $theme_mods_value ) {
        //     // Start theme mods loop:
        //     if( $theme_mods_key === 'custom_logo' ) {
        //         // This line is for changing the old attachment ID with new one.
        //         $theme_mods_value = $this->get_attachment_id( 'auxin_import_id', $theme_mods_value );
        //     }
        //     // Update theme mods
        //     set_theme_mod( $theme_mods_key , maybe_unserialize( $theme_mods_value ) );
        // }

        // foreach ( $plugins_options as $plugin => $options ) {
        //     if( empty( $options ) ){
        //         continue;
        //     }
        //     foreach ( $options as $option => $value) {
        //         if( strpos( $option, 'page_id' ) !== false ) {
        //             $value = $this->get_meta_post_id( 'auxin_import_post', $value );
        //         }
        //         update_option( $option, maybe_unserialize( $value ) );
        //     }
        // }

        // // @deprecated A temporary fix for an issue with elementor typography scheme
        // $elementor_typo_scheme = [
        //     '1' => [
        //         'font_family' => 'Arial',
        //         'font_weight' => ''
        //     ],
        //     '2' => [
        //         'font_family' => 'Arial',
        //         'font_weight' => ''
        //     ],
        //     '3' => [
        //         'font_family' => 'Tahoma',
        //         'font_weight' => ''
        //     ],
        //     '4' => [
        //         'font_family' => 'Tahoma',
        //         'font_weight' => ''
        //     ]
        // ];
        // update_option( 'elementor_scheme_typography', $elementor_typo_scheme );

        // set_theme_mod( 'elementor_page_typography_scheme', 0 );

        // // Stores css content in custom css file
        // auxin_save_custom_css();
        // // Stores JavaScript content in custom js file
        // auxin_save_custom_js();

        // wp_send_json_success( array( 'step' => 'options', 'next' => 'menus', 'message' => __( 'Importing Menus', 'auxin-elements' ) ) );
    }



        public function get_demo_data(){
        // Get & return json data from local server
        if( false !== ( $data = @file_get_contents( $this->get_theme_dir() . '/json/sample-demo.json' ) ) ) {

            $data = json_decode( $data, true );
            return  $data['data'];
        }

        return false;
        }

        public function get_theme_dir(){

        if( defined( THEME_CUSTOM_DIR ) ) {
            return  THEME_CUSTOM_DIR;
        }

        $uploads = wp_get_upload_dir();
        return $uploads[ 'basedir' ] . '/' ;

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