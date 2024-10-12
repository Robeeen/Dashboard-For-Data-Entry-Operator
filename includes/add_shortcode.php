<?php

add_shortcode('user_editpost', 'edit_display_form');

function edit_display_form() {
    ob_start();
    global $wpdb;
    $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';    
    $custom_table = $wpdb->prefix . 'custom_data'; 
    $msg = '';
    
   //Update data
   if(isset($_REQUEST['submit'])){
    if(!empty($id)){
       $update = $wpdb->update(
            $custom_table, 
            array(
                'company_name' => $_REQUEST['company_name'],
                'address' => $_REQUEST['address'],
                'phone' => $_REQUEST['phone'],
                'product_name' => $_REQUEST['product_name']
            ),
            array(
                'id' => $id,
            ),  
        );   
    }
    if(false == $update){
      echo  $wpdb->last_error; //It will show any error realtime!
    }else{
        echo '<div id="form-response">' . $msg = 'Record Updated</div>';
        
    }
 }

    //To echo data on each field before edit
    $user_result = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM wp_custom_data WHERE id = %d",  $id), ARRAY_A);
        //print_r($user_result);
?>

    <!-- Form on the left side -->
<div style="display:flex">
    <div style="width: 70%;">
        <h3>Edit Company Data</h3>

        <form id="custom-edit-form" method="POST">
            <div class="form-group">
                <label>Company Name: <input type="text" class="form-control" name="company_name"
                        value="<?php echo $user_result['company_name'];?>"></label>
            </div>
            <div class="form-group">
                <label>Address: <input type="text" class="form-control" name="address"
                        value="<?php echo $user_result['address'];?>"></label>
            </div>
            <div class="form-group">
                <label>Phone: <input type="text" class="form-control" name="phone"
                        value="<?php echo $user_result['phone'];?>"></label>
            </div>
            <div class="form-group">
                <label>Product Name: <input type="text" class="form-control" name="product_name"
                        value="<?php echo $user_result['product_name'];?>"></label>
            </div>

            <button type="submit" id="submit" name="submit" class="btn btn-primary">Update</button>
            <a href='form-edit.php?page=edit-page&id=$display->ID' class='btn btn-info' role='button'>Back</a>
        </form>
    </div>
</div>

<?php   
    return ob_get_clean();
    
}