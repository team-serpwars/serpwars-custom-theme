<?php
	require_once("serpwars-theme.importer.logger.server-events.php");
	class Serpwars_Theme_WXR_Import_UI {


		public function __construct( $options = array() ) {
			$empty_types = array(
			'post'    => array(),
			'comment' => array(),
			'term'    => array(),
			'user'    => array(),
			);
		}
		public function import() {
			$this->id = wp_unslash( (int) $_REQUEST['id'] );
			$this->fetch_attachments = true;
			$importer = $this->get_importer();

			// Are we allowed to create users?
			// if ( ! $this->allow_create_users() ) {
			// 	add_filter( 'wxr_importer.pre_process.user', '__return_null' );
			// }
			add_action( 'wxr_importer.processed.post', array( $this, 'imported_post' ), 10, 2 );
			add_action( 'wxr_importer.process_failed.post', array( $this, 'imported_post' ), 10, 2 );
			add_action( 'wxr_importer.process_already_imported.post', array( $this, 'already_imported_post' ), 10, 2 );
			add_action( 'wxr_importer.process_skipped.post', array( $this, 'already_imported_post' ), 10, 2 );
			add_action( 'wxr_importer.processed.comment', array( $this, 'imported_comment' ) );
			add_action( 'wxr_importer.process_already_imported.comment', array( $this, 'imported_comment' ) );
			add_action( 'wxr_importer.processed.term', array( $this, 'imported_term' ) );
			add_action( 'wxr_importer.process_failed.term', array( $this, 'imported_term' ) );
			add_action( 'wxr_importer.process_already_imported.term', array( $this, 'imported_term' ) );
			add_action( 'wxr_importer.processed.user', array( $this, 'imported_user' ) );
			add_action( 'wxr_importer.process_failed.user', array( $this, 'imported_user' ) );


			//Track ID

			$file = get_attached_file( $this->id );

			print_r($importer );
			die();

		}
		public function set_logger( $logger ) {
			$this->logger = $logger;
		}
		protected function get_importer() {


			$importer = new Serpwars_Theme_WXR_Importer( $this->get_import_options() );
			$logger = new Serpwars_Theme_Importer_Logger_ServerSentEvents();
			$importer->set_logger( $logger );
			return $importer;
		}
		protected function get_import_options() {
		// Dev 
		$options = array(
			'fetch_attachments' => $this->fetch_attachments,
			'default_author'    => 1,
		);

		// Production code
		// $options = array(
		// 	'fetch_attachments' => $this->fetch_attachments,
		// 	'default_author'    => get_current_user_id(),
		// );

		/**
		 * Filter the importer options used in the admin UI.
		 *
		 * @param array $options Options to pass to Customify_Sites_WXR_Importer::__construct
		 */
			return apply_filters( 'wxr_importer.admin.import_options', $options );
		}
	}
?>