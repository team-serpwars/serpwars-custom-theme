<?php
	require_once("serpwars-theme-rest-api.php");
	class SW_Theme_Custom_Dashboard{
		static $_instance;
		public $title;
		public $config;
		public $current_tab = '';
		public $url         = '';
		protected $tgmpa_menu_slug 	= 'tgmpa-install-plugins';
		protected $tgmpa_url 		= 'themes.php?page=tgmpa-install-plugins';

		public $plugins;
		protected $tgmpa_instance;


		static function get_instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance      = new self();
				self::$_instance->url = admin_url( 'admin.php' );
				self::$_instance->url = add_query_arg(
					array( 'page' => 'serpwars' ),
					self::$_instance->url
				);
	
				self::$_instance->title = __( 'Theme Options', 'serpwars' );
				self::$_instance->tgmpa_instance 	= call_user_func( array( get_class( $GLOBALS['tgmpa'] ),'get_instance' ) );
				// add_action( 'init'					, array(  self::$_instance, 'get_tgmpa_instanse' ), 30 );
				add_action( 'admin_menu', array( self::$_instance, 'add_menu' ), 5 );
				add_action( 'admin_enqueue_scripts',array(self::$_instance ,'scripts' )  );

	
				add_action( 'admin_notices', array( self::$_instance, 'admin_notice' ) );
				add_action( 'wp_ajax_serpwars_setup_plugins'	, array(  Serpwars_Theme_API::get_instance(), 'ajax_plugins' ) );
				add_action( 'wp_ajax_nopriv_serpwars_setup_plugins'	, array(  Serpwars_Theme_API::get_instance(), 'ajax_plugins' ) );
				
	
			

				// add_action( 'admin_init', array( self::$_instance, 'admin_init' ) );
	
				// Tabs.
				// add_action( 'serpwars/dashboard/tab/changelog', array( self::$_instance, 'tab_changelog' ) );
	
			}
		return self::$_instance;

		}
		 function scripts($hook){


		if($hook=="toplevel_page_serpwars"){		
		wp_enqueue_style( 'serpwars-custom-theme-vendor', get_template_directory_uri()."/assets/css/chunk-vendors.708f6df1.css" , array(),"1.0.0", 'all');
		wp_enqueue_style( 'serpwars-custom-theme-app', get_template_directory_uri()."/assets/css/app.352b09dd.css" );
		wp_enqueue_script( "serpwars-custom-theme-vendor",  get_template_directory_uri()."/assets/js/chunk-vendors.6089e68e.js" , array(), "1.0.0", true );
		wp_enqueue_script( "serpwars-custom-theme-app",  get_template_directory_uri()."/assets/js/app.17180010.js" , array(), "1.0.0", true );

		wp_localize_script( 'serpwars-custom-theme-app', 'serpwars_setup_params', array(
            'tgm_plugin_nonce' => array(
                'update'  => wp_create_nonce( 'tgmpa-update' ),
                'install' => wp_create_nonce( 'tgmpa-install' ),
            ),
            'ajaxurl'          => admin_url( 'admin-ajax.php' ),
            'wpnonce'          => wp_create_nonce( 'serpwars_setup_nonce' ),
            'imported_done'    => esc_html__( 'This demo has been successfully imported.', 'serpwars' ),
            'imported_fail'    => esc_html__( 'Whoops! There was a problem in demo importing.', 'serpwars' ),
            'progress_text'    => esc_html__( 'Processing: Download', 'serpwars' ),
            'nextstep_text'    => esc_html__( 'Continue', 'serpwars' ),
            'activate_text'    => esc_html__( 'Install Plugins', 'serpwars' ),
            'makedemo_text'    => esc_html__( 'Import Content', 'serpwars' ),
            'btnworks_text'    => esc_html__( 'Installing...', 'serpwars' ),
            'onbefore_text'    => esc_html__( 'Please do not refresh or leave the page during the Installation process.', 'serpwars' ),
            'svg_loader'       => '<svg width="90" height="30" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg" fill="#505050"><circle cx="10" cy="10" r="10"><animate attributeName="r" from="10" to="10" begin="0s" dur="0.8s" values="10;9;10" calcMode="linear" repeatCount="indefinite" /><animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite" /></circle><circle cx="50" cy="10" r="9" fill-opacity="0.3"><animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;10;9" calcMode="linear" repeatCount="indefinite" /><animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite" /></circle><circle cx="90" cy="10" r="10"><animate attributeName="r" from="10" to="10" begin="0s" dur="0.8s" values="10;9;10" calcMode="linear" repeatCount="indefinite" /><animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite" /></circle></svg>'
        ) );


		}
 			// wp_enqueue_script( 'custom-plugin', get_template_directory_uri() . '/inc/plugins.js' ,array('jquery'),false,true);

 		

		}



		

		
		public function ajax_plugins() {
			// Inputs validations
			// if ( ! check_ajax_referer( 'serpwars_setup_nonce', 'wpnonce' ) || ! isset( $_POST['slug'] ) || empty( $_POST['slug'] ) ) {
			// 	wp_send_json_error( array( 'message' => esc_html__( 'No Slug Found', 'serpwars' ) ) );
			// }
        	$request = array();
        	// send back some json we use to hit up TGM
        	$plugins = $this->get_plugins();
        	foreach ( $plugins['activate'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$request = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-activate',
					'action2'       => - 1,
					'message'       => esc_html__( 'Activating', 'serpwars' ),
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
					'message'       => esc_html__( 'Updating', 'serpwars' ),
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
					'message'       => esc_html__( 'Installing', 'serpwars' ),
				);
				break;
			}
		}

		if ( ! empty( $request ) ) {
			$request['hash'] = md5( serialize( $request ) ); // used for checking if duplicates happen, move to next plugin
			wp_send_json_success( $request );
		}

        wp_send_json_success( array( 'message' => esc_html__( 'Activated', 'serpwars' ) ) );

		}
		function box_plugins() {

		?>
		<div class="cd-box box-plugins">
			<div class="cd-box-top"><?php _e( 'Custom Serpwars Theme ready to import sites', 'serpwars' ); ?></div>
			<div class="cd-sites-thumb">
				<!-- <img src="<?php echo esc_url( get_template_directory_uri() ) . '/assets/images/admin/sites_thumbnail.jpg'; ?>"> -->
			</div>
			<div class="cd-box-content">
				<p><?php _e( '<strong>Custom Serpwars Theme Addons</strong> is a free add-on for the Custom Serpwars Theme theme which help you browse and import ready made websites with few clicks.', 'serpwars' ); ?></p>

					<!-- Maybe Just try to integrate the plugin functionality to the theme ? will save us extra clicks -->
					<
				<?php

				$plugin_slug = 'serpwars-sites';
				$plugin_info = array(
					'name'            => 'serpwars-sites',
					'active_filename' => 'serpwars-sites/serpwars-sites.php',
				);

				$plugin_info  = wp_parse_args(
					$plugin_info,
					array(
						'name'            => '',
						'active_filename' => '',
					)
				);
				$status       = is_dir( WP_PLUGIN_DIR . '/' . $plugin_slug );
				$button_class = 'install-now button';               if ( $plugin_info['active_filename'] ) {
					$active_file_name = $plugin_info['active_filename'];
				} else {
					$active_file_name = $plugin_slug . '/' . $plugin_slug . '.php';
				}

				$sites_url = add_query_arg(
					array(
						'page' => 'serpwars-sites',
					),
					admin_url( 'themes.php' )
				);

				$view_site_txt = __( 'View Site Library', 'serpwars' );

				if ( ! is_plugin_active( $active_file_name ) ) {
					$button_txt = esc_html__( 'Install Now', 'serpwars' );
					if ( ! $status ) {
						$install_url = wp_nonce_url(
							add_query_arg(
								array(
									'action' => 'install-plugin',
									'plugin' => $plugin_slug,
								),
								network_admin_url( 'update.php' )
							),
							'install-plugin_' . $plugin_slug
						);

					} else {
						$install_url  = add_query_arg(
							array(
								'action'        => 'activate',
								'plugin'        => rawurlencode( $active_file_name ),
								'plugin_status' => 'all',
								'paged'         => '1',
								'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $active_file_name ),
							),
							network_admin_url( 'plugins.php' )
						);
						$button_class = 'activate-now button-primary';
						$button_txt   = esc_html__( 'Active Now', 'serpwars' );
					}

					$detail_link = add_query_arg(
						array(
							'tab'       => 'plugin-information',
							'plugin'    => $plugin_slug,
							'TB_iframe' => 'true',
							'width'     => '772',
							'height'    => '349',

						),
						network_admin_url( 'plugin-install.php' )
					);

					echo '<div class="rcp">';
					echo '<p class="action-btn plugin-card-' . esc_attr( $plugin_slug ) . '"><a href="' . esc_url( $install_url ) . '" data-slug="' . esc_attr( $plugin_slug ) . '" class="' . esc_attr( $button_class ) . '">' . $button_txt . '</a></p>'; // WPCS: XSS OK.
					echo '<a class="plugin-detail thickbox open-plugin-details-modal" href="' . esc_url( $detail_link ) . '">' . esc_html__( 'Details', 'serpwars' ) . '</a>';
					echo '</div>';
				} else {
					echo '<div class="rcp">';
					echo '<p ><a href="' . esc_url( $sites_url ) . '" data-slug="' . esc_attr( $plugin_slug ) . '" class="view-site-library">' . $view_site_txt . '</a></p>'; // // WPCS: XSS OK.
					echo '</div>';
				}

				?>
				<script type="text/javascript">
					jQuery( document ).ready( function($){
						var  sites_url = <?php echo json_encode( $sites_url ); // phpcs:ignore ?>;
						var  view_sites = <?php echo json_encode( $view_site_txt ); // phpcs:ignore ?>;
						

						$( '#plugin-filter .box-plugins' ).on( 'click', '.activate-now', function( e ){
							e.preventDefault();
							var button = $( this );
							var url = button.attr('href');
							button.addClass( 'button installing updating-message' );
							$.get( url, function( ){
								$( '.rcp .plugin-detail' ).hide();
								button.attr( 'href', sites_url );
								button.attr( 'class', 'view-site-library' );
								button.text( view_sites );
							} );
						} );
					} );
				</script>
			</div>
		</div>
		<?php
	}
	function get_plugin_file( $plugin_slug ) {
		$installed_plugins = get_plugins();
		foreach ( (array) $installed_plugins as $plugin_file => $info ) {
			if ( strpos( $plugin_file, $plugin_slug . '/' ) === 0 ) {
				return $plugin_file;
			}
		}
		return false;
	}

	function box_recommend_plugins() {
		/*
		 Elementor, CPT UI, Advanced Custom Fields PRO, font-awesome, DynamicConditions,
		*/
		$list_plugins = array(
			'elementor',
			'custom-post-type-ui',
			'advanced-custom-fields',
			'font-awesome',
			'dynamicconditions',
		);

		$list_plugins = apply_filters( 'serpwars/recommend-plugins', $list_plugins );
		$key          = 'serpwars_plugins_info_' . wp_hash( json_encode( $list_plugins ) ); // phpcs:ignore
		$plugins_info = get_transient( $key );
		if ( false === $plugins_info ) {
			$plugins_info = array();
			if ( ! function_exists( 'plugins_api' ) ) {
				require_once ABSPATH . '/wp-admin/includes/plugin-install.php';
			}
			foreach ( $list_plugins as $slug ) {
				$info = plugins_api( 'plugin_information', array( 'slug' => $slug ) );
				if ( ! is_wp_error( $info ) ) {
					$plugins_info[ $slug ] = $info;
				}
			}
			set_transient( $key, $plugins_info );
		}

		$html = '';
		foreach ( $plugins_info as $plugin_slug => $info ) {
			$status      = is_dir( WP_PLUGIN_DIR . '/' . $plugin_slug );
			$plugin_file = $this->get_plugin_file( $plugin_slug );
			if ( ! is_plugin_active( $plugin_file ) ) {
				$html .= '<div class="cd-list-item">';
				$html .= '<p class="cd-list-name">' . esc_html( $info->name ) . '</p>';
				if ( $status ) {
					$button_class = 'activate-now';
					$button_txt   = esc_html__( 'Activate', 'serpwars' );
					$url          = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . urlencode( $plugin_file ), 'activate-plugin_' . $plugin_file ); // phpcs:ignore
				} else {
					$button_class = 'install-now';
					$button_txt   = esc_html__( 'Install Now', 'serpwars' );
					$url          = wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'install-plugin',
								'plugin' => $plugin_slug,
							),
							network_admin_url( 'update.php' )
						),
						'install-plugin_' . $plugin_slug
					);
				}

				$detail_link = add_query_arg(
					array(
						'tab'       => 'plugin-information',
						'plugin'    => $plugin_slug,
						'TB_iframe' => 'true',
						'width'     => '772',
						'height'    => '349',
					),
					network_admin_url( 'plugin-install.php' )
				);

				$class = 'action-btn plugin-card-' . $plugin_slug;

				$html .= '<div class="rcp">';
				$html .= '<p class="' . esc_attr( $class ) . '"><a href="' . esc_url( $url ) . '" data-slug="' . esc_attr( $plugin_slug ) . '" class="' . esc_attr( $button_class ) . '">' . $button_txt . '</a></p>';
				$html .= '<a class="plugin-detail thickbox open-plugin-details-modal" href="' . esc_url( $detail_link ) . '">' . esc_html__( 'Details', 'serpwars' ) . '</a>';
				$html .= '</div>';

				$html .= '</div>';
			}
		} // end foreach

		if ( $html ) {
			?>
			<div class="cd-box">
				<div class="cd-box-top"><?php _e( 'Recommend Plugins', 'serpwars' ); ?></div>
				<div class="cd-box-content cd-list-border">
					<?php
						echo $html; // WPCS: XSS OK.
					?>
				</div>
			</div>
			<?php
		}
	}

		function add_menu() {
			add_menu_page(
				$this->title,
				$this->title,
				'manage_options',
				'serpwars',
				array( $this, 'page' ),
				'',
				2
			);
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
		function setup() {
			$theme        = wp_get_theme();
			if ( is_child_theme() ) {
				$theme = $theme->parent();
			}
			$this->config = array(
				'name'       => $theme->get( 'Name' ),
				'theme_uri'  => $theme->get( 'ThemeURI' ),
				'desc'       => $theme->get( 'Description' ),
				'author'     => $theme->get( 'Author' ),
				'author_uri' => $theme->get( 'AuthorURI' ),
				'version'    => $theme->get( 'Version' ),
			);

			$custom_list = array();
			self::$_instance->plugins = $this->get_plugins( $custom_list );

			$this->current_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : ''; // phpcs:ignore


		}
		function page() {
			$this->setup();
			// $this->page_header();
			// $this->page_content();
			$this->page_contents();
			echo '<div class="wrap">';
			$cb = apply_filters( 'serpwars/dashboard/content_cb', false );
			if ( ! is_callable( $cb ) ) {
				$cb = array( $this, 'page_inner' );
			}
	
			if ( is_callable( $cb ) ) {
				call_user_func_array( $cb, array( $this ) );
			}
	
			echo '</div>';
		}
		public function page_contents() { ?>
			<div id="app"></div>
		<?php }
		public function page_content() { ?>
			<div class="required-plugins">
				<?php $plugins = $this->get_plugins();?>
			
				<ul class="serpwars-wizard-plugins">


					<?php	foreach ( $plugins['all'] as $slug => $plugin ) { ?>
						<li class="serpwars-plugin" data-slug="<?php echo esc_attr( $slug ); ?>">
							<label class="serpwars-control serpwars-checkbox">
								<?php echo esc_html( $plugin['name'] ); ?>
								<input name="plugin[]" value="<?php echo esc_attr($slug); ?>" type="checkbox" checked>
								<div class="serpwars-indicator"></div>
							</label>
							<div class="status column-status">
							<?php
							    $keys = $class = '';
							    if ( isset( $plugins['install'][ $slug ] ) ) {
								    $keys 	= esc_html__( 'Ready to install', 'serpwars' );
								    $class  = 'install';
							    }
							    if ( isset( $plugins['activate'][ $slug ] ) ) {
								    $keys 	= esc_html__( 'Not activated', 'serpwars' );
								    $class  = 'activate';
							    }
							    if ( isset( $plugins['update'][ $slug ] ) ) {
								    $keys 	= esc_html__( 'Ready to update', 'serpwars' );
								    $class  = 'update';
							    }
						    ?>
								<span class="<?php echo $class ?>">
									<?php echo $keys; ?>
								</span>
								<div class="spinner"></div>
				            </div>
						</li>
					<?php } ?>
				</ul>
				<div class="serpwars-sticky">
        			<div class="serpwars-setup-actions step">
        				<a href="#"
        				   class="serpwars-button serpwars-primary install-plugins "
        				   data-callback="install_plugins"><?php esc_html_e( 'Install Plugins', 'serpwars' ); ?></a>
        				<?php wp_nonce_field( 'serpwars-setup' ); ?>

        				<a href="#"
        				   class="serpwars-button serpwars-primary demo-importer "
        				   data-callback="demo_iporter"><?php esc_html_e( 'Import Demo Data', 'serpwars' ); ?></a>
        			</div>
        		</div>
			</div>
			
		<?php }
		public function page_header() {
		?>
		<div class="cd-header">
			<div class="cd-row">
				<div class="cd-header-inner">
					<?php $welcome_page_title = sprintf( __( 'Welcome to %s', 'serpwars' ) . '</strong>',  '<strong>'. $this->config['name']); ?>
					<h1 class="cd-header-title"><?php echo wp_kses( $welcome_page_title, array(
                		'br' => array(),
                		'em' => array(),
                		'strong' => array(),
            		) ); ?></h1>
					
					<span class="cd-version"><?php echo esc_html( $this->config['version'] ); ?></span>				

				</div>
			</div>
		</div>
		<div class="serpwars-setup-content"> 
            	<div class="serpwars-section-content-box"> 
            		<h3 class="serpwars-content-title"><?php _e('Recommended Plugins', 'serpwars' ); ?></h3>
            		 <p style="margin-bottom:0;"><?php echo sprintf( esc_html__( 'The following is a list of best integrated plugins for %s , you can install them from here and add or remove them later on WordPress plugins page.', 'serpwars' ), $this->config['name'] );?></p> 
            	</div> 
            </div> 
		<?php
		}
	

			private function page_inner() {
		?>
		<div id="plugin-filter" class="cd-row metabox-holder">
			<hr class="wp-header-end">
			<?php

			do_action( 'serpwars/dashboard/start', $this );

			if ( $this->current_tab && has_action( 'serpwars/dashboard/tab/' . $this->current_tab ) ) {
				do_action( 'serpwars/dashboard/tab/' . $this->current_tab, $this );
			} else {
				?>
				<div class="cd-main">
					<?php do_action( 'serpwars/dashboard/main', $this ); ?>
				</div>
				<div class="cd-sidebar">
					<?php do_action( 'serpwars/dashboard/sidebar', $this ); ?>
				</div>
				<?php
			}

			do_action( 'serpwars/dashboard/end', $this );

			?>
		</div>
		<?php
	}

		function admin_notice() {
		global $pagenow;
		if ( is_admin() && ( 'themes.php' == $pagenow ) && isset( $_GET['activated'] ) ) {
			// serpwars_maybe_change_header_version();
			?>
		<div class="serpwars-notice-wrapper notice is-dismissible">
			<div class="serpwars-notice">
				<div class="serpwars-notice-img">
					<!-- <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/admin/serpwars_logo@2x.png' ); ?>" alt="<?php esc_attr_e( 'logo', 'serpwars' ); ?>"> -->
				</div>
				<div class="serpwars-notice-content">
					<div class="serpwars-notice-heading"><?php _e( 'Thanks for installing Customify, you rock! <img draggable="false" class="emoji" alt="" src="https://s.w.org/images/core/emoji/2.4/svg/1f918.svg">', 'serpwars' ); ?></div>
					<p><?php printf( __( 'To fully take advantage of the best our theme can offer please make sure you visit our <a href="%1$s">Customify options page</a>.', 'serpwars' ), esc_url( admin_url( 'themes.php?page=serpwars' ) ) ); ?></p>
					<?php if ( is_child_theme() ) { ?>
						<?php $child_theme = wp_get_theme(); ?>
						<?php printf( esc_html__( 'You\'re using %1$s theme, It\'s a child theme of %2$s.', 'serpwars' ), '<strong>' . $child_theme->Name . '</strong>', '<strong>' . esc_html__( 'Customify', 'serpwars' ). '</strong>' ); // phpcs:ignore ?>
						<?php
						$copy_link_args = array(
							'page' => 'serpwars',
							'action' => 'show_copy_settings',
						);
						$copy_link = add_query_arg( $copy_link_args, admin_url( 'themes.php' ) );
						?>
						<?php printf( '%s <a href="%s" class="go-to-setting">%s</a>', esc_html__( 'Now you can copy setting data from parent theme to this child theme', 'serpwars' ), esc_url( $copy_link ), esc_html__( 'Copy Settings', 'serpwars' ) ); ?>
					<?php } ?>
				</div>
			</div>
		</div>
			<?php
		}
		if ( isset( $_GET['copied'] ) && 1 == $_GET['copied'] ) {
			?>
			<div class="notice notice-success is-dismissible">
				<p><strong><span class="dashicons dashicons-yes" style="color: #79ba49;"></span>&nbsp;<?php esc_html_e( 'Your theme settings were copied.', 'serpwars' ); ?></strong></p>
			</div>
			<?php
		}
	}

	}

	SW_Theme_Custom_Dashboard::get_instance();
?>