$(document).ready(function () {
  //=====================Login Script================================================================

  $("#Login").on("submit", function (e) {
    e.preventDefault();
    var mobile = $("input#mobile").val();
    var password = $("input#password").val();

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
      var mobile = document.getElementById("mobile").value;
      var password = document.getElementById("password").value;
      var action = "login";
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

          if (arr[0] == 1) {
            document.getElementById("toast__text").innerHTML = "success";
            window.location.href = "dashboard";
            document.getElementById("van-toast").style.display = "flex";
            setTimeout(function () {
              document.getElementById("van-toast").style.display = "none";
            }, 3000);
          } else if (arr[0] == 2) {
            document.getElementById("toast__text").innerHTML =
              "Account Blocked!!";
            document.getElementById("van-toast").style.display = "flex";
            setTimeout(function () {
              document.getElementById("van-toast").style.display = "none";
            }, 3000);
          } else if (arr[0] == 3) {
            document.getElementById("toast__text").innerHTML =
              "Account or password error, please login in 10 seconds";
            document.getElementById("van-toast").style.display = "flex";
            setTimeout(function () {
              document.getElementById("van-toast").style.display = "none";
            }, 3000);
          } else if (arr[0] == 0) {
            document.getElementById("toast__text").innerHTML =
              "something went wrong!";
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

// change eye on password
function changeEye() {
  var passwordField = document.getElementById("password");
  var eyeIcon = document.getElementById("passvisicon");
  
  if (passwordField.type === "password") {
    passwordField.type = "text";
    eyeIcon.src = "assets/icons/closeEye.png";
  } else {
    passwordField.type = "password";
    eyeIcon.src = "assets/icons/openEye.png";
  }
}