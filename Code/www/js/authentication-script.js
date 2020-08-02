/**
 * Global value
 */
    var api_url = 'https://udpt/api/api.php/';
    var domain_url = 'https://udpt/www/';
/**
 * Check login field input and send login info to API
 */
function loginSubmit() {
    var username = document.getElementById('inputUsername').value;
    var password = document.getElementById('inputPassword').value;
    var inputCheck = 0;

    if (password === '')
    {
        document.getElementById('passwordBlank').style.display = 'block';
        inputCheck = 1;
    }
    else
    {
        document.getElementById('passwordBlank').style.display = 'none';
    }

    if (username === '')
    {
        document.getElementById('usernameBlank').style.display = 'block';
        inputCheck = 1;
    }
    else
    {
        document.getElementById('usernameBlank').style.display = 'none';
    }

    // if (inputCheck)
    //     return;

    var hash = CryptoJS.MD5(password).toString();

    var data = {
        "username": username,
        "password": hash
    }

    $.ajax ({
        url: domain_url + "authentication/auth.php?username=" + username + "&password=" + hash,
        success: function(response) {
            switch (response) {
                case 'AUTHENTICATION_ERROR_WRONG':
                    document.getElementById('login-info-wrong').style.display = 'block';
                    document.getElementById('login-not-activate').style.display = 'none';
                    break;
                case 'AUTHENTICATION_ERROR_ACTIVATE':
                    document.getElementById('login-not-activate').style.display = 'block';
                    document.getElementById('login-info-wrong').style.display = 'none';
                    break;
                default:
                    window.location.href = domain_url + "home.php"
            }
        }
    });
}
/**
 * Hide / Show password when click
 */
function togglePassword()
{
    var passwordField = document.getElementById('inputPassword');
    if(passwordField.type === "password")
    {
        passwordField.type = "text";
    }
    else
    {
        passwordField.type = "password";
    }
}
/**
 * Check user input and send submit info to signup API
 */
function signupSubmit()
{
    // Take values in signup form in to data array
    var array = $('#signup-form').serializeArray();

    // Check blank input field and convert to JSON object format
    var data = {};
    var check = 0;
    for (var i = 0; i < array.length; i++) 
    {
        // If field is filled
        if(array[i]['value'])
        {
            // Exclude sex field, field always have value
            // Hide field blank error
            if(array[i]['name'] != "sex")
            {
                var id = array[i]['name'] + "Blank";
                document.getElementById(id).style.display = "none";
            }
            // 
            data[array[i]['name']] = array[i]['value'];
        }
        else
        {
            var id = array[i]['name'] + "Blank";
            document.getElementById(id).style.display = "block";
            check = 1;
        }
    }
    // If are there any blank fields, return
    if (check == 1)
        return;

    // Hash password using MD5 algorithm
    data['password'] = CryptoJS.MD5(data['password']).toString();

    // AJAX call to API server
    $.ajax({
        url: api_url + "user/",
        data: JSON.stringify(data),
        timeout: 0,
        contentType: "application/json",
        method: "POST",
        statusCode: {
            200: function(result) {
                window.location.href = domain_url + "signup-success";
            },
            400: function(result) {
                var error = result['responseJSON'];
                switch (error['ERROR']) {
                    case 'USER_CREATE_ERROR_EMAIL':
                        document.getElementById('signup-email-error').style.display = 'block';
                        document.getElementById('signup-phone-error').style.display = 'none';
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        break;
                    case 'USER_CREATE_ERROR_PHONE':
                        document.getElementById('signup-phone-error').style.display = 'block';
                        document.getElementById('signup-email-error').style.display = 'none';
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        break;
                    default:
                        break;
                }
            }
        }
    })
}

