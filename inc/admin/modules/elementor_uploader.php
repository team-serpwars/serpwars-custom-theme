<?php
    if ( ! defined('ABSPATH') )  exit;

	use Elementor\Core\Base\Document;
	use Elementor\Core\Editor\Editor;
	use Elementor\DB;
	use Elementor\Core\Settings\Manager as SettingsManager;
	use Elementor\Core\Settings\Page\Model;
	use Elementor\Modules\Library\Documents\Library_Document;
	use Elementor\Plugin;
	use Elementor\Utils;

    if(class_exists ("Elementor\TemplateLibrary\Source_Base")){        
		        class ElementorUploader extends Elementor\TemplateLibrary\Source_Base{
		        	/**
			 * Elementor template-library post-type slug.
			 */
			const CPT = 'elementor_library';
		
			/**
			 * Elementor template-library taxonomy slug.
			 */
			const TAXONOMY_TYPE_SLUG = 'elementor_library_type';
		
			/**
			 * Elementor template-library category slug.
			 */
			const TAXONOMY_CATEGORY_SLUG = 'elementor_library_category';
		
			/**
			 * Elementor template-library meta key.
			 * @deprecated 2.3.0 Use \Elementor\Core\Base\Document::TYPE_META_KEY instead
			 */
			const TYPE_META_KEY = '_elementor_template_type';
		
			/**
			 * Elementor template-library temporary files folder.
			 */
			const TEMP_FILES_DIR = 'elementor/tmp';
		
			/**
			 * Elementor template-library bulk export action name.
			 */
			const BULK_EXPORT_ACTION = 'elementor_export_multiple_templates';
		
			const ADMIN_MENU_SLUG = 'edit.php?post_type=elementor_library';
		
			const ADMIN_SCREEN_ID = 'edit-elementor_library';

        	public function get_id() {
				return 'local';
			}
			public function get_title() {
				return __( 'Local', 'elementor' );
			}
			public function register_data() {
				$labels = [
					'name' => _x( 'My Templates', 'Template Library', 'elementor' ),
					'singular_name' => _x( 'Template', 'Template Library', 'elementor' ),
					'add_new' => _x( 'Add New', 'Template Library', 'elementor' ),
					'add_new_item' => _x( 'Add New Template', 'Template Library', 'elementor' ),
					'edit_item' => _x( 'Edit Template', 'Template Library', 'elementor' ),
					'new_item' => _x( 'New Template', 'Template Library', 'elementor' ),
					'all_items' => _x( 'All Templates', 'Template Library', 'elementor' ),
					'view_item' => _x( 'View Template', 'Template Library', 'elementor' ),
					'search_items' => _x( 'Search Template', 'Template Library', 'elementor' ),
					'not_found' => _x( 'No Templates found', 'Template Library', 'elementor' ),
					'not_found_in_trash' => _x( 'No Templates found in Trash', 'Template Library', 'elementor' ),
					'parent_item_colon' => '',
					'menu_name' => _x( 'Templates', 'Template Library', 'elementor' ),
				];
		
				$args = [
					'labels' => $labels,
					'public' => true,
					'rewrite' => false,
					'menu_icon' => 'dashicons-admin-page',
					'show_ui' => true,
					'show_in_menu' => true,
					'show_in_nav_menus' => false,
					'exclude_from_search' => true,
					'capability_type' => 'post',
					'hierarchical' => false,
					'supports' => [ 'title', 'thumbnail', 'author', 'elementor' ],
				];
		
				/**
				 * Register template library post type args.
				 *
				 * Filters the post type arguments when registering elementor template library post type.
				 *
				 * @since 1.0.0
				 *
				 * @param array $args Arguments for registering a post type.
				 */
				$args = apply_filters( 'elementor/template_library/sources/local/register_post_type_args', $args );
		
				$this->post_type_object = register_post_type( self::CPT, $args );
		
				$args = [
					'hierarchical' => false,
					'show_ui' => false,
					'show_in_nav_menus' => false,
					'show_admin_column' => true,
					'query_var' => is_admin(),
					'rewrite' => false,
					'public' => false,
					'label' => _x( 'Type', 'Template Library', 'elementor' ),
				];
		
				/**
				 * Register template library taxonomy args.
				 *
				 * Filters the taxonomy arguments when registering elementor template library taxonomy.
				 *
				 * @since 1.0.0
				 *
				 * @param array $args Arguments for registering a taxonomy.
				 */
				$args = apply_filters( 'elementor/template_library/sources/local/register_taxonomy_args', $args );
		
				register_taxonomy( self::TAXONOMY_TYPE_SLUG, self::CPT, $args );
		
				/**
				 * Categories
				 */
				$args = [
					'hierarchical' => true,
					'show_ui' => true,
					'show_in_nav_menus' => false,
					'show_admin_column' => true,
					'query_var' => is_admin(),
					'rewrite' => false,
					'public' => false,
					'labels' => [
						'name' => _x( 'Categories', 'Template Library', 'elementor' ),
						'singular_name' => _x( 'Category', 'Template Library', 'elementor' ),
						'all_items' => _x( 'All Categories', 'Template Library', 'elementor' ),
					],
				];
		
				/**
				 * Register template library category args.
				 *
				 * Filters the category arguments when registering elementor template library category.
				 *
				 * @since 2.4.0
				 *
				 * @param array $args Arguments for registering a category.
				 */
				$args = apply_filters( 'elementor/template_library/sources/local/register_category_args', $args );
		
				register_taxonomy( self::TAXONOMY_CATEGORY_SLUG, self::CPT, $args );
			}

			public function get_items( $args = [] ) {
				$template_types = array_values( self::$template_types );
		
				if ( ! empty( $args['type'] ) ) {
					$template_types = $args['type'];
				}
		
				$templates_query = new \WP_Query(
					[
						'post_type' => self::CPT,
						'post_status' => 'publish',
						'posts_per_page' => -1,
						'orderby' => 'title',
						'order' => 'ASC',
						'meta_query' => [
							[
								'key' => Document::TYPE_META_KEY,
								'value' => $template_types,
							],
						],
					]
				);
		
				$templates = [];
		
				if ( $templates_query->have_posts() ) {
					foreach ( $templates_query->get_posts() as $post ) {
						$templates[] = $this->get_item( $post->ID );
					}
				}
		
				return $templates;
			}

			public function get_item( $template_id ) {
				$post = get_post( $template_id );


				$user = get_user_by( 'id', $post->post_author );

				$page = SettingsManager::get_settings_managers( 'page' )->get_model( $template_id );

				$page_settings = $page->get_data( 'settings' );

				$date = strtotime( $post->post_date );

				$data = [
					'template_id' => $post->ID,
					'source' => $this->get_id(),
					'type' => self::get_template_type( $post->ID ),
					'title' => $post->post_title,
					'thumbnail' => get_the_post_thumbnail_url( $post ),
					'date' => $date,
					'human_date' => date_i18n( get_option( 'date_format' ), $date ),
					'author' => $user->display_name,
					'hasPageSettings' => ! empty( $page_settings ),
					'tags' => [],
					'export_link' => $this->get_export_link( $template_id ),
					'url' => get_permalink( $post->ID ),
				];

				/**
				 * Get template library template.
				 *
				 * Filters the template data when retrieving a single template from the
				 * template library.
				 *
				 * @since 1.0.0
				 *
				 * @param array $data Template data.
				 */
				$data = apply_filters( 'elementor/template-library/get_template', $data );

				return $data;
			}

			public function get_data( array $args ) {
				$db = Plugin::$instance->db;
		
				$template_id = $args['template_id'];
		
				// TODO: Validate the data (in JS too!).
				if ( ! empty( $args['display'] ) ) {
					$content = $db->get_builder( $template_id );
				} else {
					$document = Plugin::$instance->documents->get( $template_id );
					$content = $document ? $document->get_elements_data() : [];
				}
		
				if ( ! empty( $content ) ) {
					$content = $this->replace_elements_ids( $content );
				}
		
				$data = [
					'content' => $content,
				];


		
				if ( ! empty( $args['with_page_settings'] ) ) {
					$page = SettingsManager::get_settings_managers( 'page' )->get_model( $args['template_id'] );
		
					$data['page_settings'] = $page->get_data( 'settings' );
				}
		
				return $data;				
			}

			public function delete_template( $template_id ) {
				if ( ! current_user_can( $this->post_type_object->cap->delete_post, $template_id ) ) {
					return new \WP_Error( 'template_error', __( 'Access denied.', 'elementor' ) );
				}

				return wp_delete_post( $template_id, true );
			}

			public function save_item( $template_data ) {
				// if ( ! current_user_can( $this->post_type_object->cap->edit_posts ) ) {
				// 	return new \WP_Error( 'save_error', __( 'Access denied.', 'elementor' ) );
				// }

				$defaults = [
					'title' => __( '(no title)', 'elementor' ),
					'page_settings' => [],
					'status' => 'publish',
					// 'status' => current_user_can( 'publish_posts' ) ? 'publish' : 'pending',
				];

				$template_data = wp_parse_args( $template_data, $defaults );

				$document = Plugin::$instance->documents->create(
					$template_data['type'],
					[
						'post_title' => $template_data['title'],
						'post_status' => $template_data['status'],
						'post_type' => self::CPT,
					]
				);



				if ( is_wp_error( $document ) ) {
					/**
					 * @var \WP_Error $document
					 */
					return $document;
				}


				if ( ! empty( $template_data['content'] ) ) {
					$template_data['content'] = $this->replace_elements_ids( $template_data['content'] );
				}


				$document->save( [
					'elements' => $template_data['content'],
					'settings' => $template_data['page_settings'],
				] );

				$template_id = $document->get_main_id();

				/**
				 * After template library save.
				 *
				 * Fires after Elementor template library was saved.
				 *
				 * @since 1.0.1
				 *
				 * @param int   $template_id   The ID of the template.
				 * @param array $template_data The template data.
				 */
				do_action( 'elementor/template-library/after_save_template', $template_id, $template_data );

				/**
				 * After template library update.
				 *
				 * Fires after Elementor template library was updated.
				 *
				 * @since 1.0.1
				 *
				 * @param int   $template_id   The ID of the template.
				 * @param array $template_data The template data.
				 */
				do_action( 'elementor/template-library/after_update_template', $template_id, $template_data );

				return $template_id;
			}

			public function update_item( $new_data ) {
				if ( ! current_user_can( $this->post_type_object->cap->edit_post, $new_data['id'] ) ) {
					return new \WP_Error( 'save_error', __( 'Access denied.', 'elementor' ) );
				}

				$document = Plugin::$instance->documents->get( $new_data['id'] );

				if ( ! $document ) {
					return new \WP_Error( 'save_error', __( 'Template not exist.', 'elementor' ) );
				}

				$document->save( [
					'elements' => $new_data['content'],
				] );

				/**
				 * After template library update.
				 *
				 * Fires after Elementor template library was updated.
				 *
				 * @since 1.0.0
				 *
				 * @param int   $new_data_id The ID of the new template.
				 * @param array $new_data    The new template data.
				 */
				do_action( 'elementor/template-library/after_update_template', $new_data['id'], $new_data );

				return true;
			}

			public function export_template( $template_id ) {
				$file_data = $this->prepare_template_export( $template_id );

				if ( is_wp_error( $file_data ) ) {
					return $file_data;
				}

				$this->send_file_headers( $file_data['name'], strlen( $file_data['content'] ) );

				// Clear buffering just in case.
				@ob_end_clean();

				flush();

				// Output file contents.
				echo $file_data['content'];

				die;
			}

			public static function get_template_type( $template_id ) {
				return get_post_meta( $template_id, Document::TYPE_META_KEY, true );
			}
			private function get_export_link( $template_id ) {
				// TODO: BC since 2.3.0 - Use `$ajax->create_nonce()`
				/** @var \Elementor\Core\Common\Modules\Ajax\Module $ajax */
				// $ajax = Plugin::$instance->common->get_component( 'ajax' );

				return add_query_arg(
					[
						'action' => 'elementor_library_direct_actions',
						'library_action' => 'export_template',
						'source' => $this->get_id(),
						'_nonce' => wp_create_nonce( 'elementor_ajax' ),
						'template_id' => $template_id,
					],
					admin_url( 'admin-ajax.php' )
				);
			}

	

			public function elementor_template_import(){
				 $uploads_dir = wp_upload_dir();


				// $path = $_REQUEST['path'];
				// $import_result = $this->import_single_template($path);

				// wp_send_json_success( $import_result );
				// if ( is_wp_error( $import_result ) ) {
				// 	return $import_result;
				// }

				// $items[] = $import_result;
				// return $items;

			}
			public function import_single_template($path){
            $file_name = $path;
            $data = json_decode( file_get_contents( $file_name ), true );
            $content = $data['content'];

            $content = $this->process_export_import_content($content,'on_import');


            $page_settings = [];
            if ( ! empty( $data['page_settings'] ) ) {
            $page = new Model( [
                'id' => 0,
                'settings' => $data['page_settings'],
            ] );

            $page_settings_data = $this->process_element_export_import_content( $page, 'on_import' );

            if ( ! empty( $page_settings_data['settings'] ) ) {
                $page_settings = $page_settings_data['settings'];
            }
            }


            $template_id = $this->save_item( [
            'content' => $content,
            'title' => $data['title'],
            'type' => $data['type'],
            'page_settings' => $page_settings,
        ] );

  

        if ( is_wp_error( $template_id ) ) {
            return $template_id;
        }


        return $this->get_item( $template_id );



            // $content = $elementor_uploader->process_export_import_content($content,'on_import');

        }


			public function __construct() {
				parent::__construct();

				add_action( 'wp_ajax_nopriv_sw_elementor_template_import', [ $this, 'elementor_template_import' ] );
				add_action( 'wp_ajax_sw_elementor_template_import', [ $this, 'elementor_template_import' ] );


				// $this->add_actions();
			}

        }
    }
