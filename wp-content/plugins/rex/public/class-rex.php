<?php
/**
 * Plugin Name: Class Rex
 *
 * @package   Rex
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-plugin-name-admin.php`
 *
 * @package Rex
 * @author  Your Name <email@example.com>
 */
class Rex {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'rex';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		/* Define custom functionality.
		 * Refer To http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'init', array( $this, 'create_custom_post' ) );
		

		
		
		// Custom taxonomies won't be necessary until we make this custom post completely generic
		// and start allowing users to define their own categories
		add_action( 'init', array( $this, 'create_custom_taxonomies' ) );

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		// @TODO: Define activation functionality here
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public.js', __FILE__ ), array( 'jquery' ), self::VERSION );
	}

	/**
	 * Create custom post type, using this plugin's slug as the post type.
	 *
	 * @since    1.0.0
	 */
	public function create_custom_post() {
		register_post_type( $this->plugin_slug,
			array(
			'labels' 			=> array(
				'name' 					=> __( 'Book Recommendations' ),
				'singular_name' => __( 'Book Recommendation' ),
				'all_items'			=> __( 'Show All'),
				'add_new'				=> __( 'Add New' ),
				'add_new_item' 	=> __( 'Add New Book Recommendation' ),
				'edit_item' 		=> __( 'Edit Book Recommendation' ),
				'new_item' 			=> __( 'New Book Recommendation' ),
				'view_item' 		=> __( 'View Book Recommendation' ),
				'search_items' 	=> __( 'Search Book Recommendations' ),
				'not_found' 		=> __( 'No book recommendations found' ),
				'not_found_in_trash' => __( 'No book recommendations found in trash' ),
				),
			'public' 			=> true,
			'has_archive'	=> true,
			'supports'		=> array(
				'custom_fields'	// for "liking" a rex
				)
			)
		);
	}

	/**
	 * Registers user-defined taxonomies for this custom post type.
	 * Also allows other plugins -- through 'rex_register_taxonomy' hook -- to 
	 * 		define additional taxonomies. 
	 * $taxonomies is an associative array, where key is the name of the taxonomy, and
	 * 		value defines the taxonomy args.
	 *
	 * @since    1.0.0
	 */
	public function create_custom_taxonomies() {
		$taxonomies = apply_filters( $this->plugin_slug . '_register_taxonomies', array() );
		$taxonomies = array_merge( $taxonomies, array(
			'category_tags' 	=> array(
				'labels' 							=> array(
					'name' 								=> 'Category Tags',
					'singular_name' 			=> 'Category Tag',
					'all_items'						=> 'All Categories',
					'edit_item'						=> 'Edit Category',
					'view_item'						=> 'View Category',
					'update_item'					=> 'Update Category',
					'add_new_item'				=> 'Add New Category',
					'new_item_name'				=> 'New Category Name',
				), 
				'hierarchical'				=> true,
				'capabilities'				=> array( // Only allow administrators to edit taxonomies
					'manage_terms' 				=> 'manage_options',	// Admin-level
					'edit_terms'					=> 'manage_options',	// Admin-level
					'delete_terms'				=> 'manage_options',	// Admin-level
					'assign_terms'				=> 'upload_files',		// Author-level
				),
			),
			'age_group_tags' 	=> array(
				'labels' 							=> array(
					'name' 								=> 'Age Group Tags',
					'singular_name' 			=> 'Age Group Tag',
					'all_items'						=> 'All Age Groups',
					'edit_item'						=> 'Edit Age Group',
					'view_item'						=> 'View Age Group',
					'update_item'					=> 'Update Age Group',
					'add_new_item'				=> 'Add New Age Group',
					'new_item_name'				=> 'New Age Group Name',
				), 
				'hierarchical'				=> true,
				'capabilities'				=> array( // Only allow administrators to edit taxonomies
					'manage_terms' 				=> 'manage_options',	// Admin-level
					'edit_terms'					=> 'manage_options',	// Admin-level
					'delete_terms'				=> 'manage_options',	// Admin-level
					'assign_terms'				=> 'upload_files',		// Author-level
				),
			),
		));

		foreach ( $taxonomies as $key => $taxonomy ) {
			register_taxonomy( $key, $this->plugin_slug, $taxonomy );
			register_taxonomy_for_object_type( $key, $this->plugin_slug );
		}
	}

	

	public function display_select_book_meta_box( $post ) {
		// Include nonce for security.
		wp_nonce_field( $this->plugin_slug . '_meta_box_select_book', $this->plugin_slug . '_meta_box_select_book_nonce' );

		include_once( 'views/meta-boxes/select-book-meta-box.php' );
	}

	public function display_add_blurb_meta_box( $post ) {
		// Include nonce for security.
		wp_nonce_field( $this->plugin_slug . '_meta_box_add_blurb', $this->plugin_slug . '_meta_box_add_blurb_nonce' );

		include_once( 'views/meta-boxes/add-blurb-meta-box.php' );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);

	}

	/**
	 * @since    1.0.0
	 */
	public function add_meta_boxes() {

		// Add user-defined meta boxes, if any

		// Add default meta boxes
		add_meta_box(
			'select-book-meta-box',
			__( 'Book Information' ),
			array( $this, 'display_select_book_meta_box' ),
			$this->plugin_slug,
			'normal'
		);

		add_meta_box(
			'add-blurb-meta-box',
			__( 'Your Comments' ),
			array( $this, 'display_add_blurb_meta_box' ),
			$this->plugin_slug,
			'advanced'
		);
	}

	public function save_meta_boxes( $post_ID ) {

		// Make sure user saved from a page with this custom post's meta boxes.
		if ( ! isset( $_POST[ $this->plugin_slug . '_meta_box_select_book_nonce' ] ) ||
			! isset( $_POST[ $this->plugin_slug . '_meta_box_add_blurb_nonce' ] ) ) {
			return;
		}

		// Make sure this is not an autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Make sure user has appropriate permissions.
		if ( ! current_user_can( 'edit_post', $post_ID ) ) {
			return;
		}

		if ( isset( $_POST['book-select-title'] ) ) {
			update_post_meta( $post_ID, 'book_title', $_POST['book-select-title'] );

			// Avoid infinite loop by unhooking function temporarily.
			remove_action( 'save_post_' . $this->plugin_slug, array( $this, 'save_meta_boxes' ) );

			// Post title should also be updated with new title value.
			$updated_post = array(
				'ID'					=> $post_ID,
				'post_title' 	=> $_POST['book-select-title'],
			);
			wp_update_post( $updated_post );

			// Re-hook the function.
			add_action( 'save_post_' . $this->plugin_slug, array( $this, 'save_meta_boxes' ) );

		}

		if ( isset( $_POST['book-select-isbn'] ) ) {
			update_post_meta( $post_ID, 'book_isbn', $_POST['book-select-isbn'] );
		}

		if ( isset( $_POST['book-select-author'] ) ) {
			update_post_meta( $post_ID, 'book_author', $_POST['book-select-author'] );
		}

		if ( isset( $_POST['book-select-description'] ) ) {
			update_post_meta( $post_ID, 'book_description', $_POST['book-select-description'] );
		}

		if ( isset( $_POST['book-select-url'] ) ) {
			update_post_meta( $post_ID, 'book_url', $_POST['book-select-url'] );
		}

		if ( isset( $_POST['book-select-thumbnail'] ) ) {
			update_post_meta( $post_ID, 'book_thumbnail', $_POST['book-select-thumbnail'] );
		}

		if ( isset( $_POST['book-blurb-text'] ) ) {
			update_post_meta( $post_ID, 'book_blurb', $_POST['book-blurb-text'] );
		}
	}

}