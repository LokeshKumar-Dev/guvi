$ ('document').ready (function () {
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
        console.log('res', JSON.parse(response));
        console.log(response1)
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
