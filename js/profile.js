$ ('document').ready (function () {
    // $('.datepicker').datepicker();
    var uId;
    var name;
    var email;
    var last_name;
    var birthday;
    var number;

    var storedToken = localStorage.getItem('token');

    console.log("tokn", storedToken)
    $("#logout-btn").click(function(){
        alert("Are u sure");
        if(storedToken){
            localStorage.removeItem('token');
        }
        window.location.replace("php/");
    }); 

    $("#profileForm").submit(profileForm);
    function profileForm (e) {
        e.preventDefault();
        first_name = $("#first_name").val();
        last_name = $("#last_name").val() || null;
        birthday = $("#birthday").val() || null;
        number = $("#number").val() || null;

        $.ajax({
            type: 'POST',
            url: './php/profile-process.php',
            data: {uId, name: first_name, last_name, birthday, number},
    
            success: function(response) {
                console.log(response)
                if (response["status"] == 200) {
                    //Successfully Logged In
                    $("#uId").text(response['uId']);
                    uId = response['uId'];
                    name = response['users']['name'];
                    email = response['users']['email'];
                    //Sometimes we don't get
                    last_name = response['users']['last_name'];
                    birthday = response['users']['birthday'];
                    number = response['users']['number'];

                    $("#name").html(name);
                    $("#first_name").val(name);
                    $("#last_name").val(last_name);
                    $("#birthday").val(birthday);
                    $("#number").val(number);
                    $("#email").html(email);
                } else {
                    //Internal Server Error (Some other Issues)
                    console.log(response)
                }
            }
        });
        return 0;
      }

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
                    uId = response['uId'];
                    name = response['users']['name'];
                    email = response['users']['email'];
                    //Sometimes we don't get
                    last_name = response['users']['last_name'];
                    birthday = response['users']['birthday'];
                    number = response['users']['number'];

                    $("#name").html(name);
                    $("#first_name").val(name);
                    $("#last_name").val(last_name);
                    $("#birthday").val(birthday);
                    $("#number").val(number);
                    $("#email").html(email);
                } else {
                    //Internal Server Error (Some other Issues)
                    console.log(response)
                }
            }
        });
    }
    else{
        alert("You have to Login")
        window.location.replace("php/");
    }
});