<?php
//include('E:\xampp\htdocs\devwp\wp-content\plugins\dashboard\includes\admin\admin.php');

// Inside includes/rest-endpoints.php
$user_id = ""; 

add_action('rest_api_init', function () {
    register_rest_route('custom-dashboard/v1', '/data/', array(
        'methods' => 'POST',
        'callback' => 'insert_custom_data',
        'permission_callback' => '__return_true',
    ));
    $GLOBALS['user_id'] = get_current_user_id();
    register_rest_route('custom-dashboard/v1', '/data/', array(
        'methods' => 'GET',
        'callback' => 'get_custom_data',
        'permission_callback' => '__return_true',
    ));
    //Not implemented
    register_rest_route('custom-dashboard/v1', '/update/(?P\d+)', array(
        'methods' => 'PUT',
        'callback' => 'edit_record',
        'args' => array(
            'id' => array(
                'required' => true,
                'validate_callback' => function($param, $request, $key){
                    return is_numeric($param);
                }
            )
            ),
        'permission_callback' => '__return_true',
    ));
});
//Not implemented
function edit_record(WP_REST_Request $request){
    global $wpdb; 

    $user_id = $request->get_param('id');   

    $address = sanitize_text_field($request->get_param('address'));
    $company_name = sanitize_text_field($request->get_param('company_name'));
    $product_name = sanitize_text_field($request->get_param('product_name'));
    $phone = sanitize_text_field($request->get_param('phone'));

    if (empty($user_id)) {
        return new WP_Error('no_value', 'New value is required', array('status' => 400));
    }

    $custom_table = $wpdb->prefix . 'custom_data'; 
    $result = $wpdb->update(
        $custom_table, 
        array(
            'company_name' => $company_name,
            'address' => $address,
            'phone' => $phone,
            'product_name' => $product_name
        ),
        array(
            'id' => $user_id,
        ),  
    );
    if ($result === false){
        return new WP_Error('db_update_error', 'Failed to update the record', array('status' => 500));
    }

    return new WP_REST_Response('Updated Permission successfully!!', 200);
}

function insert_custom_data(WP_REST_Request $request) {
    global $wpdb;
    $custom_table = $wpdb->prefix . 'custom_data';  
    $user_id = sanitize_text_field($request->get_param('user_id'));
    $user = sanitize_text_field($request->get_param('user_login'));
    $company_name = sanitize_text_field($request->get_param('company_name'));
    $address = sanitize_text_field($request->get_param('address'));
    $phone = sanitize_text_field($request->get_param('phone'));
    $product_name = sanitize_text_field($request->get_param('product_name'));

    $wpdb->insert($custom_table, array(
        'user_id' => $user_id,
        'user_login' => $user,
        'company_name' => $company_name,
        'address' => $address,
        'phone' => $phone,
        'product_name' => $product_name,
    ));

    return new WP_REST_Response('Data inserted successfully!!', 200);
}

function get_custom_data() {    
   
    global $wpdb;
    $custom_table = $wpdb->prefix . 'custom_data';    
    $query = $wpdb->prepare("SELECT * FROM $custom_table WHERE $custom_table.user_id = %d", $GLOBALS['user_id']);
    $results = $wpdb->get_results($query);
    if(empty($results)){
        return new WP_Error('no_data', 'No data found for this user', array('status' => 404));
    }     
  
    return new WP_REST_Response($results);
   
}
