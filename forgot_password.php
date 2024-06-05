<?php

?>

<html lang="en" style="font-size: 41.2px;">

<head>
    <?php include("header.php"); ?>
    <title>Forgot Password - Kohinoor</title>
    <link rel="stylesheet" href="assets/css/login.css" />
    <link href="assets/css/loginChunk.css" rel="stylesheet">
    <script src="assets/js/forgot_password.js"></script>
</head>

<body style="font-size: 12px;">
    <div>
    <form action="#" method="post" id="ForgotPass" class="card-body" autocomplete="off">
        <div data-v-45ff4027="" class="background">
            <div data-v-45ff4027="" class="nav_bar">
                <div data-v-45ff4027="" class="nav_left"><button data-v-45ff4027="" class="page_btn" type="button" onclick="window.history.go(-1); return false;"><i
                            data-v-45ff4027="" class="van-icon van-icon-arrow-left">
                        </i></button></div>
                <div data-v-45ff4027="" class="nav_middle">Reset Password</div>
                <div data-v-45ff4027="" class="nav_right"></div>
            </div>
            <div data-v-45ff4027="" class="operate_container fst">
                <div data-v-45ff4027="" class="input_box"><img data-v-45ff4027="" src="assets/icons/mobile.png"
                        alt=""><span data-v-1e316e03="">+91</span><input data-v-45ff4027="" type="text" name="mobile" id="mobile"
                        placeholder="Mobile Number"></div>
            </div>
            <div data-v-45ff4027="" class="operate_container">
                <div data-v-45ff4027="" class="otp_row">
                    <div data-v-45ff4027="" class="input_box"><img data-v-45ff4027="" src="assets/icons/code.png"
                            alt=""><input data-v-45ff4027="" type="text" name="otp" id="otp"
                            placeholder="Verification Code"></div><button data-v-45ff4027="" type="button" id="reg_otp"
                        onclick="sendOTP()" class="otp_btn">OTP</button>
                </div>
            </div>
            <div data-v-45ff4027="" class="operate_container">
                <div data-v-45ff4027="" class="input_box"><img data-v-45ff4027="" src="assets/icons/key.png"
                        alt=""><input data-v-45ff4027="" type="password" name="password" id="password"
                        placeholder="Password"></div>
            </div>
            <div data-v-45ff4027="" class="operate_container">
                <div data-v-45ff4027="" class="input_box_btn"><button data-v-45ff4027="" class="long_btn">Reset
                        Password</button></div>
            </div>
        </div>
    </form>
    </div>

    <div class="van-toast van-toast--middle van-toast--text" id="van-toast" style="z-index: 2005; display: none;">
        <div class="van-toast__text" id="toast__text"></div>
    </div>

    <div id="otploader"
        style="position: absolute; background: #00000082; color: white !important; width: 60px; z-index: 9999; border-radius: 5px; top: 40%; left: 40%; display: none;">
        <img src="assets/icons/loader-forever.gif" style="width: 60px;">
    </div>

</body>

</html>