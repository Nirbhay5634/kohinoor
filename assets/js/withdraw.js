$(document).ready(function () {
  //=====================Withdraw Script================================================================

  $("#Withdraw").on("submit", function (e) {
    e.preventDefault();
    var withdrawAmountInput = document.getElementById("withdrawAmount");
    var withdrawAmount = parseInt(withdrawAmountInput.value);
    var accountNumberInput = document.getElementById("accountNumber");
    var accountNumber = accountNumberInput.value.trim();
    var ifscInput = document.getElementById("ifsc");
    var ifsc = ifscInput.value.trim();
    var minWithdraw = document.getElementById("minWithdraw").value;
    var paymentMode = document.querySelector('input[name="paymentMode"]:checked').getAttribute('value');

    if (isNaN(withdrawAmount) || withdrawAmount < minWithdraw) {
      document.getElementById("toast__text").innerHTML =
        "Minimum withdrawal amount: Rs " + minWithdraw;
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else if (accountNumber === "") {
      document.getElementById("toast__text").innerHTML =
        "Account no is required!";
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else if (ifsc === "") {
      document.getElementById("toast__text").innerHTML =
        "IFSC code is required!";
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else {
      var action = "withdraw";
      $.ajax({
        type: "POST",
        url: "globalApi.php",
        data: {
          withdrawAmount: withdrawAmount,
          accountNumber: accountNumber,
          ifsc: ifsc,
          minWithdraw: minWithdraw,
          paymentMode: paymentMode,
          action: action,
        },

        success: function (html) {
          var arr = html.split("~");

          if (arr[0] == 1) {
            document.getElementById("toast__text").innerHTML = "success";
            window.location.href = "dashboard";
            document.getElementById("van-toast").style.display = "flex";
            setTimeout(function () {
              document.getElementById("van-toast").style.display = "none";
            }, 3000);
          } else if (arr[0] == 2) {
            document.getElementById("toast__text").innerHTML =
              "something went wrong!!";
            document.getElementById("van-toast").style.display = "flex";
            setTimeout(function () {
              document.getElementById("van-toast").style.display = "none";
            }, 3000);
          } else if (arr[0] == 3) {
            document.getElementById("toast__text").innerHTML =
            "Minimum withdrawal amount: Rs " + minWithdraw;
            document.getElementById("van-toast").style.display = "flex";
            setTimeout(function () {
              document.getElementById("van-toast").style.display = "none";
            }, 3000);
          }
        },
      });
    }
  });
});

function showWithdrawPopup() {
  document.getElementById("popupForm").style.display = "flex";
}

function hideWithdrawPopup() {
  document.getElementById("popupForm").style.display = "none";
}

window.addEventListener("click", function (event) {
  var withdrawPopup = document.getElementById("popupForm");
  if (event.target == withdrawPopup) {
    withdrawPopup.style.display = "none";
  }
});
