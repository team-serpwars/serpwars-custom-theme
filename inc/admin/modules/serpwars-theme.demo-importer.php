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

            add_action( 'wp_ajax_nopriv_serpwars_load_options'           , array( $this, 'load_options') );
            add_action( 'wp_ajax_serpwars_load_options'           , array( $this, 'load_options') );
            add_action( 'wp_ajax_serpwars_import_step'           , array( $this, 'import_step') );
            add_action( 'wp_ajax_nopriv_serpwars_import_step'           , array( $this, 'import_step') );
            add_action( 'wp_ajax_nopriv_serpwars_import_options'           , array( $this, 'import_options') );
            add_action( 'wp_ajax_nopriv_serpwars_import_acf_options'           , array( $this, 'import_acf_options') );

            add_action( 'wp_ajax_serpwars_import_templates'           , array( $this, 'import_templates') );
            add_action( 'wp_ajax_nopriv_serpwars_import_templates'           , array( $this, 'import_templates') );
            add_action( 'wp_ajax_serpwars_import_elementor_templates'           , array( $this, 'import_template') );
            add_action( 'wp_ajax_nopriv_serpwars_import_elementor_templates'           , array( $this, 'import_template') );
    	    // add_action( 'wp_ajax_auxin_templates_data'  , array( $this, 'templates') );
    	    // add_action( 'wp_ajax_import_step'           , array( $this, 'import_step') );
    	}

    	 public function load_options() {

            $theme_options = get_option("serpwars_theme_options") ? get_option("serpwars_theme_options") : array();

            if(empty($theme_options)){
                $data    = $this->get_demo_data();

                $options = array(
                    "elementor_templates" => array(),
                    "acf"=>array(),
                    "cptui"=>array()
                );               

                foreach ($data['elementor_templates'] as $i=>$item) {
                    array_push($options["elementor_templates"],(object)array(
                        "name" => $item['name'],
                        "id" => 0
                    ));            
                }
                foreach ($data['acf'] as $i=>$item) {
                    array_push($options["acf"],(object)array(
                        "title" => $item['title'],
                        "id" => 0
                    ));            
                }

                foreach ($data['cptui'] as $i=>$item) {
                    array_push($options["cptui"],(object)array(
                        "slug" => $item['name'],
                        "title" => $item['label']
                    ));                
                }
                
                // print_r($options);

                update_option("serpwars_theme_options",$options );
                $theme_options = get_option("serpwars_theme_options") ;
            }

            wp_send_json_success($theme_options);


         }
         public function import() {
    	 	//

    	 	$data = json_decode( $this->parse( 'https://localhost/custom-site/wp-content/uploads/json/sample-data.json', 'insert', 'post' ), true );



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

        public function import_acf_options2() {
        }
        public function import_acf_options() {
            $data    = $this->get_demo_data();
            $theme_options = get_option("serpwars_theme_options");


            if(isset($data['acf'])){
                $ids = array();
                foreach($data['acf'] as $index => $acf){
                    if($theme_options["acf"][$index]->id == 0 ){
                        $post = acf_get_field_group_post( $acf['key'] );
                        if( $post ) {
                            $acf['ID'] = $post->ID;
                            $theme_options["acf"][$index] = (object) array(
                                "id"=> $post->ID,
                                "title"=> $post->post_title,
                                "found"=> true
                            );
                        }
                        $field_group['ID'] = $post->ID;
                        $acf = acf_import_field_group( $acf );
                        $ids[] = $acf['ID'];
                        $total = count($ids);
                        $text = sprintf( _n( 'Imported 1 field group', 'Imported %s field groups', $total, 'acf' ), $total );                       
                       

                    }              
                
                }


            update_option("serpwars_theme_options","" );
            update_option("serpwars_theme_options",$theme_options );

            }

            wp_send_json_success($theme_options);
        }
        public function import_options() {
            $data    = $this->get_demo_data();
            $theme_options = get_option("serpwars_theme_options");

            if(isset($data['cptui'])){
                $cptdata = get_option( 'cptui_post_types', false );
                $cptdata = ($cptdata) ? $cptdata : array();
                $cpt = array();
                $acf_local = array();

                    // print_r($cptdata[$item['name']]['name']);
                foreach ($data['cptui'] as $i=>$item) {
                    // Check if item exist
                    if(!isset($cptdata[$item['name']])){
                        $cptdata[$item['name']] = $item;                    
                    }
                    array_push($cpt,(object) array(
                        "slug" => $item['name'],
                        "title" => $item['label'],
                        "found" => true,
                    ));

                }

                update_option('cptui_post_types',$cptdata,true);
                $theme_options["cptui"] = $cpt;

            }

            

            update_option("serpwars_theme_options","" );
            update_option("serpwars_theme_options",$theme_options );
            wp_send_json_success($theme_options);
        }
        public function import_templates() {
            $data    = $this->get_demo_data();
            if(isset($data['elementor_templates'])){             
                wp_send_json_success( $data['elementor_templates']) ;
            }
        }
        public function import_template() {

            $url = sanitize_text_field($_POST['url']);
            $name = sanitize_text_field($_POST['name']);
            $index = sanitize_text_field($_POST['index']);

             if( false !== ( $data = @file_get_contents( $this->get_theme_dir() . 'json/'.$url ) ) ) {

            $template = json_decode( $data, true );

            $this->import_elementor_post($name,$index,$template);

            }       
        }
        public function import_step() {
            $data    = $this->get_demo_data();

            if( ! is_array( $data ) ){
                wp_send_json_error( array( 'message' => __( 'Error in getting data!', 'serpwars' ) ) );
            }



            $options = get_option( 'serpwars_demo_options', false );
            $options = ($options) ? $options : array();


            // return $this->import_options( $data['options'] );


            die();
        }

            public function import_elementor_data( array $templates ) {               
                foreach($templates as $template){
                    

                    // $this->import_elementor_post($template);

                    // print_r($template);
                }
            }

            public function import_elementor_post($name,$index,$template){
                $theme_options = get_option("serpwars_theme_options");
                $page_template = $template["type"];
                $template_title = $template["title"];
                $item_index = -1;

                // foreach ($theme_options["elementor_templates"] as $index=>$item) {
                $item = $theme_options["elementor_templates"][$index];
                    if($name == $item->name && !get_post($item->id)){
                         extract($template);

                $sanitize_key    = sanitize_key(  $page_template  );

                $args = array(
                    'post_title'    => wp_strip_all_tags( $item->name ),
                    'post_status'   => 'publish',
                    'post_type'     => 'elementor_library'
                );

                $post_id = wp_insert_post( $args );


                    if(!is_wp_error($post_id)){
                    // $json_content = json_decode( $data , true );
                    update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
                    update_post_meta( $post_id, '_elementor_data',$content);
                    update_post_meta( $post_id, '_elementor_version', '2.5.14' );
    
                    //     if( ! empty( $page_template ) ){
                            update_post_meta( $post_id, '_wp_page_template', '_default' );
                    //     }
    
                    //     if( $post_type === 'elementor_library' ) {
                            update_post_meta( $post_id, '_elementor_template_type', $page_template );
                    //     }               
                        $theme_options["elementor_templates"][$index]->id = $post_id;
    
    
                        update_option("serpwars_theme_options","" );
                        update_option("serpwars_theme_options",$theme_options );
    
                        wp_send_json_success(array(
                            "option"=>$theme_options,
                            "post_id"=>$post_id,
                            "stuff"=>$theme_options["elementor_templates"][$index]->id
                        ));
    
                    }else{
                    //     //there was an error in the post insertion,
                        // $data = false;
                        wp_send_json_error($post_id);
                    }


               
                }elseif (get_post($item->id)) {
                    wp_send_json_success(array(
                    "option"=>$theme_options,
                    "post_id"=>$post_id,
                    "stuff"=>$theme_options["elementor_templates"][$index]->id
                    ));
                }                    
                // }
               

                // print_r($post_id);
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