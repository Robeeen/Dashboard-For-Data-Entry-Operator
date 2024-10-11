<?php


add_shortcode('user_editpost', 'edit_display_form');

function edit_display_form() {

    ob_start();
    global $wpdb;
    $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';    
    $custom_table = $wpdb->prefix . 'custom_data'; 
    $msg = '';

    
   // Update data
   if(isset($_POST['update'])){
    if(!empty($id)){
        $wpdb->update(
            $custom_table, 
            array(
                'company_name' => $_POST['company_name'],
                'address' => $_POST['address'],
                'phone' => $_POST['phone'],
                'product_name' => $_POST['product_name']
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
        $wpdb->prepare("SELECT * FROM wp_custom_data WHERE id = %d",  $id), ARRAY_A);
        print_r($user_result);
?>
<div style="display:flex">
    <!-- Form on the left side -->
    <div style="width: 70%;">
        <h3>Edit Company Data</h3>

        <form id="custom-data-form" method="POST" action=''>
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

            <button type="submit" id="update" class="btn btn-primary">Update</button>
        </form>
        <div id="form-response"></div>
    </div>
</div>

<!-- <script>
document.getElementById('custom-data-form').addEventListener('update', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('<?php echo esc_url(rest_url('custom-dashboard/v1/update/(?P<id>\d+)')); ?>', {
            method: 'PUT',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('form-response').innerText = 'Data Updated successfully!';
            fetchData(); // Reload table data after inserting
            document.getElementById("custom-data-form").reset();
        });
});
</script> -->

<?php   
    return ob_get_clean();
    
}