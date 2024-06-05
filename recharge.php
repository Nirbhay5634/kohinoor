<?php
ob_start();
session_start();
if (!isset($_SESSION['userID']) || $_SESSION['userID'] == "") {
    header("Location: login");
    exit();
}
require_once "config.php";

$userID = $_SESSION['userID'];
$userName = getUserField($conn,"name",$userID);
$walletBalance = getUserField($conn,"walletBalance",$userID);
$withdrawableBalance = getUserField($conn,"withdrawableBalance",$userID);

$rechargeInfo = getTransactionSetting($conn,"recharge_info");
$rechargeYT = getTransactionSetting($conn,"recharge_yt");
$minRecharge = getTransactionSetting($conn,"minimum_recharge");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("header.php"); ?>
    <title>Recharge - Kohinoor</title>
    <link rel="stylesheet" href="assets/css/recharge.css">
    <script src="assets/js/recharge.js"></script>
</head>
<body>
    <div class="container">
        <div class="user-details-box">
            <div class="user-info-center">
                <div class="username"><?php echo $userName;?></div>
                <div class="balance-container">
                    <div class="balance-value"><?php echo $walletBalance;?></div>
                    <div class="wallet-balance">
                        <div class="label">Wallet Balance</div>
                    </div>
                </div>
                <div class="balance-container">
                    <div class="balance-value"><?php echo $withdrawableBalance;?></div>
                    <div class="withdrawable-balance">
                        <div class="label">Withdrawable Balance</div>
                    </div>
                </div>
                <button class="recharge-money-button" onclick="showPopup()">+ ADD MONEY</button>
            </div>
        </div>

        <div class="video-section">
            <div class="video-container">
                <iframe src="https://www.youtube.com/embed/<?php echo $rechargeYT; ?>" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
            </div>
        </div>

        <div class="home-icon">
            <img src="assets/icons/home.png" onclick="location.href='dashboard'" alt="Home Icon">
        </div>

        <div id="popupForm" class="popup-form">
            <div class="popup-content">
                <span class="close" onclick="hidePopup()">&times;</span>
                <h2>Add Money</h2>
                <form id="moneyForm" action="ccpay" method="GET" autocomplete="off" onsubmit="return validateAmount()">
                    <label for="amount">Enter Amount</label>
                    <input type="number" id="amount" name="amount" placeholder="Enter Amount">
                    <div id="amount-error" class="error-message"></div>
                    <input type="hidden" id="minRecharge" value="<?php echo $minRecharge;?>">
                    <button type="submit" class="submit-button">ADD MONEY</button>
                </form>
                <p class="info-text"><?php echo $rechargeInfo;?></p>
            </div>
        </div>
    </div>
</body>
</html>
