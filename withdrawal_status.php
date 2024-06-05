<?php
ob_start();
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['userID'] == "") {
    header("Location: login");
    exit();
}
require_once "config.php";

$userID = $_SESSION['userID'];
$query_txn_count = "SELECT COUNT(*) AS total FROM withdraw WHERE userID = '$userID'";
$result_txn_count = mysqli_query($conn, $query_txn_count);

$fetchtxn = mysqli_fetch_assoc($result_txn_count);
$total_records = $fetchtxn['total'];

// Pagination variables
$default_records_per_page = 10;
$records_per_page = isset($_GET['rows']) ? intval($_GET['rows']) : $default_records_per_page;
$total_pages = ceil($total_records / $records_per_page);
$page = isset($_GET['page']) ? max(1, min($_GET['page'], $total_pages)) : 1;
$offset = ($page - 1) * $records_per_page;

$query_txn = "SELECT * FROM withdraw WHERE userID = '$userID' ORDER BY created_at DESC LIMIT $offset, $records_per_page";
$result_txn = mysqli_query($conn, $query_txn);

if (!$result_txn) {
    die('Error in withdraw query: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("header.php"); ?>
    <title>Kohinoor - Withdraw Record</title>
    <link rel="stylesheet" href="assets/css/withdrawal_status.css">
    <script src="assets/js/withdrawal_status.js" defer></script>
</head>

<body>
    <div class="navbar">
        <svg class="back-icon" onclick="goBack()" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white"
            width="27px" height="27px">
            <path d="M0 0h24v24H0z" fill="none" />
            <path d="M19 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H19v-2z" />
        </svg>
        <h1>Withdraw Record</h1>
    </div>
    <div class="container">
        <div class="table-header">
            <div class="table-column">Date</div>
            <div class="table-column">Mode</div>
            <div class="table-column">Points</div>
            <div class="table-column">Status</div>
        </div>
        <div id="table-body">
            <?php if (mysqli_num_rows($result_txn) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($result_txn)) { ?>
            <div class="table-row">
                <div class="table-column"><?php echo date('Y-m-d', strtotime($row['created_at'])); ?></div>
                <div class="table-column"><?php echo htmlspecialchars($row['method']); ?></div>
                <div class="table-column"><?php echo htmlspecialchars($row['amount']); ?></div>
                <div class="table-column"><?php echo htmlspecialchars($row['status']); ?></div>
            </div>
            <?php } ?>
            <?php } else { ?>
            <div class="no-records">No records found.</div>
            <?php } ?>
        </div>
    </div>
    <div class="pagination-controls">
        <div class="page-range">
            <?php
            $start = ($page - 1) * $records_per_page + 1;
            $end = min($start + $records_per_page - 1, $total_records);
            ?>
            <span><?php echo $start; ?>-<?php echo $end; ?> of <?php echo $total_pages; ?></span>
        </div>
        <div class="pagination">
            <?php if ($page > 1) : ?>
            <a href="?page=<?php echo $page - 1; ?>&rows=<?php echo $records_per_page; ?>"><img
                    src="assets/icons/forward.png" alt="Previous"></a>
            <?php else : ?>
            <img src="assets/icons/forward.png" onclick="handlePagination('first')">
            <?php endif; ?>
            <?php if ($page < $total_pages) : ?>
            <a href="?page=<?php echo $page + 1; ?>&rows=<?php echo $records_per_page; ?>"><img
                    src="assets/icons/back.png" alt="Next"></a>
            <?php else : ?>
            <img src="assets/icons/back.png" onclick="handlePagination('last')">
            <?php endif; ?>

        </div>
    </div>
    <div class="rows-per-page">
        <label for="rows">Rows per page:</label>
        <select id="rows" name="rows" onchange="changeRowsPerPage()">
            <option value="5" <?php if ($records_per_page == 5) echo 'selected'; ?>>5</option>
            <option value="10" <?php if ($records_per_page == 10) echo 'selected'; ?>>10</option>
            <option value="20" <?php if ($records_per_page == 20) echo 'selected'; ?>>20</option>
            <option value="50" <?php if ($records_per_page == 50) echo 'selected'; ?>>50</option>
        </select>
    </div>
</body>

</html>