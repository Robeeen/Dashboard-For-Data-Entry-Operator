console.log("Connected");

document.getElementById('').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("<?php echo esc_url(rest_url('custom-dashboard/v1/data/')); ?>", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('form-response').innerText = 'Data inserted successfully!';        
    });
});