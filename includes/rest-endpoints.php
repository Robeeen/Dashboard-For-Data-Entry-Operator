<?php

// Inside includes/rest-endpoints.php

add_action('rest_api_init', function () {
    register_rest_route('custom-dashboard/v1', '/data/', array(
        'methods' => 'POST',
        'callback' => 'insert_custom_data',
    ));
    
    register_rest_route('custom-dashboard/v1', '/data/', array(
        'methods' => 'GET',
        'callback' => 'get_custom_data',
    ));
});

function insert_custom_data(WP_REST_Request $request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_data';

    $user_id = get_current_user_id();
   
    $user = sanitize_text_field($request->get_param('user_login'));
    $company_name = sanitize_text_field($request->get_param('company_name'));
    $address = sanitize_text_field($request->get_param('address'));
    $phone = sanitize_text_field($request->get_param('phone'));
    $product_name = sanitize_text_field($request->get_param('product_name'));

    $wpdb->insert($table_name, array(
        'user_id' => $user_id,
        'user_login' => $user,
        'company_name' => $company_name,
        'address' => $address,
        'phone' => $phone,
        'product_name' => $product_name
    ));

    return new WP_REST_Response('Data inserted successfully', 200);
}

function get_custom_data() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_data';
    $user_id = get_current_user_id();

  //$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d", $user_id));
   $results = $wpdb->get_results($wpdb->prepare("SELECT $table_name.address, $table_name.phone, $table_name.product_name, $table_name.current_user FROM $table_name WHERE user_id = $user_id "));

    return new WP_REST_Response($results, 200);
}
