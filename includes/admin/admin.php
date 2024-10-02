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
    echo "<form action='admin.php' method='get' id='admin_call'><table border=1 >";
            echo "<tbody>";
            echo "<tr>";
            echo "<th>User Name </th><th>Company Name </th><th>Controls</th>";
            echo "</tr>";
    if($query){        
        foreach($query as $display){            
            echo "<tr><td>$display->user_login</td>
                    <td>$display->user_email</td>
                    <td>
                        <label for='test'>
                            <input type='checkbox' name='permission' id='permission' value='1' />
                            Permit User
                        </label> 

                    </td>
                </tr>";         
        }}
        
        echo "</tbody>";
        echo "</table></form>";
        echo "<div id='form-response'></div>";

      

        if($display->user_login){
            echo "true";
        }
    ?>
   
    

<?php 
}
add_action('admin_init', 'my_handle_form_submission');

function my_handle_form_submission() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dashboard'])) {
        // Assuming you are adding the meta to a specific post (e.g., post ID 123)
        $post_id = 123;
        $checkbox_value = $_POST['dashboard'] ? 1 : 0;

        // Add or update the post meta
        if (!add_post_meta($post_id, 'dashboard', $checkbox_value, true)) {
            update_post_meta($post_id, 'dashboard', $checkbox_value);
        }

        // Optional: Add an admin notice after saving
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success is-dismissible">
                    <p>Checkbox value saved successfully!</p>
                  </div>';
        });
    }
}







