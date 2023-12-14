<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://dulanjaya@surge.global
 * @since      1.0.0
 *
 * @package    S_Marvel
 * @subpackage S_Marvel/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    S_Marvel
 * @subpackage S_Marvel/includes
 * @author     Dulanjaya <dulanjaya@surge.global>
 */
class S_Marvel {

	public  $client;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      S_Marvel_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'S_MARVEL_VERSION' ) ) {
			$this->version = S_MARVEL_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 's-marvel';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->add_plugin_menu();

	}

   /**
	 * client 
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_client() {

 
		//$wpcmxentral_settings = get_option('wpcmxentral-settings');
		//$api_url = $wpcmxentral_settings['wpcmxentral-api-url'];
		//$api_key = $wpcmxentral_settings['wpcmxentral-api-token'];
 
		$client = new \GuzzleHttp\Client();
		
		return $client;
	}
 

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - S_Marvel_Loader. Orchestrates the hooks of the plugin.
	 * - S_Marvel_i18n. Defines internationalization functionality.
	 * - S_Marvel_Admin. Defines all hooks for the admin area.
	 * - S_Marvel_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-s-marvel-loader.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-s-marvel-api-validation.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-s-marvel-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-s-marvel-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-s-marvel-public.php';

		$this->loader = new S_Marvel_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the S_Marvel_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new S_Marvel_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new S_Marvel_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new S_Marvel_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    S_Marvel_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Admin menu
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_menu(){
		add_action('admin_menu', function(){				
				add_menu_page('Marvel API', 'Marvel API', 'manage_options', 's-marvel-api', array(__CLASS__,'s_marvel_admin_settings'), 'dashicons-superhero', 6  ); 
				add_submenu_page('s-marvel-api', 'Documentation', 'Documentation', 'manage_options', 'marvel-documentation', array(__CLASS__,'s_marvel_documentation')); 				 			   
		   }
	   ); 
		 
   } 

	/**
	 * Admin settings page
	 *
	 * @since    1.0.0
	 */	
	public static function s_marvel_admin_settings(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/s-marvel-admin-settings.php';
	} 

	public static function s_marvel_documentation(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/s-marvel-documentation.php';
	} 

	public static function admin_notice__success($message) {
		?>
			<div class="notice notice-success is-dismissible">
				<p><?php _e( $message, 's_marvel' ); ?></p>
			</div>
			<?php
		} 
		
	public static function admin_notice__error($message) {
		?>
			<div class="notice notice-error is-dismissible">
				<p><?php _e( $message, 's_marvel' ); ?></p>
			</div>
			<?php
		}		
	

}
