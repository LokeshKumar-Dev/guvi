$ ('document').ready (function () {
    var storedToken = localStorage.getItem('token');

    console.log("token", storedToken)
    // Sending JWT token to the PHP file through AJAX request
    $.ajax({
        type: 'POST',
        url: './php/profile.php',
        data: {token: storedToken},
        success: function(response) {
            console.log(response);
        }
    });
});