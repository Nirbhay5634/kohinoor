<?php
ob_start();
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['userID'] == "") {
    header("Location: login");
    exit();
}
require_once "config.php";
define('DIAMOND_ICON', 'assets/icons/diamond.png');
define('DIAMOND_ICON_SIZE', 'width: 15px; height: 15px; vertical-align: middle;');

$userID = $_SESSION['userID'];
$query_txn_count = "SELECT COUNT(*) AS total FROM transactions WHERE userID = '$userID'";
$result_txn_count = mysqli_query($conn, $query_txn_count);

$fetchtxn = mysqli_fetch_assoc($result_txn_count);
$total_records = $fetchtxn['total'];

// Pagination variables
$records_per_page = 10;
$total_pages = ceil($total_records / $records_per_page);
$page = isset($_GET['page']) ? max(1, min($_GET['page'], $total_pages)) : 1;
$offset = ($page - 1) * $records_per_page;

$query_txn = "SELECT * FROM transactions WHERE userID = '$userID' ORDER BY created_at DESC LIMIT $offset, $records_per_page";
$result_txn = mysqli_query($conn, $query_txn);

if (!$result_txn) {
    die('Error in recharge query: ' . mysqli_error($conn));
}
?>
<html lang="en" style="font-size: 41.2px;">

<head>
    <?php include("header.php"); ?>
    <title>Transactions - Kohinoor</title>
    <link href="assets/css/txnChunk.css" rel="stylesheet">
    <link href="assets/css/txn.css" rel="stylesheet">
    <script src="assets/js/transaction.js"></script>
</head>

<body>
    <div>
        <div data-v-f26d0378="" class="recharge">
            <div data-v-f26d0378="" class="nav_bar">
                <div data-v-f26d0378="" class="nav_left"><button data-v-f26d0378="" class="page_btn" onclick="location.href='dashboard';"><i data-v-f26d0378="" class="van-icon van-icon-arrow-left"></i></button></div>
                <div data-v-f26d0378="" class="nav_middle">
                    Transactions
                </div>
                <div data-v-f26d0378="" class="nav_right"></div>
            </div>
            <div data-v-f26d0378="" class="recharge_box">
                <div data-v-f26d0378="" class="completed_list">
                    <ul data-v-f26d0378="" class="list_box">
                        <?php while ($row = mysqli_fetch_assoc($result_txn)) {
                            if ($row['action'] == 'recharge') { ?>
                                <li data-v-f26d0378="">
                                    <ol data-v-f26d0378="">
                                        <p data-v-f26d0378="">
                                            <span style="color:<?= $row['status'] == 'success' ? 'green' : ($row['status'] == 'failed' ? 'red' : 'black') ?>">
                                                <?= $row['status'] == 'success' ? '+' : '' ?>
                                                <img src="<?= DIAMOND_ICON ?>" alt="Diamond Icon" style="<?= DIAMOND_ICON_SIZE ?>" />
                                                <?= number_format($row['amount'], 2) ?>
                                            </span>
                                        </p>
                                        </p>
                                        <p data-v-f26d0378=""><img src="<?= DIAMOND_ICON ?>" alt="Diamond Icon" style="<?= DIAMOND_ICON_SIZE ?>" /><?= number_format($row['pre_balance'], 2); ?></p>
                                    </ol>
                                    <ol data-v-f26d0378="">
                                        <p data-v-f26d0378="">
                                            <?= $row['status'] == 'success' ? 'Recharge Success' : ($row['status'] == 'unpaid' ? 'Recharge Unpaid' : ($row['status'] == 'failed' ? 'Recharge Failed' : 'Unknown Status')) ?>
                                        </p>
                                        <p data-v-f26d0378="" class="times"><img src="<?= DIAMOND_ICON ?>" alt="Diamond Icon" style="<?= DIAMOND_ICON_SIZE ?>" /><?= number_format($row['curr_balance'], 2); ?></p>
                                    </ol>
                                    <ol data-v-f26d0378="">
                                        <p data-v-f26d0378="" class="oddnum"><?php echo $row['created_at']; ?></p>
                                    </ol>
                                </li>
                            <?php } elseif ($row['action'] == 'withdraw') { ?>
                                <li data-v-f26d0378="">
                                    <ol data-v-f26d0378="">
                                        <p data-v-f26d0378="">
                                            <span style="color: <?= $row['status'] == 'withdrawing' ? 'violet' : ($row['status'] == 'agree' ? 'green' : ($row['status'] == 'applying' ? 'black' : 'red')) ?>">
                                                <?= $row['status'] == 'failed' ? '+' : '' ?><img src="<?= DIAMOND_ICON ?>" alt="Diamond Icon" style="<?= DIAMOND_ICON_SIZE ?>" /><?= number_format($row['amount'], 2) ?>
                                            </span>
                                        </p>
                                        <p data-v-f26d0378=""><img src="<?= DIAMOND_ICON ?>" alt="Diamond Icon" style="<?= DIAMOND_ICON_SIZE ?>" /><?= number_format($row['pre_balance'], 2); ?></p>
                                    </ol>
                                    <ol data-v-f26d0378="">
                                        <p data-v-f26d0378="">
                                            <?= $row['status'] == 'withdrawing' ? 'Withdrawing' : ($row['status'] == 'applying' ? 'Applying' : ($row['status'] == 'agree' ? 'Agree Withdraw' : ($row['status'] == 'failed' ? 'Withdraw Failed' : 'Unknown Status'))) ?>
                                        </p>
                                        <p data-v-f26d0378="" class="times"><img src="<?= DIAMOND_ICON ?>" alt="Diamond Icon" style="<?= DIAMOND_ICON_SIZE ?>" /><?= number_format($row['curr_balance'], 2); ?></p>
                                    </ol>
                                    <ol data-v-f26d0378="">
                                        <p data-v-f26d0378="" class="oddnum"><?php echo $row['created_at']; ?></p>
                                    </ol>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>

                </div>
                <div data-v-f26d0378="" class="pagination">
                    <ul data-v-f26d0378="" class="page_box">
                        <li data-v-f26d0378="" class="page">
                            <span data-v-f26d0378=""><?php echo ($page - 1) * $records_per_page + 1 ?>-<?php echo min($page * $records_per_page, $total_records) ?>
                                of <?php echo $total_pages ?></span>
                        </li>
                        <li data-v-f26d0378="" class="page_btn">
                            <?php if ($page > 1) : ?>
                                <a href="?page=<?php echo $page - 1; ?>"><i data-v-f26d0378="" class="van-icon van-icon-arrow-left"></i></a>
                            <?php else : ?>
                                <i data-v-f26d0378="" class="van-icon van-icon-arrow-left" onclick="handlePagination('first')"></i>
                            <?php endif; ?>
                            <?php if ($page < $total_pages) : ?>
                                <a href="?page=<?php echo $page + 1; ?>"><i data-v-f26d0378="" class="van-icon van-icon-arrow"></i></a>
                            <?php else : ?>
                                <i data-v-f26d0378="" class="van-icon van-icon-arrow" onclick="handlePagination('last')"></i>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
                <div data-v-f26d0378="" class="choose_page">
                    <div data-v-f26d0378="" class="choose_page_par"><span data-v-f26d0378="">Rows per page:</span>
                        <div data-v-f26d0378="" class="page_box_two">
                            <div data-v-f26d0378="" class="van-dropdown-menu">
                                <div class="van-dropdown-menu__bar van-dropdown-menu__bar--opened">
                                    <div role="button" tabindex="0" class="van-dropdown-menu__item" onclick="rowPerPage();"><span class="van-dropdown-menu__title" id="rowPerPageActive" style="color: rgb(156, 39, 176);">
                                            <div class="van-ellipsis">10</div>
                                        </span></div>
                                </div>
                                <div data-v-f26d0378="">
                                    <div class="van-dropdown-item van-dropdown-item--down" id="rowPerPageSelector" style="display:none">
                                        <div class="van-popup van-popup--top van-dropdown-item__content" style="transition-duration: 0.2s; z-index: 2001;">
                                            <div role="button" tabindex="0" class="van-cell van-cell--clickable van-dropdown-item__option van-dropdown-item__option--active" style="color: rgb(156, 39, 176);" onclick="updateRowsPerPage(10)">
                                                <div class="van-cell__title"><span>10</span></div>
                                                <div class="van-cell__value"><i class="van-icon van-icon-success van-dropdown-item__icon" style="color: rgb(156, 39, 176);"></i></div>
                                            </div>
                                            <div role="button" tabindex="0" class="van-cell van-cell--clickable van-dropdown-item__option" onclick="updateRowsPerPage(20)">
                                                <div class="van-cell__title"><span>20</span></div>
                                            </div>
                                            <div data-v-f26d0378="" class="content"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="dashboard" class="home-icon"><img src="assets/icons/home.png" alt="Home"></a>

    <div class="van-toast van-toast--middle van-toast--text" id="van-toast" style="z-index: 2005; display: none;">
        <div class="van-toast__text" id="toast__text"></div>
    </div>

</body>

</html>