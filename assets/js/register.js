$(document).ready(function () {
  //=====================Register Script================================================================

  $("#Register").on("submit", function (e) {
    e.preventDefault();
    var mobile = $("input#mobile").val();
    var otp = $("input#otp").val();
    var password = $("input#password").val();
    var checkclick = document.getElementById("reg_otp");

    if (mobile == "") {
      document.getElementById("toast__text").innerHTML =
        "Mobile number is required";
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else if (mobile.length < 10) {
      document.getElementById("toast__text").innerHTML =
        "Enter valid Mobile number";
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else if (otp == "") {
      document.getElementById("toast__text").innerHTML =
        "Verification code is required";
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else if (checkclick.clicked == false) {
      document.getElementById("toast__text").innerHTML =
        "Verification code is required";
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else if (password == "") {
      document.getElementById("toast__text").innerHTML = "Password is required";
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else if (password.length < 5) {
      document.getElementById("toast__text").innerHTML =
        "Password must be 5 characters";
      document.getElementById("van-toast").style.display = "flex";
      setTimeout(function () {
        document.getElementById("van-toast").style.display = "none";
      }, 3000);
    } else {
      //================================================match otp===================================================

      if (otp == "") {
        document.getElementById("toast__text").innerHTML = "Please fill OTP";
        document.getElementById("van-toast").style.display = "flex";
        setTimeout(function () {
          document.getElementById("van-toast").style.display = "none";
        }, 1000);
      } else if (otp.length < 6) {
        document.getElementById("toast__text").innerHTML =
          "OTP Code Error. Must 6 characters";
        document.getElementById("van-toast").style.display = "flex";
        setTimeout(function () {
          document.getElementById("van-toast").style.display = "none";
        }, 1000);
      } else {
        $.ajax({
          type: "POST",
          url: "otp.php",
          data: "otp=" + otp + "&type=" + "otpval",

          success: function (html) {
            // alert(html);
            var arr = html.split("~");

            if (arr[0] == 1) {
              var mobile = document.getElementById("mobile").value;
              var password = document.getElementById("password").value;
              var action = "register";
              $.ajax({
                type: "POST",
                url: "globalApi.php",
                data: {
                  mobile: mobile,
                  password: password,
                  action: action,
                },

                success: function (html) {
                  var arr = html.split("~");
                  console.log(arr);

                  if (arr[0] == 1) {
                    document.getElementById("toast__text").innerHTML =
                      "success";
                    window.location.href = "index.php";
                    document.getElementById("van-toast").style.display = "flex";
                    setTimeout(function () {
                      document.getElementById("van-toast").style.display =
                        "none";
                    }, 3000);
                  } else if (arr[0] == 2) {
                    document.getElementById("toast__text").innerHTML =
                      "Mobile No already registered!";
                    document.getElementById("van-toast").style.display = "flex";
                    setTimeout(function () {
                      document.getElementById("van-toast").style.display =
                        "none";
                    }, 3000);
                  } else if (arr[0] == 3) {
                    document.getElementById("toast__text").innerHTML =
                      "please verify mobile no!";
                    document.getElementById("van-toast").style.display = "flex";
                    setTimeout(function () {
                      document.getElementById("van-toast").style.display =
                        "none";
                    }, 3000);
                  } else if (arr[0] == 0) {
                    document.getElementById("toast__text").innerHTML =
                      "something went wrong!";
                    document.getElementById("van-toast").style.display = "flex";
                    setTimeout(function () {
                      document.getElementById("van-toast").style.display =
                        "none";
                    }, 3000);
                  }
                },
              });
            } else if (arr[0] == 0) {
              document.getElementById("toast__text").innerHTML =
                "OTP Code Error";
              document.getElementById("van-toast").style.display = "flex";
              setTimeout(function () {
                document.getElementById("van-toast").style.display = "none";
              }, 1000);
            }
          },
        });
      }
    }
  });
});

//=====================OTP Generation Script================================================================

function sendOTP() {
  var mobile = $("input#mobile").val();

  if (mobile == "") {
    document.getElementById("toast__text").innerHTML =
      "Mobile number is required";
    document.getElementById("van-toast").style.display = "flex";
    setTimeout(function () {
      document.getElementById("van-toast").style.display = "none";
    }, 3000);
  } else if (mobile.length < 10) {
    document.getElementById("toast__text").innerHTML =
      "Enter valid Mobile number";
    document.getElementById("van-toast").style.display = "flex";
    setTimeout(function () {
      document.getElementById("van-toast").style.display = "none";
    }, 3000);
  } else {
    $.ajax({
      type: "Post",
      data: "mobile=" + mobile + "& type=" + "mobile",
      url: "otp.php",

      success: function (html) {
        // alert(html);
        var arr = html.split("~");
        try {
          if (arr[0] == 1) {
            //data = JSON.parse(arr[1])
            //alert(data.Status);
            $("#otpclose").click();
            $("#otploader").show();
            document.getElementById("reg_otp").style.backgroundColor =
              "#999999";
            document.getElementById("reg_otp").disabled = true;

            setTimeout(function () {
              $("#otploader").hide();

              document.getElementById("toast__text").innerHTML = "OTP sent";
              document.getElementById("van-toast").style.display = "flex";
              setTimeout(function () {
                document.getElementById("van-toast").style.display = "none";
              }, 3000);
            }, 2000);

            var countdownNum = 30;
            incTimer();

            function incTimer() {
              setTimeout(function () {
                if (countdownNum != 0) {
                  countdownNum--;
                  document.getElementById("reg_otp").innerHTML =
                    countdownNum + " seconds";
                  incTimer();
                } else {
                  document.getElementById("reg_otp").style.backgroundColor =
                    "#F27B21";
                  document.getElementById("reg_otp").disabled = null;
                  document.getElementById("reg_otp").innerHTML = "OTP";
                }
              }, 1000);
            }
          } else if (arr[0] == 2) {
            document.getElementById("toast__text").innerHTML =
              "The mobile number has been registered, please enter the password to login!";
            document.getElementById("van-toast").style.display = "flex";
            setTimeout(function () {
              document.getElementById("van-toast").style.display = "none";
            }, 2000);
          } else if (arr[0] == 3) {
            document.getElementById("toast__text").innerHTML =
              "Phone Number is required!";
            document.getElementById("van-toast").style.display = "flex";
            setTimeout(function () {
              document.getElementById("van-toast").style.display = "none";
            }, 2000);
          } else {
            document.getElementById("toast__text").innerHTML = html;
            document.getElementById("van-toast").style.display = "flex";
            setTimeout(function () {
              document.getElementById("van-toast").style.display = "none";
            }, 2000);
          }
        } catch (e) {
          document.getElementById("toast__text").innerHTML = e;
          document.getElementById("van-toast").style.display = "flex";
          setTimeout(function () {
            document.getElementById("van-toast").style.display = "none";
          }, 2000);
        }
        return false;
      },
      error: function (e) {
        document.getElementById("toast__text").innerHTML = e;
        document.getElementById("van-toast").style.display = "flex";
        setTimeout(function () {
          document.getElementById("van-toast").style.display = "none";
        }, 2000);
      },
    });
  }
}