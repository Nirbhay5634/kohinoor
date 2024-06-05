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

$withdrawInfo = getTransactionSetting($conn,"withdraw_info");
$withdrawYT = getTransactionSetting($conn,"withdraw_yt");
$minWithdraw = getTransactionSetting($conn,"minimum_withdrawal");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("header.php"); ?>
    <title>Withdraw - Kohinoor</title>
    <link rel="stylesheet" href="assets/css/withdraw.css">
    <link rel="stylesheet" href="assets/css/loginChunk.css">
    <script src="assets/js/withdraw.js"></script>
</head>

<body>
    <div class="container">
        <div class="user-details-box">
            <div class="user-info-center">
                <div class="username"><?php echo $userName; ?></div>
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
                <button class="withdraw-money-button" onclick="showWithdrawPopup()">- WITHDRAW</button>
            </div>
        </div>

        <div class="video-section">
            <div class="video-container">
                <iframe src="https://www.youtube.com/embed/<?php echo $withdrawYT; ?>" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
        </div>

        <div class="home-icon">
            <img src="assets/icons/home.png" onclick="location.href='dashboard'" alt="Home Icon">
        </div>

        <div id="popupForm" class="popup-form">
            <div class="popup-content">
                <span class="close" onclick="hideWithdrawPopup()">&times;</span>
                <h2>Withdraw Money</h2>
                <form action="#" method="post" id="Withdraw" class="card-body" autocomplete="off">
                    <label for="withdrawAmount">Enter Amount</label>
                    <input type="number" id="withdrawAmount" name="withdrawAmount" placeholder="Enter Amount">

                    <label for="paymentMode">Payment Mode</label>
                    <input type="radio" id="paymentMode" name="paymentMode" value="account-transfer" checked> Account Transfer

                    <label for="accountNumber">Account Number</label>
                    <input type="number" id="accountNumber" name="accountNumber" placeholder="Enter Account Number">

                    <label for="ifsc">IFSC</label>
                    <input type="text" id="ifsc" name="ifsc" placeholder="Enter IFSC">
                    <input type="hidden" id="minWithdraw" value="<?php echo $minWithdraw;?>">
                    <input type="hidden" id="action" value="withdraw">
                    <button type="submit" class="submit-button">WITHDRAW</button>
                </form>
                <p class="info-text"><?php echo $withdrawInfo;?></p>
            </div>
        </div>
    </div>
    <div class="van-toast van-toast--middle van-toast--text" id="van-toast" style="z-index: 2005; display: none;">
        <div class="van-toast__text" id="toast__text"></div>
    </div>
</body>

</html>