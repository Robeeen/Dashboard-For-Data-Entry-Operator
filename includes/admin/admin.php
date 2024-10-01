<?php




//Call for Dashbaord admin page.
add_action( 'admin_menu', 'dashboard_admin_menu' );

function dashboard_admin_menu() {
    add_menu_page(
        __( 'Page Title', 'my-textdomain' ),
        __( 'Dasboard Menu', 'my-textdomain' ),
        'manage_options',
        'admin-page',
        'my_admin_page_contents',
        'dashicons-schedule',
        6
    );
}

function my_admin_page_contents(){

    echo __("hellow this is admin");
    global $wpdb;
    $custom_table = $wpdb->prefix . 'users';    
    $query = $wpdb->get_results("SELECT * FROM $custom_table");
    echo "<form action='admin.php' method='get'><table border=1>";
            echo "<tbody>";
            echo "<tr>";
            echo "<th>User Name </th><th>Company Name </th><th>Controls</th>";
            echo "</tr>";
    if($query){        
        foreach($query as $display){            
            echo "<tr><td>$display->user_login</td>
                    <td>$display->user_email</td>
                </tr>";         
        }}
        
        echo "</tbody>";
        echo "</table></form>";
    ?>
    <div class="wrap">         
            <form method="POST">
                <label for="my_checkbox">
                    <input type="checkbox" name="my_checkbox" id="my_checkbox" value="1" />
                    Enable the User
                </label>
                <?php submit_button(); ?>
            </form>
    </div>  

<?php 

add_action('admin_init', 'handle_checkbox_submission');

function handle_checkbox_submission(){
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['my_checkbox'])){
        $post_id = 500;
        $checkbox_value = $_POST['my_checkbox'] ? 1 : 0;

        if(!add_post_meta($post_id, '_my_checkbox', $checkbox_value, false)){
            update_post_meta($post_id, '_my_checkbox', $checkbox_value);
        }

        // Optional: Add an admin notice after saving
        add_action('admin_notice', function(){
            echo '<div class="notice">Checkbox Value saved</div>';
        });

    }
}
}




