<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://pixobe.com
 * @since      1.0.0
 *
 * @package    Pixobe_Cartography
 * @subpackage Pixobe_Cartography/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pixobe_Cartography
 * @subpackage Pixobe_Cartography/admin
 * @author     Pixobe <email@pixobe.com>
 */
class Pixobe_Cartography_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Add admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function admin_home_page()
	{
		require_once plugin_dir_path(__FILE__) . 'partials/admin_home_page.php';
	}

	/**
	 * Add admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function admin_add_page()
	{
		require_once plugin_dir_path(__FILE__) . 'partials/admin_add_page.php';
	}

	/**
	 * Add admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function admin_info_page()
	{
		require_once plugin_dir_path(__FILE__) . 'partials/admin_info_page.php';
	}

	/**
	 * Add admin menu and sub menus.
	 *
	 * @since    1.0.0
	 */
	public function add_menu()
	{

		add_menu_page(
			'Pixobe Cartography',
			'Cartography',
			'manage_options', // capability
			$this->plugin_name, // menu_slug
			array($this, 'admin_home_page'),
			'dashicons-admin-site-alt2' // icon-url
		);

		// add sub menu
		add_submenu_page(
			$this->plugin_name,
			'All Maps',
			'All Maps',
			'manage_options',
			$this->plugin_name,
			array($this, 'admin_home_page'),
		);

		// add sub menu
		add_submenu_page(
			$this->plugin_name,
			'Add New Map',
			'Add New',
			'manage_options',
			'pixobe_map_add',
			array($this, 'admin_add_page'),
		);
		// add sub menu
		add_submenu_page(
			$this->plugin_name,
			'Information',
			'Info',
			'manage_options',
			'pixobe_map_info',
			array($this, 'admin_info_page'),
		);
	}

	/**
	 * Add admin menu and sub menus.
	 *
	 * @since    1.0.0
	 */
	public function register_rest_fns()
	{
		require_once plugin_dir_path(__FILE__) . '/rest/Pixobe_Rest_Controller.php';

		$controller = new Pixobe_Rest_Controller();
		// // register routes
		$controller->register_routes();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pixobe_Cartography_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pixobe_Cartography_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(dirname(__FILE__)) . 'public/build/admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pixobe_Cartography_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pixobe_Cartography_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script("cartograph-main", plugin_dir_url(dirname(__FILE__)) . 'public/build/main.js', array('jquery'), $this->version, false);
		wp_enqueue_script("cartograph-admin", plugin_dir_url(dirname(__FILE__)) . 'public/build/admin.js', array('cartograph-main'), $this->version, false);
	}


	/**
	 * Load asynchronously
	 */
	public function async_scripts($tag, $handle)
	{
		if ('cartograph-main' !== $handle && 'cartograph-admin' !== $handle)
			return $tag;
		return str_replace(' src', ' defer src', $tag);
	}
}
