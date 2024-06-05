<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("header.php"); ?>
    <title>Result History</title>
    <link rel="stylesheet" href="assets/css/result_chart.css">
</head>

<body>
    <div class="container">
        <h1>Result History</h1>
        <div class="nav">
            <div class="dropdowns">
                <select id="year-dropdown" onchange="updateTable()">
                    <!-- Options for years -->
                </select>
                <select id="month-dropdown" onchange="updateTable()">
                    <!-- Options for months -->
                </select>
            </div>
            <div class="search-icon">
                <a href="#"><img src="assets/icons/search.png" alt="Search"></a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Faridabad</th>
                    <th>DS</th>
                    <th>Gali</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <!-- Rows will be dynamically populated here -->
            </tbody>
        </table>
    </div>
    <a href="dashboard" class="home-icon"><img src="assets/icons/home.png" alt="Home"></a>

    <script src="assets/js/result_chart.js"></script>
</body>

</html>