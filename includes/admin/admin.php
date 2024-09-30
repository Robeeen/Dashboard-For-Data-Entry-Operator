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

    echo __("hellow this is admin");
    global $wpdb;
    $custom_table = $wpdb->prefix . 'users';    
    $query = $wpdb->get_results("SELECT * FROM $custom_table");
    echo "<table border=1>";
            echo "<tbody>";
            echo "<tr>";
            echo "<th>User Name </th><th>Company Name </th><th>Controls</th>";
            echo "</tr>";
    if($query){        
        foreach($query as $display){            
            echo "<tr><td>$display->user_login</td><td>$display->user_email</td><td>" . "<input type='checkbox'>" . "</td></tr>"; 
        
        }}
        echo "</tbody>";
        echo "</table>";


}