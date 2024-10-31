<?php

/**
 * 
 */
class Pixobe_Cartography_Tables
{

    public static $version = "1.0";
   

    public static function install()
    {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $table = "pixobe_cartography_maps";

        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
        config JSON NOT NULL,
        version text NOT NULL,
		PRIMARY KEY  (id)
	    ) $charset_collate;";
       
        dbDelta($sql);
    }

}