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
    <title>Login - Kohinoor</title>
    <link rel="stylesheet" href="assets/css/login.css" />
    <link href="assets/css/loginChunk.css" rel="stylesheet">
    <script src="assets/js/login.js"></script>
</head>

<body style="font-size: 12px;">
    <div>
        <form action="#" method="post" id="Login" class="card-body" autocomplete="off">
            <div data-v-1e316e03="" class="background">
                <div data-v-1e316e03="" class="brand"><img data-v-1e316e03="" src="assets/icons/kohinoor-logo.png">
                    <div data-v-1e316e03="" class="desc">100% legal and safety platform</div>
                </div>
                <div data-v-1e316e03="" class="operate_container">
                    <div data-v-1e316e03="" class="input_box"><img data-v-1e316e03="" src="assets/icons/mobile.png"
                            alt=""><span data-v-1e316e03="">+91</span><input data-v-1e316e03="" type="tel"
                            maxlength="10" placeholder="Mobile Number" name="mobile" id="mobile"
                            style="margin-left: 5px;"></div>
                </div>
                <div data-v-1e316e03="" class="operate_container">
                    <div data-v-1e316e03="" class="input_box"><img data-v-1e316e03="" src="assets/icons/key.png"
                            alt=""><input data-v-1e316e03="" type="password" name="password" id="password"
                            placeholder="Password"><img data-v-1e316e03="" src="assets/icons/openEye.png"
                            class="input_box_pwd_img" id="passvisicon" onclick="changeEye();">
                    </div>
                </div>
                <div data-v-1e316e03="" class="operate_container_resetpwd" onclick="location.href='forgot_password'">
                    <span data-v-1e316e03="">Forgot Password</span>
                </div>
                <div data-v-1e316e03="" class="operate_container" style="margin-top: 16px;">
                    <div data-v-1e316e03="" class="input_box_btn"><button data-v-1e316e03=""
                            class="long_btn">Login</button>
                    </div>
                </div>
                <div data-v-1e316e03="" class="operate_container_register" onclick="location.href='register'">
                    Don't have an account with Kohinoor? &nbsp;
                    <span data-v-1e316e03=""
                        style="text-decoration: underline rgb(242, 123, 33); color: black; font-weight: 500;">Sign
                        Up</span>
                </div>
                <div data-v-1e316e03="" class="login_bottom"><img data-v-1e316e03=""
                        src="assets/icons/socialMedia.png"><span data-v-1e316e03=""> © Copyright 2024,Kohinoor. All
                        rights
                        are
                        reserved.</span></div>
            </div>
        </form>
    </div>
    <div class="van-toast van-toast--middle van-toast--text" id="van-toast" style="z-index: 2005; display: none;">
        <div class="van-toast__text" id="toast__text"></div>
    </div>

</html>