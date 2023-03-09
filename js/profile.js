$ ('document').ready (function () {
    var storedToken = localStorage.getItem('token');

    console.log("token", storedToken)

    // Sending JWT token to the PHP file through AJAX request
    if(storedToken){
        $.ajax({
            type: 'POST',
            url: './php/profile.php',
            data: {token: storedToken},
    
            success: function(response) {
                response = JSON.parse(response);
                if (response["status"] == 200) {
    
                    //Successfully Logged In
                    $("#uId").text(response['uId']);
                    
                } else {
                    //Internal Server Error (Some other Issues)
                    $ ('#error').fadeIn (1000, function () {
                        $ ('#error').html (
                        '<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span>   ' +
                            data +
                            ' !</div>'
                        );
                        $ ('#btn-submit').html (
                        '<span class="glyphicon glyphicon-log-in"></span>   Login'
                        );
                });
                }
            }
        });
    }
    else{
        alert("You have to Login")
    }
});