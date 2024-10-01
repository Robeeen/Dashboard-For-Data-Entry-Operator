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
            <?php wp_nonce_field('save_checkbox', 'my_checkbox_nonce'); ?>
                <label for="my_checkbox">
                    <input type="checkbox" name="my_checkbox" id="my_checkbox" value="1" />
                    Enable the User
                </label>
                <?php submit_button(); ?>
            </form>
    </div>  

<?php 
}

add_action('admin_init', 'my_handle_form_submission');

function my_handle_form_submission() {


    if (!isset($_POST['my_checkbox_nonce']) || !wp_verify_nonce($_POST['my_checkbox_nonce'], 'save_checkbox')) {
        return; // Nonce verification failed, do nothing
    }

    // Check for user permission to save (optional security check)
    if (!current_user_can('edit_posts')) {
        return; // Current user doesn't have permission
    }

    // Sanitize and retrieve checkbox value
    $checkbox_value = isset($_POST['my_checkbox']) ? 1 : 0; // Handle unchecked case

    // Debug: Check if post ID is valid
    $post_id = 98; // You should replace this with a real post ID or get it dynamically

    if ($post = get_post($post_id)) {

        // Attempt to add the post meta
        $meta_key = '_my_checkbox_meta_key';
        $add_meta_result = add_post_meta($post_id, $meta_key, $checkbox_value, true);

        // If the meta already exists, update it
        if (!$add_meta_result) {
            $update_meta_result = update_post_meta($post_id, $meta_key, $checkbox_value);

            if ($update_meta_result) {
                add_action('admin_notices', function() {
                    echo '<div class="notice notice-success is-dismissible">
                            <p>Checkbox value updated successfully!</p>
                          </div>';
                });
            } else {
                add_action('admin_notices', function() {
                    echo '<div class="notice notice-error is-dismissible">
                            <p>Failed to update the checkbox value!</p>
                          </div>';
                });
            }
        } else {
            add_action('admin_notices', function() {
                echo '<div class="notice notice-success is-dismissible">
                        <p>Checkbox value added successfully!</p>
                      </div>';
            });
        }
    } else {
        // Invalid post ID
        add_action('admin_notices', function() {
            echo '<div class="notice notice-error is-dismissible">
                    <p>Invalid post ID. Post does not exist!</p>
                  </div>';
        });
    }


}







