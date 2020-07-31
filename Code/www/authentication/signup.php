<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "www/ulti/ulti.php";

    httpsRedirect();
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
    <title>Đăng ký</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="/www/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/e5407c478d.js" crossorigin="anonymous"></script>
</head>
<body">
    <div class="signup-wrapper">
        <div class="corral">
            <div class="signup-content">
                <div id="error-notifications"">
                    <div class="form-error" id="signup-email-error">
                        <i class="fas fa-exclamation-circle">  Email đã được sử dụng</i>
                    </div>
                    <div class="form-error" id="signup-phone-error">
                        <i class="fas fa-exclamation-circle">  Số điện thoại đã được sử dụng</i>
                    </div>
                </div>
                <form id="signup-form" autocomplete="off">
                    <h1 style="margin-bottom: 2rem">Đăng ký tài khoản</h1>
                    <div class="form-group">
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="Họ và tên">
                        <small id="nameBlank" class="form-test" style="color: red; display: none;">*Họ và tên trống</small>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="selectSex" name="sex">
                            <option value="nam">Nam</option>
                            <option value="nu">Nữ</option>
                            <option value="other">LGBTQ+</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="inputAddress" name="address" placeholder="Địa chỉ">
                        <small id="addressBlank" class="form-test" style="color: red; display: none;">*Địa chỉ trống</small>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="inputIdentity" name="identity" placeholder="CMND / Căn cước / Passport">
                        <small id="identityBlank" class="form-test" style="color: red; display: none;">*CMND / Căn cước / Passport</small>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="inputPhone" name="phone" placeholder="Số điện thoại">
                        <small id="phoneBlank" class="form-test" style="color: red; display: none;">*Số điện thoại trống</small>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
                        <small id="emailBlank" class="form-test" style="color: red; display: none;">*Email trống</small>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <div id="password-field-wrapper" class="form-control">
                            <div class="row">
                                <input type="password" class="col-10" id="inputPassword" name="password" style="border: 0;" placeholder="Mật khẩu">
                                <button type="button" class="show-hide-password col" onclick="togglePassword()"><i class="fas fa-eye"></i></button>
                            </div>
                        </div>
                        <small id="passwordBlank" class="form-test" style="color: red; display: none;">Mật khẩu trống</small>
                    </div>
                    <button type="button" class="btn btn-primary" style="width: 100%;" onclick="signupSubmit()">Xác nhận</button>
                </form>
            </div>
        </div>
    </div>

    <script src="/www/js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="/www/js/crypto-js.min.js"></script>
    <script src="/www/js/authentication-script.js"></script>
</body>
</html>