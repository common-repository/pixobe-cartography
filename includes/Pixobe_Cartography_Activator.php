<?php

/**
 * Fired during plugin activation
 *
 * @link       https://pixobe.com
 * @since      1.0.0
 *
 * @package    Pixobe_Cartography
 * @subpackage Pixobe_Cartography/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Pixobe_Cartography
 * @subpackage Pixobe_Cartography/includes
 * @author     Pixobe <email@pixobe.com>
 */
class Pixobe_Cartography_Activator
{

	/**
	 * Activation tasks
	 *
	 * Add menu, register rest api, create database.
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		// create db
		self::create_tables();
	}

	/**
	 *  Create tables
	 */
	public static function create_tables()
	{
		require_once plugin_dir_path( __FILE__ ) . 'db/Pixobe_Cartography_Tables.php';
		Pixobe_Cartography_Tables::install();
	}

}
