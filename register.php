<?php
ob_start();
session_start();
if (isset($_SESSION['userID']) && $_SESSION['userID'] != "") {
    header("Location: dashboard");
    exit();
}
?>
<html lang="en" style="font-size: 41.2px;">

<head>
    <?php include("header.php"); ?>
    <title>Register - Kohinoor</title>
    <link rel="stylesheet" href="assets/css/login.css" />
    <link href="assets/css/loginChunk.css" rel="stylesheet">
    <script src="assets/js/register.js"></script>
</head>

<body style="font-size: 12px;">
    <div>
        <form action="#" method="post" id="Register" class="card-body" autocomplete="off">
            <div data-v-5239c677="" class="background" style="">
                <div data-v-5239c677="" class="brand"><img data-v-5239c677="" src="assets/icons/kohinoor-logo.png">
                    <div data-v-5239c677="" class="desc">100% legal and safety platform</div>
                </div>
                <div data-v-5239c677="" class="operate_container_login" onclick="location.href='login.php'">
                    Already have an account? &nbsp;
                    <span data-v-5239c677="" style="text-decoration: underline rgb(242, 123, 33); color: black; font-weight: 500;">Login</span>
                </div>
                <div data-v-5239c677="" class="operate_container" style="margin-top: 10px;">
                    <div data-v-5239c677="" class="input_box"><img data-v-5239c677="" src="assets/icons/mobile.png" alt=""><span data-v-5239c677="">+91</span><input data-v-5239c677="" type="tel" maxlength="10" name="mobile" id="mobile" placeholder="Mobile Number"></div>
                </div>
                <div data-v-5239c677="" class="operate_container">
                    <div data-v-5239c677="" class="otp_row">
                        <div data-v-5239c677="" class="input_box"><img data-v-5239c677="" src="assets/icons/code.png" alt=""><input data-v-5239c677="" type="text" name="otp" id="otp" placeholder="Verification Code"></div><button data-v-5239c677="" type="button" id="reg_otp" onclick="sendOTP()" class="otp_btn">OTP</button>
                    </div>
                </div>
                <div data-v-5239c677="" class="operate_container">
                    <div data-v-5239c677="" class="input_box"><img data-v-5239c677="" src="assets/icons/key.png" alt=""><input data-v-5239c677="" type="password" name="password" id="password" placeholder="Password"></div>
                </div>
                <!--
            <div data-v-5239c677="" class="operate_container">
                <div data-v-5239c677="" class="input_box"><img data-v-5239c677=""
                        src="assets/icons/recommendation.png"
                        alt=""><input data-v-5239c677="" type="text" placeholder="Recommendation Code"><span
                        data-v-5239c677="" class="tips_span" style="bottom: -17px; z-index: 2;"></span></div>
            </div>
            -->
                <div data-v-5239c677="" class="operate_container"><span data-v-5239c677="" class="top_tips">Welcome
                        Bonus
                        &nbsp;
                        <span data-v-5239c677="" style="color: rgb(242, 90, 33); font-weight: 500; font-size: 16px;">
                            +₹121
                        </span></span></div>
                <div data-v-5239c677="" class="operate_container">
                    <div data-v-5239c677="" class="input_box_btn"><button data-v-5239c677="" class="long_btn">Create
                            Account</button></div>
                </div>
                <div data-v-5239c677="" class="privacypolicy">
                    By signing up, you agree to our <br data-v-5239c677=""><span data-v-5239c677="" style="font-weight: 500; color: rgb(0, 0, 255);">Terms &amp; Conditions</span>
                    and
                    <span data-v-5239c677="" style="font-weight: 500; color: rgb(0, 0, 255);">Privacy Policy</span>
                </div>
                <div data-v-5239c677="" class="register_bottom">
                    <div data-v-5239c677="" class="register_bottom_safe_relieved">Safety &amp; Relieved</div>
                    <div data-v-5239c677="" class="register_bottom_desc"><span data-v-5239c677="" style="color: rgb(145, 145, 145); font-weight: bold; font-size: 14px;">1</span>
                        CRORE+USERS
                        <span data-v-5239c677="" style="color: rgb(145, 145, 145); font-weight: bold; font-size: 14px;">18</span>
                        LAKH+ INVESTORS
                        <span data-v-5239c677="" style="color: rgb(145, 145, 145); font-weight: bold; font-size: 14px;">150</span>
                        CRORE+ USER INCOME
                    </div>
                    <div data-v-5239c677="" class="register_bottom_span">© Copyright 2024,Kohinoor. All rights are
                        reserved.
                    </div>
                </div>

            </div>
        </form>
    </div>
    <div class="van-toast van-toast--middle van-toast--text" id="van-toast" style="z-index: 2005; display: none;">
        <div class="van-toast__text" id="toast__text"></div>
    </div>

    <div id="otploader" style="position: absolute; background: #00000082; color: white !important; width: 60px; z-index: 9999; border-radius: 5px; top: 40%; left: 40%; display: none;">
        <img src="assets/icons/loader-forever.gif" style="width: 60px;">
    </div>

</body>

</html>