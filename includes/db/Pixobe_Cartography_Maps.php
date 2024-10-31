

<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;


/**
 * Helper class for interacting with Pixobe_Cartography_Maps Table
 *
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */
class Pixobe_Cartography_Maps
{
    /**
     * The name of our database table
     *
     * @access  public
     * @since   1.0
     */
    public $table_name;

    /**
     * The version of our database table
     *
     * @access  public
     * @since   1.0
     */
    public $version;

    /**
     * The name of the primary column
     *
     * @access  public
     * @since   1.0
     */
    public $primary_key;

    function __construct()
    {
        $this->table_name = "pixobe_cartography_maps";
        $this->primary_key = "id";
        $this->version = "1.0";
    }


    function insert($record)
    {
        global $wpdb;
        $default = array(
            'config' => json_encode($record),
            'version' => $this->version
        );

        $item = shortcode_atts($default, $_REQUEST);
        $result = $wpdb->insert($this->table_name, $item);

        if ($result != false) {
            $result =  $wpdb->insert_id;
        }

        return $result;
    }

    /**
     * 
     */
    function update($id, $config)
    {
        global $wpdb;

        $wpdb->update(
            $this->table_name,
            array(
                "config" => $config
            ),
            array('id' => $id)
        );

        return $id;
    }

    /**
     * 
     */
    function delete_maps($maps)
    {
        global $wpdb;
        $ids = implode(',', array_map('absint', $maps));
        $wpdb->query("DELETE FROM $this->table_name WHERE ID IN($ids)");
        $remaining_rows = $wpdb->get_results("SELECT id , config  FROM $this->table_name");
        return $remaining_rows;
    }

    function get($id)
    {
        global $wpdb;
        $result = $wpdb->get_row("SELECT config FROM $this->table_name WHERE id = $id ");
        return $result;
    }

    /**
     * 
     * 
     */
    function get_all()
    {
        global $wpdb;
        $default_row = $wpdb->get_results("SELECT id , config  FROM $this->table_name");
        return $default_row;
    }
}
