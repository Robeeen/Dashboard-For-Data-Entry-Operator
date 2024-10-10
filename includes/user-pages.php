<?php

// Inside includes/user-pages.php

add_action('user_register', 'create_user_dashboard_page');

function create_user_dashboard_page($user_id) {
    $user_info = get_userdata($user_id);
    $user_name = $user_info->user_login;

    // Create a new page for the user
    $page_data = array(
        'post_title'    => $user_name . "'s Dashboard",
        'post_content'  => '[user_dashboard]',
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_author'   => $user_id,
    );

    wp_insert_post($page_data);

    $page_new = array(
        'post_title'    => $user_name . "'s Editrecord",
        'post_content'  => '[user_editpost]',
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_author'   => $user_id,
        'post_name'     => $user_name . "'s-editrecord",
    );
    wp_insert_post($page_new);
}

add_action('wp_login', 'redirect_to_dashboard', 10, 2);

function redirect_to_dashboard($user_login, $user) {
    $user_dashboard = get_page_by_title($user->user_login . "'s Dashboard");
    if ($user_dashboard) {
        wp_redirect(get_permalink($user_dashboard->ID));
        exit;
    }
}


