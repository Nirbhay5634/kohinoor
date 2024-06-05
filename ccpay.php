<?php
ob_start();
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['userID'] == "") {
	header("Location: login");
	exit();
}
require_once "config.php";
$pre = "KohinoorCC";
$post = random_strings(20);
$randomNumber = $pre . $post;

$userID = $_SESSION['userID'];
$mobileNo = $_SESSION['mobile'];
$upiid = getTransactionSetting($conn, "upi_id");
$amount = $_GET['amount'];
$ist_time_rec = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
$ist_time_rec_str = $ist_time_rec->format('Y-m-d H:i:s');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$utr = $_POST['utr'];
	$getUTRQuery = "SELECT * FROM `recharge` WHERE utr='$utr' ";
	$getUTRResult = mysqli_query($conn, $getUTRQuery);
	$utrcount = mysqli_num_rows($getUTRResult);

	if ($utrcount == 0) {
		$pre_balance = getUserField($conn, 'walletBalance', $userID);
		$curr_balance = $pre_balance;
		$insertRechargeSQL = "INSERT INTO recharge VALUES ('','$userID', '$mobileNo', '$amount', '$upiid', '$utr', '$randomNumber', 'ccpay', 'unpaid','$pre_balance','$curr_balance', '$ist_time_rec_str','')";
		$insertRechargeResult = mysqli_query($conn, $insertRechargeSQL);
		$trans_sql = "INSERT INTO transactions VALUES ('','$userID', '$mobileNo', 'recharge', '$amount','unpaid', '$pre_balance', '$curr_balance', '$ist_time_rec_str')";
		$transResult = mysqli_query($conn, $trans_sql);

		if ($insertRechargeResult && $transResult) {

			echo "<script>

			
			document.addEventListener('DOMContentLoaded', function(event) { 
				document.getElementById('toast__text').innerHTML =
					'success';
				document.getElementById('van-toast').style.display = 'flex';
				setTimeout(function () {
					document.getElementById('van-toast').style.display = 'none';
				}, 3000);

				var copiedElement = document.getElementById('error');
				if (copiedElement) {
					copiedElement.innerHTML = 'UTR Submitted Successfully';
					copiedElement.style.display = '';
					copiedElement.style.color = 'green'; 
					setTimeout(function () { 
						copiedElement.style.display = 'none'; 
						window.location.href='dashboard';
					}, 3000);
				}
			});
		</script>";
		} else {
			echo "Error: " . mysqli_error($conn);
		}
	} else {
		echo "<script>
		document.addEventListener('DOMContentLoaded', function(event) { 
			var copiedElement = document.getElementById('error');
			if (copiedElement) {
				copiedElement.innerHTML = 'UTR Already Submitted';
				copiedElement.style.display = '';
				setTimeout(function () { 
					copiedElement.style.display = 'none'; 
				}, 3000);
			}
		});
		</script>";
	}

	$conn->close();
}
?>
<html lang="en">

<head>
	<?php include("header.php"); ?>
	<title>CCPAY - Kohinoor</title>
	<link rel="stylesheet" href="assets/css/ccpay.css" />
	<link rel="stylesheet" href="assets/Cashier_files/bootstrap.min.css">
	<script src="assets/Cashier_files/jquery.min.js.download"></script>
	<script type="text/javascript" src="assets/Cashier_files/jquery.js.download"></script>
	<link rel="stylesheet" href="assets/css/loginChunk.css">
	<script src="assets/js/ccpay.js"></script>
</head>

<body style="background-color: #ecedf2;">

	<div id="div_paytm" class="container">
		<div class="headerbox">
			<div class="title">
				<img src="assets/Cashier_files/UPI_logo.png" width="177.5px" height="94.5px">
			</div>
			<div class="timer" align="right">
				<img style="width:16px;margin-bottom: 3px;" src="assets/Cashier_files/hourglass.svg">
				<span class="ng-binding" id="second_show">1773</span>
			</div>
		</div>
		<div class="contentbox">
			<div class="ct1">
				<div class="stepbg">
					<span>Supports all UPI payments</span>
				</div>
				<div class="stepbg1">
					<div class="title">Amount Payable</div>
					<div class="amount">₹&nbsp;
						<?php echo $amount; ?>
					</div>
					<div class="pay" id="newclick" style="display:none">
						<table width="100%">
							<tbody>
								<tr>
									<td align="left">
										<div class="logo"></div>
									</td>
									<td align="right"><button type="button" class="btn paybtn" onclick="toPaytm()">Click To Pay</button></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="stepbg">
					<span>Transfer with UPI</span>
				</div>
				<div class="stepbg2">
					<div class="title">click the amount to copy</div>
					<div class="amount" onclick="copyBtn(&#39;span_amount2&#39;)"><span>₹&nbsp;</span><span id="span_amount2">
							<?php echo $amount; ?>
						</span></div>
					<div>
						<span class="title">Order No:</span><span class="orderno">
							<?php echo $randomNumber; ?>
						</span>
					</div>
					<div class="accnobg"><span id="nes_accno">
							<?php echo $upiid; ?>
						</span></div>
					<div class="btnbg">
						<button type="button" class="btn btncopy" onclick="copyBtn(&#39;nes_accno&#39;)">Copy
							Beneficiary UPI</button>

					</div>
					<div class="memobg">
						Open your UPI wallet and complete the transfer
						Record your reference No.(Ref No.) after payment
					</div>
					<div class="titlebg">
						Step 2: Submit Ref No/Reference No/UTR
					</div>
					<div class="inputbg">
						<form id="payment" method="post" action="">
							<input type="text" id="utr" name="utr" placeholder="Input 12-digit Ref No here" maxlength="12" oninput="this.value=this.value.replace(/[^\d]/g,&#39;&#39;)" onchange="this.value=this.value.replace(/[^\d]/g,&#39;&#39;)">
						</form>
					</div>
					<div id="error" class="tipbg" style="display:none"></div>
					<div class="submitbg">
						<button type="button" class="btn btnsubmit" onclick="submit()">Submit Ref Number</button>
					</div>
					<div class="memobg">
						<div>Generally, your transfer will be confirmed within 10 minutes please, contact the game
							support if you have any recharge issues Send these details:</div>
						<div>1.Your ID</div>
						<div>2.Amount</div>
						<div>3.Date of Payment</div>
						<div>4.Payment screenshot</div>
					</div>
				</div>

				<div class="footerbox">
					<div class="f1">
						<div class="fleft">
							<i class="fimg"></i><span class="ftxt">100% Secure Payments Powered by Paytm</span>
						</div>
						<div class="fright">
							<img src="assets/Cashier_files/footer-new-logos.png" class="frimg">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div style="left: -100%;position:absolute;">
		<span id="content_span"></span>
	</div>
	<div class="van-toast van-toast--middle van-toast--text" id="van-toast" style="z-index: 2005; display: none;">
		<div class="van-toast__text" id="toast__text"></div>
	</div>
</body>

</html>