<?php

    ob_start();
    global $wpdb;

    //$current_user = wp_get_current_user();
    //$current_user = wp_get_current_user();
    //$id = $current_user->ID;
    $GLOBALS['user_id'] = get_current_user_id();
    $user_result = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM wp_custom_data WHERE id = %d",   $GLOBALS['user_id'])
    );

    ?>

<div style="display:flex">
    <!-- Form on the left side -->
    <div style="width: 70%;">
        <h3>Insert Company Data</h3>
  
        <form id="custom-data-form">
            <div class="form-group">               
                <label>Company Name: <input type="text" class="form-control" name="company_name" required></label>
            </div>
            <div class="form-group">
                <label>Address: <input type="text" class="form-control" name="address" required></label>
            </div>
            <div class="form-group">
                <label>Phone: <input type="text" class="form-control" name="phone" required></label>
            </div>
            <div class="form-group">
                <label>Product Name: <input type="text" class="form-control" name="product_name" required></label>               
            </div>

            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
        </form>
        <div id="form-response"></div>
    </div>


    
</div>

<script>
    document.getElementById('custom-data-form').addEventListener('submit', function(e) {
         e.preventDefault();
         const formData = new FormData(this);

    fetch('<?php echo esc_url(rest_url('custom-dashboard/v1/update/$id}')); ?>', {
            method: 'PUT',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('form-response').innerText = 'Data updated successfully!';
            fetchData(); // Reload table data after inserting
            document.getElementById("custom-data-form").reset();
        });
});


</script>
