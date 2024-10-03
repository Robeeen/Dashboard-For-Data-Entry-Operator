<?php



//Call for Dashbaord admin page.
add_action( 'admin_menu', 'dashboard_admin_menu' );

function dashboard_admin_menu() {
    add_menu_page(
        __( 'Dashboard Page', 'my-textdomain' ),
        __( 'Dasboard Menu', 'my-textdomain' ),
        'manage_options',
        'admin-page',
        'my_admin_page_contents',
        'dashicons-schedule',
        6
    );
    add_submenu_page( 
		'admin-page',
		'Edit Record',
		'Edit Record',
		'manage_options',
		'edit-page',
		'submenu_page_callback',
	);
  
}

function submenu_page_callback(){
    global $wpdb;
    $record_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : "";
    $user_result = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM wp_users WHERE ID = %d", $record_id)
    );
   // echo $user_result->user_status;
    ?>
    <form action='' method='POST'>  
    <h2>Change Permission</h2>

    <input type='checkbox' id='status' name='status' <?php echo $user_result->user_status ? 'checked' : 0;?> />               
    <input type='submit' name='submit_permission' value='submit' />
    </form>
<?php
    if(isset($_REQUEST['submit_permission'])){
        
        //$status = $_REQUEST['status'];
        $checkbox_value = $_REQUEST['status'] ? 1 : 0;
        $record_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : "";
        

    if(!empty( $record_id )){
        global $wpdb;
        $table_name = $wpdb->prefix . 'users';

        $result = $wpdb->update(
            $table_name,
            array(
                'user_status' => $checkbox_value,
            ),
            array(
                'ID' => $record_id,
            )
            );

            if($result !== false){
                echo "Status Updated Successfully.";
            }else{
                echo "Failed to Update";
            }
    }

    }else{
    echo "nonce vertification failed or fill-up the Filed value";
    }

    
}

function my_admin_page_contents(){

    echo __("hellow this is admin");
    global $wpdb;
    $custom_table = $wpdb->prefix . 'users';    
    $query = $wpdb->get_results("SELECT * FROM $custom_table");
    echo "<form action='' method='POST'><table border=1 >";  

            echo "<tbody>";
            echo "<tr>";
            echo "<th>User Name </th><th>Company Name </th><th>Controls</th>";
            echo "</tr>";
    if($query){     
        foreach($query as $display){
                  echo "<tr> 
                            <td>$display->user_login</td>
                            <td>$display->user_email</td>
                            <td><a href='admin.php?page=edit-page&id=$display->ID'>Edit</a></td>
                        </tr>"; 
            }     
    }     
  
    echo "</tbody>";
    echo "</table></form>";
    echo "<div id='form-response'></div>";   
}







