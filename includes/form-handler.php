<?php

// Inside includes/form-handler.php+

function user_dashboard_shortcode() {
    ob_start();
    global $wpdb;
    $current_user = wp_get_current_user();
    $id = $current_user->ID;
    $user_result = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM wp_users WHERE ID = %d", $id)
    );
    
    ?>

    <div style="<?php echo $user_result->user_status == 1 ? 'display : flex' : 'display: none' ;?>">
        <!-- Form on the left side -->
        <div style="width: 50%;">
            <h3>Insert Company Data </h3>
            <?php $current_user = wp_get_current_user();
                  $id = $current_user->ID;
                  echo "Hello! " . $user=$current_user->user_login;                
                 ?>
            <form id="custom-data-form">
                <lable><input type="hidden" name="user_id" value="<?php echo $id;?>"></label><br>
                <label>Company Name: <input type="text" name="company_name" required></label><br>
                <label>Address: <input type="text" name="address" required></label><br>
                <label>Phone: <input type="text" name="phone" required></label><br>
                <label>Product Name: <input type="text" name="product_name" required></label><br>
                <lable><input type="hidden" name="user_login" value="<?php echo $user;?>"></label><br>
               
                <button type="submit">Submit</button>
            </form>
            <div id="form-response"></div>
        </div>

        <!-- Table on the right side -->
        <div style="width: 50%;">
            <h3>Company Data</h3>
            <input type="text" id="search-input" placeholder="Search...">
            <table id="data-table" class='table' >
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Product Name</th>
                        <th>Logged By</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated here via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
    

    <script>
        document.getElementById('custom-data-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('<?php echo esc_url(rest_url('custom-dashboard/v1/data/')); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('form-response').innerText = 'Data inserted successfully!';
                fetchData(); // Reload table data after inserting
                document.getElementById("custom-data-form").reset();
            });
        });

        document.getElementById('search-input').addEventListener('input', function() {
            fetchData(this.value);
            
        });

        function fetchData(searchTerm = '') {
            fetch('<?php echo esc_url(rest_url('custom-dashboard/v1/data/')); ?>')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#data-table tbody');
                    tbody.innerHTML = '';

                    data.filter(item => item.company_name.includes(searchTerm)).forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                        <td>${row.company_name}</td>
                        <td>${row.address}</td>
                        <td>${row.phone}</td>
                        <td>${row.product_name}</td>                        
                        <td>${row.user_login}</td>`;
                        tbody.appendChild(tr);
                    });
                });
        }

        fetchData(); // Load data on page reload
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('user_dashboard', 'user_dashboard_shortcode');
