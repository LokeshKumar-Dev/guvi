$ ('document').ready (function () {
  /* handle form validation */

  jQuery.validator.addMethod (
    'passwordCheck',
    function (value, element) {
      return (
        this.optional (element) ||
        /^(?=.*[0-9])(?=.*[a-z])(?!.* ).{8,16}$/i.test (value)
      );
    },
    'Letters and numbers only please'
  );

  $ ('#signup').validate ({
    rules: {
      user_name: {
        required: true,
        minlength: 3,
      },
      password: {
        required: true,
        minlength: 8,
        maxlength: 15,
        passwordCheck: true,
      },
      password_confirm: {
        required: true,
        equalTo: '#password',
      },
      user_email: {
        required: true,
        email: true,
      },
    },
    messages: {
      user_name: {
        required: 'please enter valid name',
        minlength: 'need more',
      },
      password: {
        required: 'please provide a password',
        minlength: 'password at least have 8 characters',
        passwordCheck: 'Should contain number and alphabets',
      },
      user_email: 'please enter a valid email address',
      password_confirm: {
        required: 'please retype your password',
        equalTo: "password doesn't match !",
      },
    },
    submitHandler: submitForm,
  });

  /* handle form submit */
  function submitForm () {
    var data = $ ('#signup').serialize ();
    $.ajax ({
      type: 'POST',
      url: './php/signup-process.php',
      data: data,
      beforeSend: function () {
        $ ('#error').fadeOut ();
        $ ('#btn-submit').html (
          '<span class="glyphicon glyphicon-transfer"></span>   sending ...'
        );
      },
      success: function (response) {
        console.log (response);
        //EMAIL or USER already EXITS
        if (response == 2) {
          $ ('#error').fadeIn (1000, function () {
            $ ('#error').html (
              '<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span>   Sorry email already taken !</div>'
            );
            $ ('#btn-submit').html (
              '<span class="glyphicon glyphicon-log-in"></span>   Sign up'
            );
          });
        } else if (response == 1) {
          //Successfully Registered
          $ ('#btn-submit').html (
            'Signing Up ... <div class="preloader-wrapper active" style="height:30px;width:30px;><div class="spinner-layer small spinner-red-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch">  <div class="circle"></div></div><div class="circle-clipper right">  <div class="circle"></div></div>  </div></div>'
          );

          //Redirects to HOME
          console.log ('timeout 0 ');
          function timeoutFunc () {
            window.location.href = './login.html';
          }
          setTimeout (timeoutFunc, 3000);
        } else {
          //Internal Server Error (Some other Issues)
          $ ('#error').fadeIn (1000, function () {
            $ ('#error').html (
              '<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span>   ' +
                data +
                ' !</div>'
            );
            $ ('#btn-submit').html (
              '<span class="glyphicon glyphicon-log-in"></span>   Sign up'
            );
          });
        }
      },
    });
    return false;
  }
});
