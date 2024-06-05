<?php
ob_start();
session_start();
require_once "config.php";

$ist_time_rec = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
$currentTime = $ist_time_rec->format('Y-m-d H:i:s');

if (isset($_POST['action'])) {

    $action = $_POST['action'];
}

if ($action == 'register') {
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $otpmobile = $_SESSION["signup_mobilematched"];

    if (strlen($otpmobile !== $mobile)) {
        echo "3"; // mobile not verified
    } else {
        $chkuser = mysqli_query($conn, "select * from `users` where `mobileNo`='" . $mobile . "'");
        $userRow = mysqli_num_rows($chkuser);
        if ($userRow == null) {
            $userID = getNextUserId($conn);
            $name = "User";
            if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ipAddress = $_SERVER['REMOTE_ADDR'];
            }
            $register_bonus = getTransactionSetting($conn, 'register_bonus');
            if ($register_bonus > 0) {
                $sql = mysqli_query($conn, "INSERT INTO `users` (`userID`,`name`,`mobileNo`, `password`,`walletBalance`,`status`,`rIP`,`created_at`) VALUES ('" . $userID . "','" . $name . "','" . $mobile . "','" . $password . "','" . $register_bonus . "','1','" . $ipAddress . "','" . $currentTime . "')");
                $trans_sql = mysqli_query($conn, "INSERT INTO `transactions` ('','" . $userID . "','" . $mobile . "','register_bonus','" . $register_bonus . "','success','" . $register_bonus . "','" . $register_bonus . "','" . $currentTime . "')");
                $register_bonus_sql = mysqli_query($conn, "INSERT INTO `register_bonus` ('','" . $userID . "','" . $mobile . "','" . $register_bonus . "','success','" . $register_bonus . "','" . $register_bonus . "','" . $currentTime . "')");
            } else {
                $sql = mysqli_query($conn, "INSERT INTO `users` (`userID`,`name`,`mobileNo`, `password`,`status`,`rIP`,`created_at`) VALUES ('" . $userID . "','" . $name . "','" . $mobile . "','" . $password . "','1','" . $ipAddress . "','" . $currentTime . "')");
                $trans_sql = true;
            }
            if ($sql && $trans_sql) {
                unset($_SESSION["signup_mobilematched"]);
                echo "1"; // successful register
            } else {
                echo "0"; // something wrong
            }
        } else {
            echo "2"; // mobile already registered
        }
    }
}
if ($action == 'login') {
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

    if ($mobile != '' && $password != '') {
        $sql = "select * from `users` where `mobileNo`='" . $mobile . "' and `password`='" . $password . "'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        $line = mysqli_fetch_assoc($result);
        if ($num >= 1) {
            if ($line['status'] == '1') {
                if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $loginIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $loginIp = $_SERVER['REMOTE_ADDR'];
                }
                $userid = $line['userID'];
                $sqlUpdateLoginIp = "UPDATE `users` SET `loginIP` = '" . $loginIp . "' WHERE `userID` = '" . $userid . "'";
                $conn->query($sqlUpdateLoginIp);
                $_SESSION['userID'] = $userid;
                $_SESSION['mobile'] = $line['mobileNo'];
                echo "1"; // successful login
            } else {
                echo "2"; // account blocked
            }
        } else {
            echo "3"; // invalid username or password
        }
    } else {
        echo "0"; // username password null
    }
}
if ($action == 'forgot_password') {
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $otpmobile = $_SESSION["forgot_mobilematched"];

    if (strlen($otpmobile !== $mobile)) {
        echo "3"; // mobile not verified
    } else if ($mobile != '' && $password != '') {
        $sql = "select * from `users` where `mobileNo`='" . $mobile . "'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        $line = mysqli_fetch_assoc($result);
        if ($num >= 1) {
            if ($line['status'] == '1') {
                $userid = $line['userID'];
                $updatePassword = mysqli_query($conn, "UPDATE `users` SET `password`='" . $password . "' where `userID`='$userid'");
                echo "1"; // successful update pass
            } else {
                echo "2"; // account blocked
            }
        } else {
            echo "3"; // invalid username
        }
    } else {
        echo "0"; // username password null
    }
}
if($action == 'withdraw'){
    $amount = $_POST['withdrawAmount'];
    $accountNo = $_POST['accountNumber'];
    $ifsc = $_POST['ifsc'];
    $minWithdraw = $_POST['minWithdraw'];
    $paymentMode = $_POST['paymentMode'];
    $status = "applying";

    $userID = $_SESSION['userID'];
    $mobileNo = $_SESSION['mobile'];

    $pre = "KohinoorWS";
    $post = random_strings(20);
    $randomNumber = $pre . $post;

    if($amount>=$minWithdraw){
        $pre_balance = getUserField($conn, 'walletBalance', $userID);
		$curr_balance = $pre_balance - $amount;

        $sqlUpdateWalletBalance = "UPDATE `users` SET `walletBalance` = '" . $curr_balance . "' WHERE `userID` = '" . $userID . "'";
        $sqlUpdateWalletBalanceResult = mysqli_query($conn, $sqlUpdateWalletBalance);
        $insertWithdrawSQL = "INSERT INTO withdraw VALUES ('','$userID', '$mobileNo', '$amount', '$accountNo', '$ifsc', '$randomNumber', '$paymentMode', '$status','$pre_balance','$curr_balance', '$currentTime','')";
		$insertWithdrawResult = mysqli_query($conn, $insertWithdrawSQL);
		$trans_sql = "INSERT INTO transactions VALUES ('','$userID', '$mobileNo', 'withdraw', '$amount','$status', '$pre_balance', '$curr_balance', '$currentTime')";
		$transResult = mysqli_query($conn, $trans_sql);

        if($sqlUpdateWalletBalanceResult && $insertWithdrawResult && $transResult){
            echo "1";
        }
        else{
            echo "2";
        }
    }
    else{
        echo "3";
    }
}
if ($action == 'update_bank') {
    $mobile = $_SESSION['mobile'];
    $userID = $_POST['userID'];
    $accountNo = $_POST['accountNumber'];
    $ifscCode = $_POST["ifscCode"];

    $sql = "select * from `bank_details` where `userID`='" . $userID . "'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num >= 1) {
        $updateBank = mysqli_query($conn, "UPDATE `bank_details` SET `accountNo`='" . $accountNo . "', `ifsc`='" . $ifscCode . "' where `userID`='$userID'");
        if ($updateBank) {
            echo "1"; // successful update bank
        } else {
            echo "0"; // update failed
        }
    } else {
        $insertBank = mysqli_query($conn, "INSERT INTO `bank_details` (`userID`, `mobileNo`, `accountNo`, `ifsc`, `created_at`) VALUES ('$userID', '$mobile', '$accountNo', '$ifscCode', '$currentTime')");
        if ($insertBank) {
            echo "1"; // successful insert bank
        } else {
            echo mysqli_error($conn); // insert failed
        }
    }
}
if ($action == 'reset_password') {
    $mobile = $_SESSION['mobile'];
    $userID = $_POST['userID'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST["newPassword"];

    $sql = "select * from `users` where `userID`='" . $userID . "' and `password`='" . $oldPassword . "'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    $line = mysqli_fetch_assoc($result);

    if ($num >= 1) {
        if ($line['status'] == '1') {
            $updatePassword = mysqli_query($conn, "UPDATE `users` SET `password`='" . $newPassword . "' where `userID`='$userID'");
            if ($updatePassword) {
                echo "1"; // successful update password
            } else {
                echo "0"; // update failed
            }
        }
        else{
            echo "2"; // account blocked
        }
    } else {
        echo "3"; // invalid username or password
    }
}
if($action == 'result-history'){
    $month = $_POST["month"];
    $year = $_POST["year"];

    $data = fetchDataFromDatabase($conn, $month, $year);
    echo json_encode($data);
}
function fetchDataFromDatabase($conn, $month, $year) {
    $query = "SELECT * FROM result_history WHERE MONTH(date) = $month AND YEAR(date) = $year";
    $result = $conn->query($query);

    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}
