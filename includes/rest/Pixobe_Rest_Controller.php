<?php

/**
 * 
 */
class Pixobe_Rest_Controller extends WP_REST_Controller
{


    function __construct()
    {
        $this->slug = "pixobe-cartography";
        $this->version = "1";
        // create a db helper
        require_once plugin_dir_path(__FILE__) . '/../db/Pixobe_Cartography_Maps.php';
        $this->pcdb = new Pixobe_Cartography_Maps();
    }

    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes()
    {

        $version = '1';
        $namespace = 'pixobe-cartography/v' . $version;

        $maps = 'maps';

        register_rest_route($namespace, '/' . $maps, array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array($this, 'get_map_list'),
                'args'                => array(),
            ),
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array($this, 'add_map'),
                'args'                => $this->get_endpoint_args_for_item_schema(true),
            ),
            array(
                'methods'             => WP_REST_Server::DELETABLE,
                'callback'            => array($this, 'delete_maps'),
                'args'                => array(
                    'context' => array(
                        'default' => 'view',
                    ),
                ),
            ),
        ));

        $map = 'maps';
        register_rest_route($namespace, '/' . $map . '/(?P<id>[\d]+)', array(
            array(
                'methods'             => WP_REST_Server::EDITABLE,
                'callback'            => array($this, 'update_map'),
                'permission_callback' => array($this, 'get_action_permission_check'),
                'args'                => $this->get_endpoint_args_for_item_schema(false),
            ),
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array($this, 'read_map'),
                'args'                => array(
                    'context' => array(
                        'default' => 'view',
                    ),
                ),
            ),

        ));

        $topojson = 'topojsons';

        register_rest_route($namespace, '/' . $topojson. '/maps/(?P<id>[\w]+)', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array($this, 'get_map'),
                'args'                => array(),
            ),
            
        ));

        register_rest_route($namespace, '/' . $topojson.'/topojson', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array($this, 'get_topojsons'),
                'args'                => array(),
            ),
            
        ));
    }

    /**
     * 
     */
    public function get_map_list()
    {
        $maps = $this->pcdb->get_all();
        foreach ($maps as $value) {
            $value->config = json_decode($value->config);
        }
        return new WP_REST_Response($maps, 200);
    }

    /**
     * 
     */
    public function add_map($request)
    {
        $body = $request->get_body();
        if (!empty($body)) {
            $body = json_decode($body);
            // add a new record
            $inserted_id = $this->pcdb->insert($body);
            if ($inserted_id == false) {
                return new WP_Error('cant-create', __('message', 'text-domain'), array('status' => 500));
            }
            return new WP_REST_Response(array('id' => "$inserted_id", 'config' => $body), 200);
        }
        return new WP_Error('cant-create', __('message', 'text-domain'), array('status' => 500));
    }

    /**
     * 
     */
    public function update_map($request)
    {
        $id = $request->get_param("id");
        $body = $request->get_body();
        if (!empty($body)) {
            // add a new record
            $this->pcdb->update($id, $body);
            $body = json_decode($body);
            return new WP_REST_Response(array('id' => $id, 'config' => $body), 200);
        }
        return new WP_Error('cant-update', __('unknown exception', 'text-domain'), array('status' => 500));
    }

    /**
     * 
     */
    public function read_map($request)
    {
        $params = $request->get_params();
        $id = $params['id'];
        if (!empty($id)) {
            // add a new record
            $result = $this->pcdb->get($id);
            if (empty($result)) {
                return new WP_Error('no-record', __("Record $id not found.", 'text-domain'), array('status' => 500));
            }
            $result->config = json_decode($result->config);
            return new WP_REST_Response($result->config, 200);
        }
        return new WP_Error('cant-create', __('message', 'text-domain'), array('status' => 500));
    }

    function delete_maps($request)
    {
        $body = $request->get_body();
        if (!empty($body)) {
            $body = json_decode($body);
            // add a new record
            $maps = $this->pcdb->delete_maps($body);
            foreach ($maps as $value) {
                $value->config = json_decode($value->config);
            }
            return new WP_REST_Response($maps, 200);
        }
        return new WP_Error('cant-delete', __('unknown exception', 'text-domain'), array('status' => 500));
    }


    /**
     * Get location specific topojson basing on id
     */
    function get_map($request)
    {
        $params = $request->get_params();
        $id = $params['id'];

        $response = wp_remote_request(
            "https://unpkg.com/@pixobe/topojsons/maps/$id",
            array(
                'method'     => 'GET'
            )
        );

        $body = wp_remote_retrieve_body($response);
        // return topojson
        return new WP_REST_Response(json_decode($body), 200);
    }

    /**
     * This will give a single json with all available maps
     */
    function get_topojsons()
    {
        $response = wp_remote_request(
            "https://unpkg.com/@pixobe/topojsons/topojson.json",
            array(
                'method'     => 'GET'
            )
        );

        $body = wp_remote_retrieve_body($response);
        // return topojson
        return new WP_REST_Response(json_decode($body), 200);
    }
    /**
     * 
     */
    public function get_action_permission_check()
    {
        return true;
    }
}
