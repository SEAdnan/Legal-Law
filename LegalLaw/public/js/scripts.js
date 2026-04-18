// scripts.js

// Function to show an alert when a button is clicked
function showAlert(message) {
    alert(message);
}

// Example of adding an event listener to a button
document.addEventListener('DOMContentLoaded', function() {
    const alertButton = document.getElementById('alertButton');
    if (alertButton) {
        alertButton.addEventListener('click', function() {
            showAlert('This is a custom alert message!');
        });
    }
});

// Example of form validation
function validateForm() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    if (email === '' || password === '') {
        alert('Please fill in all fields.');
        return false;
    }
    return true;
}

// Attach the validateForm function to the form submission
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!validateForm()) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });
    }
});