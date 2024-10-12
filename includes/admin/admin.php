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
		'',
		'manage_options',
		'edit-page',
		'edit_page_callback',
	);
    add_submenu_page(
        'admin-page',
        'Delete Operator',
        '',
        'manage_options',
        'delete-operator-page',
        'delete_operator_callback'
    );
    add_submenu_page(
        'admin-page',
        'Display Data',
        'Display Data',
        'manage_options',
        'display-page',
        'display_page_callback'
    );
    add_submenu_page(
        'admin-page',
        'Delete Data',
        '',
        'manage_options',
        'delete-page',
        'delete_page_callback'
    );
  
}

//Permission Change Each Operator
function edit_page_callback(){
    global $wpdb;
    $record_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : "";
    $user_result = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM wp_users WHERE ID = %d", $record_id)
    );
   // echo $user_result->user_status;
    ?>
<form action='' method='POST'>
    <div class='jumbotron'>
        <h2 class='display-4'>Change Permission</h2><br>
        <div class="form-check checkbox-xl">
            <input type='checkbox' class='form-check-input' id='status' name='status'
                <?php echo $user_result->user_status ? 'checked' : '';?> />
            <input type='submit' name='submit_permission' value='Submit' class="btn btn-primary" />
            <a href='admin.php?page=admin-page' class='btn btn-primary' role='button'>Back</a>
        </div>
    </div>
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
            }    }
    echo "<meta http-equiv='refresh' content='0'>";
    }    
}
//Admin page - Main page
function my_admin_page_contents(){    
    global $wpdb;
    $custom_table = $wpdb->prefix . 'users';    
    $query = $wpdb->get_results("SELECT * FROM $custom_table");
    echo "<div class='jumbotron'>";
    echo  __("<h2 class='display-4'>Dashboard Control of Operator</h2><br>");
    echo "<form action='' method='POST'><table class='table'>";            
            echo "<thead class='thead-dark'>";
            echo "<tr>";
            echo "<th scope='col'>User Name</th><th scope='col'>Email Address</th><th>Permission</th><th>Delete User</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
    if($query){     
        foreach($query as $display){
                  echo "<tr> 
                            <td>$display->user_login</td>
                            <td>$display->user_email</td>
                            <td><a href='admin.php?page=edit-page&id=$display->ID' class='btn btn-primary btn-sm' role='button'>Edit</a></td>
                            <td><a href='admin.php?page=delete-operator-page&id=$display->ID' class='btn btn-danger btn-sm' role='button'>Delete</a></td>
                        </tr>"; 
            }     
    }  
    echo "</tbody>";
    echo "</table></form>";
    echo "</div>";
    echo "<div id='form-response'></div>";   
}

//Delete Operator Access
function delete_operator_callback(){
    ?>
    <div class='jumbotron'>
<?php
    global $wpdb;
    $record_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : "";
    echo $record_id;
    $table_name = $wpdb->prefix . 'users';    

    if(isset($_REQUEST['delete'])){
        if ($_REQUEST['info'] == 'yes'){
            if(!empty($record_id)){
                $result = $wpdb->delete( //We need work here later on $result since saying not defined!
                    $table_name,
                    array(
                        'ID' => $record_id,
                    ),
                    array(
                        '%d',
                    )
                );
                if(false == $result){
                    echo  $wpdb->last_error; //It will show any error realtime! 
                }else{
                    echo '<div id="form-response">' . $msg = 'The account has been Deleted!</div>';
                }
            }       
        }
    }?>
    
    <h2 class='display-4'>Delete Operator Account</h2><br>
        <form method="post">
            <div class="form-check delete">
                <label>Are you sure want delete <?php echo $record_id; ?>?</label><br>
                <input type="radio" name="info" value="yes" class="form-check-input" >
                <label class="form-check-label" for="info">
                    Yes &nbsp;
                </label>
                <input type="radio" name="info" value="no" class="form-check-input" checked>
                <label class="form-check-label" for="info">
                &nbsp; No
                </label>
            </div><br>
            <div>
                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                <a href='admin.php?page=admin-page' class='btn btn-primary' role='button'>Back</a>
                <input type="hidden" name="id" value="<?php echo  $record_id; ?>" />
            </div>
        </form>
</div>
    
<?php
}

//Display all User input data and Delete Function:
function display_page_callback(){
    global $wpdb;
    $custom_table = $wpdb->prefix . 'custom_data';    
    $query = $wpdb->get_results("SELECT * FROM $custom_table");
    echo "<div class='jumbotron'>";
    echo  __("<h2 class='display-4'>Display User Input Records</h2><br>");
    echo "<form action='' method='POST'><table class='table'>";            
            echo "<thead class='thead-dark'>";
            echo "<tr>";
            echo "<th scope='col'>User Name</th>
                <th scope='col'>Company Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Product Name</th>
                <th>Delete Row</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
    if($query){     
        foreach($query as $display){
                  echo "<tr> 
                            <td>$display->user_login</td>
                            <td>$display->company_name</td>
                            <td>$display->address</td>
                            <td>$display->phone</td>
                            <td>$display->product_name</td>
                            <td><a href='admin.php?page=delete-page&id=$display->id' class='btn btn-danger btn-sm' role='button' >Remove</a></td>
                        </tr>"; 
            }     
    }  
    echo "</tbody>";
    echo "</table></form>";
    echo "</div>";    
}

//Delete all data from the Display Page
function delete_page_callback(){
?>
    <div class='jumbotron'>
<?php
    
    global $wpdb;
    $custom_table = $wpdb->prefix . 'custom_data';    
    $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';    
    if(isset($_REQUEST['delete'])){
        if ($_REQUEST['conf'] == 'yes'){
        if(!empty($id)){
           $deleted = $wpdb->delete(
                $custom_table,
                array(
                    'id' => $id,
                ),
                array(
                    '%d' 
                ),
            );
            
         if(true == $deleted){
            echo '<div id="form-response">' . $msg = 'The record has been Deleted!</div>';
         }else{
            echo  $wpdb->show_errors();
         }

        }
        }
}?>

    <h2 class='display-4'>Delete user record</h2><br>
        <form method="post">
            <div class="form-check delete">
                <label>Are you sure want delete <?php echo $id; ?>?</label><br>
                <input type="radio" name="conf" value="yes" class="form-check-input" >
                <label class="form-check-label" for="conf">
                    Yes &nbsp;
                </label>
                <input type="radio" name="conf" value="no" class="form-check-input" checked>
                <label class="form-check-label" for="conf">
                &nbsp; No
                </label>
            </div><br>
            <div>
                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                <a href='admin.php?page=display-page' class='btn btn-primary' role='button'>Back</a>
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
            </div>
        </form>
</div>

<?php
}