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
    echo "<form action='' method='POST'>";  
    echo "<h2>Change Permission</h2>" . "<br/>";
    echo "<input type='text' name='status' id='status'/>";                      
    echo "<input type='submit' name='submit_permission' value='submit' />";
    echo "</form>";

    if(isset($_REQUEST['submit_permission'])){
        
        $status = $_REQUEST['status'];
        $record_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : "";
        

    if(!empty( $record_id )){
        global $wpdb;
        $table_name = $wpdb->prefix . 'users';

        $result = $wpdb->update(
            $table_name,
            array(
                'user_status' => $status,
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







