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
		}

		function ajax_import_content(){

        	// $this->user_can();

        	$import_ui = new Serpwars_Theme_WXR_Import_UI();
        	$import_ui->import();

        	// die( 'content_imported' );
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