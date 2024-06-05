<?php
ob_start();
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['userID'] == "") {
    header("Location: login");
    exit();
}
require_once "config.php";

$userID = $_SESSION['userID'];
$mobileNo = $_SESSION['mobile'];
$userName = getUserField($conn, "name", $userID);
$password = getUserField($conn, "password", $userID);
$accountNo = getBankDetail($conn, "accountNo", $userID);
$commissionRate = getTransactionSetting($conn, "commission_rate");
$ifsc = getBankDetail($conn, "ifsc", $userID);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("header.php"); ?>
    <title>Kohinoor - Profile</title>
    <link rel="stylesheet" href="assets/css/profile.css">
    <script src="assets/js/profile.js" defer></script>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="assets/icons/kohinoor-logo-white.png" alt="Kohinoor" class="logo">
            <p class="commission-rate">Commission Rate: <?php echo $commissionRate; ?></p>
        </div>
        <div class="profile">
            <h2><?php echo $userName; ?></h2>
            <p class="mobile-no">+91<?php echo $mobileNo; ?></p>
        </div>
        <div class="section">
            <label for="password">Password</label>
            <div class="input-group">
                <input type="password" id="password" value="<?php echo $password; ?>" disabled>
                <img src="assets/icons/openEye.png" class="toggle-icon" id="togglePassword">
            </div>
        </div>
        <div class="edit-links">
            <a href="#" id="changePassword">Change Password?</a>
        </div>
        <div class="section password-change" id="passwordBox" style="display: none;">
            <label for="oldPassword">Old Password</label>
            <div class="input-group">
                <input type="password" id="oldPassword">
            </div>
            <label for="newPassword">New Password</label>
            <div class="input-group">
                <input type="password" id="newPassword">
            </div>
            <button id="finalChangePassword">Change</button>
            <button id="cancelChangePass" class="cancel-button">Cancel</button>
        </div>
        <div class="section" id="account_change">
            <label for="accountNumber">Account Number</label>
            <div class="input-group">
                <input type="text" id="accountNumber" maxlength="16" value="<?php echo $accountNo; ?>" disabled>
            </div>
            <label for="ifscCode">IFSC Code</label>
            <div class="input-group">
                <input type="text" id="ifscCode" maxlength="11" value="<?php echo $ifsc; ?>" disabled>
            </div>
        </div>
        <div class="section" id="accountBox" style="display: none;">
            <button id="changeAccount">Change</button>
            <button id="cancelChangeAcc" class="cancel-button">Cancel</button>
        </div>
        <div class="edit-links">
            <a href="#" id="editAccountDetails">Edit Account Details</a>
        </div>

        <input type="hidden" id="userID" value="<?php echo $userID; ?>">
    </div>

    <div class="home-icon" onclick="location.href='dashboard'">
        <img src="assets/icons/home.png" alt="Home Icon" />
    </div>

    <div class="van-toast van-toast--middle van-toast--text" id="van-toast" style="z-index: 2005; display: none;">
        <div class="van-toast__text" id="toast__text"></div>
    </div>
</body>

</html>