<?php
	// no direct access allowed
	if ( ! defined('ABSPATH') )  exit;

	// require_once("modules/serpwars-theme.exporter.php");
	// require_once("modules/serpwars-theme.import-ui.php");
	// require_once("modules/serpwars-theme.ajax.php");
	require_once("modules/serpwars-theme.demo-importer.php");
	require_once("modules/serpwars-theme.base.php");

	class Serpwars_Theme_API extends Serpwars_Welcome_Base {
		protected static $instance 	= null;
		protected $tgmpa_instance;
		protected $tgmpa_url 		= 'themes.php?page=tgmpa-install-plugins';
		protected $tgmpa_menu_slug 	= 'tgmpa-install-plugins';

		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance 	= new self;
			}
			return self::$instance;
		}

		public function __construct() {
        	parent::__construct();
			$this->init_globals();
			$this->init_actions();
		}

		public function init_globals() {
			$this->page_slug       	= 'serpwars-theme';
        	$this->parent_slug      = 'serpwars-theme';
		}

		public function init_actions() { 
			parent::init_actions();

			if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
				add_action( 'init'					, array( $this, 'get_tgmpa_instanse' ), 30 );
				add_action( 'init'					, array( $this, 'set_tgmpa_url' ), 40 );
			}
			Serpwars_Demo_Importer::get_instance();

			add_filter( 'tgmpa_load'				, array( $this, 'tgmpa_load' ), 10, 1 );
            add_action( 'wp_ajax_serpwars_setup_plugins'	, array( $this, 'ajax_plugins' ) );
            add_action( 'wp_ajax_nopriv_serpwars_setup_plugins'	, array( $this, 'ajax_plugins' ) );
            add_action( 'wp_ajax_serpwars_demo_data'       , array( $this, 'import') );
            add_action( 'wp_ajax_nopriv_serpwars_demo_data'       , array( $this, 'import') );
            if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
				add_action( 'init'					, array( $this, 'get_tgmpa_instanse' ), 30 );
				add_action( 'init'					, array( $this, 'set_tgmpa_url' ), 40 );
			}


			if( isset( $_POST['action'] ) && $_POST['action'] === "serpwars_setup_plugins" && wp_doing_ajax() ) {		
				add_filter( 'wp_redirect', '__return_false', 1 );
			}

		}

		public function set_tgmpa_url() {
			$this->tgmpa_menu_slug 	= ( property_exists( $this->tgmpa_instance, 'menu' ) ) ? $this->tgmpa_instance->menu : $this->tgmpa_menu_slug;
			$this->tgmpa_menu_slug 	= apply_filters( $this->theme_id . '_theme_setup_wizard_tgmpa_menu_slug', $this->tgmpa_menu_slug );
	
			$tgmpa_parent_slug 		= ( property_exists( $this->tgmpa_instance, 'parent_slug' ) && $this->tgmpa_instance->parent_slug !== 'themes.php' ) ? 'admin.php' : 'themes.php';
	
			$this->tgmpa_url 		= apply_filters( $this->theme_id . '_theme_setup_wizard_tgmpa_url', $tgmpa_parent_slug . '?page=' . $this->tgmpa_menu_slug );
		}

		public function tgmpa_load( $status ) {
			return true;;
			// return is_admin() || current_user_can( 'install_themes' );
		}
		public function ajax_plugins() {
			$request = array();
			$plugins = $this->get_plugins();


		foreach ( $plugins['activate'] as $slug => $plugin ) {
			if ( $slug === 'related-posts-for-wp' ) {
				update_option( 'rp4wp_do_install', false );
			}
			if ( $_POST['slug'] == $slug ) {
				$request = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-activate',
					'action2'       => - 1,
					'message'       => esc_html__( 'Activating', 'serpwars-theme' ),
				);
				break;
			}
		}

		
		foreach ( $plugins['update'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$request = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-update',
					'action2'       => - 1,
					'message'       => esc_html__( 'Updating', 'serpwars-theme' ),
				);
				break;
			}
		}
		foreach ( $plugins['install'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$request = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-install',
					'action2'       => - 1,
					'message'       => esc_html__( 'Installing', 'serpwars-theme' ),
				);
				break;
			}
		}

		if ( ! empty( $request ) ) {
			$request['hash'] = md5( serialize( (object)$request ) ); // used for checking if duplicates happen, move to next plugin
			wp_send_json_success( (object)$request );
		}

        wp_send_json_success( array( 'message' => esc_html__( 'Activated', 'serpwars-theme' ) ) );


		}
		public function get_tgmpa_instanse() {
			$this->tgmpa_instance 	= call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );

		}

		private function get_plugins( $custom_list = array() ) {

			$plugins  = array(
				'all'      => array(), // Meaning: all plugins which still have open actions.
				'install'  => array(),
				'update'   => array(),
				'activate' => array(),
        	);
			foreach ( $this->tgmpa_instance->plugins as $slug => $plugin ) {

				if( ! empty( $custom_list ) && ! in_array( $slug, $custom_list ) ){
					// This condition is for custom requests lists
					continue;
				} elseif( $this->tgmpa_instance->is_plugin_active( $slug ) && false === $this->tgmpa_instance->does_plugin_have_update( $slug ) ) {
					// No need to display plugins if they are installed, up-to-date and active.
					continue;
				} else {
					$plugins['all'][ $slug ] = $plugin;
	
					if ( ! $this->tgmpa_instance->is_plugin_installed( $slug ) ) {
						$plugins['install'][ $slug ] = $plugin;
					} else {
	
						if ( false !== $this->tgmpa_instance->does_plugin_have_update( $slug ) ) {
							$plugins['update'][ $slug ] = $plugin;
						}
						if ( $this->tgmpa_instance->can_plugin_activate( $slug ) ) {
							$plugins['activate'][ $slug ] = $plugin;
						}
	
					}
				}
			}

        	return $plugins;


		}


	
	}


	

    Serpwars_Theme_API::get_instance();
	
?>