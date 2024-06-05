<?php
require_once "config.php";
$ist_time_rec = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
$currentTime = $ist_time_rec->format('Y-m-d H:i:s');

$sqlFetchOtpApi = "SELECT * FROM otp WHERE id='1'";
$resultFetchOtpApi = $conn->query($sqlFetchOtpApi);

if ($resultFetchOtpApi) {
    $rowFetchOtpApi = mysqli_fetch_array($resultFetchOtpApi);
    $otpApi = $rowFetchOtpApi['otp_api'];
    $otpMessage = $rowFetchOtpApi['otp_message'];
    $otpRoute = $rowFetchOtpApi['otp_route'];
} else {
    echo json_encode(array('status' => 'error', 'message' => "Database query failed: " . $conn->error));
    exit;
}

if (isset($_POST['type'])) {
    if ($_POST['type'] == 'mobile') {
        $mobile = trim($_POST['mobile']);
        $otp = generateOTP();
        $checkUserQuery = "SELECT * FROM users WHERE mobileNo = '$mobile'";
        $result = mysqli_query($conn, $checkUserQuery);
        $userCount = mysqli_num_rows($result);
        $line = mysqli_fetch_assoc($result);

        if ($userCount != 0) {
            if ($line['status'] == '1') {
                session_start();
                unset($_SESSION["forgot_mobile"]);
                unset($_SESSION["forgot_otp"]);
                $_SESSION["forgot_mobile"] = $mobile;
                $_SESSION["forgot_otp"] = $otp;

                $fields = array(
                    "message" => "$otpMessage",
                    "variables_values" => "$otp",
                    "route" => $otpRoute,
                    "numbers" => $mobile,
                );

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($fields),
                    CURLOPT_HTTPHEADER => array(
                        "authorization: $otpApi",
                        "accept: */*",
                        "cache-control: no-cache",
                        "content-type: application/json"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    $responseArray = json_decode($response, true);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        $return = $responseArray['return'];
                        if ($return == true) {
                            $insertOtpQuery = "INSERT INTO otp_verification (mobileNo, otp, action, created_at) VALUES ('$mobile', '$otp', 'forgot_password', '$currentTime')";
                            $conn->query($insertOtpQuery);
                            echo "1"; // otp sent successful
                        } else {
                            echo "something went wrong!!";
                            // echo $response;
                        }
                    } else {
                        echo "Error in decoding JSON response.";
                    }
                }
            }
            else{
                echo "3"; // account blocked
            }
        } else {
            echo "2"; //  mobile not exist
        }
    }
    if ($_POST['type'] == 'otpval') {
        session_start();
        $otp = $_POST['otp'];
        $mobile = $_SESSION["forgot_mobile"];
        $sessionotp = $_SESSION["forgot_otp"];

        if (strlen($sessionotp !== $otp)) {
            echo "0"; // otp not matched
        } else {

            $_SESSION["forgot_mobilematched"] = $_SESSION["forgot_mobile"];
            unset($_SESSION["forgot_mobile"]);
            unset($_SESSION["forgot_otp"]);

            echo "1"; // otp matched
        }
    }
}
