<?php 
	class SW_Theme_Custom{
		static $_instance;
		static $version;
		static $theme_url;
		static $theme_name;
		static $theme_author;
		static $path;
	

	static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance    = new self();
			$theme              = wp_get_theme();
			self::$version      = $theme->get( 'Version' );
			self::$theme_url    = $theme->get( 'ThemeURI' );
			self::$theme_name   = $theme->get( 'Name' );
			self::$theme_author = $theme->get( 'Author' );
			self::$path         = get_template_directory();

			self::$_instance->init();
		}

		return self::$_instance;
	}

	function init() {
		// $this->init_hooks();
		$this->includes();
		$this->customizer = SW_Theme_Custom::get_instance();
		// $this->customizer->init();
		do_action( 'SW_Theme_Custom/init' );
	}
	private function includes() {
		$files = array(
		);

		foreach ( $files as $file ) {
			require_once self::$path . $file;
		}

		// $this->load_configs();
		// $this->load_compatibility();
		$this->admin_includes();
	}

	private function admin_includes() {
		if ( ! is_admin() ) {
			return;
		}

		$files = array(
			// '/inc/admin/editor.php',  // Metabox settings.
			'/inc/admin/dashboard.php',  // Metabox settings.
		);

		foreach ( $files as $file ) {
			require_once self::$path . $file;
		}

		// add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

}
?>