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

$dashboardInfo = getTransactionSetting($conn,"dashboard_info");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("header.php"); ?>
    <title>Kohinoor - Home</title>
    <link rel="stylesheet" href="assets/css/dashboard.css" />
    <script src="assets/js/dashboard.js"></script>
</head>

<body>
    <header class="header">
        <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
        <div class="title">KOHINOOR CLUB</div>
    </header>

    <section class="profile">
        <div class="diamond-icon">
            <img src="assets/icons/diamond copy.png" alt="Diamond Icon" />
        </div>
        <div class="user-info">
            <div class="username"><?php echo $userName;?></div>
            <div class="points-section">
                <img src="assets/icons/diamond.png" alt="Diamond Icon" />
                <div class="points"><?php echo $walletBalance;?></div>
            </div>
        </div>
    </section>

    <nav class="menu" id="menu">
        <div class="logo">
            <img src="assets/icons/kohinoor-logo-white.png" alt="Kohinoor Logo" />
        </div>
        <ul>
            <li onclick="location.href='profile'"><img src="assets/icons/profile.png" alt="Profile Icon" /> Profile</li>
            <li onclick="location.href='result_chart'"><img src="assets/icons/result_chart_black.png"
                    alt="Result Chart Icon" /> Result Chart</li>
            <li onclick="location.href='withdrawal_status'"><img src="assets/icons/withdrawal_black.png"
                    alt="Withdrawal Status Icon" /> Withdrawal Status</li>
            <li onclick="location.href='how_to_play'"><img src="assets/icons/how_to_play_icon.png"
                    alt="How to play Icon" /> How to play</li>
            <li onclick="location.href='help'"><img src="assets/icons/help.png" alt="Help Icon" /> Help</li>
            <li onclick="location.href='logout'"><img src="assets/icons/logout.png" alt="Log Out Icon" /> Log Out</li>
        </ul>
    </nav>

    <main class="content">
        <div class="card" onclick="location.href='recharge'">
            <img src="assets/icons/add-diamond.png" alt="Add Points Icon" />
            <div>Add Points</div>
        </div>
        <div class="card" onclick="location.href='jodi'">
            <img src="assets/icons/3d-dice.png" alt="Jodi Icon" />
            <div>Jodi</div>
        </div>
        <div class="card" onclick="location.href='haruf'">
            <img src="assets/icons/6d-dice.png" alt="Haruf Icon" />
            <div>Haruf</div>
        </div>
        <div class="card" onclick="location.href='transactions'">
            <img src="assets/icons/transaction_icon.png" alt="Transaction Icon" />
            <div>Transaction</div>
        </div>
        <div class="card" onclick="location.href='crossing'">
            <img src="assets/icons/cross.png" alt="Crossing Icon" />
            <div>Crossing</div>
        </div>
        <div class="card" onclick="location.href='quick'">
            <img src="assets/icons/quick_play.png" alt="Quick Icon" />
            <div>Quick</div>
        </div>
        <div class="card" onclick="location.href='bid_history'">
            <img src="assets/icons/bid_history.png" alt="Bid History Icon" />
            <div>Bid History</div>
        </div>
        <div class="card" onclick="location.href='withdraw'">
            <img src="assets/icons/withdrawal_black.png" alt="Withdraw Points Icon" />
            <div>Withdraw Points</div>
        </div>
        <div class="card" onclick="location.href='how_to_play'">
            <img src="assets/icons/how_to_play_icon.png" alt="How to play Icon" />
            <div>How to play?</div>
        </div>
    </main>

    <div class="home-icon" onclick="location.href='dashboard'">
        <img src="assets/icons/home.png" alt="Home Icon" />
    </div>

    <footer class="footer">
        <?php echo $dashboardInfo;?>
    </footer>
</body>

</html>