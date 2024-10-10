<?php


add_shortcode('user_editpost', 'edit_display_form');

function edit_display_form() {

    ob_start();
    global $wpdb;
    $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : "";
    $custom_table = $wpdb->prefix . 'custom_data'; 
    $msg = '';

    
   // Update data
   if(isset($_REQUEST['update'])){
    if(!empty($id)){
        $wpdb->update(
            $custom_table, 
            array(
                'company_name' => $_GET['company_name'],
                'address' => $_GET['address'],
                'phone' => $_GET['phone'],
                'product_name' => $_GET['product_name']
            ),
            array(
                'id' => $id,
            ),  
        );
            $msg = 'Record Updated';
    }

}

    //To echo data on each field before edit
    $user_result = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM wp_custom_data WHERE id = %d",  $id));
?>
    <div style="display:flex">
            <!-- Form on the left side -->
            <div style="width: 70%;">
                <h3>Edit Company Data</h3>
        
                <form id="custom-data-form">
                    <div class="form-group">               
                        <label>Company Name: <input type="text" class="form-control" name="company_name" value="<?php echo esc_attr($user_result->company_name);?>" ></label>
                    </div>
                    <div class="form-group">
                        <label>Address: <input type="text" class="form-control" name="address" value="<?php echo esc_attr($user_result->address);?>" ></label>
                    </div>
                    <div class="form-group">
                        <label>Phone: <input type="text" class="form-control" name="phone" value="<?php echo esc_attr($user_result->phone);?>" ></label>
                    </div>
                    <div class="form-group">
                        <label>Product Name: <input type="text" class="form-control" name="product_name" value="<?php echo esc_attr($user_result->product_name);?>" ></label>               
                    </div>

                    <button type="submit" id="update" class="btn btn-primary">Update</button>
                </form>
                <div id="form-response"></div>
            </div>
    </div>
    
    <?php   
    return ob_get_clean();
    
}



