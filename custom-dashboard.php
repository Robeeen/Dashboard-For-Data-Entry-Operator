<?php

 /*
 * Plugin Name: Dasborad Plugin
 * Description: A plugin to create custom dashboards for users with registration, form input, and table display.
 * Version: 1.0.0
 * Requires at least: 5.0
 * Requires PHP: 8.0
 * Author: Shams Khan
 * Author URI: https://shamskhan.com
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:
 * Text Domain: custom-table
 * Domain Path: /languages/asset/
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

//plugin Versions
define( 'PLUGIN_NAME_VERSION', '1.0.0' );


// Activation hook to create a custom table
register_activation_hook(__FILE__, 'create_custom_table');
function create_custom_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_data';

    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,        
        user_id bigint(20) UNSIGNED NOT NULL,
        user_login varchar(255) NOT NULL,
        company_name varchar(255) NOT NULL,
        address varchar(255) NOT NULL,
        phone varchar(15) NOT NULL,
        product_name varchar(255) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Include other plugin components
define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
include_once( MY_PLUGIN_PATH . 'includes/user-pages.php');
include_once( MY_PLUGIN_PATH . 'includes/form-handler.php');
include_once( MY_PLUGIN_PATH . 'includes/rest-endpoints.php');
include_once( MY_PLUGIN_PATH . 'includes/admin/admin.php');
include_once( MY_PLUGIN_PATH . 'includes/add_shortcode.php');

// Define all links
define( 'jQuery', '//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js' );
define( 'bootstrap-js', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js' );
define( 'bootstrap-cs', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');

//For admin panel js and css 
function add_ajax_scripts() {
    wp_enqueue_script( 'ajaxcalls', plugins_url( 'ajax-calls.js', __FILE__ ), array('jquery') ); 
    wp_enqueue_style( 'css', plugins_url( 'style.css', __FILE__));
}
add_action( 'admin_enqueue_scripts', 'add_ajax_scripts' );

//For admin panel 
function add_bootstrap_js(){
    wp_enqueue_script('jQuery', '//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js');
    wp_enqueue_script('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
    wp_enqueue_style('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
}
add_action( 'admin_enqueue_scripts', 'add_bootstrap_js');

//Front-end bootstrap
function add_bootstrap_js_front(){
    wp_enqueue_script('jQuery', '//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js');
    wp_enqueue_script('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
    wp_enqueue_style('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');   
}
add_action( 'wp_enqueue_scripts', 'add_bootstrap_js_front');

//For style to front-end
function style_frontEnd(){
    wp_enqueue_style( 'CSS', plugins_url( 'front-style.css', __FILE__));
}
add_action( 'wp_enqueue_scripts', 'style_frontEnd');

//Deactivation Hook - remove all Editrecord and Dashboard Pages
register_deactivation_hook( __FILE__, 'remove_all_dashboard_page');

function remove_all_dashboard_page(){
    //remove all dashboard pages
    $query1 = new WP_Query ( array('s' => 's Dashboard'));

    while ($query1->have_posts ()) {
        $query1->the_post ();
        $id = get_the_ID ();
        wp_delete_post ($id, true);
      }
      wp_reset_postdata ();

    //remove all Editrecord pages
    $query2 = new WP_Query ( array('s' => 's Editrecord'));

    while ($query2->have_posts ()){
        $query2->the_post ();
        $id = get_the_ID ();
        wp_delete_post($id, true);
    }
    wp_reset_postdata ();

    //Remove the database Table 
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_data'; // Table name with WordPress prefix

    $sql = "DROP TABLE IF EXISTS $table_name"; //delete tables from the db .
    $wpdb->query($sql);
}


