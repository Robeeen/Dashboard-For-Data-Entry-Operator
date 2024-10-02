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
    echo "<form action='' method='POST'><table border=1 >";
            echo "<tbody>";
            echo "<tr>";
            echo "<th>User Name </th><th>Company Name </th><th>Controls</th>";
            echo "</tr>";
    if($query){        
        foreach($query as $display){            
            echo "<tr><td>$display->user_login</td>
                    <td>$display->user_email</td>
                    <td>              
                        <input type='text' name='permission' id='permission'/>                 
                        
                        <input type='submit' name='submit_permission' value='submit' /> 
                    </td>
                </tr>";         
    }};
        
    echo "</tbody>";
    echo "</table></form>";
    echo "<div id='form-response'></div>";   
    

    if(isset($_POST['submit_permission'])){
            $status = is_numeric( $_POST['permission'] );
            $record_id = $display->ID;
            

        if(!empty( $status && $record_id )){
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
        }
        if($result !== false){
            echo "Status Updated Successfully.";
        }else{
            echo "Failed to Update";
        }
    }

}







