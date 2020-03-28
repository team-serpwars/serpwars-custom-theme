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

            add_action( 'wp_ajax_serpwars_import_options'           , array( $this, 'import_options') );
            add_action( 'wp_ajax_nopriv_serpwars_import_options'           , array( $this, 'import_options') );

            add_action( 'wp_ajax_serpwars_import_acf_options'           , array( $this, 'import_acf_options') );
            add_action( 'wp_ajax_nopriv_serpwars_import_acf_options'           , array( $this, 'import_acf_options') );

            add_action( 'wp_ajax_serpwars_import_templates'           , array( $this, 'import_templates') );
            add_action( 'wp_ajax_nopriv_serpwars_import_templates'           , array( $this, 'import_templates') );

            add_action( 'wp_ajax_serpwars_import_elementor_templates'           , array( $this, 'import_template') );
            add_action( 'wp_ajax_nopriv_serpwars_import_elementor_templates'           , array( $this, 'import_template') );

            add_action( 'wp_ajax_nopriv_serpwars_uninstall_features'  , array($this, 'uninstall_features' ) );
            add_action( 'wp_ajax_serpwars_uninstall_features'  , array($this, 'uninstall_features' ) );
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
                die();
                wp_send_json_success();
            }


         }

        public function import_acf_options() {
            $data    = $this->get_demo_data();
            $theme_options = get_option("serpwars_theme_options");

            $json  = $data['acf'];


            if( isset($json['key']) ) {            
                $json = array( $json );             
            }

            $ids = array();
            $keys = array();
            $imported = array();

            foreach( $json as $field_group ) {
                $keys[] = $field_group['key'];
            }
            foreach( $keys as $key ) {
            // attempt find ID
            $field_group = _acf_get_field_group_by_key( $key );
            // bail early if no field group
            if( !$field_group ) continue;           
            // append
            $ids[ $key ] = $field_group['ID'];            
            }

            acf_enable_local();
            acf_reset_local();

            foreach( $json as $field_group ) {            
            // add field group
            acf_add_local_field_group( $field_group );            
            }

            foreach( $keys as $key ) {
            
            // vars
            $field_group = acf_get_local_field_group( $key );
            
            
            // attempt get id
            $id = acf_maybe_get( $ids, $key );
            
            if( $id ) {
                
                $field_group['ID'] = $id;
                
            }
            
            
            // append fields
            if( acf_have_local_fields($key) ) {
                
                $field_group['fields'] = acf_get_local_fields( $key );
                
            }
            
            
            // import
            $field_group = acf_import_field_group( $field_group );
            
            
            // append message
            $imported[] = array(
                'ID'        => $field_group['ID'],
                'title'     => $field_group['title'],
                'updated'   => $id ? 1 : 0
            );


        }

                foreach($imported as $index => $field_group){

                    $theme_options["acf"][$index]->id = $field_group['ID'];           
                    $theme_options["acf"][$index]->title = $field_group['title'];           
                    $theme_options["acf"][$index]->found = true;   
                }

        
            // if(isset($data['acf'])){
            //     $ids = array();
            //     foreach($data['acf'] as $index => $acf){
            //         if($theme_options["acf"][$index]->id == 0 || !get_post($theme_options["acf"][$index]->id)){ //Item has id of 0 or if it does not really exist at all
            //            if(function_exists ('acf_get_field_group_post')){                
            //             $post = acf_get_field_group_post( $acf['key'] );
            //             if( $post ) {
            //                 $acf['ID'] = $post->ID;
            //                 $theme_options["acf"][$index] = (object) array(
            //                     "id"=> $post->ID,
            //                     "title"=> $post->post_title,
            //                     "found"=> true
            //                 );
            //             }
            //             $field_group['ID'] = $post->ID;
            //             $acf = acf_import_field_group( $acf );
            //             $ids[] = $acf['ID'];
            //             $total = count($ids);
            //             $text = sprintf( _n( 'Imported 1 field group', 'Imported %s field groups', $total, 'acf' ), $total );   

            //            }else{

            //             $field_group = acf_get_local_field_group( $acf  );

            //             // attempt get id
            // $id = acf_maybe_get( $ids, $key );
            
            // if( $id ) {
                
            //     $field_group['ID'] = $id;
                
            // }
            
            
            // // append fields
            // if( acf_have_local_fields($key) ) {
                
            //     $field_group['fields'] = acf_get_local_fields( $key );
                
            // }
            
            
            // // import
            // $field_group = acf_import_field_group( $field_group );

           
            // $res = wp_update_post($field_group["ID"] ,array(
            //     'post_title'=>$acf["title"]
            // ));
            // wp_send_json_success(array($field_group, $res ,$field_group["ID"],$field_group->ID));



            //            }                                                                
            //         }

                   
                
            //     }
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

            // }
            // $this->import_options();
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
        public function uninstall_features(){
            $theme_options = get_option("serpwars_theme_options");
            $data    = $this->get_demo_data();
            $cpts = array();
            $new_plugin = array();
            $new_active_plugin = array();
            $plugins = $data["plugins"];
            $current_cpts =  get_option('cptui_post_types');
            $active_plugins =  get_option('active_plugins');


            foreach($active_plugins as $plugin){
                array_push($new_active_plugin,explode("/",$plugin)[0]);
            }

            foreach ($new_active_plugin as $index => $plugin) {
                if(!in_array($plugin, $plugins)){
                    array_push($new_plugin, $active_plugins[$index]);
                }
            }

            update_option('active_plugins',$new_plugin);

            foreach($data["menu"] as $menu_name => $menu){
                $menu_exists = wp_get_nav_menu_object( $menu_name );
                if($menu_exists){
                    wp_delete_nav_menu($menu_name);
                }
            }
            foreach($data["cptui"] as $name=>$cpt){
                array_push($cpts,$name);
            }


            if(!empty($theme_options)){
                $new_cpt = array();
                foreach ($theme_options['elementor_templates'] as $template) {
                    if(get_post($template->id)){
                        wp_delete_post( $template->id, true );
                    }                    # code...
                }

                foreach ($theme_options['acf'] as $acf) {
                    if(get_post($acf->id)){
                        wp_delete_post( $acf->id, true );
                    }                    # code...
                }

            foreach($current_cpts as $name=>$cpt){
                if(!in_array($name, $cpts)){
                    $new_cpt[$name]= $cpt;
                }
            }
            update_option('cptui_post_types',$new_cpt,true);


                if(get_post($theme_options['front_page'])){
                   wp_delete_post($theme_options['front_page'], true );
                   update_option("page_on_front",0,true);
                } 
            }

            delete_option( "serpwars_theme_options" );
            wp_send_json_success("Features Were Uninstalled");

        }
        public function import_front_page(){
            $data    = $this->get_demo_data();
            $theme_options = get_option("serpwars_theme_options");

            if(!isset($theme_options["front_page"]) || !get_post($theme_options["front_page"])){               

                if( false !== ( $data = @file_get_contents( 'https://serpwars-theme-templates.herokuapp.com/'.$data["front_page"]["url"]) ) ) {
                    $data = json_decode( $data, true );
                    $uploads_dir = wp_upload_dir();
                

                    if( strpos( $data["content"], '{{demo_uploads_url}}' ) !== false ) {
                        $data["content"] = str_replace( "{{demo_uploads_url}}", $uploads_dir["url"], $data["content"]) ;
                    }


                    $args = array(
                        'post_title'    => wp_strip_all_tags( $data["title"] ),
                        'post_status'   => 'publish',
                        'post_type'   => 'page',
                        'post_content'   => $data["content"],
                    );


                     $post_id = wp_insert_post( $args );

                      if(!is_wp_error($post_id)){
                        $theme_options["front_page"] = $post_id;
                    // $json_content = json_decode( $data , true );
                    update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
                    update_post_meta( $post_id, '_elementor_data',$data["meta"]["_elementor_data"]);
                    update_post_meta( $post_id, '_elementor_page_settings',unserialize($data["meta"]["_elementor_page_settings"]));
                    update_post_meta( $post_id, '_elementor_controls_usage',unserialize($data["meta"]["_elementor_controls_usage"]));
                    update_post_meta( $post_id, '_elementor_css',unserialize($data["meta"]["_elementor_css"]));
                    update_post_meta( $post_id, '_elementor_version', '2.9.3' );
                    update_post_meta( $post_id, '_elementor_pro_version', '2.8.3' );
                    update_post_meta( $post_id, '_edit_lock', '1583351696:1' );
    
                    //     if( ! empty( $page_template ) ){
                            update_post_meta( $post_id, '_wp_page_template', 'elementor_canvas' );
                    //     }
    
                    //     if( $post_type === 'elementor_library' ) {
                            update_post_meta( $post_id, '_elementor_template_type', "wp-page" );
                    //     }               
    
    
                        update_option("serpwars_theme_options","" );
                        update_option("serpwars_theme_options",$theme_options );
                        update_option("page_on_front",$post_id);

    
    
                    }else{
                    }


                }
            }

        }
        public function import_templates() {
            $data    = $this->get_demo_data();

            $this->import_menus($data);
            $this->import_front_page();

            if(isset($data['elementor_templates'])){             
                wp_send_json_success( $data['elementor_templates']) ;
            }
        }
        public function import_template() {

            $url = sanitize_text_field($_POST['url']);
            $name = sanitize_text_field($_POST['name']);
            $index = sanitize_text_field($_POST['index']);

             if( false !== ( $data = @file_get_contents( 'https://serpwars-theme-templates.herokuapp.com/'.$url ) ) ) {
             // if( false !== ( $data = @file_get_contents( $this->get_theme_dir() . 'json/'.$url ) ) ) {

            $template = json_decode( $data, true );
           

            $this->import_elementor_post($name,$index,$template);


            }       
        }

        public function import_menus($data){
            $data = $data["menu"];
            $this->get_menus($data);            
        }

        public function get_menus( array $args ) {


            
            foreach ($args as $menu_name => $menu_data) {
               

                if(! $menu_exists){ //toggle this
                $menu_id = wp_create_nav_menu($menu_name);
                // $menu_id = 6;
                    if( is_wp_error( $menu_id ) ) continue;

                    foreach ($menu_data['items'] as $item_key => $item_value) {
                        $meta_data = $item_value['menu-meta'];
                        $old_item_ID = $item_value['menu-item-current-id'];

                        unset( $item_value['menu-meta']             );
                        unset( $item_value['menu-item-current-id']  );
                        unset( $item_value['menu-item-attr-title']  );
                        unset( $item_value['menu-item-classes']     );
                        unset( $item_value['menu-item-description'] );
                        if( strpos( $item_value['menu-item-url'], '{{demo_home_url}}' ) !== false ) {
                                $item_value['menu-item-url'] = esc_url( str_replace( "{{demo_home_url}}", get_site_url(), $item_value['menu-item-url'] ) );
                        }
                        $item_value['menu-item-object-id'] = 0;

                        
                        $item_id = wp_update_nav_menu_item( $menu_id, 0, $item_value );
                        $post_id = $this->get_meta_post_id( '_menu_item_object_id', strval( $menu_data['id'] ) );

                        update_post_meta( $post_id, '_menu_item_object_id', $menu_id );


                        if ( is_wp_error( $item_id ) ) {
                            continue;
                        }
                         //Add 'meta-data' options for menu items
                    foreach ($meta_data as $meta_key => $meta_value) {

                        switch ( $meta_key ) {
                            case '_menu_item_object_id':
                                // Change exporter's object ID value
                                switch ( $item_value['menu-item-type'] ) {
                                    case 'post_type':
                                    case 'taxonomy':
                                        $meta_value = $item_value['menu-item-object-id'];
                                        break;
                                }
                                break;

                            case '_menu_item_menu_item_parent':
                                if( (int) $meta_value != 0 ) {
                                    $meta_value     = auxin_get_transient( 'auxin_menu_item_old_parent_id_' . $meta_value );
                                }
                                break;
                            case '_menu_item_url':
                                // if( ! empty( $meta_value ) ) {
                                    $meta_value     = $item_value['menu-item-url'];
                                // }
                                break;
                        }

                        update_post_meta( $item_id, $meta_key, $meta_value );

                    }
                    // wp_send_json_success("Menu ".$menu_name." Created");
                }
                # code...

                if( is_array( $menu_data['location'] ) ) {
                    // Putting up menu locations on theme_mods_phlox
                    $locations = get_theme_mod( 'nav_menu_locations' );
                    foreach ( $menu_data['location'] as $location_id => $location_name ) {
                        $locations[$location_name] = $menu_id;
                    }
                    set_theme_mod( 'nav_menu_locations', $locations );
                }
            }
        }


        }

            public function get_meta_post_id( $key, $value ) {

        global $wpdb;

        $sql = $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key=%s AND meta_value=%s", $key, $value );

        $meta = $wpdb->get_results( $sql );

        if ( is_array($meta) && !empty($meta) && isset($meta[0]) ) {
            $meta   =   $meta[0];
        }

        if ( is_object( $meta ) ) {
            return $meta->post_id;
        } else {
            return 0;
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
        // if( false !== ( $data = @file_get_contents( $this->get_theme_dir() . '/json/sample-demo.json' ) ) ) {
        if( false !== ( $data = @file_get_contents( 'https://serpwars-theme-templates.herokuapp.com/sample-demo.json' ) ) ) {

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
           //   if( false !== strpos( $requst['errors']['http_request_failed'][0], 'cURL error 28') ){
           //       set_theme_mod('increasing_curl_timeout_is_required', 15);
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