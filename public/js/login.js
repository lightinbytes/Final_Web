document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const errorDiv = document.getElementById('error');
    errorDiv.textContent = '';

    fetch('index.php?controller=auth&action=login', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.href = data.redirect;
        } else {
            if (data.data && data.data.errors) {
                errorDiv.textContent = Object.values(data.data.errors).join(' ');
            } else {
                errorDiv.textContent = data.message;
            }
        }
    })
    .catch(error => {
        errorDiv.textContent = 'An error occurred. Please try again.';
        console.error('Error:', error);
    });
});