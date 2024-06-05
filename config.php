<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'kohinoor_database');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
date_default_timezone_set("Asia/Kolkata");

if ($conn == false) {
    dir('Error: Cannot connect');
    echo "Fail";
}

function generateOTP()
{
    $characters = '123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 6; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $pin = $randomString;
}

function getNextUserId($conn)
{
    $query = "SELECT userID FROM users ORDER BY id DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastId = $row['userID'];
    } else {
        $lastId = 999;
    }

    $lastIdNumeric = (int)substr($lastId, 2);
    $nextId = $lastIdNumeric + 1;
    $userId = "KM" . $nextId;
    return $userId;
}

function getTransactionSetting($a, $field)
{
    $getTransQuery = mysqli_query($a, "SELECT `$field` FROM `transaction_settings`");
    if (!$getTransQuery) {
        return null;
    }

    $getTransResult = mysqli_fetch_array($getTransQuery);
    if (!$getTransResult || !isset($getTransResult[$field])) {
        return null;
    }

    return $getTransResult[$field];
}

function getUserField($a, $field, $id)
{
    $getUserQuery = mysqli_query($a, "select `$field` from `users` where `userID`='" . $id . "'");
    $getUserResult = mysqli_fetch_array($getUserQuery);
    return $getUserResult["$field"];
}

function getBankDetail($a, $field, $id)
{
    $getBankQuery = mysqli_query($a, "select `$field` from `bank_details` where `userID`='" . $id . "'");
    $getBankResult = mysqli_fetch_array($getBankQuery);
    if (!$getBankResult || !isset($getBankResult[$field])) {
        return null;
    }
    return $getBankResult["$field"];
}

function random_strings($length_of_string)
{
    $str_result = '0123456789012345678901234567890123456789';
    return substr(
        str_shuffle($str_result),
        0,
        $length_of_string
    );
}
