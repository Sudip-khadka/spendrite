document.addEventListener('DOMContentLoaded', function () {
    // Get references to form elements
    var emailInput = document.getElementById('email');
    var usernameInput = document.getElementById('username');
    var sendOTPButton = document.getElementById('send-otp');

    sendOTPButton.addEventListener('click', function () {
        // Validate email and username inputs (you can add more validation)
        var email = emailInput.value;
        var username = usernameInput.value;

        if (!email || !username) {
            alert('Please fill in both email and username fields.');
            return;
        }

        // Send a request to your server to generate and send OTP
        // You can use fetch or another AJAX library for this purpose
        fetch('send_otp.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email: email,
                username: username
            })
        })
        .then(function (response) {
            if (response.ok) {
                // Redirect to OTP verification page
                window.location.href = 'otp_verification.php';
            } else {
                alert('Failed to send OTP. Please try again later.');
            }
        })
        .catch(function (error) {
            console.error('Error:', error);
        });
    });
});
