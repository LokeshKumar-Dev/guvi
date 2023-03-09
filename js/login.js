$ ('document').ready (function () {
  var storedToken = localStorage.getItem('token');
  
  // Sending JWT token to the PHP file through AJAX request
  if(storedToken){
    $.ajax({
        type: 'POST',
        url: './php/profile.php',
        data: {token: storedToken},

        success: function(response) {
            response = JSON.parse(response);
            if (response["status"] == 200) {

              //Redirects to HOME
              function timeoutFunc () {
                window.location.href = './profile.html';
              }
              setTimeout (timeoutFunc, 2000);
                
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

  $ ('#login').validate ({
    rules: {
      user_email: {
        required: true,
        email: true,
      },
    },
    messages: {
      user_email: 'please enter email',
    },
    submitHandler: loginForm,
  });

  /* handle form login */
  function loginForm () {
    var data = $("#login").serialize();

    $.ajax ({
      type: 'POST',
      url: './php/login-process.php',
      data: data,
      beforeSend: function () {
        $ ('#error').fadeOut ();
        $ ('#btn-submit').html (
          '<span class="glyphicon glyphicon-transfer"></span>   sending ...'
        );
      },
      success: function (response) {
        //EMAIL or USER already EXITS
        response = JSON.parse(response);
        if (response["status"] == 200) {
          //Successfully Registered
          $ ('#btn-submit').html (
            '<img src="ajax-loader.gif" />   Loggin in wait ...'
          );

          //Redirects to HOME
          function timeoutFunc () {
            localStorage.setItem('token', response["token"]);
            console.log("to store", response["token"], response)
            window.location.href = './profile.html';
          }
          setTimeout (timeoutFunc, 2000);
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
      },
    });
    return false;
  }
});
