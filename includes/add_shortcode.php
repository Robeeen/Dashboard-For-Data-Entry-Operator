<?php


add_shortcode('user_editpost', 'edit_display_form');

function edit_display_form() {

    ob_start();
    global $wpdb;
    echo $GLOBALS['user_id'] = get_current_user_id();
    $user_result = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM wp_custom_data WHERE id = %d",   $GLOBALS['user_id']));
?>
    <div style="display:flex">
            <!-- Form on the left side -->
            <div style="width: 70%;">
                <h3>Edit Company Data</h3>
        
                <form id="custom-data-form">
                    <div class="form-group">               
                        <label>Company Name: <input type="text" class="form-control" name="<?php echo esc_attr($user_result->company_name);?>" value="<?php echo esc_attr($user_result->company_name);?>" required></label>
                    </div>
                    <div class="form-group">
                        <label>Address: <input type="text" class="form-control" name="address" value="<?php echo esc_attr($user_result->address);?>" required></label>
                    </div>
                    <div class="form-group">
                        <label>Phone: <input type="text" class="form-control" name="phone" value="<?php echo esc_attr($user_result->phone);?>" required></label>
                    </div>
                    <div class="form-group">
                        <label>Product Name: <input type="text" class="form-control" name="product_name" value="<?php echo esc_attr($user_result->product_name);?>" required></label>               
                    </div>

                    <button type="submit" id="submit" class="btn btn-primary">Update</button>
                </form>
                <div id="form-response"></div>
            </div>
    </div>
    
    <?php   
    return ob_get_clean();
    
}



