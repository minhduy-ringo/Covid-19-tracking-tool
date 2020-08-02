<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "www/ulti/ulti.php";

    httpsRedirect();

    if(checkSession())
    {
        $redirect = $GLOBALS['domain_url'] . "home.php";
        header("Location: $redirect");
    }
?>

<!doctype html>
    
<html lang="en">
<head>
<meta charset="utf-8">
    <title>Đăng nhập</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="/www/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/e5407c478d.js" crossorigin="anonymous"></script>
</head>
<body">
    <div class="login-wrapper">
        <div class="corral">
            <div class="content">
                <div id="error-notifications">
                    <div class="form-error" id="login-info-wrong">
                        <i class="fas fa-exclamation-circle">  Tên đăng nhập hoặc mật khẩu không chính xác</i>
                    </div>
                    <div class="form-error" id="login-not-activate">
                        <i class="fas fa-exclamation-circle">  Tài khoản chưa được kích hoạt</i>
                    </div>
                </div>
                <form autocomplete="on">
                    <div class="form-group">
                        <label for="username">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="inputUsername" placeholder="Email / CMND / Căn cước / Passport" value="0352837767">
                        <small id="usernameBlank" class="form-test" style="color: red; display: none;">Tên đăng nhập trống</small>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <div id="password-field-wrapper" class="form-control">
                            <div class="row">
                                <input type="password" class="col-10" id="inputPassword" name="password" style="border: 0;" placeholder="Mật khẩu" value="123456789">
                                <button type="button" class="show-hide-password col" onclick="togglePassword()"><i class="fas fa-eye"></i></button>
                            </div>
                        </div>
                        <small id="passwordBlank" class="form-test" style="color: red; display: none;">Mật khẩu trống</small>
                    </div>
                        <button type="button" class="btn btn-primary" style="width: 100%;" onclick="loginSubmit()">Đăng nhập</button>
                </form>
                <div id="sign-up-container">
                    <div class="login-signup-separator">
                        <span class="text-in-separator">Hoặc</span>
                    </div>
                    <a role="button" href="/www/authentication/signup.php" class="btn btn-secondary" id="create-account" style="width: 100%;">Tạo tài khoản</a>
                </div>
            </div>
        </div>
    </div>

    <script src="/www/js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/www/js/crypto-js.min.js"></script>
    <script type="text/javascript" src="/www/js/authentication-script.js"></script>
</body>
</html>