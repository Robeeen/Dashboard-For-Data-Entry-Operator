<?php

function dashboard_admin_menu() {
    add_menu_page(
        __( 'Page Title', 'my-textdomain' ),
        __( 'Menu Title', 'my-textdomain' ),
        'manage_options',
        'sample-page',
        'my_admin_page_contents',
        'dashicons-schedule',
        6
    );
}
add_action( 'admin_menu', 'dashboard_admin_menu' );

function my_admin_page_contents(){
    echo "hellow this is admin";
}